<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}


$database = new DB();
$result = $database->table('user')->where('uid',$_SESSION['login'])->select();

include './source/GoogleAuthenticator/GoogleAuthenticator.php';
$ga = new PHPGangsta_GoogleAuthenticator();
$_HTML['title'] ='雙因素認證';
$panel_html = './app/views/profile/2fa/manage.php';
if(empty($result['FA_key'])){
    $panel_html = './app/views/profile/2fa/set.php';
    if($_POST){
		// 測試是否正常設定
        $secret = $_SESSION['temp_ga_secret'];
        $checkResult = $ga->verifyCode($secret, @$_POST['2fa'],"2");
        if ($checkResult){
            $_HTML['status'] = ' is-valid';
            $database->table('user')->where('uid',$_SESSION['login'])->update(['FA_key',$secret]);
            unset($_SESSION['temp_ga_secret']);
            header("Refresh: 1; url=".$_Global['URL']."/Dashboard");
        }
        else{
            $_HTML['status'] = ' is-invalid';
        }
    }
    else{
        $secret = $ga->createSecret('32');
        $_SESSION['temp_ga_secret'] = $secret;
    }
    $_HTML['2fa_key'] = $secret;
    $_HTML['2fa_img'] = $ga->getQRCodeGoogleUrl($_SESSION['username'], $secret,'135Cloud User Center');
}
else{
    $secret = $result['FA_key'];
    $checkResult = $ga->verifyCode($secret, @$_POST['2fa'],"2");
    if ($checkResult){
        $database->table('user')->where('uid',$_SESSION['login'])->update(['FA_key',"NULL"]);
        $_HTML['status'] = '2FA 已關閉';
        header("Refresh: 1; url=".$_Global['URL']."/Dashboard");
    }
    else{
        $_HTML['status'] = 'token 錯誤';
    }
    

}