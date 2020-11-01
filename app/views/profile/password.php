<?php require './app/views/common/header.php'; ?>

<body id="page-top">

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
          
          <?php if(@$_HTML['notice']){ ?><h1 class="h3 mb-4 text-gray-800"></h1>
          <div class="card mb-4 py-2 border-bottom-<?=$_HTML['status']?>">
            <div class="card-body">
            <?=$_HTML['notice']?>
            </div>
          </div><?php } ?>
         


          <div class="card ">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">修改密碼</h6>
            </div>
            <div class="card-body">
              <form method="POST">
                <fieldset>
                  <div class="form-group row">
                    <label  class="col-sm-3 col-form-label">原本的密碼<code>*</code></label>
                    <div class="col-sm-9">
                    <input type="password" class="form-control" name="old_password">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label  class="col-sm-3 col-form-label">新的密碼</label>
                    <div class="col-sm-9">
                    <input type="password" class="form-control" name="new_password">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label  class="col-sm-3 col-form-label">確認新密碼</label>
                    <div class="col-sm-9">
                    <input type="password" class="form-control" name="check_password">
                    </div>
                  </div>
                </fieldset>
                <div class="my-2"></div>
                <button type="submit" class="btn btn-primary">Submit</button>
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

</body>

</html>
