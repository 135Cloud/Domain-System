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
                  <p>您可以在此修改 WHOIS 相關資訊，如域名註冊人、聯絡人等資訊，以及是否要開啟隱私保護。</p>
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
                管理域名 WHOIS
                </div>
                <div class="card-body">
                  <p>目前的 WHOIS 隱私保護服務狀態為：<?=$_HTML['private_status']?></p>
                </div>
              </div>
              <div class="card mb-4">
                <div class="card-header">
                WHOIS 資訊
                </div>
                <div class="card-body">
                  <p><?=$_HTML['whois_info']?></p>
                </div>
              </div>
              <div class="card mb-4">
                <div class="card-header">
                WHOIS 資訊修改
                </div>
                <div class="card-body">
                  <form method="POST">
                    <div class="form-group">
                      <label>Registrant</label>
                      <select class="form-control" name="registrant">
                      <?=$_HTML['registrant']?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Administrative</label>
                      <select class="form-control" name="administrative">
                      <?=$_HTML['administrative']?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Technical</label>
                      <select class="form-control" name="technical">
                      <?=$_HTML['technical']?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Billing</label>
                      <select class="form-control" name="billing">
                      <?=$_HTML['billing']?>
                      </select>
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="customSwitch1" name="whois_private" <?=@$_HTML['switch']?> >
                        <label class="custom-control-label" for="customSwitch1">開啟 WHOIS 隱私保護</label>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </form>
                </div>
              </div>
            </div>
          </div>


            