<?php
//輸入值處理
if(!empty($_POST)){
	input_post_security_function($_POST);
}

function input_post_security_function($array){
	foreach($array as $key=>$data){
		if(is_array($data)){
			$return[$key] = input_post_security_function($data);
		}
		   else{
			$return[$key] = addslashes(htmlspecialchars($data));
		}
	}
	$array = @$return;
}