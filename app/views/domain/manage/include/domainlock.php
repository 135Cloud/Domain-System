          <div class="row">
            <div class="col-md-3 mb-4">
              <div class="box box-solid">
                <div class="list-group">
                  <a class="list-group-item list-group-item-action" href="?domain=<?=$domain?>">概觀</a>
                  <a class="list-group-item list-group-item-action" href="?domain=<?=$domain?>&amp;manage=dnsserver">DNS 伺服器</a>
                  <a class="list-group-item list-group-item-action active" href="?domain=<?=$domain?>&amp;manage=domainlock">域名防盜</a>
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
                  <p>按「解除」按鈕將解鎖域名。當域名被解鎖時，將可以將該域名轉移到其他註冊商。我們強烈建議您鎖定所有域名，並在轉移前才解鎖，避免域名在未經您授權的狀況下被轉移。</p>
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
                管理域名轉移鎖
                </div>
                <div class="card-body">
                <form method="POST">
                <p>目前域名鎖定狀態為：<?=$_HTML['manage']?></p>
                </form>
                </div>
              </div>
            </div>
          </div>


            