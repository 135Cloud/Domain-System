<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}
require './source/namesilo/namesilo.php';
$_HTML['title'] = '域名管理';

if($_GET['domain']){
	$database = new DB();
	$domain = $database->table('domains')->where('domain','=',strtolower($_GET['domain']))->where('uid','=',$_SESSION['login'])->select();
	if(!empty($domain)){
		$domain = $domain['domain'];
		$Namesilo = new Namesilo_API();
		$domain_info = $Namesilo->getDomainInfo($domain);
		if($domain_info['code']=='300'){
			switch(@$_GET['manage']){
				case 'dnsserver':
					//changeNameServers
				case 'domainlock':
					//domainUnlock domainLock
				case 'dns':
					//dnsUpdateRecord
				case 'dnssec':
					//dnsSecDeleteRecord dnsSecAddRecord dnsSecListRecords
				case 'emailfw':
					//configureEmailForward
				case 'domainfw':
					//domainForward
				case 'regisns':
					//modifyRegisteredNameServer deleteRegisteredNameServer addRegisteredNameServer listRegisteredNameServers
				case 'whois':
					//contactDomainAssociate
				case 'epp':
					//retrieveAuthCode contactList->administrative

					//引入舊系統檔案，修改移植的
					$include_file = './app/controllers/domain/manage/include/'.$_GET['manage'].'.php';
					$panel_html = './app/views/domain/manage/include/'.$_GET['manage'].'.php';
				break;
				default:
					$include_file = './app/controllers/domain/manage/include/default.php';
					$panel_html = './app/views/domain/manage/include/default.php';
				break;
			}
			//var_dump($domain_info);
			if(file_exists($include_file)){
				require($include_file);
			}
		}
		else{
			$panel_html = './app/views/domain/manage/include/error.php';
			$error_info = $domain_info['detail'];
		}
	}
	else{
		$_Global['error_code'] = 403;
	}
}
else{
	header("Refresh: 1; url=".$_Global['URL']."/Domain/Manager");
}