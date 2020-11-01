<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}
$_HTML['title'] = '帳務管理';

$database = new DB();
foreach($database->table('invoices')->where('uid',$_SESSION['login'])->get() as $data){
	switch($data['status']){
		case 'active':
			$status = '<span class="badge badge-pill badge-success">有效</span>';
		break;
		case 'draft':
			$status = '<span class="badge badge-pill badge-info">草稿</span>';
		break;
		case 'void':
			$status = '<span class="badge badge-pill badge-dark">作廢</span>';
		break;
		case 'paid':
			$status = '<span class="badge badge-pill badge-light">已付</span>';
		break;
		case 'expired':
			$status = '<span class="badge badge-pill badge-warning">過期</span>';
		break;
	}
	@$_data['table'] .= '<tr data-href="'.$_Global['URL'].'/Invoice/View?id='.$data['id'].'"><td>'.$data['id'].'</td><td>'.$data['date_create'].'</td><td>'.$data['date_due'].'</td><td>NT$ '.$data['total'].'</td><td>'.$status.'</td></a></tr>';
}