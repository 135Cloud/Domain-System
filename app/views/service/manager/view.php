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
          <h1 class="h3 mb-4 text-gray-800"><?=$_HTML['title']?> - <?=strtoupper($result['name'])?></h1>


          <?php @include($panel_html);?>
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
    $('#table').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
    })
  })

  <?=@$_HTML['footer_js']?>
</script>
</body>

</html>
