<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}

if(!empty($_SESSION['cart'])){
    $database = new DB();
    $all_fee = 0;
    foreach($_SESSION['cart'] as $data){
        $all_fee += $data['price'];

		switch($data['type']){
			case 'domain-reg':
                $text_name = '域名註冊 - '.$data['name'];
                $domain_data[] = ['domain'=>$data['name'],'conn_id'=>$data['contact_id'],'status'=>'register','private'=>$data['private'],'quantity'=>$data['quantity'],'epp'=>''];
			break;
			case 'domain-tra':
                $text_name = '域名轉入 - '.$data['name'];
                // 修正 尚未輸入EPP的轉入
                if(empty($data['epp'])){
                    $data['epp'] = '';
                }
                $domain_data[] = ['domain'=>$data['name'],'conn_id'=>$data['contact_id'],'status'=>'transfer','private'=>$data['private'],'quantity'=>$data['quantity'],'epp'=>@$data['epp']];
			break;
			case 'domain-ren':
				$text_name = '域名續費 - '.$data['name'];
                $domain_data[] = ['domain'=>$data['name'],'conn_id'=>'0','status'=>'renew','private'=>'0','quantity'=>$data['quantity'],'epp'=>''];
            break;
            
            case 'service':
                $result = $database->table('plan_list')->where('id','=',$data['plan'])->select();
                $text_name = $result['name'] . ' - ' .  $data['name'];
                $database->table('plan_list')->where('id',$data['plan'])->update(['quantity',$result['quantity']-1]);
                $service_data[] = ['domain'=>$data['name'],'plan'=>$data['plan'],'status'=>'new','cycle'=>$data['quantity']];
            break;
            case 'service_r':
                $result = $database->table('plan_list')->where('id','=',$data['plan'])->select();
                $text_name = $result['name'] . ' - ' . $data['name'] .' (ID'. $data['id'].')';
                $database->table('plan_list')->where('id',$data['plan'])->update(['quantity',$result['quantity']-1]);
                $service_data[] = ['domain'=>$data['id'],'plan'=>$data['plan'],'status'=>'renew','cycle'=>$data['quantity']];
            break;
		}

        $insert_line[] = [  'text'=>$text_name,
                            'quantity'=>$data['quantity'],
                            'price'=>$data['price']];

    }

    $date = new DateTime();
    if(@$domain_data){
        $date->modify('+3 day');
    }
    else{
        $date->modify('+7 day');
    }


    $inv_id = $database->table('invoices')->insert_GetID([  'uid'=>$_SESSION['login'],
                                                            'status'=>'active',
                                                            'date_due'=> $date->format('Y-m-d') ,
                                                            'total'=>$all_fee]);
                                   
    foreach($insert_line as $key => $data){
        $data['id'] = $inv_id;
        $database->table('invoices_lines')->insert($data);
    }
    if(@$domain_data){
        foreach($domain_data as  $data){
            $data['invoice'] = $inv_id;
            $data['uid'] = $_SESSION['login'];
            $database->table('invoice_domain_temp')->insert($data);
        }
    }
    if(@$service_data){
        foreach($service_data as $data){
            $data['invoice'] = $inv_id;
            $data['uid'] = $_SESSION['login'];
            $database->table('invoice_service_temp')->insert($data);
        }
    }
    unset($_SESSION['cart']);   
    unset($_SESSION['_cart_c']);  
    header('Location: '.$_Global['URL'].'/Invoice/View?id='.$inv_id);
}