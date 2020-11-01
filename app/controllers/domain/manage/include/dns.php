<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}

if(@$_POST){
	//var_dump($_POST);
	if($_POST['nhost']==$domain||$_POST['nhost']=="@"){
		$_POST['nhost'] = '';
	}
	if(@$_POST['edit']){
		$rrid = $_POST['edit'];
		$array = ['rrhost'=>$_POST['nhost'],
				  'rrvalue'=>$_POST['nvalue'],
				  'rrdistance'=>$_POST['ndistance'],
				  'rrttl'=>$_POST['nttl']];
		$Update = $Namesilo->dnsUpdateRecord($domain,$array,$rrid);
	}
	else{
		$array = ['rrtype'=>@$_POST['type'],
				  'rrhost'=>@$_POST['nhost'],
				  'rrvalue'=>@$_POST['nvalue'],
				  'rrttl'=>@$_POST['nttl']];
		$Update = $Namesilo->dnsUpdateRecord($domain,$array);
	}
	if($Update['code']==300){
		$result = '更新/新增成功';
	}
	else{
		$result = $Update['detail'];
	}
}
if(@$_GET['del']){
	$del = $Namesilo->dnsDeleteRecord($domain,$_GET['del']);
	header("Refresh: 0; url=".$_Global['URL']."/Domain/Manager/View?domain=".$domain."&manage=dns");
}




$dns_record = $Namesilo->dnsListRecords($domain);
if($dns_record['code']=="300"){
	$_HTML['dns_list'] =  '<table class="table table-hover align-items-center text-center" id="table"><thead><tr><th>Type</th><th>Name</th><th>Value</th><th>TTL</th><th style="width:120px;">Action</th></tr></thead><tbody>';

	foreach($dns_record['resource_record'] as $data){
		$_HTML['dns_list'] .= show_list($data);
		$_HTML['js_arr'][md5($data["record_id"])] = gen_js_array($data,$domain);
	}
	$_HTML['dns_list'] .= '</tbody></table>';
}


function show_list($data){
	$action = '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editDNSRecord" data-whatever="'.md5($data['record_id']).'">Edit</button>';
	return '<tr><td>'.$data['type'].'</td><td>'.$data['host'].'</td><td>'.$data['value'].'</td><td>'.$data['ttl'].'</td><td>'.$action.'</td></tr>';
}

function gen_js_array($data,$domain){
	unset($data['record_id']);
	$data['host'] = str_replace(".".$domain,"",$data['host']);
	if($data['host']==$domain){
		$data['host'] = "@";
	}
	if(empty($data['distance'])){
		$data['distance'] = NULL;
	}
	return $data;
}

$js_data = json_encode($_HTML['js_arr']);
$_HTML['footer_js'] = 
<<<EOF
$('#editDNSRecord').on('show.bs.modal', function (event) {
	var a = $js_data
	var dns_id = $(event.relatedTarget).data('whatever')
	var data = a[dns_id]
	$('#DNS_type').val(data.type)
	$('#DNS_name').val(data.host)
	$('#DNS_value').val(data.value)
	$('#DNS_ttl').val(data.ttl)
	$('#DNS_distance').val(data.distance)
	$('#DNS_edit_check').val(dns_id)
	$('#remove_link').attr("href", location.search + '&del=' + dns_id)
	if(data.type=="MX"){
		console.log(data);
		$('#DNS_distance_div').show()
	}
	else{
		$('#DNS_distance_div').hide()
	}
})
$("#NSType").change(function ChangeType(){switch($("#NSType").val()){case "A":$("#dnsvalue").attr("placeholder", "The IPv4 Address");break;case "AAAA":$("#dnsvalue").attr("placeholder", "The IPv6 Address");break;case "MX":case "CNAME":$("#dnsvalue").attr("placeholder", "The Target Hostname");break;case "TXT":$("#dnsvalue").attr("placeholder", "Content");break;}});
EOF;
