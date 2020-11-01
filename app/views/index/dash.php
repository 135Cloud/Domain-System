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
          <h1 class="h3 mb-4 text-gray-800">135Cloud 客戶管理系統</h1>
          <div class="row">
            <div class="col-lg-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">有效網址數量</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?=@$_HTML['domains_row']?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-book fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">有效服務數量</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?=@$_HTML['service_row']?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">待處理帳單數</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?=@$_HTML['invoice_count']?></div>
                    </div>
                    <div class="col-auto">
                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-lg-6 mb-4">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">可用服務</h6>
                </div>
                <div class="card-body">
                <table class="table table-hover">
                <thead>
                <th scope="col">訂閱方案</th>
                <th scope="col">建立時間</th>
                <th scope="col">到期時間</th>
                </thead>
                <tbody>
                <?=$_HTML['service']?>
                </tbody>
                </table>
                </div>
              </div>
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">逾期帳單</h6>
                  <a href="<?=$_Global['URL']?>/Invoice/List" class="btn btn-primary btn-icon-split btn-sm"><span class="icon text-white-50"><i class="fas fa-arrow-right"></i></span><span class="text">前往查看</span></a>
                </div>
                <div class="card-body">
                <?=$_HTML['invoice']?>
                </div>
              </div>
            </div>
            <div class="col-lg-6 mb-4">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">可用網址</h6>
                </div>
                <div class="card-body">
                <table class="table table-hover">
                <thead>
                <th scope="col">網址名稱</th>
                <th scope="col">註冊於</th>
                <th scope="col">到期日</th>
                </thead>
                <tbody>
                <?=$_HTML['domain']?>
                </tbody>
                </table>
                </div>
              </div>
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">最新消息</h6>
                  <a href="https://besv.net/forum-120-1.html" target="_blank" class="btn btn-primary btn-icon-split btn-sm"><span class="icon text-white-50"><i class="fas fa-arrow-right"></i></span><span class="text">檢視更多</span></a>
                </div>
                <div id=news>
                </div>
                
              </div>
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
  <script>
$.get("https://besv.net/api-announcement.php",function(data){data.forEach(function(array){document.getElementById("news").innerHTML+='<a href="https://besv.net/thread-'+array["id"]+'-1-1.html" class="list-group-item list-group-item-action flex-column align-items-start" target="_blank"><div class="d-flex w-100 justify-content-between"><h5 class="mb-1">'+array["subject"]+'</h5><small class="text-muted">'+array["time"]+'</small></div></a>';});});</script>
</body>

</html>
