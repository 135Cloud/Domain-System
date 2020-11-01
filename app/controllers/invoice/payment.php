<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}

if(!is_numeric($_GET['id'])){
    $_Global['error_code'] = '403';
}
else{
    $database = new DB();
    $invoice = $database->table('invoices')->where('id',$_GET['id'])->where('uid',$_SESSION['login'])->select();
    if($invoice['status']=='active'){
        switch($_GET['ec']){
            case 'Credit':
            case 'WebATM':
            case 'ATM':
            case 'CVS':
                // ECPay
                include './source/ecpay/ECPay.Payment.Integration.php';
                try {
                    $obj = new ECPay_AllInOne();

                    $obj->HashKey		= $_Payment['HashKey'];
                    $obj->ServiceURL	= $_Payment['ServiceURL'];
                    $obj->HashIV		= $_Payment['HashIV'];
                    $obj->MerchantID	= $_Payment['MerchantID'];
                    $obj->EncryptType = '1';

                    $MerchantTradeNo				= "DM".date("ym").time().substr(md5(uniqid()), -2);
                    $now                            = date('Y/m/d H:i:s');
                    $obj->Send['ReturnURL']			= $_Global['URL']."/ecpay/return" ;         //付款完成通知回傳的網址
                    $obj->Send['PaymentInfoURL']	= $_Global['URL']."/ecpay/info" ;  		
                    $obj->Send['ClientBackURL']		= $_Global['URL']."/Invoice/View?id=".$_GET['id'];
        
                    $obj->Send['MerchantTradeNo']	= $MerchantTradeNo;                         //訂單編號
                    $obj->Send['MerchantTradeDate']	= $now;                      //交易時間
                    $obj->Send['TradeDesc']			= 'invoice'.$_GET['id']; 	
                    $payment_fee = 0;
                    if($_GET['ec']=='CVS'){
                        if($invoice['total']<500){
                            $payment_fee = 15;
                        }
                        $obj->Send['ChoosePayment']		    = ECPay_PaymentMethod::CVS;
                        $obj->Send['ChooseSubPayment']		= ECPay_PaymentMethod::CVS;
                        $obj->SendExtend['StoreExpireDate']	= '1440'; 

                    }
                    if($_GET['ec']=='Credit'){
                        $payment_fee = round($invoice['total'] * 0.01);
                        $obj->Send['ChoosePayment']		    = ECPay_PaymentMethod::Credit;
                    }
                    if($_GET['ec']=='WebATM'){
                        $obj->Send['ChoosePayment']		    = ECPay_PaymentMethod::WebATM;
                    }
                    if($_GET['ec']=='ATM'){
                        $obj->Send['ChoosePayment']		    = ECPay_PaymentMethod::ATM;
                        $obj->SendExtend['ExpireDate']      = 1;
                    }

                    $obj->Send['TotalAmount']		        = $invoice['total'] + $payment_fee;                         //交易金額
                    

                    foreach($database->table('invoices_lines')->where('id',$_GET['id'])->get() as $data){
                        array_push($obj->Send['Items'], array('Name' => $data['text'], 'Price' => $data['price'],'Currency' => " ", 'Quantity' => $data['quantity'], 'URL' => "none"));
                    }


                    $database->table('payment')->insert(['invoice_id'=>$invoice['id'],
                                                         'uniTradeNo'=>$MerchantTradeNo,
                                                         'MerchantTradeDate'=>$now]);
                    
                    $obj->CheckOut();
                } catch (Exception $e) {
                    echo $e->getMessage();
                } 
            break;
            case 'funds':
                exit('<script>document.location.href="'.$_Global['URL'].'/Invoice/Funds?id='.$_GET['id'].'&ec=funds";</script>');
                // 
            case 'discount':
                exit('<script>document.location.href="'.$_Global['URL'].'/Invoice/Funds?id='.$_GET['id'].'&ec=points";</script>');
            break;
            default:
            exit();
        }
    }
}