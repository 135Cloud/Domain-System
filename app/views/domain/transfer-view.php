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
         


          <div class="card mb-4 ">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">轉移狀態</h6>
            </div>
            <div class="card-body">
              <P><?=@$_HTML['trans_status']?></P>  
              <P><?=@$_HTML['trans_message']?></P>  
            
            </div>
          </div>

          <?php if(@$_HTML['show_epp']){ ?>
          <div class="card mb-4 ">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">EPP 轉移代碼相關</h6>
            </div>
            <div class="card-body">
              <form role="form" method=POST>
                <div class="form-group">
                  <label>EPP Code</label>
                  <input type="text" class="form-control" placeholder="轉入授權碼" name="epp">
								  <small class="form-text text-muted"><?=@$_HTML['epp_help']?></small>
                </div>
                <button type="submit" class="btn btn-primary">UPDATE</button>
              </form>
            </div>
          </div>
          <?php } ?>

          <div class="card mb-4 ">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">其他動作</h6>
            </div>
            <div class="card-body">
              *下方功能僅在需要使用時才會有作用。
            <p><form method=POST><input name=resend value=true hidden><button type="submit" class="btn btn-secondary">重新寄送驗證信給管理連絡人</button></form></p>
            <p><form method=POST><input name=resubmit value=true hidden><button type="submit" class="btn btn-secondary">重新向註冊機構送出轉移要求</button></form></p>
            
            <!--<br><p><form method=POST><input name=update value=true hidden><button type="submit" class="btn btn-secondary">手動更新資料庫狀態</button></form></p>-->
               
            
            
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
  
</body>

</html>
