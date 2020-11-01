<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}
$database = new DB();
$result = $database->table('profile')->where('uid',$_SESSION['login'])->select();

$_HTML['title']='修改帳號聯繫資訊';
if($_POST){

    if(!empty($_POST['contactName'])&&!empty($_POST['contactEmail'])){
        $email_domain = explode("@",$_POST['contactEmail']);
        if(@!checkdnsrr($email_domain[1],"MX")){
            $_HTML['error'] = 'Email 錯誤';
        }
    }
    else{
        $_HTML['error'] = '欄位未輸入';

    }
    if(preg_match("/^09[0-9]{8}$/", $_POST['dev_phone'])){
    }
    elseif(preg_match("/^\+[1-9]{1}[0-9]{10,15}$/", $_POST['dev_phone'])){
    }
    else{
        $_HTML['error'] = '手機錯誤';
    }
	
	if(@!$_HTML['error']){
		$database->table('profile')->where('uid',$_SESSION['login'])->update([	['name',$_POST['contactName']],
																				['email',$_POST['contactEmail']],
																				['phone',$_POST['dev_phone']]]);
	}
}
$profile = $database->table('profile')->where('uid',$_SESSION['login'])->select();

if(preg_match("/^9[0-9]{8}$/", $profile['phone'])){
	//台灣手機號碼 09xxxxxxxx for SMS
	$profile['phone'] = '0'.$profile['phone'];
}
$_HTML['contactName'] = $profile['name'];
$_HTML['contactEmail'] = $profile['email'];
$_HTML['dev_phone'] = $profile['phone'];