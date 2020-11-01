<?php
if(!defined('IN_PF')) {
	exit('Access Denied');
}
require './source/namesilo/namesilo.php';
$_HTML['title'] = '轉入域名管理';
$database = new DB();
if(@empty($_GET['domain'])){
    foreach($database->table('domains_trans')->where('uid',$_SESSION['login'])->get() as $data){
        $Namesilo = new Namesilo_API();
        $result = $Namesilo->checkTransferStatus($data['domain']);
        // var_dump($result);
        $status = trans_status($data['status']);
        @$_HTML['table'] .= '<tr data-href="'.$_Global['URL'].'/Domain/Transfer-Manager?domain='.$data['domain'].'"><td>'.$data['domain'].'</td><td>'.$data['create_at'].'</td><td>'.$status['status'].'</td></tr>';
    }
}

else{
    // 取代掉預設顯示頁面
    $View_file = './app/views/domain/transfer-view.php';
    $result = $database->table('domains_trans')->where('uid',$_SESSION['login'])->where('domain',$_GET['domain'])->select();
    if(!empty($result)){
        $domain = $_GET['domain'];
        // 有找到對應的等待轉入網址之資訊

        // 初始化 API
        $Namesilo = new Namesilo_API();

        // 其他動作部分
        if(@$_POST['epp']){
            $Namesilo->transferUpdateChangeEPPCode($domain,$_POST['epp']);
            echo '<script>alert("已更新 EPP Code")</script>';
            $database->table('domains_trans')->where('domain',$domain)->update('epp',$_POST['epp']);
        }

        if(@$_POST['resubmit']){
            $resubmit_result = $Namesilo->transferUpdateResubmitToRegistry($domain);
            
            if($resubmit_result['code']=='300'){
                $detail = '已重新送出轉移要求';
            }
            else{
                $detail = $resubmit_result['detail'];
            }
            echo '<script>alert("'.$detail.'")</script>';
        }
        if(@$_POST['resend']){
            $resubmit_result = $Namesilo->transferUpdateResendAdminEmail($domain);
            
            if($resubmit_result['code']=='300'){
                $detail = '已重新寄送驗證信件';
            }
            else{
                $detail = $resubmit_result['detail'];
            }
            echo '<script>alert("'.$detail.'")</script>';
        }

        // if(@$_POST['update']){
        //     echo '<script>alert("正在更新相關資料中")</script>';
        // }
        


        $domain_info = $Namesilo->checkTransferStatus($domain);


        $status = trans_status(@$domain_info['status']);
        $_HTML['trans_status'] = $status['code'].' - '.$status['status'];
        $_HTML['trans_message'] = @$domain_info['message'];
        if($status['code']=="902"){
            $_HTML['epp_help'] = 'EPP Code 是轉入網址必要的資訊，需輸入才能繼續進行轉移作業。';
            $_HTML['show_epp'] = true;
        }
        
        if($status['code']=="913"){
            $_HTML['epp_help'] = '您輸入的 EPP Code 有誤，請確認後重新輸入。';
            $_HTML['show_epp'] = true;
        }
    }
    else{
       exit();
    }
}





function trans_status($why){
    switch($why){
		case 'Retrieving Administrative Contact Email':
        case '901':
            return ['code'=>'901','status'=>'正在抓取管理連絡人 Email'];
            
		case 'Missing Authorization Code':
        case '902':                 //需顯示EPP
            return ['code'=>'902','status'=>'找不到授權代碼'];
            
		case 'Pending Reply from Administrative Contact':
        case '903':
            return ['code'=>'903','status'=>'等待管理連絡人的回覆'];
            
		case 'Transfer Rejected':
        case '904':
            return ['code'=>'904','status'=>'轉移被拒絕'];
            
		case 'Transfer Timed Out':
        case '905':
            return ['code'=>'905','status'=>'轉移逾時'];
            
		case 'Transfer Accepted':
        case '906':
            return ['code'=>'906','status'=>'轉移已接受'];
            
		case 'Registry Transfer Request Failed':
        case '907':
            return ['code'=>'907','status'=>'註冊機構轉移請求失敗'];
            
		case 'Pending at Registry':
        case '908':
            return ['code'=>'908','status'=>'待註冊機構處理'];
            
		case 'Registrar Rejected':
        case '909':
            return ['code'=>'909','status'=>'註冊機構拒絕'];
            
		case 'Approved':
        case '910':
            return ['code'=>'910','status'=>'已核准'];
            
		case 'Approved (Auto)':
        case '911':
            return ['code'=>'911','status'=>'已核准 (自動)'];
            
		case 'Transfer Completed':
        case '999':
            return ['code'=>'999','status'=>'轉移已完成'];
            
		case 'Incorrect Authorization Code':
        case '913':                 //需顯示EPP
            return ['code'=>'913','status'=>'錯誤的授權代碼'];
            
		case 'Domain is Locked':
        case '914':
            return ['code'=>'914','status'=>'域名已經上鎖'];
            
		case 'Domain is Private':
        case '915':
            return ['code'=>'915','status'=>'域名為資料為隱私保護機構資料'];
            
		case 'Checking Domain Status':
        case '916':
            return ['code'=>'916','status'=>'正在檢查域名狀態'];
            
		case 'Retrieving Administrative Contact Email (2)':
        case '917':
            return ['code'=>'917','status'=>'正在抓取管理連絡人 Email (2)'];
            
		case 'Submitting Transfer Request to Registry':
        case '918':
            return ['code'=>'918','status'=>'向註冊機構送出轉移申請'];
            
		case 'On Hold - Created in last 60 days':
        case '919':
            return ['code'=>'919','status'=>'保留 - 過去 60 天內建立'];
            
		case 'On Hold - Transferred in last 60 days':
        case '920':
            return ['code'=>'920','status'=>'保留 - 過去 60 天內轉移'];
            
		case 'Registry Rejected':
        case '921':
            return ['code'=>'921','status'=>'註冊機構拒絕'];
            
		case 'Domain Transferred Elsewhere':
        case '922':
            return ['code'=>'922','status'=>'轉移到其他地方的域名'];
            
		case 'User Cancelled':
        case '923':
            return ['code'=>'923','status'=>'使用者已取消'];
            
		case 'Domain has a pendingDelete status':
        case '924':
            return ['code'=>'924','status'=>'域名有 pendingDelete 狀態'];
            
		case 'Domain has a pendingTransfer status':
        case '925':
            return ['code'=>'925','status'=>'域名有 pendingTransfer 狀態'];
            
		case 'Time Out':
        case '926':
            return ['code'=>'926','status'=>'逾時'];

        default:
            return ['code'=>'000','status'=>'無資料'];
	}
}