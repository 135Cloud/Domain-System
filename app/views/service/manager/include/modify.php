          <div class="row">
            <div class="col-md-3 mb-4">
            <div class="box box-solid mb-4">
                <div class="list-group">
                  <a class="list-group-item list-group-item-action" href="?id=<?=$id?>">概觀</a>
                  <a class="list-group-item list-group-item-action" href="?id=<?=$id?>&amp;manage=details">詳細資料</a>
                </div>
              </div>
              <div class="box box-solid">
                <div class="list-group mb-4">
                  <a class="list-group-item list-group-item-action" href="?id=<?=$id?>&amp;manage=renewal">續費訂閱</a>
                  <a class="list-group-item list-group-item-action active" href="?id=<?=$id?>&amp;manage=modify">方案升級</a>
                </div>
              </div>
            </div>
                  
            <div class="col-md-9">
              <div class="card mb-4">
                <div class="card-header">
                方案選項
                </div>
                <div class="card-body">
                  <form method=POST>
                    <div class="form-group">
                      可選方案
                      <?=@$_HTML['cyc']?>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </form>
								</div>
              </div>
              <div class="card mb-4">
                <div class="card-header">
                  訂閱資訊
                </div>
                <div class="card-body">
									<p>當前方案名稱： <?=@$_HTML['plan_name']?></p>
									<p>訂閱到期日期： <?=@$_HTML['expire']?></p>
									<p>訂閱剩餘日期： <?=@$_HTML['expire_left']?> 天</p>
								</div>
              </div>
            </div>
          </div>


            