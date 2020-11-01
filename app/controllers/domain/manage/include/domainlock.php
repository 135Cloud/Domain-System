<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}

$_HTML['note'] = '按「送出」按鈕將解鎖域名。當域名被解鎖時，將可以將該域名轉移到其他註冊商。我們強烈建議您鎖定所有域名，並在轉移前才解鎖，避免在未經您授權狀況下的將域名轉移。';
$_HTML['manage'] = '<p class="lead">目前域名鎖定狀態為：';

if($_POST){
	if($_POST['lock']=='unlock'){
		$result = $Namesilo->domainlock($domain);
	}
	elseif($_POST['lock']=='lock'){
		$result = $Namesilo->domainlock($domain,true);
	}
	else{
		exit();
	}
	

	if($result['code']=='300'){
		if($_POST['lock']=='unlock'){
			$domain_info['locked'] = 'No';
		}
		if($_POST['lock']=='lock'){
			$domain_info['locked'] = 'Yes';
		}
	}
	$_HTML['detail'] = $result['detail'];
}

switch($domain_info['locked']){
	case 'Yes':
		//鎖定
		$_HTML['manage'] = '<span class="btn-lg btn-success"><i class="fas fa-lock"></i> 鎖定</span></p><input name="lock" value="unlock" hidden><button type="submit" class="btn btn-primary">解除</button>';
		break;
	case 'No':
		//尚未鎖定
		$_HTML['manage'] = '<span class="btn-lg btn-warning"><i class="fas fa-unlock"></i> 解除</span></p><input name="lock" value="lock" hidden><button type="submit" class="btn btn-primary">鎖定</button>';
		break;
}