          <div class="row">
            <div class="col-md-3 mb-4">
              <div class="box box-solid">
                <div class="list-group">
                  <a class="list-group-item list-group-item-action" href="?domain=<?=$domain?>">概觀</a>
                  <a class="list-group-item list-group-item-action" href="?domain=<?=$domain?>&amp;manage=dnsserver">DNS 伺服器</a>
                  <a class="list-group-item list-group-item-action" href="?domain=<?=$domain?>&amp;manage=domainlock">域名防盜</a>
                  <a class="list-group-item list-group-item-action" href="?domain=<?=$domain?>&amp;manage=dns">管理 DNS 記錄</a>
                  <a class="list-group-item list-group-item-action active" href="?domain=<?=$domain?>&amp;manage=dnssec">DNSSEC</a>
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
                  <h4><i class="icon fa fa-info"></i> 重要提醒!</h4>
                  <p>當您在設定 DS 記錄時，您的 DNS 伺服器未正確設定與其對應之記錄時，您的網址將無法正確解析。<br>如果您對 DNSSEC 有疑問, 或者如果您在修改 DS 記錄後遇到問題, 則需要與主機託管商聯繫。</p>        
                  <p>您可以使用此頁來管理域的 DS 記錄。本頁面僅於您要設定 DNSSEC 的 DS 記錄時才會用到。</p>      
                </div>
              </div>


<?php if(@$_HTML['detail']){ ?>

<div class="alert alert-dismissible <?=$_HTML['detail']['status']?> mb-4">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <?=$_HTML['detail']['txt']?>
</div>

<?php }?>

              <div class="card mb-4">
                <div class="card-header">
                DNSSEC 記錄
                </div>
                <div class="card-body">
                  <?=$_HTML['dnssec_list']?>
                </div>
              </div>

              <div class="card mb-4">
                <div class="card-header">
                管理 DNSSEC
                </div>
                <div class="card-body">
                  <form method="POST">
                    <div class="form-group">
                      <label for="digestType">摘要 Digest</label>
                      <input type="text" class="form-control" name="digest">
                    </div>
                    <div class="form-group">
                      <label for="digestType">金鑰標記 Key Tag</label>
                      <input type="text" class="form-control" name="keyTag">
                    </div>
                    <div class="form-group">
                      <label for="digestType">摘要類型 Digest Type</label>
                      <select class="form-control" name="digestType">
                        <?=@$_HTML['digestType_select']?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="alg">演算法 Algorithm</label>
                      <select class="form-control" name="alg">
                        <?=@$_HTML['alg_select']?>
                      </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </form>
                </div>
              </div>



            </div>
          </div>


            