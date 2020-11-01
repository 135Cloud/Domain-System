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
          
          <?php if(@$_HTML['error']){ ?><div class="alert alert-dismissible alert-danger"><?=$_HTML['error']?></div><?php }?>


          <div class="card mb-4">
            <div class="card-body">
              選擇方案為 <b class="h4"><?=@$_HTML['Plan_name']?></b>
            </div>
          </div>

          <form method=POST>
          <div class="card mb-4">
            <div class="card-header">
              選擇結算週期
            </div>
            <div class="card-body">
              <div class="form-group">
                <?=@$_HTML['cyc']?>
              </div>
            </div>
          </div>
          
          <div class="card mb-4">
            <div class="card-header">
              選擇欲使用網址
            </div>
            <div class="card-body">
              <div class="accordion" id="accordionExample">
                <div class="card">
                  <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                      <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        使用您已經在此註冊的網址
                      </button>
                    </h2>
                  </div>

                  <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body">
                       <div class="form-group">
                        <select class="form-control" name="select_domain">
                          <option disabled selected hidden>下拉選擇網址</option><?=$_HTML['domain']?>
                        </select>
                      </div>
                      <button type="submit" class="btn btn-primary">Submit</button>              
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header" id="headingTwo">
                    <h2 class="mb-0">
                      <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        使用在其他註冊商的網址 (您將需要更新DNS)
                      </button>
                    </h2>
                  </div>
                  <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="card-body">
                      <div class="form-group">
                        <input class="form-control" type="text" name="input_domain" placeholder="example.com"/>
                      </div>
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          </form>

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
