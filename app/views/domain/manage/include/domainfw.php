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
                  <a class="list-group-item list-group-item-action active" href="?domain=<?=$domain?>&amp;manage=domainfw">域名轉發</a>
                  <a class="list-group-item list-group-item-action" href="?domain=<?=$domain?>&amp;manage=regisns">註冊 DNS 伺服器</a>
                  <a class="list-group-item list-group-item-action" href="?domain=<?=$domain?>&amp;manage=whois">WHOIS 資訊</a>
                  <a class="list-group-item list-group-item-action" href="?domain=<?=$domain?>&amp;manage=epp">授權碼</a>
                </div>
              </div>
            </div>
            <div class="col-md-9">

<div class="card border-left-warning shadow mb-4">
  <div class="card-body">
  <p>使用我們的域名轉發服務將自動將 DNS 伺服器設為我們的 DNS 伺服器（如果尚未設定）。這可能導致任何第三方託管服務（如網站託管和電子郵件託管）停止運行。<br>
當您向域執行其他操作時，域名轉發會自動刪除，例如更改 DNS 伺服器、更改 DNS 記錄、停放域名。</p>  </div>
</div>


<?php if(@$_HTML['detail']){ ?>

<div class="alert alert-dismissible alert-primary mb-4">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<?=$_HTML['detail']?>
</div>

<?php }?>



              <div class="card mb-4">
                <div class="card-header">
                  域名轉發
                </div>
                <div class="card-body">
                  <form method="POST">
                    <div class="row mb-1">
                      <div class="col-2"><select class="custom-select" name="protocol"><?=$protocol_select?></select></div>
                      <div class="col-5"><input type="text" class="form-control" placeholder="www.google.com.tw" name="address" value="<?=$input_address?>"></div>
                      <div class="col-4"><select class="custom-select" name="forward_type"><?=$method_select?></select></div>
                      <div class="col-1"><button type="submit" class="btn btn-info btn-flat">Forward</button></div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>


            