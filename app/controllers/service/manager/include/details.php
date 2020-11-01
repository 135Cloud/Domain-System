<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}

require './source/plesk/PleskApiClient.php';
$server =   $database->table('server_list')->where('id',$result['server'])->select();
$action = new Plesk_XML_API($server['server'],$server['login'],$server['pwd']);

$service_info = $action->Get_Subscriptions(['filter'=>['id'=>$result['sys_id']],'dataset'=>['hosting-basic'=>'','stat'=>'','limits'=>'','disk_usage'=>'']]);

foreach($service_info['result']['data']['hosting']['vrt_hst']['property'] as $data){
	@$service_result_hosting[$data['name']] = $data['value'];
}
foreach($service_info['result']['data']['limits']['limit'] as $data){

	if($data['value']=='-1'){
		$data['value'] = '無限制';
	}
	
	elseif($data['name']=='disk_space'||$data['name']=='max_traffic'){
		$data['value']/=(1048576);
	}
	$service_result_limit[$data['name']] = $data['value'];
}
$service_result_stat = $service_info['result']['data']['stat'];
$service_result_disk_usage = $service_info['result']['data']['disk_usage'];
foreach($service_result_disk_usage as $data){
	@$service_result_stat['disk_space'] += $data;
}