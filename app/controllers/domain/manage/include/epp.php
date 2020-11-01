<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}
$_HTML['note'] = '將域名的 EPP 代碼通過電子郵件發送給管理連絡人。';
$_HTML['manage'] = '';





$contact_id = $domain_info['contact_ids']['administrative'];
$result = $Namesilo->contactGet($contact_id);
if($result['code']=='300'){
	//
	$_HTML['Email'] = $result['contact']['email'];
}
else{
	// fail
	$_HTML['detail'] = $result['detail'];
}


if(@$_POST['trans_out']){
	$result = $Namesilo->retrieveAuthCode($domain);
	$_HTML['detail'] = $result['detail'];
}