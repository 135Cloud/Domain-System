<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}

$_HTML['created']		= $domain_info['created'];
$_HTML['expires']		= $domain_info['expires'];
$_HTML['status']		= $domain_info['status'];
$_HTML['traffic_type']	= $domain_info['traffic_type'];


switch($domain_info['traffic_type']){
	case 'Parked':
		$_HTML['traffic_type'] = '停放';
		break;
	case 'Forwarded':
		$_HTML['traffic_type'] = '轉發';
		break;
	case 'Custom DNS':
		$_HTML['traffic_type'] = '自訂DNS';
		break;
}
foreach(['email_verification_required',"locked","private"] as $feild){
	switch($domain_info[$feild]){
		case 'No':
			$_HTML[$feild] = '否';
			break;
		case 'Yes':
			$_HTML[$feild] = '是';
			break;
	}
}

if($domain_info['email_verification_required']=="Yes"&&isset($_GET['authemail'])){
	$auth_id = array();
	foreach($domain_info['contact_ids'] as $id){
		if(@!$auth_id[$id]){
			$Namesilo->emailVerification($id);
		}
	}
	echo '<script>alert(\'已送出驗證E-mail，請及時查收\');window.location.href=\''.$_SERVER['URL'].'Domain/Manager/View?domain='.$domain.'\';</script>';
	
}