<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}

require './source/plesk/PleskApiClient.php';
$server =   $database->table('server_list')->where('id',$result['server'])->select();
$action = new Plesk_XML_API($server['server'],$server['login'],$server['pwd']);

$service_info = $action->Get_Subscriptions(['filter'=>['id'=>$result['sys_id']],'dataset'=>['gen_info'=>'']]);

$service_result = @$service_info['result']['data']['gen_info'];
if(!empty($service_result)){
	switch($service_result['status']){
		case '0':
			$_HTML['status'] = '<b class="text-success">啟用中</b>';
			$login_btn = '<a class="btn btn-info" href="?id='.$id.'&amp;manage=login">登入後台</a>';
		break;
		case '4':
			$_HTML['status'] = '<b class="text-warning">正在備份/還原中</b>';
		break;
		case '16':
			$_HTML['status'] = '<b class="text-danger">已由系統管理員停用</b>';
		break;
		case '32':
			$_HTML['status'] = '<b class="text-danger">已由經銷商停用</b>';
		break;
		case '64':
			$_HTML['status'] = '<b class="text-danger">已由客戶停用</b>';
		break;
		case '256':
			$_HTML['status'] = '<b class="text-secondary">過期</b>';
		break;
	}
	
}
else{
	$_HTML['status'] = '<b class="text-info">查無資料</b>';
	$service_result['cr_date'] = "N/A";
	$service_result['name'] = "N/A";
	$service_result['dns_ip_address'] = "N/A";
}
