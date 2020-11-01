<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}

if(!is_numeric($_GET['id'])){
    $_Global['error_code'] = '403';
}
else{
    $_HTML['title'] = '餘額付款';
    $database = new DB();
    $invoice = $database->table('invoices')->where('id',$_GET['id'])->where('uid',$_SESSION['login'])->select();
    $invoice_id = $invoice['id'];
    if($invoice['status']=='active'){

        if($invoice['note']=='FUNDS'){
            exit('儲值不可用餘額付款及點數折抵');
        }


        $user_info = $database->table('user')->where('uid',$invoice['uid'])->select();
        $_HTML['userinfo'] = '<p>付款人帳號<br>'.$user_info['username'].' (UID '.$user_info['uid'].' )</p><p>帳務通知信箱<br>'.$user_info['email'].'</p>';
        $_HTML['totals'] = $invoice['total'];
        $_HTML['paid'] = $invoice['paid'];

        if(empty($invoice['date_billed'])){
            $invoice['date_billed'] = '尚無付款資訊';
        }
        switch($_GET['ec']){
            case 'funds':
                // 
                $funds = $database->table('funds')->where('uid',$_SESSION['login'])->select();

                $_HTML['funds_txt'] = '錢包餘額';
                $_HTML['funds'] = $funds['funds'];

                if($funds['funds'] < $invoice['total']){
                    $_HTML['default_amout'] = $funds['funds'];
                }
                else{
                    $_HTML['default_amout'] = $invoice['total'];
                }

                if($funds['funds']<=0){
                    $error = '餘額不足，請使用其他方式付款。';
                }
                elseif($_POST){
                    
                    if($_POST['pay_amount']>$funds['funds']){
                        $error = '請確認您輸入的金額不得多於您的實際餘額。';
                    }
                    elseif($_POST['pay_amount']>($invoice['total']-$invoice['paid'])){
                        $error = '您輸入的金額不得多於應付金額';
                    }
                    else{
                        $now = new DateTime();
                        $pay_amount= (int)$_POST['pay_amount'];
                        $new_fund = $funds['funds'] - $pay_amount;
                        
                        $database->table('payment')->insert(['invoice_id'=>$invoice_id,
                                                             'uniTradeNo'=>'FUND_'.uniqid(),
                                                             'ecRtnMsg'=>'餘額付款',
                                                             'ecTradeAmt'=> $pay_amount,
                                                             'MerchantTradeDate'=>$now->format("Y-m-d H:i:s")]);
                                                             
                        $database->table('funds')->where('uid',$invoice['uid'])->update(['funds', $new_fund]);
                        $database->table('funds_his')->insert([ 'uid'=>$_SESSION['login'],
                                                                'original'=>$funds['funds'],
                                                                'modify'=>($pay_amount) * (-1),
                                                                'result'=>$new_fund,
                                                                'why'=>'支付訂單 #'.$invoice_id]);
                            
                        if($pay_amount >= ($invoice['total']-$invoice['paid'])){
                            // 付費 狀態轉已付款
                            $database->table('invoices')->where('id',$invoice_id)->update([ ['status','paid'],
                                                                                            ['paid',$invoice['paid']+$pay_amount],
                                                                                            ['payment_fee',$invoice['payment_fee']+'0'],
                                                                                            ['date_billed',$now->format("Y-m-d H:i:s")]]);


                            //執行網址續費註冊等
                            require './app/controllers/ecpay/action-domain.php';

                            //服務處理動作
                            require './app/controllers/ecpay/action-service.php';

                            exit('<script>document.location.href="'.$_Global['URL'].'/Invoice/View?id='.$invoice_id.'";</script>');

                        }
                        else{
                            $database->table('invoices')->where('id',$invoice_id)->update([ ['paid',$invoice['paid']+$pay_amount],
                                                                                            ['payment_fee',$invoice['payment_fee']+'0'],
                                                                                            ['date_billed',$now->format("Y-m-d H:i:s")]]);
                        }
                    }
                }


                $_HTML['payment_body'] = '';

            break;
            case 'points':
                $_HTML['funds_txt'] = '論壇點數';

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://besv.net/dzapi.php?mod=credit&u='.$_SESSION['login']);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $output = curl_exec($ch); 
                if(curl_error($ch)){
                    exit('系統錯誤');
                }
                
                curl_close($ch);
                $result = json_decode($output, TRUE);
                $_HTML['funds'] = $funds['funds'] = $result['extcredits5'];


                $limit = round($invoice['total']/10,0);
                if($funds['funds'] < $limit){
                    $_HTML['default_amout'] = $funds['funds'];
                }
                else{
                    $_HTML['default_amout'] = $limit;
                }
                $point_check = $database->table('invoices_lines')->where('text','點數折抵')->where('id',$invoice_id)->get();

                if($funds['funds']<=0){
                    $error = '點數不足，無法折抵。';
                }
                elseif($point_check->num_rows){
                    $error = '不允許多次折抵。';
                }
                elseif($_POST){
                    $pay_amount = (int)$_POST['pay_amount'];
                    $new_fund = $funds['funds'] - $pay_amount;
                    if($pay_amount>$funds['funds']){
                        $error = '您的點數有'.$funds['funds'].'點，不可折抵超過'.$funds['funds'].'點';
                    }
                    elseif($pay_amount>$limit){
                        $error = '折抵金額上限為10%';
                    }
                    elseif(($invoice['total']-$invoice['paid'])==$pay_amount){
                        $error = '折抵後金額不得為0';
                    }
                    else{
                        $invoice['total'] -= $pay_amount;

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, 'https://besv.net/dzapi.php?mod=credit_use&u='.$_SESSION['login'].'&use='.$pay_amount);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        $output = curl_exec($ch); 
                        $output = curl_exec($ch); 
                        if(curl_error($ch)){
                            exit('系統錯誤');
                        }
                        curl_close($ch);
                        $result = json_decode($output, TRUE);

                        if($result['status']==true){
                            $database->table('invoices')->where('id',$invoice_id)->update(['total',$invoice['total']]);

                            $database->table('invoices_lines')->insert(['id'=>$invoice_id,
                                                                        'text'=>'點數折抵',
                                                                        'quantity'=>'1',
                                                                        'price'=>$pay_amount * (-1)]);
                                                                        
                            exit('<script>document.location.href="'.$_Global['URL'].'/Invoice/View?id='.$invoice_id.'";</script>');
                        }
                        else{
                            exit('系統錯誤');
                        }

                    }
                }

                
            break;
            default:
            exit();
        }
    }
    else{
        $_Global['error_code'] = '403';
    }
}