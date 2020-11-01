<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}


$expire = new DateTime($result['expired']);
$today = new DateTime();
$plan_id = $result['plan_id'];
$plan_result = $database->table('plan_list')->where('id','=',$plan_id)->select();

if(@$_POST){
	$cycle = $_POST['cyc'];
	if($plan_result[$cycle]=='-1'){
		$error = '結算週期錯誤';
	}
	else{
		$fee = $plan_result[$cycle];
		$quantity = filter_var($cycle, FILTER_SANITIZE_NUMBER_INT);
	}
	if(@$error){
		$_HTML['error'] = $error;
	}
	else{
		$_SESSION['cart'][] = ['type'=>'service_r','name'=>@$result['name'],'quantity'=>$quantity,'price'=>$fee,'plan'=>$plan_id,'id'=>$_GET['id']];
		header("Refresh: 0; url=".$_Global['URL']."/Cart/View");

	}
}



// 產生週期選項
$first = ' checked=""';
foreach(['price_24m'=>"兩年",'price_12m'=>"每年",'price_3m'=>"每季",'price_1m'=>"每月"] as $felid =>$unit){
	if($plan_result[$felid]!='-1'){
		switch($felid){
			case 'price_12m':
				$price = $plan_result[$felid] / 12 ;
				$time = new DateTime($result['expired']);
				$time->modify('+12 month');
			break;
			case 'price_24m':
				$price = $plan_result[$felid] / 24 ;
				$time = new DateTime($result['expired']);
				$time->modify('+24 month');
			break;
			case 'price_3m':
				$price = $plan_result[$felid] / 3 ;
				$time = new DateTime($result['expired']);
				$time->modify('+3 month');
			break;
			case 'price_1m':
				$price = $plan_result[$felid] / 1 ;
				$time = new DateTime($result['expired']);
				$time->modify('+1 month');
			break;

		}
		$time->modify('+1 day');
		
		$time = $time->format('Y-m-d');
		@$_HTML['cyc'] = '<div class="custom-control custom-radio"><input type="radio" id="Radio'.$felid.'" value="'.$felid.'" name="cyc" class="custom-control-input"'.$first.'><label class="custom-control-label" for="Radio'.$felid.'">'.$unit.'結算, 訂閱將於 '.$time.' 到期。 共 NT$ '.$plan_result[$felid].' 元, 平均 NT$ '.round($price,1).' /月</label></div>'.$_HTML['cyc'];
		$first = '';
	}
}



$_HTML['expire'] = $expire->format('Y-m-d');
$_HTML['plan_name'] = $plan_result['name'];
$_HTML['expire_left'] = (strtotime($expire->format('Y-m-d')) - strtotime($today->format('Y-m-d')))/ (60*60*24);