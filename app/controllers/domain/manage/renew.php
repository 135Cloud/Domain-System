<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}
$_HTML['title'] = '域名續費';
$database = new DB();
$now = new DateTime();

if(@$_GET['domain']){
	$data = $database->table('domains')->where('domain','=',strtolower($_GET['domain']))->where('uid','=',$_SESSION['login'])->select();
	if(!empty($data)){
        $expires = new DateTime($data['expires']);
        if((strtotime($data['expires']) - strtotime($now->format("Y-m-d")))/86400>=-21){
            //過期21天內

            $tlds = explode('.',$data['domain']);
            $tlds_info = $database->table('tld')->where('tld',$tlds['1'])->select();
            if(empty($tlds_info)){
                $error_info = '後綴無效或目前無法註冊';
            }
            $_data['domain'] = $data['domain'];
            $_data['domian_price'] = $tlds_info['registration'];
            $_data['check_key'] = md5($_SERVER['REQUEST_TIME']);
            $_data['check_hash'] = md5($_data['check_key'].$data['domain'].$_data['check_key']);

            $View_file      ='./app/views/domain/manage/renew-config.php';
        }
    }
}
else{
    foreach($database->table('domains')->where('uid',$_SESSION['login'])->get() as $data){
        $expires = new DateTime($data['expires']);
        $renew_link= '#';
        if($data['created']=='9999-12-31'){
            $status = '<span class="badge badge-pill badge-info">N/A</span>';
            $data['created'] = '資料待更新';
            $data['expires'] = '資料待更新';
        }
        elseif($now<$expires){
            $last = (abs(strtotime($data['expires']) - strtotime($now->format("Y-m-d")))/86400);
            $status = '<span class="badge badge-pill badge-success">還有 '.$last.' 天</span>';
            $renew_link = $_Global['URL'].'/Domain/Manager/Renewal?domain='.$data['domain'];
        }
        else{
            if((abs(strtotime($data['expires']) - strtotime($now->format("Y-m-d")))/86400)<=21){
                $last = (abs(strtotime($data['expires']) - strtotime($now->format("Y-m-d")))/86400);
                $status = '<span class="badge badge-pill badge-default">過期 '.$last.' 天</span>';
                $renew_link = $_Global['URL'].'/Domain/Manager/Renewal?domain='.$data['domain'];
            }
            else{
                $status = '<span class="badge badge-pill badge-default">已過期</span>';
            }
        }
        @$_data['table'] .= '<tr data-href="'.$renew_link.'"><td>'.$data['domain'].'</td><td>'.$data['created'].'</td><td>'.$data['expires'].'</td><td>'.$status.'</td></a></tr>';
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
			$tlds = explode('.',$_POST['domain']);
			$database = new DB();
			$tlds_info = $database->table('tld')->where('tld',$tlds['1'])->select();
			$price = round($tlds_info['registration'] * $year);
			$_SESSION['cart'][] = ['type'=>'domain-ren','name'=>$domain,'quantity'=>$year,'price'=>$price];
			$_SESSION['_cart_c'][$_POST['domain']] = true;
			header("Refresh: 0; url=".$_Global['URL']."/Cart/View");
	}
}