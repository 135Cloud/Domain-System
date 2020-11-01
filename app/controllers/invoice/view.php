<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}
$_HTML['title'] = '帳單 #'.$_GET['id'];

if(!is_numeric($_GET['id'])){
    $_Global['error_code'] = '403';
}
else{
    $database = new DB();
    $invoice = $database->table('invoices')->where('id',$_GET['id'])->where('uid',$_SESSION['login'])->select();
    if(@$invoice){


        
        if($invoice['status']=='active'){
            if($invoice['note']=='FUNDS'){
                $disable_funds = true;
            }

            if(@$_GET['payment']){
                switch($_GET['payment']){
                    case 'Credit':
                    case 'WebATM':
                    case 'ATM':
                    case 'CVS':
                        header('Location: '.$_Global['URL'].'/Invoice/Payment?id='.$_GET['id'].'&ec='.$_GET['payment']);
                    break;
                    
                    case 'discount':
                        $_GET['payment']= 'points';
                    case 'funds':
                        header('Location: '.$_Global['URL'].'/Invoice/Funds?id='.$_GET['id'].'&ec='.$_GET['payment']);
                    break;
                    default:
                    exit();
                }
            }
            $_HTML['notice_fee'] = '信用卡付款需負擔 1% 手續費';
            if($invoice['total']<500){
               $_HTML['notice_fee'] .= '<br>帳單金額少於 500 元，超商付款需負擔 15 元手續費。';
            }
            elseif($invoice['total']>=6000){
                $_HTML['notice_fee'] .= '<br>帳單金額高於 6000 元，不支援超商代碼付款。';
            }
            if(empty($invoice['date_billed'])){
                $invoice['date_billed'] = '尚無付款資訊';
            }
        }

        $invoice_line = $database->table('invoices_lines')->where('id',$_GET['id'])->get();
        $_HTML['invoice_line'] = '<table class="table table-sm"><thead><tr><td style="width:80%">描述</td><td style="width:10%" class="text-center">數量</td><td style="width:10%" class="text-right">金額</td></tr></thead><tbody>';

        foreach($invoice_line as $data){
            $_HTML['invoice_line'] .= '<tr><td>'.$data['text'].'</td><td class="text-center">'.$data['quantity'].'</td><td class="text-right">'.$data['price'].'</td></tr>';
        }


        if($invoice['payment_fee']){
            $_HTML['invoice_line'] .= ' <tr><td class="highrow"> </td><td class="highrow">小計</td><td class="highrow text-right">'.$invoice['total'].'</td></tr>
                                        <tr><td> </td><td>手續費</td><td class="text-right">'.$invoice['payment_fee'].'</td></tr><tr><td> </td><td>總計</td><td class="text-right">'.($invoice['payment_fee']+$invoice['total']).'</td></tr>';
        }else{
            $_HTML['invoice_line'] .= '<tr><td class="highrow"> </td><td class="highrow">總計</td><td class="highrow text-right">'.$invoice['total'].'</td></tr>';
        }

        if($invoice['paid']){
            $_HTML['invoice_line'] .= '<tr><td> </td><td class="highrow">付款金額</td><td class="highrow text-right">'.$invoice['paid'].'</td></tr>';
            $_HTML['invoice_line'] .= '<tr><td> </td><td>差異金額</td><td class="text-right">'.($invoice['paid']-$invoice['total']-$invoice['payment_fee']).'</td></tr>';
        }

        $_HTML['invoice_line'] .= '</tbody></table>';


        $payment_history = $database->table('payment')->where('invoice_id',$_GET['id'])->get();

        $_HTML['payment_history'] = '<table class="table table-sm"><thead><tr><td>交易編號<br>金流編號</td><td>交易狀態</td><td>付款資訊</td><td>繳費期限</td></tr></thead><tbody>';
        if($payment_history->num_rows){
            foreach($payment_history as $data){
                if(empty($data['ecTradeNo'])){
                    $data['ecTradeNo'] = '無相關資料';
                }
                if($invoice['status']=='active'){
                    if($data['ecPayment']=='CVS'){
                        $pay_info = '繳費代碼 '.$data['ecPaymentNo'];
                    }
                    elseif(strpos($data['ecPayment'],'ATM')!==false){
                        $pay_info = '銀行代碼 '.$data['ecBankCode'].'<br>虛擬帳號 '.$data['ecvAccount'];
                    }
                    else{
                        $pay_info = '無資料';
                    } 
                }
                elseif($invoice['status']=='paid'){
                    if($data['ecTradeAmt']){
                        $pay_info = '已收到 '.$data['ecTradeAmt'].'<br><small class="form-text text-muted">(實際手續費'.$data['ecChargeFee'].')</small>';
                    }else{
                        $pay_info = '<small>(付款資訊隱藏)</small>';
                    }
                }
                else{
                    $pay_info = '<small>(付款資訊隱藏)</small>';
                }
    
    
                $_HTML['payment_history'] .= '<tr><td>'.$data['uniTradeNo'].'<br>'.$data['ecTradeNo'].'</td><td>'.$data['ecRtnCode'].'<br>'.$data['ecRtnMsg'].'</td><td>'.$pay_info.'</td><td>'.$data['ecExpireDate'].'</td></tr>';
            }
        }
        else{
            $_HTML['payment_history'] .= '<tr><td colspan="4" style="text-align: center;">查無資料</td></tr>';
        }
        $_HTML['payment_history'] .= '</tbody></table>';

        $user_info = $database->table('user')->where('uid',$invoice['uid'])->select();
        $_HTML['userinfo'] = '<p>付款人帳號<br>'.$user_info['username'].' (UID '.$user_info['uid'].' )</p><p>帳務通知信箱<br>'.$user_info['email'].'</p>';
       
    }
    else{
        $_Global['error_code'] = '404';
    }
}
