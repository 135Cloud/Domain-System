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
                  <p>可以為您的域名建立和管理自己的 nameserver。像是 ns1.<?=$domain?> 或 ns2.<?=$domain?> 等名稱</p>
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
                  註冊 DNS 伺服器
                </div>
                <div class="card-body">
                  <buttom href="#" class="btn btn-info btn-block" data-toggle="modal" data-target="#editRegDNS">新增 DNS 記錄</buttom><br>
                  <?=@$_HTML['dns_list']?>
                </div>
              </div>
            </div>
          </div>


            <!-- Modal -->
          <div class="modal fade" id="editRegDNS" tabindex="-1" role="dialog" aria-labelledby="editRegDNSTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <form method="POST">
                  <div class="modal-header">
                    <h5 class="modal-title" id="editRegDNSTitle">修改 DNS 記錄</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="form-group">
                      <label>主機名</label>
                      <input type="text" class="form-control" id="reg_host" name="host">
                    </div>
                    <div class="form-group">
                      <label>IP</label>
                      <textarea class="form-control" id="reg_ip" name="ips" rows="3">
                      </textarea>
                      <small class="form-text text-muted">一行 1 個 IP ，最多可設定 13 個。</small>
                    </div>
                    <div class="form-group" id="del_btn_div">
                      <a href="" class="btn btn-danger btn-sm" id="remove_link" onClick="return confirm('確定要刪除?');">DELETE</a>
                    </div>
                  </div>
                  <div class="modal-footer">
                    
                    <input name="ohost" id="RegDNS_old" hidden>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                  </div>
                </form>
              </div>
            </div>
          </div>