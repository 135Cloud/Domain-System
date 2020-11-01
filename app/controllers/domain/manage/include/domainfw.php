<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}

if($_POST){
	if($_POST['protocol']=='1'){
		$_POST['protocol'] = 'http';
	}
	elseif($_POST['protocol']=='2'){
		$_POST['protocol'] = 'https';
	}
	else{
		exit();
	}
	if($_POST['forward_type']=='999'){
		$_POST['forward_type'] = 'cloaked';
	}
	$result = $Namesilo->domainForward($domain,$_POST['protocol'],$_POST['address'],$_POST['forward_type']);
	$_HTML['detail'] = $result['detail'];
	
}


if($domain_info['forward_url']!='N/A'){
	//有轉發
	$protocol = explode('://',$domain_info['forward_url']);
	if($protocol['0']=='http'){
		$select1['0'] = ' selected';
	}
	elseif($protocol['0']=='https'){
		$select1['1'] = ' selected';
	}
	
	if($domain_info['forward_type']=='Permanent Forward (301)'){
		$select2['0'] = ' selected';
	}
	elseif($domain_info['forward_type']=='Temporary Forward (302)'){
		$select2['1'] = ' selected';
	}
	else{
		$select2['2'] = ' selected';
	}
	
	
	
	$input_address = $protocol['1'];
}


$protocol_select = '<option value="2"'.@$select1['1'].'>HTTPS://</option><option value="1"'.@$select1['0'].'>HTTP://</option>';
$method_select = '<option value="301"'.@$select2['0'].'>永久轉發（301）</option><option value="302"'.@$select2['1'].'>暫時轉發（302）</option><option value="999"'.@$select2['2'].'>隱藏轉發（iframe）</option>';


