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

              <form method="POST" action="?mod=add_to_cart">
                <fieldset>
                    <div class="form-group">
                        <label for="staticdomain">欲轉入域名</label>
                        <input type="text" readonly class="form-control-plaintext" id="staticdomain" value="<?=$_data['domain']?>">
                    </div>
                    <div class="form-group">
                        <label for="staticpirce">轉入所需費用</label>
                        <input type="text" readonly class="form-control-plaintext" id="staticpirce" value="<?=$_data['domian_price']?>/年">
                    </div>
                    <div class="form-group">
                        <label for="name_want_to_register">WHOIS聯繫人資料</label>
                        <select name="contact_id" class="form-control">
                        <?=$_HTML['domain_contact']?>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="whoisprivate" name="private" checked>
                            <label class="custom-control-label" for="whoisprivate">啟用 WHOIS 隱私保護服務(免費)</label>
                        </div>
                    <small id="Help" class="form-text text-muted">根據 ICANN 法規, 每個域名註冊機構都需要維護一個名為「WHOIS」的公開存取資料庫, 其中包含所有註冊域名的聯繫資訊。</small>
                    </div>
                    <div class="form-group">
                        <label for="epp">域名轉移密碼</label>
                        <input type="text" class="form-control" id="epp" name="epp" placeholder="Epp Code / Auth Code">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </fieldset>
                
                <input type="text" name="domain" value="<?=$_data['domain']?>" hidden>
                <input type="text" name="hash" value="<?=$_data['check_hash']?>" hidden>
                <input type="text" name="key" value="<?=$_data['check_key']?>" hidden>
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
