<?php
$check_url = basename(__FILE__);
require './source/global.php';

// UCenter Include
// require './config.inc.php';
// include './uc_client/client.php';


if(@$ht_route){
    //有執行路徑
    $file           ='./app/controllers/'.$ht_route.'.php';
    $View_file      ='./app/views/'.$ht_route.'.php';


    if(file_exists($file)){
        //檔案存在
        require $file;
        
        if(@$_Global['error_code']){
            require './source/exception/'.$_Global['error_code'].'.php';
            exit();
        }
        if(file_exists($View_file)){
            if(@$_SESSION['cart']){
                $_HTML['cart_count'] = '<span class="badge badge-danger badge-counter">'.count($_SESSION['cart']).'</span>';
            }


            require($View_file);
        }

        
    }
    else{
        //程式檔案遺失
        require './source/exception/lost_file.php';
    }
}
else{
    require './source/exception/404.php';
}