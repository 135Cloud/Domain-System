<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}
$_HTML['title'] = '訂購方案';

$database = new DB();

if(round(@$_GET['pid'])==@$_GET['pid']&&isset($_GET['pid'])&&$_GET['pid']>0){
    $pid = $_GET['pid'];
}
else{
    header("Refresh: 0; url=".$_Global['URL']."/Service/List-Plans");
    exit();
}

$result = $database->table('plan_list')->where('id','=',$pid)->select();
if($result['quantity']<=0){
    $_HTML['error'] = '本方案無庫存';
    header("Refresh: 2; url=".$_Global['URL']."/Service/List-Plans");
}
elseif($result['id']){

    if(!empty($_POST)){

        if(preg_match("/([\w\-]+\.[\w\-]+)/", @$_POST['input_domain'])){//filter_var(@$_POST['input_domain'],FILTER_VALIDATE_DOMAIN)){
            $input_domain = $_POST['input_domain'];
        }
        elseif(preg_match("/([\w\-]+\.[\w\-]+)/", @$_POST['select_domain'])){//filter_var(@$_POST['select_domain'],FILTER_VALIDATE_DOMAIN)){
            $input_domain = $_POST['select_domain'];
        }
        else{
            $error = '未選擇欲使用網址或輸入格式錯誤';
        }
        if(@$input_domain){
            $check_domain = $database->table('service_list')->where('name','=',$input_domain)->get();
            if($check_domain->num_rows){
                $error = '網址已被使用';
            }
        }
        $cycle = $_POST['cyc'];
        if($result[$cycle]=='-1'){
            $error = '結算週期錯誤';
        }
        else{
            $fee = $result[$cycle];
            $quantity = filter_var($cycle, FILTER_SANITIZE_NUMBER_INT);
        }
        if(@$error){
            $_HTML['error'] = $error;
        }
        else{
            $_SESSION['cart'][] = ['type'=>'service','name'=>@$input_domain,'quantity'=>$quantity,'price'=>$fee,'plan'=>$pid];
			header("Refresh: 0; url=".$_Global['URL']."/Cart/View");
    
        }
    }



    $_HTML['Plan_name'] = $result['name'];

    $first = ' checked=""';

    // 產生付款週期選項
    foreach(['price_24m'=>"兩年",'price_12m'=>"每年",'price_3m'=>"每季",'price_1m'=>"每月"] as $felid =>$unit){
        if($result[$felid]!='-1'){
            switch($felid){
                case 'price_12m':
                    $price = $result[$felid] / 12 ;
                break;
                case 'price_24m':
                    $price = $result[$felid] / 24 ;
                break;
                case 'price_3m':
                    $price = $result[$felid] / 3 ;
                break;
                case 'price_1m':
                    $price = $result[$felid] / 1 ;
                break;

            }
            @$_HTML['cyc'] = '<div class="custom-control custom-radio"><input type="radio" id="Radio'.$felid.'" value="'.$felid.'" name="cyc" class="custom-control-input"'.$first.'><label class="custom-control-label" for="Radio'.$felid.'">'.$unit.'結算, 共 NT$ '.$result[$felid].' 元, 平均 NT$ '.round($price,1).' /月</label></div>'.$_HTML['cyc'];
            $first = '';
        }
    }

    // 產生網址列表
    foreach($database->table('domains')->where('uid','=',$_SESSION['login'])->get() as $data){
        @$_HTML['domain'] .= '<option value="'.$data['domain'].'">'.$data['domain'].'</option>';
    }
//var_dump($result);
}