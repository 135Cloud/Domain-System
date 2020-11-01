<?php 
if(!defined('IN_PF')) {
	exit('Access Denied');
}

if(!$_SESSION['register']){
    $_Global['error_code'] = 404;
}
elseif(@$_POST){
    
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
        $database = new DB();
        //$_SESSION['register'] = ['uid'=>$uid,'username'=>$username,'email'=>$email];
        $insert = $_SESSION['register'];
        $insert['sys_id'] = $_SESSION['register']['uid'];
        $database->table('user')->insert($insert);
        $database->table('profile')->insert(['uid'=>$_SESSION['register']['uid'],'phone'=>$_POST['dev_phone'],'email'=>$_POST['contactEmail'],'name'=>$_POST['contactName']]);
        $database->table('funds')->insert(['uid'=>$_SESSION['register']['uid']]);
        $_SESSION['login'] = $_SESSION['register']['uid'];
        $_SESSION['username'] = $_SESSION['register']['username'];
		header("Refresh: 0; url=".$_Global['URL']."/Dashboard");
    }
}




$_HTML['hash'] = uniqid();
setcookie("hash", hash('ripemd160', $_HTML['hash']), time()+(10*60)); //頁面驗證有效10min
$_HTML['hash_check'] = md5(base64_encode($_HTML['hash'].'##'.$_SERVER["REMOTE_ADDR"]));