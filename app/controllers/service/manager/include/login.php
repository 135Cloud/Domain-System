<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}

require './source/plesk/PleskApiClient.php';
$server =   $database->table('server_list')->where('id',$result['server'])->select();
$action = new Plesk_XML_API($server['server'],$server['login'],$server['pwd']);
$plesk_session = $action->Login_Session($result['host_login_name'],$_SERVER['REMOTE_ADDR']);

$url = 'https://'.$server['server'].':8443/enterprise/rsession_init.php?PHPSESSID='.$plesk_session['id'];

echo '<script>document.location.href="'.$url.'";</script>';