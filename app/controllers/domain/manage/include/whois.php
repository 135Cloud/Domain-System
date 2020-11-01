<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}

$_HTML['note'] = '您可以在此修改 WHOIS 相關資訊，如域名註冊人、聯絡人等資訊，以及是否要開啟隱私保護。';

switch($domain_info['private']){
	case 'Yes':
		//鎖定
		$_HTML['private_status'] = '<span class="btn btn-success"><i class="fas fa-user-shield"></i> 開啟</span>';
		$_HTML['switch'] = ' checked=""';
	break;
	case 'No':
		//尚未鎖定
		$_HTML['private_status'] = '<span class="btn btn-warning"><i class="fas fa-user"></i> 關閉</span>';
		
	break;
}
$contact_list = [];
foreach($database->table('contact')->where('uid',$_SESSION['login'])->get() as $data){
	$contact_id = $data['contact_id'];
	$contact_list[$contact_id] = ['fn'=>$data['fn'],'cp'=>$data['cp'],'em'=>$data['em']];
}



if($_POST){
	//$database;
	var_dump($_POST);
	foreach(['registrant','administrative','technical','billing'] as $reg){
		$contact_id = $_POST[$reg];
		if(!$contact_list[$contact_id]){
			exit();
		}
	}

	$result = $Namesilo->contactDomainAssociate($domain,$_POST['registrant'],$_POST['administrative'],$_POST['technical'],$_POST['billing']);

	$_HTML['detail'] = $result['detail'];

	if(@empty($_POST['whois_private'])&&$domain_info['private']=='Yes'){
		$Namesilo->modifyPrivacy($domain,'Remove');
	}
	elseif(@isset($_POST['whois_private'])&&$domain_info['private']=='No'){
		$Namesilo->modifyPrivacy($domain,'Add');
	}

	header("Refresh: 1");
}

$_HTML['whois_info'] = '';
foreach($domain_info['contact_ids'] as $key => $data){
	$conn_info = $Namesilo->contactGet($data);
	$u_info = $conn_info['contact'];
	$_HTML['whois_info'] .= strtoupper($key).': <br>';
	$_HTML['whois_info'] .= $u_info['first_name'].' '.$u_info['last_name'].'<br>';
	$_HTML['whois_info'] .= $u_info['address'].'<br>';
	if(!empty($u_info['address2'])){
		$_HTML['whois_info'] .= $u_info['address2'].'<br>';
	}
	$_HTML['whois_info'] .= $u_info['city'].', '.$u_info['state'].' '.$u_info['zip'].'<br>';
	$_HTML['whois_info'] .= $u_info['country'].'<br>';
	$_HTML['whois_info'] .= $u_info['email'].'<br>';
	$_HTML['whois_info'] .= 'Phone: '.$u_info['phone'].'<br>';
	if(!empty($u_info['fax'])){
		$_HTML['whois_info'] .= 'Fax: '.$u_info['fax'].'<br>';
	}
	$_HTML['whois_info'] .= '<br>';
	$contact_list[$data]['select'] = strtolower($key);
}

foreach($contact_list as $id =>$data){
	if($data['cp']){
		$option_text = $data['fn'].' ('.$data['cp'].') '.$data['em'];
	}
	else{
		$option_text = $data['fn'].' '.$data['em'];
	}
	foreach(['registrant','administrative','technical','billing'] as $reg){
		if($data['select'] == $reg){
			@$_HTML[$reg] .= '<option value="'.$id.'" selected>'.$option_text.'</option>';
		}
		else{
			@$_HTML[$reg] .= '<option value="'.$id.'">'.$option_text.'</option>';
		}
	}
}


