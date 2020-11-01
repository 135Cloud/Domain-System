<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}
include './source/ecpay/ECPay.Payment.Integration.php';
try {
    // 收到綠界科技的付款結果訊息，並判斷檢查碼是否相符
        $obj = new ECPay_AllInOne();
        
        $obj->MerchantID = '1055429';
        $obj->HashKey = 'fwPMz64kKLn8TQLS';
        $obj->HashIV = 'nsMayv53d44H7tit';
        
        // $obj->HashKey	= '5294y06JbISpM5x9';
        // $obj->HashIV		= 'v77hoKGq4kWxNNIS';
        // $obj->MerchantID	= '2000214';
        
        $obj->EncryptType = ECPay_EncryptType::ENC_SHA256; // SHA256
        $feedback = $obj->CheckOutFeedback();

        $database = new DB();

        $database->table('payment')->where('uniTradeNo',$feedback['MerchantTradeNo'])->update([ ['ecTradeNo',$feedback['TradeNo']],
                                                                                                ['ecRtnMsg',$feedback['RtnMsg']],
                                                                                                ['ecRtnCode',@$feedback['RtnCode']],
                                                                                                ['ecPayment',@$feedback['PaymentType']],
                                                                                                ['ecBankCode',@$feedback['BankCode']],
                                                                                                ['ecvAccount',@$feedback['vAccount']],
                                                                                                ['ecExpireDate',@$feedback['ExpireDate']],
                                                                                                ['ecPaymentNo',@$feedback['PaymentNo']]]);
        // 以付款結果訊息進行相對應的處理
            /*
            回傳的綠界科技的付款結果訊息如下:
            Array
            (
                [] =>
                [MerchantTradeNo] =>
                [StoreID] =>
                [RtnCode] =>
                [RtnMsg] =>
                [TradeNo] =>
                [TradeAmt] =>
                [PaymentDate] =>
                [PaymentTypeChargeFee] =>
            )
            */
        
        
        $return_sta = '1';
        $return_res = 'OK';
    }catch(Exception $e) {
        $return_sta = '0';
        $return_res = $e->getMessage();
    }
    echo $return_sta.'|'.$return_res;