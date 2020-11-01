<?php
define('IN_PF',((isset($_SERVER['HTTPS']))?'https://':'http://').$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
session_start();
$data = explode('/index.php',IN_PF);
$_Global['URL'] = $data['0'];
$_Global['PATH'] = $data['1'];


require './config.php';
require './source/security/protect.php';

require './route.php';
require './not_need_login.php';
require './source/route.php';


require './source/database/db.php';

?>