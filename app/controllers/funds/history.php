<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}

$_HTML['title'] = '瀏覽餘額記錄';

$database = new DB();
foreach($database->table('funds_his')->where('uid',$_SESSION['login'])->get() as $data){
	@$_data['table'] .= '<tr><td>'.$data['update_at'].'</td><td>'.$data['why'].'</td><td>'.$data['modify'].'</td><td>NT$ '.$data['result'].'</td></tr>';
}
