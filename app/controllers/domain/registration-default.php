<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}
require './source/namesilo/namesilo.php';
//registration跟transfer同程式碼
$type = 'registration';
$_HTML['title'] = '域名註冊';

$database = new DB();
if($database->table('contact')->where('uid',$_SESSION['login'])->rows()==0){
	header("Refresh: 0; url=".$_Global['URL']."/Contact/List");
	echo '<script>alert("須先建立註冊人資料才可使用次功能")</script>';
}
foreach($database->table('tld')->get() as $data){
    @$_data['table'] .= '<tr><td>.'.$data['tld'].'</td><td>NT$ '.$data['registration'].'/年</td></tr>';
}

if(@$_GET['mod']=="check"){
	if (empty($_POST['domain'])) {
		// 額外 "-" 不能出現於頭尾、 "-" 不能同時出現於第3,4字元 交由api攔截
	   $error_info = '請輸入網址';
	}
	elseif(@$_SESSION['_cart_c'][$_POST['domain']]) {
		// 額外 "-" 不能出現於頭尾、 "-" 不能同時出現於第3,4字元 交由api攔截
	   $error_info = '網址已在購物車內';
	}
	elseif (!preg_match("/^[0-9a-z\-]{2,63}\.[a-z]+$/",$_POST['domain'])) {
		// 額外 "-" 不能出現於頭尾、 "-" 不能同時出現於第3,4字元 交由api攔截
	   $error_info = '域名格式不符系統設定';
	}
	else{
		$tlds = explode('.',$_POST['domain']);
		$database = new DB();
		$tlds_info = $database->table('tld')->where('tld',$tlds['1'])->select();
		if(empty($tlds_info)){
			$error_info = '後綴無效或目前無法註冊';
		}
		else{
			// 使用namesilo的api確認可否註冊
			$domain_check = new Namesilo_API();
			$api_check_result = $domain_check->check_domain_registration($_POST['domain']);
			if($api_check_result===true){
				//OK
				$_data['check_key'] = md5($_SERVER['REQUEST_TIME']);
				$_data['check_hash'] = md5($_data['check_key'].$_POST['domain'].$_data['check_key']);
			}
			else{
				$error_info = $api_check_result;
			}
		}
	}

	if(@!$error_info){
		// 可註冊
		// 覆寫變數 $View_file 讀取其他的內容
		$View_file = './app/views/domain/registration-to-cart.php';

		// 顯示價格
		$_data['domian_price'] = $tlds_info['registration'];
		$_data['domain'] = $_POST['domain'];

		// 域名聯絡人資料
		foreach($database->table('contact')->where('uid',$_SESSION['login'])->get() as $data){
			@$_HTML['domain_contact'] .= '<option value="'.$data['contact_id'].'">'.$data['fn'].' '.$data['em'].'</option>';
		}
	}
}


if(@$_GET['mod']=="add_to_cart"){
	if (@($_POST['hash']!=md5($_POST['key'].$_POST['domain'].$_POST['key']))) {
		//缺必要參數 正常瀏覽會自動填入的參數
		$_Global['error_code'] = '403';
	}
	elseif(is_numeric($_POST['year'])&&($_POST['year']>=1&&$_POST['year']<=10)){
		//驗證 hash 跟 domain 有且正確, 有正確申請年份
			$domain = $_POST['domain'];
			$year = (int)$_POST['year'];
			if(@$_POST['private']){
				$domain_private = 1;
			}
			else{
				$domain_private = 0;
			}
			$tlds = explode('.',$_POST['domain']);
			$database = new DB();
			$tlds_info = $database->table('tld')->where('tld',$tlds['1'])->select();
			$price = round($tlds_info['registration'] * $year);
			$_SESSION['cart'][] = ['type'=>'domain-reg','name'=>$domain,'contact_id'=>$_POST['contact_id'],'quantity'=>$year,'private'=>$domain_private,'price'=>$price];
			$_SESSION['_cart_c'][$_POST['domain']] = true;
			header("Refresh: 0; url=".$_Global['URL']."/Cart/View");
	}
}