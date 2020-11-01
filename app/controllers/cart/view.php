<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}
$_HTML['title'] = '購物車';

if(@md5('rm'.$_GET['remove'].'rf') == @$_GET['hash']){
	switch(@$_SESSION['cart'][$_GET['remove']]['type']){
		//僅限註冊網址驗證用
		case 'domain-tra':
		case 'domain-reg':
		case 'domain-ren':
			unset($_SESSION['_cart_c'][$_SESSION['cart'][$_GET['remove']]['name']]);
		break;
	}
	unset($_SESSION['cart'][$_GET['remove']]);

}


if(!empty(@$_SESSION['cart'])){
	$database = new DB();
	foreach($_SESSION['cart'] as $key => $data){
		//var_dump($data);
		$notes = [];
		switch($data['type']){
			case 'domain-reg':
				$name = '域名註冊';
				$info = $data['name'];
				$unit = ' 年';
			break;
			case 'domain-tra':
				$name = '域名轉入';
				$info = $data['name'];
				$unit = ' 次';
			break;
			case 'domain-ren':
				$name = '域名續費';
				$info = $data['name'];
				$unit = ' 年';
			break;
			case 'service_r':
			case 'service':
				$name = '網站主機服務';
				$result = $database->table('plan_list')->where('id','=',$data['plan'])->select();
				$info = $result['name'];
				
				switch($data['quantity']){
					case 1:
					case 3:
						$unit = ' 月';
					break;
					case 12:
					case 24:
						$data['quantity'] = $data['quantity']/12;
						$unit = ' 年';
					break;
				}
				
			break;
		}

		switch($data['type']){
			case 'domain-tra':
				if(@$data['epp']){
					$notes[] = '已輸入EPP代碼';
				}
			case 'domain-reg':
				if($data['private']){
					$notes[] = '含隱私保護';
				}
			case 'domain-ren':
				$unit_title = '數量';
			break;
			case 'service_r':
				$notes[] = '訂閱續約(ID'.$data['id'].')';
			case 'service':
				$notes[] = '網址 '.$data['name'];
				$unit_title = '週期';
			break;
		}
		@$_HTML['cart'] .= '<div class="card border-left-primary shadow mb-4 py-2">
		<div class="card-body">
		  <div class="row  align-items-center">
			<div class="col mr-2">
			  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">'.$name.'</div>
			  <div class="h5 mb-0 font-weight-bold text-gray-800">'.$info.'</div>
			  <div class="mb-0">'.$unit_title.': '.$data['quantity'].$unit.'</div>
			  <div class="mb-0">價格: NT$ '.$data['price'].'</div>
			  <div class="mb-0">備註: '.implode(", ",$notes).'</div>
			  
			</div>
			<div class="col-auto">
			<small><a class="text-danger" href="?remove='.$key.'&hash='.md5('rm'.$key.'rf').'">刪除</a></small>
			</div>
		  </div>
		</div>
		</div>';
	}

	@$_HTML['cart'] .= '<a href="'.$_Global['URL'].'/Cart/Checkout" class="btn btn-primary btn-block">結帳去 <i class="fas fa-arrow-right"></i></a>';

}
else{
	$_HTML['cart'] = '<div class="card shadow">
	<div class="card-body">
	  <div class="row  align-items-center">
		<div class="col mr-2">
		  購物車空空如也
		</div>
	  </div>
	</div>
	</div>';
}