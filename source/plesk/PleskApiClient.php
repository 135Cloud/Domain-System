<?php
class Plesk_XML_API{
  private $host;
  private $authorizatio;
  private $login;
  function __construct($server='127.0.0.1',$UserName=null,$password=null){
    // 設定
    $this->host = $server;
    if(is_null($password)){
      $this->authorizatio = $UserName;

    }
    else{
        $this->login        = $UserName;
        $this->authorizatio = $password;
    }
  }
  private function request($query){
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://".$this->host.":8443/enterprise/control/agent.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $this->_getHeaders());
    curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    $xml = simplexml_load_string(curl_exec($ch));
    $result = json_decode(json_encode($xml),TRUE);
    curl_close($ch);

    return $result;
  }
  private function _getHeaders(){
      $headers = ["Content-Type: application/xml","HTTP_PRETTY_PRINT: TRUE"];
      if (is_null($this->login)) {
          $headers[] = "KEY: $this->authorizatio";
      } else {
          $headers[] = "HTTP_AUTH_LOGIN: $this->login";
          $headers[] = "HTTP_AUTH_PASSWD: $this->authorizatio";
      }
      return $headers;
  }
  private function XML_create($array){
    $result = "";
    foreach($array as $key => $data){
        
        if($key=='property'){
            foreach($data as $spe){
                $return = $this->XML_create($spe);
                $result .= "<property>\n".$return."</property>\n";
            }
        }
        else{
            if(is_array($data)){
                $return =  "\n".$this->XML_create($data);
            }
            else{
                $return = $data;
            }
            $result .= "<".$key.">".$return."</".$key.">\n";
        }
    }
    return $result;
  }

  private function xml_gen($api,$type,$array){
    $array = ['packet'=>[$api=>[$type=>$array]]];
    return $this->XML_create($array);
  }


  
  public function test($array,$a,$b){
    $query = $this->xml_gen($a,$b,$array);
    return $this->request($query);
  }
  
  public function Login_Session($user,$ip){
    $api = 'server';
    $action = 'create_session';
    $request = $this->xml_gen($api,$action,['login'=>$user,'data'=>['user_ip'=>base64_encode($ip),'source_server'=>'']]);
    $result = $this->request($request);
    return $result[$api][$action]['result'];
  }
  
  public function Client_Create($pname,$email,$login,$passwd=null){
    $api = 'customer';
    $action = 'add';
    if($passwd==null){
      $passwd = $this->gen_password();
    }
    $request = $this->xml_gen($api,$action,['gen_info'=>['pname'=>$pname,
                                                             'login'=>$login,
                                                             'passwd'=>$passwd,
                                                             'email'=>$email]]);

    $result = $this->request($request);
    return $result[$api][$action]['result'];

    // array(3) {
    //     ["status"]=>
    //     string(2) "ok"
    //     ["id"]=>
    //     string(2) "12"
    //     ["guid"]=>
    //     string(36) "b3212153-cb84-4e46-ab96-d69487414833"
    //   }
  }
  

  
  public function Create_Subscriptions($domain,$plan_id,$owner,$ip,$ftp_login,$passwd=null,$expire){
    $api = 'webspace';
    $action = 'add';
    if($passwd==null){
      $passwd = $this->gen_password();
    }
    $request = $this->xml_gen($api,$action,['gen_setup'=>['name'=>$domain,
                                                          'owner-id'=>$owner,
                                                          'htype'=>'vrt_hst',
                                                          'ip_address'=>$ip,
                                                          'status'=>0],
                                            'hosting'=>['vrt_hst'=>['property'=>[['name'=>'ftp_login','value'=>$ftp_login],
                                                                                  ['name'=>'ftp_password','value'=>$passwd]],                                                                    
                                                                    'ip_address'=>$ip]],
                                            'limits'=>['limit'=>['name'=>'expiration','value'=>$expire]],
                                            'plan-id'=>$plan_id]);
    $result = $this->request($request);
    return $result[$api][$action]['result'];

    // array(3) {
    //     ["status"]=>
    //     string(2) "ok"
    //     ["id"]=>
    //     string(1) "9"
    //     ["guid"]=>
    //     string(36) "8af88ac8-2ae7-41fa-bd0c-fd07bbb493f3"
    //   }
  }

  public function Sync_Subscriptions($id=0){
    $request = $this->xml_gen('webspace','sync-subscription',['filter'=>['id'=>$id]]);
    $this->request($request);
  }

  
  // public function Disable_Subscriptions($owner=0,$id=0){
  //     if($owner){
  //       $array = ['owner-id'=>$owner];
  //     }
  //     else{
  //       $array = ['id'=>$id];
  //     }
  //     $request = ['filter'=>$array,'values'=>['gen_setup'=>['status'=>16]]];
  //     return $this->Edit_Subscriptions($request);
  // }

  public function Renew_Subscriptions($id=0,$expire){
    $request = ['filter'=>['id'=>$id],'values'=>[ 'gen_setup'=>['status'=>0]],
                                                  'limits'=>['limit'=>['name'=>'expiration','value'=>$expire]]];
    return $this->Edit_Subscriptions($request);
  }

  public function Edit_Subscriptions($request){
      $request = $this->xml_gen('webspace','set',$request);
      $result = $this->request($request);
      return $result;
  }
  
  public function Get_Subscriptions($array=[]){
    $request = $this->xml_gen('webspace','get',$array);
    $result = $this->request($request);
    return @$result['webspace']['get'];
}


  public function gen_password($len = 12){
    $spe = 0; $array = ['ABCDEFGHIJKLMNOPQRSTUVWXYZ','abcdefghijklmnopqrstuvwxyz','0123456789','-=~!@#$%^*_+'];
    for($i=0;$i<$len;$i++){
        $now = rand(0,3);
        if($spe>=2){$now = rand(0,2);}
        elseif($now==3){$spe++;}
        elseif(($i>=$len/2)&&$spe==0){$now=3;$spe++;}
        @$str .= substr(str_shuffle($array[$now]),1,1);
    }
    return $str;
}
}

