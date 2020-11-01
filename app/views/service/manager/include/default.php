          <div class="row">
            <div class="col-md-3 mb-4">
            <div class="box box-solid mb-4">
                <div class="list-group">
                  <a class="list-group-item list-group-item-action active" href="?id=<?=$id?>">概觀</a>
                  <a class="list-group-item list-group-item-action" href="?id=<?=$id?>&amp;manage=details">詳細資料</a>
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
                概觀
                </div>
                <div class="card-body">
									<p class="lead">當前狀態 <?=@$_HTML['status']?></p>
									<p class="lead">建立於　 <?=@$service_result['cr_date']?></p>
									<p class="lead">訂閱名稱 <?=@$service_result['name']?></p>
									<p class="lead">IP <?=@$service_result['dns_ip_address']?></p>
                  <?=@$login_btn;?>
								</div>
							</div>
            </div>
          </div>


            