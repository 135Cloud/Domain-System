<?php 
if(!defined('IN_PF')) {
	exit('Access Denied');
}

$_HTML['title'] = 'Dashboard';
$database = new DB;

foreach($database->table('service_list')->where('uid',$_SESSION['login'])->limit(5)->get() as $data){
	$plan_info = $database->table('plan_list')->where('id',$data['plan_id'])->select(); 
	@$_HTML['service'] .= '<tr data-href="'.$_Global['URL'].'/Service/Details?id='.$data['id'].'"><td>'.$plan_info['name'].'<br><small id="Help" class="form-text text-muted">'.$data['name'].'</small></td><td>'.$data['create_at'].'</td><td>'.$data['expired'].'</td></tr>';
}


foreach($database->table('domains')->where('uid',$_SESSION['login'])->limit(5)->ASC('expires')->get() as $data){
	if($data['created']=='9999-12-31'){
        $data['created'] = '資料待更新';
        $data['expires'] = '資料待更新';
    }
	@$_HTML['domain'] .= '<tr data-href="'.$_Global['URL'].'/Domain/Manager/View?domain='.$data['domain'].'"><td>'.$data['domain'].'</td><td>'.$data['created'].'</td><td>'.$data['expires'].'</td></tr>';
}

$fee = 0;
$i = 0;
foreach($database->table('invoices')->where('uid',$_SESSION['login'])->where('date_due','>=','CURRENT_DATE')->where('status','active')->get() as $data){
	$fee += $data['total']-$data['paid'];
	$i += 1;
}
$_HTML['invoice_count'] = $i;

if($fee>=0){
	$_HTML['invoice'] = '您有'.$i.'筆即將逾期帳單，總共'.$fee.'元。請盡速前往付款避免服務失效';
}
else{
	$_HTML['invoice'] = '您無尚未逾期帳單，前往查看全部帳單資訊。';
}



$_HTML['domains_row'] = $database->table('domains')->where('uid',$_SESSION['login'])->where('expires','>=','CURRENT_DATE')->rows();
$_HTML['service_row'] = $database->table('service_list')->where('uid',$_SESSION['login'])->where('expired','>=','CURRENT_DATE')->rows();

if(empty($_HTML['service'])){
	$_HTML['service'] = '<tr><td colspan="3" class="text-center">沒有可用的訂閱資訊</td></tr>';
}
if(empty($_HTML['domain'])){
	$_HTML['domain'] = '<tr><td colspan="3" class="text-center">沒有已申請的網址資訊</td></tr>';
}