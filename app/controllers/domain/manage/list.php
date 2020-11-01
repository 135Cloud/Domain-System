<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}
$_HTML['title'] = '域名管理';


$database = new DB();
foreach($database->table('domains')->where('uid',$_SESSION['login'])->get() as $data){
    $now = new DateTime();
    $expires = new DateTime($data['expires']);
    if($data['created']=='9999-12-31'){
        $status = '<span class="badge badge-pill badge-info">new</span>';
        $data['created'] = '資料待更新';
        $data['expires'] = '資料待更新';
    }
    elseif($now<$expires){
        $status = '<span class="badge badge-pill badge-success">active</span>';
    }
    else{
        $status = '<span class="badge badge-pill badge-default">expire</span>';
    }
	@$_data['table'] .= '<tr data-href="'.$_Global['URL'].'/Domain/Manager/View?domain='.$data['domain'].'"><td>'.$data['domain'].'</td><td>'.$data['created'].'</td><td>'.$data['expires'].'</td><td>'.$status.'</td></tr>';
}