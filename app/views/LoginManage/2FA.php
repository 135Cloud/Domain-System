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
              <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-2">Two-Factor Authentication</h1>
                    <p class="mb-4">請在下方輸入您的2FA驗證密碼</p>
                  </div>
                  <form class="user" method="post" action="?hash=<?=$_HTML['hash']?>">
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" name="2fa" placeholder="Enter 2FA token...">
                    </div>
                    <input type="hidden" class="form-control" name="hide" value="<?=$_HTML['hash_check']?>">
                    <button type="submit" class="btn btn-primary btn-user btn-block">Submit</button>
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

</body>

</html>
