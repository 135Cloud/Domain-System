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

          <?php if(@$error_info){ ?><h1 class="h3 mb-4 text-gray-800"></h1>
          <div class="card mb-4 py-2 border-bottom-warning">
            <div class="card-body">
              <?=$error_info?>
            </div>
          </div><?php } ?>


          <div class="card mb-4 py-3 border-bottom-primary">
            <div class="card-body">
              <form method="POST" action="?mod=check">
                <fieldset>
                  <div class="form-group">
                    <label for="name_want_to_register">欲註冊域名名稱</label>
                    <input type="text" class="form-control" id="name_want_to_register" name="domain" placeholder="example.com">
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </fieldset>
              </form>
            </div>
          </div>

          <div class="card mb-4 ">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">域名價格</h6>
            </div>
            <div class="card-body">
              <div class="my-2"></div>
              <table id="contact_table" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th width=40%>TLD</th>
                  <th width=60%>註冊/續費</th>
                </tr>
                </thead>
                <tbody>
                <?=@$_data['table']?>
                </tbody>
              </table>
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
