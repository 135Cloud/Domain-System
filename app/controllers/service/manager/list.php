<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}
$_HTML['title'] = '服務管理';
$now = new DateTime();
$database = new DB();
foreach($database->table('service_list')->where('uid',$_SESSION['login'])->get() as $data){
	$expired = new DateTime($data['expired']);
	if($now<$expired){
		$status = '<span class="badge badge-pill badge-success">有效</span>';
	}
	else{
		$status = '<span class="badge badge-pill badge-warning">過期</span>';
	}
	if($data['disable']){
		$status = '<span class="badge badge-pill badge-warning">停用</span>';
	}
	$plan_info = $database->table('plan_list')->where('id',$data['plan_id'])->select();
	@$_data['table'] .= '<tr data-href="'.$_Global['URL'].'/Service/Details?id='.$data['id'].'"><td>'.$plan_info['name'].'<br><small id="Help" class="form-text text-muted">'.$data['name'].'</small></td><td>'.$data['create_at'].'</td><td>'.$data['expired'].'</td><td>'.$status.'</td></tr>';
}