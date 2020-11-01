          <div class="row">
            <div class="col-md-3 mb-4">
              <div class="box box-solid">
                <div class="list-group">
                  <a class="list-group-item list-group-item-action" href="?domain=<?=$domain?>">概觀</a>
                  <a class="list-group-item list-group-item-action" href="?domain=<?=$domain?>&amp;manage=dnsserver">DNS 伺服器</a>
                  <a class="list-group-item list-group-item-action" href="?domain=<?=$domain?>&amp;manage=domainlock">域名防盜</a>
                  <a class="list-group-item list-group-item-action" href="?domain=<?=$domain?>&amp;manage=dns">管理 DNS 記錄</a>
                  <a class="list-group-item list-group-item-action" href="?domain=<?=$domain?>&amp;manage=dnssec">DNSSEC</a>
                  <a class="list-group-item list-group-item-action" href="?domain=<?=$domain?>&amp;manage=emailfw">電子郵件轉發</a>
                  <a class="list-group-item list-group-item-action" href="?domain=<?=$domain?>&amp;manage=domainfw">域名轉發</a>
                  <a class="list-group-item list-group-item-action" href="?domain=<?=$domain?>&amp;manage=regisns">註冊 DNS 伺服器</a>
                  <a class="list-group-item list-group-item-action" href="?domain=<?=$domain?>&amp;manage=whois">WHOIS 資訊</a>
                  <a class="list-group-item list-group-item-action" href="?domain=<?=$domain?>&amp;manage=epp">授權碼</a>
                </div>
              </div>
            </div>
            <div class="col-md-9">

              <div class="card border-left-warning shadow mb-4">
                <div class="card-body">
                  <p>將域名的 EPP 代碼通過電子郵件發送給管理連絡人。</p>
                </div>
              </div>


<?php if(@$_HTML['detail']){ ?>

<div class="alert alert-dismissible alert-primary mb-4">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <?=$_HTML['detail']?>
</div>

<?php }?>



              <div class="card mb-4">
                <div class="card-header">
                  域名轉出代碼
                </div>
                <div class="card-body">
                  <form method="POST">
                    <p>請注意，這世界上幾乎全部的代管公司/服務提供商將網址應用於他們的服務上，都<b><u>不會有</u></b>要將網址轉移至他們的系統上才能使用的狀況，僅需管理或設定 DNS即可。<br>他們會提供你要設定的 DNS 記錄或 DNS 伺服器資訊，將其設定後系統中，即可將您的網址連結至您的代管公司/服務提供商。</p>
                    <p>如果您確定要轉出網址，需要解除域名轉移鎖定。</p>
                    <p class="text-primary">*域名註冊或轉移後的 60 天內將暫時無法轉出。</p>
                    <p>Email 將寄給 <?=@$_HTML['Email']?> <small>( Administrative Contact Information 的 Email )</small></p>
                    <div class="form-group"><div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="trans_out_Check" name="trans_out">
                    <label class="custom-control-label" for="trans_out_Check">我明確知道我正在做什麼，確定要取得域名轉出授權代碼。</label></div></div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </form>
                </div>
              </div>
            </div>
          </div>


            