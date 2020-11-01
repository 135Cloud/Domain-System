<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}
$_HTML['title'] = '域名價格';

$database = new DB();
foreach($database->table('tld')->get() as $data){
    @$_data['table'] .= '<tr><td>.'.$data['tld'].'</td><td>NT$ '.$data['registration'].'/年</td><td>NT$ '.$data['transfer'].'</td></tr>';
}