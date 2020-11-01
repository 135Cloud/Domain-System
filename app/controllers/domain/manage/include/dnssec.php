<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}

$_HTML['note'] = '您可以使用此頁來管理域的 DS 記錄。本頁面僅於您要設定 DNSSEC 的 DS 記錄時才會用到。';

$digestType_array = [	'1'=>'SHA-1',
						'2'=>'SHA-256',
					   '3'=>'GOST R 34.11-94',
					   '4'=>'SHA-384'];

$alg_array = [	'1'=>'RSA/MD5',
				'2'=>'Diffie-Hellman',
				'3'=>'DSA/SHA-1',
				'4'=>'Elliptic Curve',
				'5'=>'RSA/SHA-1',
				'6'=>'DSA-NSEC3-SHA1',
				'7'=>'RSASHA1-NSEC3-SHA1',
				'8'=>'RSA/SHA-256',
				'10'=>'RSA/SHA-512',
				'12'=>'ECC-GOST',
				'13'=>'ECDSA Curve P-256 with SHA-256',
				'14'=>'ECDSA Curve P-384 with SHA-384',
				'252'=>'Indirect',
				'253'=>'Private DNS',
				'254'=>'Private OID'];


if(@$_POST['digest']&&$_POST['digestType']&&$_POST['alg']){
	if(@$digestType_array[$_POST['digestType']]&&$alg_array[$_POST['alg']]){
		$result = $Namesilo->dnsSecAddRecord($domain,$_POST['digest'],$_POST['keyTag'],$_POST['digestType'],$_POST['alg']);
		if($result['code']!='300'){
			$_HTML['detail']['txt'] = $result['detail'];
			$_HTML['detail']['status'] = 'alert-danger';
		}
		else{
			$_HTML['detail']['txt'] = '新增成功';
			$_HTML['detail']['status'] = 'alert-primary';
		}
	}	
}


if(@$_GET['delect']){
	
	if($_GET['delect']==md5($_GET['digest'].$_GET['keyTag'])){
		$Namesilo->dnsSecDeleteRecord($domain,$_GET['digest'],$_GET['keyTag'],$_GET['digestType'],$_GET['alg']);
		header("Refresh: 0; url=".$_Global['URL']."/Domain/Manager/View?domain=".$domain."&manage=dnssec");
	}
	else{
		$_Global['error_code'] = '403';
	}
}



$result = $Namesilo->dnsSecListRecords($domain);
if($result['code'] != '300'){
	$_HTML['manage'] = $result['detail'];
}
else{
	if(!empty($result['ds_record'])){
		$_HTML['dnssec_list'] =  '<table class="table table-hover align-items-center text-center" id="table"><thead><tr><th style="width:60%">摘要<br><small>Digest</small></th><th style="width:10%">金鑰標記<br><small>Key Tag</small></th><th style="width:10%">摘要類型<br><small>Digest Type</small></th><th style="width:10%">演算法<br><small>Algorithm</small></th><th style="width:120px;">Action</th></tr></thead><tbody>';

		$data = $result['ds_record'];

		$action = '<a href="'.$_Global['URL'].'/Domain/Manager/View?domain='.$domain.'&manage=dnssec&delect='.md5($data['digest'].$data['key_tag']).'&digest='.$data['digest'].'&keyTag='.$data['key_tag'].'&alg='.$data['algorithm'].'&digestType='.$data['digest_type'].'" class="btn btn-primary btn-sm" onclick="confirm(\'確定要刪除紀錄？\')">Delete</button>';
		$_HTML['dnssec_list'] .= '<tr><td>'.$data['digest'].'</td><td>'.$data['digest_type'].'</td><td>'.$data['algorithm'].'</td><td>'.$data['key_tag'].'</td><td>'.$action.'</td></tr>';


		
		$_HTML['dnssec_list'] .= '</tbody></table>';
		
	}
	else{
		$_HTML['dnssec_list'] = '目前沒有相關記錄';
	}


	foreach($digestType_array as $key => $txt){
		$select = '';
		if(@$_POST['digestType']==$key){
			$select = 'selected';
		}
		@$_HTML['digestType_select'] .= '<option value="'.$key.'"'.$select.'>'.$key.' ('.$txt.')</option>';
	}
	foreach($alg_array as $key => $txt){
		$select = '';
		if(@$_POST['alg']==$key){
			$select = 'selected';
		}
		@$_HTML['alg_select'] .= '<option value="'.$key.'"'.$select.'>'.$key.' ('.$txt.')</option>';
	}
}












