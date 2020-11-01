<?php 
if(!defined('IN_PF')) {
	exit('Access Denied');
}
if(@$_SESSION['login']){
	exit('<script>document.location.href="'.$_Global['URL'].'/Dashboard";</script>');
}

if($_POST){
	if(md5(base64_encode(@$_GET["hash"].'##'.$_SERVER["REMOTE_ADDR"]))!=@$_POST["hide"]||empty(@$_POST["hide"])){
		//驗證沒過
        $_Global['error_code'] = 403;
	}
	elseif(@$_COOKIE['hash'] != hash('ripemd160', $_GET['hash'])){
		// Cookie檢查沒過
		$_Global['error_code'] = 403;
	}
	elseif(@$_POST['username']||@$_POST['password']||@$_POST['email']){
		// 釣魚
		$_Global['error_code'] = 403;
    }
	else{
		if(!empty($_POST['dev_d_u'])&&!empty($_POST['dev_u_p'])){
			// try UC login function
			//list($uid, $username, $password, $email) = uc_user_login($_POST['dev_d_u'], $_POST['dev_u_p']);
			
			$uid="35";
			$username="s860304";
			$email="s860304@hotmail.com";
			// UID > 0 成功登入
			if($uid > 0) {

				$database = new DB();
				$user_info = $database->table('user')->where('uid',$uid)->select();
				$time = new DateTime();
				if(empty($user_info)){
					// 首次登入 需要建立必要資料
					$_SESSION['register'] = ['uid'=>$uid,'username'=>$username,'email'=>$email];
					header("Refresh: 0; url=".$_Global['URL']."/Register");
				}
				elseif(@$user_info['FA_key']){
					header("Refresh: 0; url=".$_Global['URL']."/Login/2FA");
				}
				else{
					// 執行登入
					$_SESSION['login'] = $uid;
					$_SESSION['username'] = $username;
					header("Refresh: 0; url=".$_Global['URL']."/Dashboard");
				}
			}
			else{
				$_HTML['error_txt'] = '帳號或密碼錯誤';
			}
		}
		if(empty($_POST['dev_d_u'])){
			$_HTML['error_txt'] = '請輸入帳號';
		}
		elseif(empty($_POST['dev_u_p'])){
			$_HTML['error_txt'] = '請輸入密碼';
		}
	}


}


$_HTML['hash'] = uniqid();
setcookie("hash", hash('ripemd160', $_HTML['hash']), time()+(8*60)); //登入頁面驗證有效8min
$_HTML['hash_check'] = md5(base64_encode($_HTML['hash'].'##'.$_SERVER["REMOTE_ADDR"]));
