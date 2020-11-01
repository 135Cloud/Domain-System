<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}
//about route redirect

if(empty(@$_SERVER['PATH_INFO'])){
    $ht_route = $route['Index'];
}
else{
    $ht_route_auth = explode("/" , substr($_SERVER['PATH_INFO'],1));
    if(empty($ht_route_auth[0])){
        unset($ht_route_auth[0]);
        array_value($ht_route_auth);
    }
    for($i=0;$i<count($ht_route_auth);$i++){
        // 輸入是否轉小寫處理
        // 否
        //$route_key = strtolower($ht_route_auth[$i]);
        
        // 是
        $route_key = $ht_route_auth[$i];

        // 路由樹狀無向下
        if(is_string(@$route[$route_key])&&$i+1==count($ht_route_auth)){
            $ht_route = $route[$route_key];
        }
        // 樹狀有向下
        elseif(is_array(@$route[$route_key])){
            //瀏覽預設
            if($i+1==count($ht_route_auth)){
                if(is_string(@$route[$route_key]['Index'])){
                    $ht_route = $route[$route_key]['Index'];
                }
            }
            //繼續向下
            else{
                $route = $route[$route_key];
            }
        }
    }
}
if(@$ht_route&&!in_array(@$ht_route,$route_n)&&empty($_SESSION['login'])){
    header("Refresh: 0; url=".$_Global['URL']."/Login");
    exit();
}