<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}
$_HTML['title'] = '服務管理';
$now = new DateTime();
$database = new DB();
if(!is_numeric($_GET['id'])){
    $_Global['error_code'] = '403';
}
else{
	$result = $database->table('service_list')->where('uid',$_SESSION['login'])->where('id',$_GET['id'])->select();
	if($result){
		if($result['disable']=='0'){
			$_HTML['enable'] = true;
		}
		$id=$_GET['id'];
		switch(@$_GET['manage']){
			case 'details':
			case 'login':
			case 'renewal':
			case 'modify':
				$include_file = './app/controllers/service/manager/include/'.$_GET['manage'].'.php';
				$panel_html = './app/views/service/manager/include/'.$_GET['manage'].'.php';
				break;
			default:
				//overview
				$include_file = './app/controllers/service/manager/include/default.php';
				$panel_html = './app/views/service/manager/include/default.php';
			break;
		}
		if(file_exists($include_file)){
			require($include_file);
		}
	}
	else{
		$_Global['error_code'] = 403;
	}
}