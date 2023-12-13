<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Forgot Password &mdash; <?= get_compnay_title(); ?></title>
  <?php include('include-css.php'); ?></head>
 </head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
            <img src="<?= base_url('assets/icons/'.(!empty(get_full_logo())?get_full_logo():'logo.png')); ?>" alt="logo" width="350">
            </div>

            <div class="card card-primary">
              <div class="card-header"><h4>Forgot Password</h4></div>

              <div class="card-body">
                <p class="text-muted">We will send a link to reset your password</p>
                <div id="success-result d-none" class="alert alert-success"></div>
                <form action="<?= base_url('auth/forgot_password'); ?>" id="forgot_password_form">
                  <div class="form-group">
                    <label for="identity">Email</label>
                    <input id="identity" type="identity" class="form-control" name="identity" tabindex="1" required autofocus>
                  </div>

                  <div id="login-result" class="alert alert-info d-none">
                  </div>

                  <div class="form-group">
                    <button type="submit" id="loginbtn" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Forgot Password
                    </button>
                  </div> 
                </form>
              </div>
            </div>
            <div class="simple-footer">
              Copyright &copy; <?= get_compnay_title(); ?> <?=date('Y');?>
              <br>
              Design & Developed By <a href="https://www.infinitietech.com/" target="_blank">Infinitie Technologies</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>


<script>
    csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
    csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
</script>

<?php include('include-js.php'); ?>

</body>

</html>