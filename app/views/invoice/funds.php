<?php require './app/views/common/header.php'; ?>

<body id="page-top" >
  <div class="container">
    <br>
    <h1 class="h3 mb-4 text-gray-800">Invoice #<?=$_GET['id']?></h1>
    <hr>
    <div class="row">
      <div class="col-xs-12 col-md-4 float-xs-left">
        <div class="card">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">付款人資訊</h6>
          </div>
          <div class="card-body" style="height:170px">
          <?=$_HTML['userinfo']?>
          <div class="my-2"></div>
          </div>
        </div>
      </div>

      
      <div class="col-xs-12 col-md-4 float-xs-left">
        <div class="card">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">付款資訊</h6>
          </div>
          <div class="card-body" style="height:170px">
          <p>帳單成立 <?=$invoice['date_create']?></p>
          <p>付款時間 <?=$invoice['date_billed']?></p>
          <p>繳費期限 <?=$invoice['date_due']?></p>
          <div class="my-2"></div>
          </div>
        </div>
      </div>

      
      <div class="col-xs-12 col-md-4 float-xs-left">
        <div class="card">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">帳單資訊</h6>
          </div>
          <div class="card-body" style="height:170px">
            <p>應付金額：<?=@$_HTML['totals']?><br>實付金額：<?=@$_HTML['paid']?></p>
            <p><?=@$_HTML['funds_txt']?>：<?=@$_HTML['funds']?></p>
          </div>
        </div>
      </div>

    </div>

    <hr>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
          <?php if($_GET['ec']=='funds'){ ?>
            <form method=POST>
              <div class="form-group">
                <label class="control-label">使用餘額支付金額</label>
                <div class="form-group">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">$</span>
                    </div>
                    <input type="text" class="form-control" name="pay_amount" value="<?=@$_HTML['default_amout']?>" aria-label="Amount (to the nearest dollar)">
                    <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">送出</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          <?php }if($_GET['ec']=='points'){ ?>
            <form method=POST>
              <div class="form-group">
                <label class="control-label">使用論壇點數折扣</label>
                <div class="form-group">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">$</span>
                    </div>
                    <input type="text" class="form-control" name="pay_amount" value="<?=@$_HTML['default_amout']?>" aria-label="Amount (to the nearest dollar)">
                    <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">送出</button>
                    </div>
                    
                  </div>
                  <small class="form-text text-muted">使用論壇積分"點數"，可折抵帳單部分金額，折抵上限總金額為10%。</small>
                </div>
              </div>
            </form>
          <?php } ?>
          </div>
        </div>
      </div>
    </div>
    <br>
    <div style="text-align:center;"><a href="#" onclick="window.history.go(-1); return false;">返回</a></div>
  </div>



  
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>



  <?php require './app/views/common/footer.php'; ?>
 


  <?php if(@$error){ ?>
  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="ture">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content border-bottom-danger">
        <div class="modal-body">
          <br>
          <p class="text-center text-danger"><?=$error?></p>
        </div>
      </div>
    </div>
  </div>
  <script>
  $('#myModal').modal('show');
  </script>
  <?php } ?> 

</body>
<style>

.table > tbody > tr > .emptyrow {
    border-top: none;
}
.table > tbody > tr > .highrow {
    border-top: 3px solid;
}
</style>
</html>