/*
if(@$_GET['del']){
	$data = [];
	$base = base64_decode(@$_GET['del']);
	foreach(explode('&',$base) as $temp){
		$split = explode('=',$temp);
		$data[$split['0']] = $split['1'];
	}
	$action = 'dnsSecDeleteRecord';
	$query = $default_namesilo;
	$query['domain'] = @$_GET['domain'];
	$query['digest'] = $data['digest'];
	$query['keyTag'] = $data['keyTag'];
	$query['digestType'] = $data['digest_type'];
	$query['alg'] = $data['alg'];
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $namesilo_api.$action.'?'.http_build_query($query));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($ch); 
	curl_close($ch);
	$result = @simplexml_load_string($output);
	$result = json_decode(json_encode($result), TRUE);
	$_HTML['status'] = 'callout callout-success';
	if($result['reply']['code'] != '300'){
		$_HTML['status'] = 'callout callout-danger';
	}
	$_HTML['detail'] = $result['reply']['detail'];
	echo '<script Language="JavaScript">setTimeout("location.href=\''.$_SERVER['URL'].'/domain/manage?domain='.@$_GET['domain'].'&action=dnssec\'",800);</script>';
}
else{
	if($_POST){
		// 新增
		print_r($_POST);
		if(@$digestType_array[$_POST['digestType']]&&$alg_array[$_POST['alg']]){
			$action = 'dnsSecAddRecord';
			$query = $default_namesilo;
			$query['domain'] = @$_GET['domain'];
			$query['digest'] = $_POST['digest'];
			$query['keyTag'] = $_POST['keyTag'];
			$query['digestType'] = $_POST['digestType'];
			$query['alg'] = $_POST['alg'];
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $namesilo_api.$action.'?'.http_build_query($query));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch); 
			curl_close($ch);
			$result = @simplexml_load_string($output);
			$result = json_decode(json_encode($result), TRUE);
			$_HTML['status'] = 'callout callout-success';
			if($result['reply']['code'] != '300'){
				$_HTML['status'] = 'callout callout-danger';
			}
			$_HTML['detail'] = $result['reply']['detail'];
		}
			
	}
	
	
	$_HTML['manage'] = '<div class="alert alert-info alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-info"></i> 免責聲明 DISCLAIMER</h4>當您在設定 DS 記錄時，您的 DNS 伺服器未正確設定與其對應之記錄時，您的網址將無法正確解析。<br>如果您對 DNSSEC 有疑問, 或者如果您在修改 DS 記錄後遇到問題, 則需要與主機託管商聯繫。</div>';
	$action = 'dnsSecListRecords';
	$query = $default_namesilo;
	$query['domain'] = @$_GET['domain'];
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $namesilo_api.$action.'?'.http_build_query($query));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($ch); 
	curl_close($ch);
	$result = @simplexml_load_string($output);
	$result = json_decode(json_encode($result), TRUE);

	if($result['reply']['code'] != '300'){
		$_HTML['manage'] = $result['reply']['detail'];
	}
	else{
		// 新增表單
		$_HTML['manage'] .= '<div class="form-group"><label for="digestType" class="col-sm-2 control-label">Digest</label><div class="col-sm-10"><input type="text" class="form-control" name="digest"></div></div>';
		$_HTML['manage'] .= '<div class="form-group"><label for="digestType" class="col-sm-2 control-label">Key Tag</label><div class="col-sm-10"><input type="text" class="form-control" name="keyTag"></div></div>';

		$_HTML['manage'] .= '<div class="form-group"><label for="digestType" class="col-sm-2 control-label">Digest Type</label><div class="col-sm-10"><select class="form-control" name="digestType">';
		foreach($digestType_array as $key => $txt){
			if($_POST['digestType']==$key){
				$select = 'selected';
			}
			else{
				$select = '';
			}
			$_HTML['manage'] .= '<option value="'.$key.'"'.$select.'>'.$txt.'</option>';
		}
		$_HTML['manage'] .= '</select></div></div>';

		$_HTML['manage'] .= '<div class="form-group"><label for="alg" class="col-sm-2 control-label">Algorithm</label><div class="col-sm-10"><select class="form-control" name="alg">';
		foreach($alg_array as $key => $txt){
			if($_POST['alg']==$key){
				$select = 'selected';
			}
			else{
				$select = '';
			}
			$_HTML['manage'] .= '<option value="'.$key.'"'.$select.'>'.$txt.'</option>';
		}
		$_HTML['manage'] .= '</select></div></div><button type="submit" class="btn btn-info pull-right">Submit</button><br><br>';
		
		// 結果顯示
		
		if(is_array($result['reply']['ds_record'])){
			if($result['reply']['ds_record']['digest']){
				$result['reply']['ds_record']['digest_type_txt'] = $digestType_array[$result['reply']['ds_record']['digest_type']];
				$result['reply']['ds_record']['algorithm_txt'] = $alg_array[$result['reply']['ds_record']['algorithm']];
				$_HTML['manage'] .= show_list($result['reply']['ds_record'],@$_GET['domain']);
			}
			else{
				foreach($result['reply']['ds_record'] as $data){
					$data['digest_type_txt'] = $digestType_array[$data['digest_type']];
					$data['algorithm_txt'] = $alg_array[$data['algorithm']];
					$_HTML['manage'] .= show_list($data,@$_GET['domain']);
				}
			}
		}
	}
}


/*
The digest
The key tag

*/


