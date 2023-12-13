<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Change Password &mdash; <?= get_compnay_title(); ?></title>
  <?php include('include-css.php'); ?></head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="<?= base_url('assets/icons/'.get_half_logo()); ?>" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>

            <div class="card card-primary">
              <div class="card-header"><h4>Change Password</h4></div>

              <div class="card-body">

                <?=form_open('auth/reset_password/' . $code, 'id="reset_password_form"'); ?>
                  <div class="form-group">
                    <label for="email">New Password</label>
                    <?php echo form_input($new_password);?>
                    <div class="invalid-feedback">
                      Enter new password.
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                    	<label for="password" class="control-label">Confirm Password</label>
                    </div>

                    <?php echo form_input($new_password_confirm);?>
                    <div class="invalid-feedback">
                      Confirm new password
                    </div>
                  </div>

                  <?php echo form_input($user_id);?>
	                <?php echo form_hidden($csrf); ?>

                  <div id="login-result" class="alert alert-info" style="display: none;">
                  </div>
                  <div class="form-group">
                    <button type="submit" id="loginbtn" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Confirm
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <div class="simple-footer">
              Copyright &copy; <?= get_compnay_title(); ?> <?=date('Y');?>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div> 

  <?php include('include-js.php'); ?>

</body>

</html>