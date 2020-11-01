<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}

$_HTML['title'] = '帳戶資金資訊';
$database = new DB();
$funds = $database->table('funds')->where('uid',$_SESSION['login'])->select();
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://besv.net/dzapi.php?mod=credit&u='.$_SESSION['login']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch); 
curl_close($ch);
$result = json_decode($output, TRUE);

$_HTML['value1'] = $funds['funds'];
$_HTML['value2'] = $result['extcredits5'];
if(empty($result['extcredits5'])){
    $_HTML['value2'] = '資料錯誤';
}