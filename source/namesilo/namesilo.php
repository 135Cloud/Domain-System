<?php 
if(!defined('IN_PF')) {
	exit('Access Denied');
}
class Namesilo_API{

    
	function __construct(){
		$config = $GLOBALS['_Namesilo'];
		$this->url = $config['url'];
		$this->api_key = $config['key'];
	}
    private function curl_query($action,$query,$xml=0){
        $query['version'] = '1';
        $query['type'] = 'xml';
        $query['key'] = $this->api_key;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url.$action.'?'.http_build_query($query));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch); 
        curl_close($ch);
        $result = @simplexml_load_string($output);
        $result = json_decode(json_encode($result), TRUE);
        if($xml==1){
            // 要收回傳值直接是xml
            return $output;
        }
        if(empty($result)){
            // Json轉換成array失敗 回傳原始值
            return $output;
        }
        else{
            // 只回傳需要欄位
            return $result['reply'];
        }
    }

    public function check_domain_registration($domain){
        $check = $this->curl_query('checkRegisterAvailability',['domains'=>$domain]);
        if(@$check['available']){
            return true;
        }
        elseif(@$check['unavailable']){
            return '無法註冊';
        }
        elseif(@$check['invalid']){
            return '無效網址';
        }
        else{
            return $check['detail'];
        }
    }

    public function check_domain_transfer($domain){
        $output = $this->curl_query('checkTransferAvailability',['domains'=>$domain],1);
        
        $result = @simplexml_load_string($output);
        $result = json_decode(json_encode($result), TRUE);
        $result = $result['reply'];
        if(@$result['available']){
            return true;
        }
        elseif(@$result['unavailable']||@$result['invalid']){
            $why = explode('reason="',$output);
            $why = explode('">',$why['1']);
            $why = $why['0'];
            
            if (false !== ($rst = strpos($why, 'A user within our system already has this domain.'))) {
                // A user within our system already has this domain. Please remember that this process is only for transferring domains from a different registrar. To transfer this domain from one NameSilo account to your account, please read our Support section under Domain Pushes.
                return '註冊商系統中已經存在此域名，可能是您的網址已經向我方註冊，或您目前的網址註冊商與我方之註冊商相同。(請洽服務人員)';
            }
            elseif($why =='This domain cannot be transferred since it is not currently registered.'){
                // This domain cannot be transferred since it is not currently registered.
                return '無法轉入尚未註冊的網址。';
            }
            else{
                return $why;
            }
        }
        else{
            return  @$result['detail'];
        }
    }

    public function checkTransferStatus($domain){
        return $this->curl_query('checkTransferStatus',['domain'=>$domain]);
       
    }


    public function transferUpdateChangeEPPCode($domain,$auth){
        return $this->curl_query('transferUpdateChangeEPPCode',['domain'=>$domain,'auth'=>$auth]);
    }
    public function transferUpdateResubmitToRegistry($domain){
        return $this->curl_query('transferUpdateResubmitToRegistry',['domain'=>$domain]);
    }
    public function transferUpdateResendAdminEmail($domain){
        return $this->curl_query('transferUpdateResendAdminEmail',['domain'=>$domain]);
    }
    
    
    

    public function do_domain_registration($domain,$years=1,$private=1,$contact_id){
        return $this->curl_query('registerDomain',[ 'domain'    =>$domain,
                                                    'auto_renew'=>'0',
                                                    'private'   =>$private,
                                                    'years'     =>$years,
                                                    'contact_id'=>$contact_id]);
    }
    public function do_domain_transfer($domain,$epp,$private=1,$contact_id){
        return $this->curl_query('transferDomain',[ 'domain'    =>$domain,
                                                    'auto_renew'=>'0',
                                                    'private'   =>$private,
                                                    'auth'      =>$epp,
                                                    'contact_id'=>$contact_id]);
    }
    public function do_domain_renew($domain,$years=1){
        return $this->curl_query('renewDomain',['domain' =>$domain,
                                                'years'  =>$years]);
    }


    


    public function getDomainInfo($domain){
        return $this->curl_query('getDomainInfo',['domain'=>$domain]);
    }
    

    public function contactAdd($array){
        return $this->curl_query('contactAdd',$array);
    }
    public function contactGet($id){
        return $this->curl_query('contactList',['contact_id'=>$id]);
    }
    public function contactUpdate($id,$array){
        $array['contact_id'] = $id;
        return $this->curl_query('contactUpdate',$array);
    }
    public function contactDelete($contactID){
        return $this->curl_query('contactDelete',['contact_id'=>$contactID]);
    }
    public function contactDomainAssociate($domain,$contactID1,$contactID2,$contactID3,$contactID4){
        return $this->curl_query('contactDomainAssociate',['domain'=>$domain,
                                                           'registrant'=>$contactID1,
                                                           'administrative'=>$contactID2,
                                                           'technical'=>$contactID3,
                                                           'billing'=>$contactID4]);
    }


    
    
    public function retrieveAuthCode($domain){
        return $this->curl_query('retrieveAuthCode',['domain'=>$domain]);
    }


    public function emailVerification($contact_id){
        $contact = $this->contactGet($contact_id);
        if($contact['code']=='300'){
            return $this->curl_query('emailVerification',['email'=>$contact['contact']['email']]);
        }
        else{
            return $contact;
        }
    }


    public function dnsListRecords($domain){
        return $this->curl_query('dnsListRecords',['domain'=>$domain]);
    }
    public function dnsDeleteRecord($domain,$rrid){
        return $this->curl_query('dnsDeleteRecord',['domain'=>$domain,'rrid'=>$rrid]);
    }
    public function dnsUpdateRecord($domain,$array,$rrid=NULL){
        $array['domain'] = $domain;
        if($rrid){
            $array['rrid'] = $rrid;
            return $this->curl_query('dnsUpdateRecord',$array);
        }
        else{
            return $this->curl_query('dnsAddRecord',$array);
        }
    }
    

    public function dnsSecListRecords($domain){
        return $this->curl_query('dnsSecListRecords',['domain'=>$domain]);
    }
    public function dnsSecAddRecord($domain,$digest,$keyTag,$digestType,$alg){
        return $this->curl_query('dnsSecAddRecord',['domain'=>$domain,
                                                    'digest'=>$digest,
                                                    'keyTag'=>$keyTag,
                                                    'digestType'=>$digestType,
                                                    'alg'=>$alg]);
    }
    public function dnsSecDeleteRecord($domain,$digest,$keyTag,$digestType,$alg){
        return $this->curl_query('dnsSecDeleteRecord',['domain'=>$domain,
                                                    'digest'=>$digest,
                                                    'keyTag'=>$keyTag,
                                                    'digestType'=>$digestType,
                                                    'alg'=>$alg]);
    }


    public function changeNameServers($domain,$nsList){
        $query['domain'] = $domain;
        for($i=0;$i<=6;$i++){
           if(!empty($nsList[$i])){
                $query['ns'.($i+1)] = $nsList[$i];
            }
        }
        return  $this->curl_query('changeNameServers',$query);
    }


    public function domainForward($domain,$protocol,$address,$method){
        return $this->curl_query('domainForward',['domain'=>$domain,
                                                  'protocol'=>$protocol,
                                                  'address'=>$address,
                                                  'method'=>$method]);
    }


    public function domainLock($domain,$locked=NULL){
        if($locked){
            return  $this->curl_query('domainLock',['domain'=>$domain]);
        }
        else{
            return  $this->curl_query('domainUnlock',['domain'=>$domain]);
        }
    }
    

    public function listEmailForwards($domain){
        return  $this->curl_query('listEmailForwards',['domain'=>$domain]);
    }
    public function configureEmailForward($domain,$user,$to){
        $query = ['domain'=>$domain,'email'=>$user];
        for($i=0;$i<5;$i++){
            if(!empty($to[$i])){
                $query['forward'.($i+1)] = $to[$i];
            }
        }
        return  $this->curl_query('configureEmailForward',$query);
    }
    public function deleteEmailForward($domain,$user){
        return  $this->curl_query('deleteEmailForward',['domain'=>$domain,'email'=>$user]);
    }


    public function listRegisteredNameServers($domain){
        return  $this->curl_query('listRegisteredNameServers',['domain'=>$domain]);
    }
    
    public function modifyRegisteredNameServer($domain,$old_host=null,$new_host=null,$ips){
        if(empty($old_host)){
            $api_name = 'addRegisteredNameServer';

        }
        else{
            $api_name = 'modifyRegisteredNameServer';
            $query['current_host'] = $old_host;
        }
        $query['domain'] = $domain;
        $query['new_host'] = $new_host;

        for($i=0;$i<13;$i++){
            if(!empty($ips[$i])){
                $query['ip'.($i+1)] = $ips[$i];
            }
        }
        return  $this->curl_query($api_name,$query);
    }

    public function deleteRegisteredNameServer($domain,$host){
        return  $this->curl_query('deleteRegisteredNameServer',['domain'=>$domain,
                                                                'current_host'=>$host]);
    }

    public function modifyPrivacy($domain,$status=NULL){
        if($status=='Add'){
            return $this->curl_query('addPrivacy',['domain'=>$domain]);
        }
        elseif($status=='Remove'){
            return $this->curl_query('removePrivacy',['domain'=>$domain]);
        }
        return NULL;
    }
    
    
}