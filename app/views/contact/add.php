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
         


          <div class="card ">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">新增域名註冊人資訊</h6>
            </div>
            <div class="card-body">
              <form method="POST">
                <div class="row">
                  <fieldset class="col-lg-6">
                    <div class="form-group row">
                      <label  class="col-sm-3 col-form-label">姓氏<code>*</code></label>
                      <div class="col-sm-9">
                      <input type="text" class="form-control" name="last_name" placeholder="Last Name" value="<?=@$_POST['last_name']?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label  class="col-sm-3 col-form-label">名字<code>*</code></label>
                      <div class="col-sm-9">
                      <input type="text" class="form-control" name="first_name" placeholder="First Name" value="<?=@$_POST['first_name']?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label  class="col-sm-3 col-form-label">公司名</label>
                      <div class="col-sm-9">
                      <input type="text" class="form-control" name="company" placeholder="Company" value="<?=@$_POST['company']?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label  class="col-sm-3 col-form-label">Email<code>*</code></label>
                      <div class="col-sm-9">
                      <input type="email" class="form-control" name="email" placeholder="Email Address" value="<?=@$_POST['email']?>">
                      </div>
                    </div>
                  </fieldset>
                  <fieldset class="col-lg-6">
                    <div class="form-group row">
                      <label  class="col-sm-3 col-form-label">國別/地區<code>*</code></label>
                      <div class="col-sm-9">
                      <?=$_HTML['ct']?>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label  class="col-sm-3 col-form-label">州/省/地區<code>*</code></label>
                      <div class="col-sm-9">
                      <input type="text" class="form-control" name="state" placeholder="State/Province/Territory" value="<?=@$_POST['state']?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label  class="col-sm-3 col-form-label">城市<code>*</code></label>
                      <div class="col-sm-9">
                      <input type="text" class="form-control" name="city" placeholder="City" value="<?=@$_POST['city']?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label  class="col-sm-3 col-form-label">地址<code>*</code></label>
                      <div class="col-sm-9">
                      <input type="text" class="form-control" name="address" placeholder="Address" value="<?=@$_POST['address']?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label  class="col-sm-3 col-form-label">地址(第二行)</label>
                      <div class="col-sm-9">
                      <input type="text" class="form-control" name="address2" placeholder="Address2" value="<?=@$_POST['address2']?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label  class="col-sm-3 col-form-label">郵遞區號<code>*</code></label>
                      <div class="col-sm-9">
                      <input type="text" class="form-control" name="zip" placeholder="Zip/Postal Code" value="<?=@$_POST['zip']?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label  class="col-sm-3 col-form-label">電話號碼<code>*</code></label>
                      <div class="col-sm-9">
                      <input type="text" class="form-control" name="phone" placeholder="Phone Number" value="<?=@$_POST['phone']?>">
                      <small class="form-text text-muted">不須國碼(如+886)</small>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label  class="col-sm-3 col-form-label">傳真號碼</label>
                      <div class="col-sm-9">
                      <input type="text" class="form-control" name="fax" placeholder="Fax Number" value="<?=@$_POST['fax']?>">
                      <small class="form-text text-muted">不須國碼(如+886)</small>
                      </div>
                    </div>
                  </fieldset>
                </div>
                <small class="form-text text-muted">資料建議使用英文填寫，避免自動翻譯錯誤顯示。<br>英文名翻譯請參照<a href="https://www.boca.gov.tw/sp-natr-singleform-1.html" target="_blank">外交部領事事務局-姓名翻譯</a>，地址翻譯請參照<a href="https://www.post.gov.tw/post/internet/Postal/index.jsp?ID=207" target="_blank">中華郵政-中文地址英譯</a></small>
                <small class="form-text text-muted">沒有的資料留空即可，不需填寫。</small>
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
