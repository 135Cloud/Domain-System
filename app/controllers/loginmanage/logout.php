<?php 
if(!defined('IN_PF')) {
	exit('Access Denied');
}
session_destroy();
exit('<script>document.location.href="'.$_Global['URL'].'/Login";</script>');