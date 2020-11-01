<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}
require './source/namesilo/namesilo.php';
$now = new DateTime();
$database = new DB();
$Namesilo = new Namesilo_API();

$Service_Name = $_HTML['copyright'].' 服務管理通知';


switch(@$_GET['mode']){
    case '01':
        // 凌晨更新部分
        // 更新 帳單 逾期狀態
        $database->table('invoices')->where('date_due','<=',$now->format("Y-m-d"))->where('status','active')->update(['status','expired']);
        
        

        // 每天更新網址到期日 每天更新當日到期的

        foreach($database->table('domains')->like('created','%-'.$now->format("d"))->get() as $data){
            $result = $Namesilo->getDomainInfo($data['domain']);
            if($result['detail']=='success'){
                $database->table('domains')->where('domain',$data['domain'])->update([['created',$result['created']],['expires',$result['expires']]]);
            }
            else{
                $database->table('domains')->where('domain',$data['domain'])->delete();
                $database->table('do_del_log')->insert(['domain'=>$data['domain'],'uid'=>$data['uid']]);
            }
        }


        
    break;
    case '10':
        // 早上更新 通知

        $expires_today = new DateTime();

        $expires_7d    = new DateTime();
        $expires_7d->modify('+7 day');
        $expires_30d   = new DateTime();
        $expires_30d->modify('+30 day');

        foreach($database->table('domains')->where('expires',$expires_today->format("Y-m-d"))->get() as $data){
            $expires_domain[$data['uid']]['today'][] = $data['domain'];
        }
        foreach($database->table('domains')->where('expires',$expires_7d->format("Y-m-d"))->get() as $data){
             $expires_domain[$data['uid']]['7d'][] = $data['domain'];
        }
        foreach($database->table('domains')->where('expires',$expires_30d->format("Y-m-d"))->get() as $data){
            $expires_domain[$data['uid']]['30d'][] = $data['domain'];
        }
        if($expires_today->format("d")=="1"){
            $expires_next_month = new DateTime();
            $expires_next_month->modify('+1 month');
            foreach($database->table('domains')->where('expires','<',$expires_next_month->format("Y-m-d"))->get() as $data){
                $expires_domain[$data['uid']]['n_month'][] = $data['domain'];
            }
         }
        

        if(@is_array($expires_domain)){
            foreach($expires_domain as $key => $data){
                // uid $key
                $profile = $database->table('profile')->where('uid',$key)->select();
                $user = $database->table('profile')->where('user',$key)->select();
                // $profile['phone'];
                // $profile['email'];
                // $user['username']

                $msg  = '<p>'.$user['username'].' 您好, 這是 '.$_HTML['site_name'].'</p><br><p>感謝您使用 '.$_HTML['copyright'].' 的服務</p>';
                if($data['today']){
                    $title = '['.$_HTML['site_name'].'] 網址到期通知';

                    $msg .= '<br><p>您有網址已經過期（見下方列表），您目前仍可以依照正常的續費價格續費您的網址（系統自助續費僅允許 21 日內送出續費申請），在您續費之前，與過期的網址有所相關的服務將無法使用，如網站、E-MAIL等。<br>另外請注意，網址過期後可能在第 31 日被拍賣掉。</p>';
                    $msg .= '<p>關於網址過期後的處理流程，您可以參考<a href=\"https://besv.net/thread-1565-1-1.html\">https://besv.net/thread-1565-1-1.html</a>。</p>';

                    $msg .= '<p>今日到期網址：</p><ol>';
                    foreach($data['today'] as $domain){
                        $msg .= '<li>'.$domain.'</li>';
                    }
                    $msg .= '</ul><br>';

                }
                else{
                    $title = '['.$_HTML['site_name'].'] 網址即將到期通知';

                    $msg .= '<br><p>您有網址即將過期（見下方列表），當您的網址過期後，在您續費之前，過期網址所有相關的服務將無法使用，如網站、E-MAIL等。<br>另外請注意，網址過期後可能在第 31 日被拍賣掉。</p>';
                    $msg .= '<p>關於網址過期後的處理流程，您可以參考<a href=\"https://besv.net/thread-1565-1-1.html\">https://besv.net/thread-1565-1-1.html</a>。</p>';
                }
               

                if(@$data['7d']){
                    $msg .= '<p>七日後到期網址：</p><ol>';
                    foreach($data['7d'] as $domain){
                        $msg .= '<li>'.$domain.'</li>';
                    }
                    $msg .= '</ul><br>';
                }
                if(@$data['30d']){
                    $msg .= '<p>三十日後到期網址：</p><ol>';
                    foreach($data['30d'] as $domain){
                        $msg .= '<li>'.$domain.'</li>';
                    }
                    $msg .= '</ul><br>';
                }
                if(@$data['n_month']){
                    $msg .= '<p>本月份到期網址：</p><ol>';
                    foreach($data['n_month'] as $domain){
                        $msg .= '<li>'.$domain.'</li>';
                    }
                    $msg .= '</ul><br>';
                }

                
                $msg .= '<p>誠摯期待您再次使用 '.$_HTML['copyright'].' 的服務<br>'.$_HTML['copyright'].' 團隊</p><p>135cloud.com</p>';

                mailto($profile['email'],$title,$msg);

                
                if(preg_match("/^9[0-9]{8}$/", $profile['phone'])){
                    //台灣手機號碼 09xxxxxxxx for SMS
                    $profile['phone'] = '0'.$profile['phone'];
                    if(@$data['30d']){
                        $count = count($data['30d']);
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, 'https://api2.kotsms.com.tw/kotsmsapi-2.php?username='.$_kotmsm['username'].'&apikey='.$_kotmsm['apikay'].'&dstaddr='.$profile['phone'].'&smbody='.mb_convert_encoding('['.$_HTML['copyright'].']提醒您，您有 '.$count.' 個網址將於 30 天後過期，記得及時續費喔!', "big5"));
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        $output = curl_exec($ch);
                        curl_close($ch);
                    }
                    if(@$data['today']){
                        $count = count($data['today']);
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, 'https://api2.kotsms.com.tw/kotsmsapi-2.php?username='.$_kotmsm['username'].'&apikey='.$_kotmsm['apikay'].'&dstaddr='.$profile['phone'].'&smbody='.mb_convert_encoding('['.$_HTML['copyright'].']提醒您，您有 '.$count.' 個網址將於今日過期，記得續費喔!', "big5"));
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        $output = curl_exec($ch);
                        curl_close($ch);
                    }
                }

            }
        }





    break;
    
    default:

        foreach($database->table('domains')->where('created','9999-12-31')->get() as $data){
            $result = $Namesilo->getDomainInfo($data['domain']);
            if($result['detail']=='success'){
                $database->table('domains')->where('domain',$data['domain'])->update([['created',$result['created']],['expires',$result['expires']]]);
            }
        }

    break;

}


function mailto($mail_to,$title,$msg){
    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
    $headers .= "X-Mailer: 135Cloud by PHP ".phpversion()."\r\n";
    $headers .= "From: 135Cloud Domain Registration <no-reply@135cloud.com>\r\n";
    $headers .= "Reply-To: service@135cloud.com\r\n";


    $msg = '<!DOCTYPE html><html lang="zh-tw"><head><body style="margin: 0 !important; padding: 0 !important;">'.$msg.'</body></html>';

    mail($mail_to,"=?utf-8?b?".base64_encode($title)."?=",$msg,$headers);
}


