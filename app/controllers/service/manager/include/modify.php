<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}


$expire = new DateTime($result['expired']);
$today = new DateTime();
$plan_id = $result['plan_id'];
$plan_result = $database->table('plan_list')->where('id','=',$plan_id)->select();
// $plan_group = $database->table('plan_group')->where('id','=',$plan_result['plan_group'])->select();
// $plan_list = $database->table('plan_list')->where('plan_group','=',$plan_result['plan_group'])->where('server','=',$result["server"])->get();



$_HTML['expire'] = $expire->format('Y-m-d');
$_HTML['plan_name'] = $plan_result['name'];
$_HTML['expire_left'] = (strtotime($expire->format('Y-m-d')) - strtotime($today->format('Y-m-d')))/ (60*60*24);