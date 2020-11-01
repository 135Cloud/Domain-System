<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}
$_HTML['title'] = '方案列表';

$database = new DB();
if(round(@$_GET['gid'])==@$_GET['gid']&&isset($_GET['gid'])&&$_GET['gid']>0){
    $gid = $_GET['gid'];
}
else{
    $gid = "1";
}

foreach($database->table('plan_group')->get() as $data){

    if($gid==$data['id']){
        $group[] = '<b>'.$data['name'].'</b>';

    }elseif($data['display']){
        $group[] = '<a href="?gid='.$data['id'].'">'.$data['name'].'</a>';
    }
}

$_HTML['group'] = @implode(' | ',$group);


foreach($database->table('plan_list')->where('plan_group','=',$gid)->get() as $data){
    
    $title = '<div class="card bg-info text-white shadow"><div class="h4 card-body">'.$data['name'].'</div></div><br>';
    
    $price = '<hr>';
    foreach(['price_1m'=>"月",'price_3m'=>"季",'price_12m'=>"年",'price_24m'=>"2年"] as $felid =>$unit){
        if($data[$felid]!='-1'){
            $price .= '<p><b class="h4 mb-0 font-weight-bold text-gray-800">NT$ '.$data[$felid].'</b>/<small class="text-muted">'.$unit.'</small></p>';
        }

    }

    if($data['quantity']<=0){
        $btn = '<a class="btn btn-light btn-block" disable>Out of stock</a>';
    }else{
        $btn = '<a class="btn btn-primary btn-block" href="'.$_Global['URL'].'/Service/ConfProduct?pid='.$data['id'].'">Order</a>';
    }
    @$_HTML['list'] .= '<div class="col-lg-3 mb-4"><div class="card"><div class="card-body text-center">'.$title.$data['info'].$price.$btn.'</div></div></div>';
}