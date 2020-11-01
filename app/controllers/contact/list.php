<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}
$_HTML['title'] = '註冊人資料管理';

$database = new DB();
foreach($database->table('contact')->where('uid',$_SESSION['login'])->get() as $data){
    if($data['cp']==null){
        // 無公司
        $data['cp'] = 'N/A';
    }
    $link = $_Global['URL'].'/Contact/Manage?id='.$data['contact_id'];
    
    @$_data['table'] .= '<tr data-href="'.$link.'"><th>'.$data['fn'].'</th><th>'.$data['cp'].'</th><th>'.$data['em'].'</th></a></tr>';
}

