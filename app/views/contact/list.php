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
              <h6 class="m-0 font-weight-bold text-primary">註冊人資料管理</h6>
            </div>
            <div class="card-body">
                <a href="<?=$_Global['URL']?>/Contact/Add" class="btn btn-primary btn-icon-split btn-sm">
                    <span class="text">新增域名註冊人資訊</span>
                  </a>
              <div class="my-2"></div>
              <table id="contact_table" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>聯絡人</th>
                  <th>公司名</th>
                  <th>E-mail</th>
                </tr>
                </thead>
                <tbody>
                <?=@$_data['table']?>
                </tbody>
                <tfoot>
                <tr>
                  <th>聯絡人</th>
                  <th>公司名</th>
                  <th>E-mail</th>
                </tr>
                </tfoot>
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
  <script src="<?=$_Global['URL']?>/static/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?=$_Global['URL']?>/static/vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script>
  $(function () {
    $('#contact_table').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
</body>

</html>