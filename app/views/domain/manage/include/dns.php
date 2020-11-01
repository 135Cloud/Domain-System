          <div class="row">
            <div class="col-md-3 mb-4">
              <div class="box box-solid">
                <div class="list-group">
                  <a class="list-group-item list-group-item-action" href="?domain=<?=$domain?>">概觀</a>
                  <a class="list-group-item list-group-item-action" href="?domain=<?=$domain?>&amp;manage=dnsserver">DNS 伺服器</a>
                  <a class="list-group-item list-group-item-action" href="?domain=<?=$domain?>&amp;manage=domainlock">域名防盜</a>
                  <a class="list-group-item list-group-item-action active" href="?domain=<?=$domain?>&amp;manage=dns">管理 DNS 記錄</a>
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

<?php if(@$result){ ?>

              <div class="alert alert-dismissible alert-primary mb-4">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?=$result?>
              </div>

<?php }?>


              <div class="card border-left-info shadow mb-4">
                <div class="card-body">
                  <p>您可以使用下面的表單管理域名的 DNS 設定。更改後可能需要一段時間才會更新。<br>如果您無管理 DNS 經驗，請謹慎使用此表單。請記住，正確修改 DNS 記錄非常重要，任何錯誤都可能使您的網站、電子郵件或其他服務無法運行。</p>
                </div>
              </div>
              <div class="card mb-4">
                <div class="card-header">
                管理 DNS 記錄
                </div>
                <div class="card-body">
                  <buttom href="#" class="btn btn-info btn-block" data-toggle="modal" data-target="#AddDNSRecord">新增 DNS 記錄</buttom><br>
                  <?=@$_HTML['dns_list']?>
                </div>
              </div>
            </div>
          </div>
          <!-- Modal -->
          <div class="modal fade" id="editDNSRecord" tabindex="-1" role="dialog" aria-labelledby="editDNSRecordTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <form method="POST">
                  <div class="modal-header">
                    <h5 class="modal-title" id="editDNSRecordTitle">修改 DNS 記錄</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="form-group">
                      <label>Type</label>
                      <input type="text" class="form-control" id="DNS_type" disabled>
                    </div>
                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" class="form-control" id="DNS_name" name="nhost">
                    </div>
                    <div class="form-group">
                      <label>Value</label>
                      <input type="text" class="form-control" id="DNS_value" name="nvalue">
                    </div>
                    <div class="form-group" id="DNS_distance_div">
                      <label>Distance</label>
                      <input type="text" class="form-control" id="DNS_distance" name="ndistance">
                    </div>
                    <div class="form-group">
                      <label>TTL</label>
                      <input type="text" class="form-control" id="DNS_ttl" name="nttl">
                    </div>
                    <div class="form-group" id="del_btn">
                      <a href="" class="btn btn-danger btn-sm" id="remove_link" onClick="return confirm('確定要刪除?');">DELETE</a>
                    </div>
                  </div>
                  <div class="modal-footer">
                    
                    <input name="edit" id="DNS_edit_check" hidden>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Record</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <div class="modal fade" id="AddDNSRecord" tabindex="-1" role="dialog" aria-labelledby="AddDNSRecordTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <form method="POST">
                  <div class="modal-header">
                    <h5 class="modal-title" id="AddDNSRecordTitle">新增 DNS 記錄</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="form-group">
                      <label>Type</label>
                      <select class="form-control" name="type" id="NSType">
                        <option>A</option>
                        <option>AAAA</option>
                        <option>CNAME</option>
                        <option>MX</option>
                        <option>TXT</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" class="form-control" id="dnshost" placeholder="Name" name="nhost">
                    </div>
                    <div class="form-group">
                      <label>Value</label>
                      <input type="text" class="form-control" id="dnsvalue" name="nvalue" placeholder="The IPv4 Address" >
                    </div>
                    <div class="form-group">
                      <label>TTL</label>
                      <input type="text" class="form-control" id="DNS_ttl" name="nttl" placeholder="TTL">
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Record</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
            