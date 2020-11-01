<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}

$_HTML['title'] = '更改密碼';


if($_POST){
	if($_POST['new_password'] == $_POST['check_password'] && !empty($_POST['old_password'])){
		$ucresult = uc_user_edit($_SESSION['username'], $_POST['old_password'] , $_POST['new_password'],'');
		switch($ucresult){
			case "1":
				$_HTML['notice'] = '更新成功';
				$_HTML['status'] = 'success';
				break;
			case "0":
				$_HTML['notice'] = '没有做任何修改';
				$_HTML['status'] = 'info';
				break;
			case "-1":
				$_HTML['notice'] = '舊密碼錯誤';
				$_HTML['status'] = 'danger';
				break;
			case "-4":
				$_HTML['notice'] = 'Email 格式有误';
				$_HTML['status'] = 'danger';
				break;
			case "-5":
				$_HTML['notice'] = 'Email 不允许注册';
				$_HTML['status'] = 'danger';
				break;
			case "-6":
				$_HTML['notice'] = '该 Email 已经被注册';
				$_HTML['status'] = 'danger';
				break;
			case "-7":
				$_HTML['notice'] = '没有做任何修改';
				$_HTML['status'] = 'info';
				break;
			case "-8":
				$_HTML['notice'] = '该用户受保护无权限更改';
				$_HTML['status'] = 'warning';
				break;
			default:
				$_HTML['notice'] = '系統回傳錯誤';
				$_HTML['status'] = 'warning';
				break;
		}
	}
}
