<?php require './app/views/common/header.php'; ?>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">建立您的資訊</h1>
                  </div>
                  <form class="user" method="post" action="?hash=<?=$_HTML['hash']?>">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" name="contactName" placeholder="您的姓名">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" name="contactEmail" placeholder="帳務電子郵件">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" name="dev_phone" placeholder="連絡電話號碼(非台灣號碼需加國碼)">
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">送出資訊</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <?php require './app/views/common/footer.php'; ?>

  <?php if(@$_HTML['error']){ ?>
  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="ture">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content border-bottom-danger">
        <div class="modal-body">
          <br>
          <p class="text-center text-danger"><?=$_HTML['error']?></p>
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