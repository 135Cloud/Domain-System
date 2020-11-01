<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}
$_HTML['title'] = '註冊人資料新增';
require './source/namesilo/namesilo.php';
$country_json = json_decode(file_get_contents("./data/ct.json"), true);
$fields_api_req = ['fn'=>'first_name','ln'=>'last_name','ad'=>'address','cy'=>'city','st'=>'state','zp'=>'zip','ct'=>'country','em'=>'email','ph'=>'phone'];
$fields_api_opt = ['cp'=>'company','ad2'=>'address2','fx'=>'fax'];

if($_POST){
	foreach($fields_api_req as $key =>$field){
		$query[$key] = $_POST[$field];
	}
	foreach($fields_api_opt as $key =>$field){
		if(@$_POST[$field]){
			$query[$key] = $_POST[$field];
		}
	}

	$Namesilo = new Namesilo_API();
	$result = $Namesilo->contactAdd($query);
	if(@$result['code']!=300){
		// have error
		$error_info = $result['code'].' - '.$result['detail'];
	}
	else{
		$error_info = '已新增';
		$database = new DB();
		$database->table('contact')->insert(['uid'=>$_SESSION['login'],
											 'contact_id'=>$result['contact_id'],
											 'fn'=>$_POST['first_name'],
											 'cp'=>@$_POST['company'],
											 'em'=>$_POST['email']]);
											 
		header("Refresh: 1; url=".$_Global['URL']."/Contact/List");
	}
	 


}

$_HTML['ct'] = '<select class="form-control" name="country">';
foreach($country_json as $data){
	if(@$_POST['country']==$data["value"]){
		$_HTML['ct'] .= '<option value="'.$data["value"].'" selected>'.$data["txt"].'</option>';
	}
	else{
		$_HTML['ct'] .= '<option value="'.$data["value"].'">'.$data["txt"].'</option>';
	}
}
$_HTML['ct'] .= '</select>';