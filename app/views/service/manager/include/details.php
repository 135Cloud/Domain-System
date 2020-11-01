          <div class="row">
            <div class="col-md-3 mb-4">
              <div class="box box-solid mb-4">
                <div class="list-group">
                  <a class="list-group-item list-group-item-action" href="?id=<?=$id?>">概觀</a>
                  <a class="list-group-item list-group-item-action active" href="?id=<?=$id?>&amp;manage=details">詳細資料</a>
                </div>
              </div>
              <?php if(@$_HTML['enable']){ ?>
              <div class="box box-solid">
                <div class="list-group mb-4">
                  <a class="list-group-item list-group-item-action" href="?id=<?=$id?>&amp;manage=renewal">續費訂閱</a>
                  <!--<a class="list-group-item list-group-item-action" href="?id=<?=$id?>&amp;manage=modify">方案升級</a>-->
                </div>
              </div>
              <?php } ?>
            </div>
            <div class="col-md-9">
              <div class="card mb-4">
                <div class="card-header">
                資源使用狀況
                </div>
                <div class="card-body">
									<p class="lead">域名數 已用 <?=@$service_result_stat['domains']?> 個 / 可用 <?=$service_result_limit['max_site']?> 個</p>
									<p class="lead">子域名 已用 <?=@$service_result_stat['subdom']?> 個 / 可用 <?=$service_result_limit['max_subdom']?> 個</p>
									<p class="lead">資料庫 已用 <?=@$service_result_stat['db']?> 個 / 可用 <?=$service_result_limit['max_db']?> 個</p>
									<p class="lead">email 已用 <?=@$service_result_stat['box']?> 個 / 可用 <?=$service_result_limit['']?> 個</p>
									<p class="lead">磁碟 已用 <?=@floor($service_result_stat['disk_space']/1048576)?> MB  / 可用 <?=$service_result_limit['disk_space']?> MB</p>
									<p class="lead">流量 已用 <?=@floor($service_result_stat['traffic']/1048576)?> MB / 可用 <?=$service_result_limit['max_traffic']?> MB</p>
                  <?=@$login_btn;?>
								</div>
							</div>
              <div class="card mb-4">
                <div class="card-header">
                訂閱資訊
                </div>
                <div class="card-body">
									<p class="lead">FTP帳號 <?=@$service_result_hosting['ftp_login']?></p>
									<p class="lead">FTP密碼 <?=@$service_result_hosting['ftp_password']?></p>
									<p class="lead">到期日 <?=@date('Y-m-d',$service_result_limit['expiration']);?></p>
								</div>
							</div>
              <div class="card mb-4">
                <div class="card-header">
                空間使用狀況
                </div>
                <div class="card-body">
									<p class="lead">httpdocs <?=@floor($service_result_disk_usage['httpdocs']/1048576)?> MB</p>
									<p class="lead">httpsdocs <?=@floor($service_result_disk_usage['httpsdocs']/1048576)?> MB</p>
									<p class="lead">Web用戶 <?=@floor($service_result_disk_usage['web_users']/1048576)?> MB</p>
									<p class="lead">匿名FTP <?=@floor($service_result_disk_usage['anonftp']/1048576)?> MB</p>
									<p class="lead">日誌 <?=@floor($service_result_disk_usage['logs']/1048576)?> MB</p>
									<p class="lead">資料庫 <?=@floor($service_result_disk_usage['dbases']/1048576)?> MB</p>
									<p class="lead">EMAIL <?=@floor($service_result_disk_usage['mailboxes']/1048576)?> MB</p>
									<p class="lead">郵件列表 <?=@floor($service_result_disk_usage['maillists']/1048576)?> MB</p>
									<p class="lead">domaindumps <?=@floor($service_result_disk_usage['domaindumps']/1048576)?> MB</p>
									<p class="lead">設定文件 <?=@floor($service_result_disk_usage['configs']/1048576)?> MB</p>
									<p class="lead">chroot <?=@floor($service_result_disk_usage['chroot']/1048576)?> MB</p>
                  <?=@$login_btn;?>
								</div>
							</div>
            </div>
          </div>


            