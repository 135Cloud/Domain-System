<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}
set_time_limit('120');
include './source/ecpay/ECPay.Payment.Integration.php';
try {
    // 收到綠界科技的付款結果訊息，並判斷檢查碼是否相符
        $obj = new ECPay_AllInOne();
        
        $obj->MerchantID = '1055429';
        $obj->HashKey = 'fwPMz64kKLn8TQLS';
        $obj->HashIV = 'nsMayv53d44H7tit';
        
        // $obj->MerchantID	= '2000214';
        // $obj->HashKey	= '5294y06JbISpM5x9';
        // $obj->HashIV		= 'v77hoKGq4kWxNNIS';
        
        $obj->EncryptType = ECPay_EncryptType::ENC_SHA256; // SHA256
        $feedback = $obj->CheckOutFeedback();

        $database = new DB();


		if($feedback['RtnCode']==1){
			$database->table('payment')->where('uniTradeNo',$feedback['MerchantTradeNo'])->update([ ['ecTradeNo',$feedback['TradeNo']],
																									['ecRtnMsg',$feedback['RtnMsg']],
																									['ecRtnCode',@$feedback['RtnCode']],
																									['ecPayment',@$feedback['PaymentType']],
																									['ecChargeFee',@$feedback['PaymentTypeChargeFee']],
																									['ecTradeAmt',@$feedback['TradeAmt']],
																									['MerchantTradeDate',@$feedback['TradeDate']]]);
			$invoice = $database->table('payment')->where('uniTradeNo',$feedback['MerchantTradeNo'])->select();
			$invoice_id = $invoice['invoice_id'];
			$invoice = $database->table('invoices')->where('id',$invoice_id)->select();
			$user = $database->table('profile')->where('uid',$invoice['uid'])->select();
			$payment_fee = 0;
			if($feedback['PaymentType']=='Credit'){
				$payment_fee = round($invoice['total'] * 0.01);
			}
			if($feedback['PaymentType']=='CVS'){
				if($invoice['total']<500){
					$payment_fee = '15';
				}
			}
			$TradeAmt = $feedback['TradeAmt'] - $payment_fee;


			if($TradeAmt >= ($invoice['total']-$invoice['paid'])){
				// 付費 狀態轉已付款
				$database->table('invoices')->where('id',$invoice_id)->update([ ['status','paid'],
																				['paid',$invoice['paid']+$feedback['TradeAmt']],
																				['payment_fee',$invoice['payment_fee']+$payment_fee],
																				['date_billed',@$feedback['TradeDate']]]);

				if($invoice['note']=='FUNDS'){
					// 儲值
					$funds = $database->table('funds')->where('uid',$invoice['uid'])->select();

					$new_fund =  $funds['funds'] + $invoice['total'];
					$database->table('funds')->where('uid',$invoice['uid'])->update(['funds', $new_fund]);
					$database->table('funds_his')->insert([ 'uid'=>$invoice['uid'],
															'original'=>$funds['funds'],
															'modify'=>$invoice['total'],
															'result'=>$new_fund,
															'why'=>'儲值 帳單#'.$invoice_id]);
				}
				else{										
					//執行網址續費註冊等
					require './app/controllers/ecpay/action-domain.php';
	
					//服務處理動作
					require './app/controllers/ecpay/action-service.php';

				}		

			}
			else{
				$database->table('invoices')->where('id',$invoice_id)->update([ ['paid',$invoice['paid']+$feedback['TradeAmt']],
																				['payment_fee',$invoice['payment_fee']+$payment_fee],
																				['date_billed',@$feedback['TradeDate']]]);
			}



		}
		else{
			$database->table('payment')->where('uniTradeNo',$feedback['MerchantTradeNo'])->update([ ['ecTradeNo',$feedback['TradeNo']],
																									['ecRtnMsg',$feedback['RtnMsg']],
																									['ecRtnCode',@$feedback['RtnCode']],
																									['ecPayment',@$feedback['PaymentType']]]);
		}

        
        
        $return_sta = '1';
        $return_res = 'OK';
    }catch(Exception $e) {
        $return_sta = '0';
        $return_res = $e->getMessage();
    }
    echo $return_sta.'|'.$return_res;