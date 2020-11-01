<?php
if(!defined('IN_PF')) {
//	exit('Access Denied');
}
				require './source/plesk/PleskApiClient.php';
				foreach($database->table('invoice_service_temp')->where('invoice',$invoice_id)->get() as $data){

					if($data['status']=='new'){
						$plan_info = $database->table('plan_list')->where('id',$data['plan'])->select();
						$server =   $database->table('server_list')->where('id',$plan_info['server'])->select();

						$time = new DateTime();
						$time->modify('+'.$data['cycle'].' month');
						$time->modify('+1 day');


						$action = new Plesk_XML_API($server['server'],$server['login'],$server['pwd']);
						$pwd = $action->gen_password();
						$server['now_id'] = (int)$server['now_id']+1;
						$login = 'u'.$server['now_id'];
						$server_user = $action->Client_Create($user['name'],$user['email'],$login,$pwd);
						$database->table('server_list')->where('id',$server['id'])->update(['now_id',$server['now_id']]);
						$server_sub = $action->Create_Subscriptions($data['domain'],$plan_info['cp_id'],$server_user['id'],$server['default_ip'],$login,$pwd,$time->getTimestamp());

						$action->Sync_Subscriptions($server_sub['id']);

						$database->table('service_list')->insert([	'name'		=>$data['domain'],
																	'type'		=>'webhost',
																	'expired'	=>$time->format('Y-m-d'),
																	'server'	=>$plan_info['server'],
																	'sys_id'	=>@$server_sub['id'],
																	'host_login_name'=>$login,
																	'plan_id'	=>$data['plan'],
																	'uid'		=>$data['uid']]);
							
					}

					if($data['status']=='renew'){

						$plan_data = $database->table('service_list')->where('id',$data['name'])->select();
						$server =   $database->table('server_list')->where('id',$plan_data['server'])->select();
						
						$time = new DateTime($plan_data['expired']);
						$time->modify('+'.$data['cycle'].' month');
						$time->modify('+1 day');	

						$action = new Plesk_XML_API($server['server'],$server['login'],$server['pwd']);
						$action->Renew_Subscriptions($plan_data['sys_id'],$time->getTimestamp());
						$action->Sync_Subscriptions($plan_data['sys_id']);

						
						$database->table('service_list')->where('id',$plan_data['id'])->update([ ['expired',$time->format('Y-m-d')]]);
					}
				}