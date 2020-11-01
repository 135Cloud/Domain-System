<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}

$_HTML['title'] = '註冊人資料管理';
require './source/namesilo/namesilo.php';
$country_json = json_decode(file_get_contents("./data/ct.json"), true);
$fields_api_req = ['fn'=>'first_name','ln'=>'last_name','ad'=>'address','cy'=>'city','st'=>'state','zp'=>'zip','ct'=>'country','em'=>'email','ph'=>'phone'];
$fields_api_opt = ['cp'=>'company','ad2'=>'address2','fx'=>'fax'];



if(@is_numeric($_GET['id'])){
	$id = (int)$_GET['id'];
	$database = new DB();
	if($database->table('contact')->where('contact_id','=',$id)->rows()){
		$Namesilo = new Namesilo_API();


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
			$result = $Namesilo->contactUpdate($id,$query);
			if(@$result['code']!=300){
				// have error
				$error_info = $result['code'].' - '.$result['detail'];
			}
			else{
				$error_info = '已更新';
				$database = new DB();
				$database->table('contact')->where('contact_id','=',$id)->update([	['fn',$_POST['first_name']],
																					['cp',@$_POST['company']],
																					['em',$_POST['email']]]);
				header("Refresh: 1; url=".$_Global['URL']."/Contact/List");
			}
		}




		$res = $Namesilo->contactGet($id);
		if($res['code']!=300){
			$error_info = $res['code'].' - '.$res['detail'];
		}
		elseif(!$_POST){
			foreach($res['contact'] as $key => $data){
				if(!empty($data)){
					$_POST[$key] = $data;
				}
			}
		}


		if($database->table('contact')->where('uid','=',$_SESSION['login'])->rows()>1){
			$remove_btn = '<a href="?id='.$id.'&del='.md5('del.'.$id).'" class="btn btn-danger btn-icon-split float-right"><span class="text">移除聯絡人資料</span></a>';
			if(@$_GET['del']==md5('del.'.$id)){
				$result = $Namesilo->contactDelete($id);
				if(@$result['code']!=300){
					// have error
					$error_info = $result['code'].' - '.$result['detail'];
				}
				else{
					$error_info = '已刪除';
					$database->table('contact')->where('contact_id','=',$id)->delete();
					header("Refresh: 1; url=".$_Global['URL']."/Contact/List");
				}
			}
		}
		else{
			$remove_btn = '<a href="#" class="btn btn-light btn-icon-split float-right"><span class="text">移除聯絡人資料</span></a>';
		}


	}
	else{
		// 不存在
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