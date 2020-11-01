<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}

$_HTML['title'] = '帳戶餘額儲值';

if($_POST){
    if(!is_numeric($_POST['amount'])){
        $error = '僅可輸入數字';
    }
    elseif($_POST['amount']!=(int)$_POST['amount']){
        $error = '僅可輸入整數';
    }
    elseif($_POST['amount']<500){
        $error = '儲值金額不可小於 500 元';
    }
    else{
        $database = new DB();
        $date = new DateTime();
        $date->modify('+7 day');
        $inv_id = $database->table('invoices')->insert_GetID([  'uid'=>$_SESSION['login'],
                                                                'status'=>'active',
                                                                'note'=>'FUNDS',
                                                                'date_due'=> $date->format('Y-m-d') ,
                                                                'total'=>$_POST['amount']]);
        $database->table('invoices_lines')->insert(['id'=>$inv_id,'text'=>'帳戶儲值','quantity'=>$_POST['amount'],'price'=>$_POST['amount']]);
        
        header('Location: '.$_Global['URL'].'/Invoice/View?id='.$inv_id);
    }
    
}
