<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}

$_HTML['note'] = '可以於下方表格設定您域名對應的 DNS 伺服器名稱，前兩個為必要的。<br>一般的 DNS 伺服器將由您的 DNS 代管商或主機商提供，通常類似於「NS1.HOST.COM」。<br><b>請勿輸入 DNS 伺服器的 IP</b>，變更後最多可能會需要 24 小時更新';


$nameserver = $domain_info['nameservers']['nameserver'];

if(@$_POST){
	for($i=1;$i<=6;$i++){
		$nameserver[$i-1] = $_POST['nsserver'.$i];
		$query[] = $_POST['nsserver'.$i];
	}
	$result = $Namesilo->changeNameServers($domain,$query);
	$_HTML['detail'] = $result['detail'];
}

for($i=1;$i<=6;$i++){
	@$_HTML["ns_input"] .= '<div class="form-group"><label>Nameserver '.$i.'</label><input type="text" class="form-control" name="nsserver'.$i.'" value="'.@$nameserver[($i-1)].'"></div>';
 }