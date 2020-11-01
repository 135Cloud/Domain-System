<?php
if(!defined('IN_PF')) {
    exit('Access Denied');
}
// 查詢需處理網址
require './source/namesilo/namesilo.php';
$Namesilo = new Namesilo_API();
// var_dump($database->table('invoice_domain_temp')->where('invoice',$invoice_id)->get());
    foreach($database->table('invoice_domain_temp')->where('invoice',$invoice_id)->get() as $data){
        $query = NULL;
        switch($data['status']){
            case 'register':
                $query = $Namesilo->do_domain_registration($data['domain'],$data['quantity'],$data['private'],$data['conn_id']);
            break;
            case 'transfer':
                // if($data['epp']){
                    $query = $Namesilo->do_domain_transfer($data['domain'],$data['epp'],$data['private'],$data['conn_id']);
                // }
            break;
            case 'renew':
                $query = $Namesilo->do_domain_renew($data['domain'],$data['quantity']);
            break;
        }
            
        
        //執行成功
        switch($data['status']){
            case 'register':
                $database->table('domains')->insert(['domain'=>$data['domain'],'uid'=>$data['uid']]);
                $database->table('invoice_domain_temp')->where('domain','=',$data['domain'])->delete();
            break;
            case 'transfer':
                $database->table('domains')->insert(['domain'=>$data['domain'],'uid'=>$data['uid']]);
                $database->table('invoice_domain_temp')->where('domain','=',$data['domain'])->delete();
                
                if(empty($query['message'])){
                    $query['message'] = '';
                }
                $database->table('domains_trans')->insert([ 'domain'=>$data['domain'],
                'uid'=>$data['uid'],
                'epp'=>$data['epp'],
                'conn_id'=>$data['conn_id'],
                'private'=>$data['private'],
                'status'=>$query['message']]);
                
            break;
        }

        $result = $Namesilo->getDomainInfo($data['domain']);
        if($result['detail']=='success'){
            $database->table('domains')->where('domain',$data['domain'])->update([['created',$result['created']],['expires',$result['expires']]]);
        }


        $txt_log = "\n".date("YmdHis")."\naction: ".$data['domain'].' '.$data['status']."\ndetail: ".serialize(@$query['detail'])."\n";
        error_log($txt_log,"3","namesilo.log");
        
        
        
    }