<?php require './app/views/common/header.php'; ?>

<body id="page-top" >

  <!-- Page Wrapper -->
  <div id="wrapper">

    <?php require './app/views/common/sidebar.php'; ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      <?php require './app/views/common/menu.php'; ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?=$_HTML['title']?></h1>
         


          <div class="card ">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">餘額儲值</h6>
            </div>
            <div class="card-body">
                <form method=POST>
                    <div class="form-group">
                        <label class="control-label">欲儲值金額</label>
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                <span class="input-group-text">NT$</span>
                                </div>
                                <input type="text" class="form-control" name="amount" aria-label="Amount (to the nearest dollar)">
                                <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">送出</button>
                                </div>
                            </div>
                            <small class="form-text text-muted">儲值最低金額為 500 元。</small>
                            <small class="form-text text-muted">儲值行為無法與其他商品一同結帳，儲值不可使用點數折扣，送出後將自動轉單到帳單。</small>
                        </div>
                    </div>
                </form>
            </div>
          </div>



        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; <?=$_HTML['copyright']?></span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

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

</html>
