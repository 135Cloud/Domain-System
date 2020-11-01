          <div class="row">
            <div class="col-md-3 mb-4">
              <div class="box box-solid">
                <div class="list-group">
                  <a class="list-group-item list-group-item-action active" href="?domain=<?=$domain?>">概觀</a>
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
              <div class="card">
                <div class="card-header">
                概觀
                </div>
                <div class="card-body">
									<p class="lead">註冊於　 <?=@$_HTML['created']?></p>
									<p class="lead">到期於　 <?=@$_HTML['expires']?></p>
									<p class="lead">網址狀態 <?=@$_HTML['status']?></p>
									<p class="lead">DNS設定 <?=@$_HTML['traffic_type']?></p>
									<p class="lead">域名鎖定 <?=@$_HTML['locked']?></p>
									<p class="lead">隱私保護 <?=@$_HTML['private']?></p>
									<p class="lead">E-mail驗證需求 <?=@$_HTML['email_verification_required']?></p>
									<?php if(@$_HTML['email_verification_required']=="是"){ ?><p><a class="btn btn-block btn-warning btn-sm" href="?domain=<?=$domain?>&authemail=ture">驗證E-mail</a></p><br/>如您系統通知後15天內未進行 E-mail 驗證，註冊商將會停用網址，網址將處於 clientHold 狀態。<?php } ?>
								</div>
							</div>
            </div>
          </div>


            