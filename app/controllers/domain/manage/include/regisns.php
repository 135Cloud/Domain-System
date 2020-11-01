<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}

if($_POST){
	if(@$_POST['ips']&&@$_POST['host']){
		$IP_list = explode("\n",str_replace("\r","",$_POST['ips']));
		$result = $Namesilo->modifyRegisteredNameServer($domain,@$_POST['ohost'],@$_POST['host'],$IP_list);
		$_HTML['detail'] = $result['detail'];
	}
}
if(@$_GET['del']){
	$result = $Namesilo->deleteRegisteredNameServer($domain,$_GET['del']);
	$_HTML['detail'] = $result['detail'];
	header("Refresh: 0; url=".$_Global['URL']."/Domain/Manager/View?domain=".$domain."&manage=regisns");
}


$result = $Namesilo->listRegisteredNameServers($domain);
if($result['code'] != '300'){
	$_HTML['detail'] = $result['detail'];
}
else{
	$_HTML['dns_list'] =  '<table class="table table-hover align-items-center text-center" id="table"><thead><tr><th>Host</th><th>IP</th><th style="width:80px;">Action</th></tr></thead><tbody>';
	if(@$result['hosts']){
		if(!@$result['hosts']['host']){
			foreach($result['hosts'] as $data){
				$_HTML['dns_list'] .= show_list($data);
				// md5為了怕特殊符號
				$_HTML['js_arr'][md5($data["host"])] = gen_js_array($data);
			}
		}
		else{
			$_HTML['dns_list'] .= show_list($result['hosts']);
			$_HTML['js_arr'][md5($result['hosts']["host"])] = gen_js_array($result['hosts']);
		}

	}
	$_HTML['dns_list'] .= '</tbody></table>';
}


function show_list($data){
	if(is_array($data['ip'])){
		$data['ip'] = implode("<br>",$data['ip']);
	}
	$action = '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editRegDNS" data-whatever="'.md5($data['host']).'">Edit</button>';
	
	return '<tr><td>'.$data['host'].'</td><td>'.$data['ip'].'</td><td>'.$action.'</td></tr>';
}

function gen_js_array($data){
	
	if(is_array($data['ip'])){
		$data['ip'] = implode("\n",$data['ip']);
	}
	return $data;
}


$js_data = json_encode(@$_HTML['js_arr']);
$_HTML['footer_js'] = 
<<<EOF
$('#editRegDNS').on('show.bs.modal', function (event) {
	var ns = $(event.relatedTarget).data('whatever')
	if(ns){
		var a = $js_data
		var data = a[ns]
		$('#reg_host').val(data.host)
		$('#reg_ip').val(data.ip)
		$('#RegDNS_old').val(data.host)
		$('#remove_link').attr("href", location.search + '&del=' + data.host)
		$('#del_btn_div').show()
	}
	else{
		$('#reg_host').val('')
		$('#reg_ip').val('')
		$('#RegDNS_old').val('')
		$('#del_btn_div').hide()
		$('#remove_link').attr("href", '')
	}

})
EOF;