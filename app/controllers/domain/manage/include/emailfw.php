<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}

$_HTML['note'] = '您可以使用此頁面管理域名的電子郵件轉發。每個域允許您最多100個轉發。';





if($_POST){
	if(@$_POST['FW_user']&&@$_POST['FW_to']){
		$email_FW_to = explode("\n",str_replace("\r","",$_POST['FW_to']));
		$result = $Namesilo->configureEmailForward($domain,$_POST['FW_user'],$email_FW_to);
		$_HTML['detail'] = $result['detail'];
	}

}
if(@$_GET['del']){
	$result = $Namesilo->deleteEmailForward($domain,$_GET['del']);
	$_HTML['detail'] = $result['detail'];
	header("Refresh: 0; url=".$_Global['URL']."/Domain/Manager/View?domain=".$domain."&manage=emailfw");
}



$result = $Namesilo->listEmailForwards($domain);
if($result['code'] != '300'){
	$_HTML['detail'] = $result['detail'];
}
else{
	$_HTML['mailfw_list'] =  '<table class="table table-hover align-items-center text-center" id="table"><thead><tr><th>E-mail</th><th>轉寄至</th><th style="width:80px;">Action</th></tr></thead><tbody>';
	if(@$result['addresses']){
		if(!$result['addresses']['email']){
			foreach($result['addresses'] as $data){
				$_HTML['mailfw_list'] .= show_list($data);
				// md5為了怕特殊符號
				$_HTML['js_arr'][md5($data["email"])] = gen_js_array($data);
			}
		}
		else{
			$_HTML['mailfw_list'] .= show_list($result['addresses']);
			$_HTML['js_arr'][md5($result['addresses']["email"])] = gen_js_array($result['addresses']);
		}

	}
	$_HTML['mailfw_list'] .= '</tbody></table>';
}

function show_list($data){
	if(is_array($data['forwards_to'])){
		$data['forwards_to'] = implode("<br>",$data['forwards_to']);
	}
	$action = '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#EditemailFW" data-whatever="'.md5($data['email']).'">Edit</button>';
	return '<tr><td>'.$data['email'].'</td><td>'.$data['forwards_to'].'</td><td>'.$action.'</td></tr>';
}

function gen_js_array($data){
	
	$email_user = explode('@',$data['email']);
	$data['email'] = $email_user['0'];
	if(is_array($data['forwards_to'])){
		$data['forwards_to'] = implode("\n",$data['forwards_to']);
	}
	return $data;
}

$js_data = json_encode(@$_HTML['js_arr']);
$_HTML['footer_js'] = 
<<<EOF
$('#EditemailFW').on('show.bs.modal', function (event) {
	var fw_email = $(event.relatedTarget).data('whatever')
	if(fw_email){
		var a = $js_data
		var data = a[fw_email]
		$('#FW_user').val(data.email)
		$('#FW_to').val(data.forwards_to)
		$('#remove_link').attr("href", location.search + '&del=' + data.email)
		$('#del_btn_div').show()
	}
	else{
		$('#FW_user').val('')
		$('#FW_to').val('')
		$('#del_btn_div').hide()
		$('#remove_link').attr("href", '')
	}

})
EOF;
