    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?=$_Global['URL']?>">
        &nbsp;<div class="sidebar-brand-icon">
          <img src="https://data.135cloud.com/logo/135cloud.png" height="40">
        </div>
        <div class="sidebar-brand-text mx-3">135CLOUD<sup>2.0</sup></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">
<?php
$sidebar = [['name'=>'Dashboard','url'=>'/Dashboard','icon'=>'fa-tachometer-alt'],
            ['name'=>'domain','item'=>[['name'=>'域名註冊與轉入','item'=>[['name'=>'域名註冊','url'=>'/Domain/Search-Domains'],
                                                                 ['name'=>'域名轉入','url'=>'/Domain/Transfer-Domains'],
                                                                 ['name'=>'域名續費','url'=>'/Domain/Manager/Renewal'],
                                                                 ['name'=>'轉入管理系統','url'=>'/Domain/Transfer-Manager']],
                                                          'icon'=>'fa-tachometer-alt'],
                                      ['name'=>'註冊人資料管理','url'=>'/Contact/List','icon'=>'fa-address-book'],
                                      ['name'=>'域名價格','url'=>'/Domain/Price','icon'=>'fa-dollar-sign'],
                                      ['name'=>'域名管理','url'=>'/Domain/Manager','icon'=>'fa-list-alt']]],
            ['name'=>'service','item'=>[['name'=>'服務訂購','url'=>'/Service/List-Plans','icon'=>'fa-plus-square'],
                                        ['name'=>'服務管理','url'=>'/Service/Manager','icon'=>'fa-list-alt']]],
            ['name'=>'free','item'=>[ ['name'=>'免費次網址申請','url'=>'/Free/Order','icon'=>'fa-plus-square'],
                                      ['name'=>'帳號驗證','url'=>'/Free/Auth','icon'=>'fa-robot'],
                                      ['name'=>'網址管理','url'=>'/Free/Manager','icon'=>'fa-list-alt']]],
            ['name'=>'invoice','item'=>[['name'=>'帳務管理','url'=>'/Invoice/List','icon'=>'fa-tachometer-alt']]]];


function sidebar_show($sidebar_array,$_Global,$row=0){
  $show_html = '';
  foreach($sidebar_array as $key => $data){
    
    if(@$data['url']){
      $active = '';
      if($_Global['PATH']==$data['url']){
        $active = ' active';
      }
      if(@$data['icon']){
        $show_html .= '<li class="nav-item'.$active.'"><a class="nav-link" href="'.$_Global['URL'].$data['url'].'"><i class="fas fa-fw '.@$data['icon'].'"></i><span>'.$data['name'].'</span></a></li>';
      }
      else{
        $show_html .= '<a class="collapse-item'.$active.'" href="'.$_Global['URL'].$data['url'].'">'.$data['name'].'</a>';
      }
    }
    if(@$data['item']){
      if($row==0){
        $show_html .= '<hr class="sidebar-divider"><div class="sidebar-heading">'.$data['name'].'</div>' . sidebar_show($data['item'],$_Global,1);
      }
      else{
        $str1 = sidebar_show($data['item'],$_Global,1);
        $str2 = 'collapse-item active';
        if (false !== ($rst = strpos($str1, $str2))) {
          $active_li = ' active';
          $li_show = ' show';
        } else {
          $active_li = '';
          $li_show = '';
        }
        $show_html = '<li class="nav-item'.$active_li.'">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#coll'.$key.'" aria-expanded="true" aria-controls="coll'.$key.'"><i class="fas fa-fw '.@$data['icon'].'"></i><span>'.$data['name'].'</span></a><div id="coll'.$key.'" class="collapse'.$li_show.'"><div class="bg-white py-2 collapse-inner rounded">'.$str1 .'</div></div></li>';
      }
    }
  }
  return $show_html;
}
echo sidebar_show($sidebar,$_Global);
?>



      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->