<?php require './app/views/common/header.php'; ?>

<body id="page-top" >
  <div class="container">
    <br>
    <h1 class="h3 mb-4 text-gray-800">Invoice #<?=$_GET['id']?></h1>
    <hr>
    <div class="row">
      <div class="col-lg-4 mb-4 float-xs-left">
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

      
      <div class="col-lg-4 mb-4 float-xs-left">
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

      
      <div class="col-lg-4 mb-4 float-xs-left">
        <div class="card">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">金流資訊</h6>
          </div>
          <div class="card-body text-center" style="height:170px">
          <?php if($invoice['status']=='active'){?>
          <p>付款方式：</p>
          <a href="?id=<?=$_GET['id']?>&payment=Credit" class="btn btn-secondary btn-sm">信用卡</a> 
          <a href="?id=<?=$_GET['id']?>&payment=WebATM" class="btn btn-secondary btn-sm">WebATM</a>
          <a href="?id=<?=$_GET['id']?>&payment=ATM" class="btn btn-secondary btn-sm">ATM</a>
          <a href="?id=<?=$_GET['id']?>&payment=CVS" class="btn btn-secondary btn-sm">超商代碼</a>
          <small class="form-text text-muted"><?=@$_HTML['notice_fee']?></small>
          
          <?php if(@!$disable_funds){ ?>
          <a href="?id=<?=$_GET['id']?>&payment=funds" class="btn btn-info btn-sm">預付款項</a>
          <a href="?id=<?=$_GET['id']?>&payment=discount" class="btn btn-info btn-sm">點數折抵</a>
          <?php } ?>
          <?php }else{?>
          <div class="bg-primary text-white p-3 d-inline-block my-4"><?=strtoupper($invoice['status'])?></div>
          <?php }?>
          
          
          </div>
        </div>
      </div>

    </div>

    <hr>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">項目</h6>
          </div>
          <div class="card-body">
          <?=$_HTML['invoice_line']?>
          </div>
        </div>
      </div>
    </div>

    <hr>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">金流記錄</h6>
          </div>
          <div class="card-body">
          <?=@$_HTML['payment_history']?>
          </div>
        </div>
      </div>
    </div>
    <br>
    <div style="text-align:center;"><a href="<?=$_Global['URL']?>/Invoice/List">回列表</a></div>
  </div>



  
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>



  <?php require './app/views/common/footer.php'; ?>
 
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
