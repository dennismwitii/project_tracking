<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Settings &mdash; <?= get_compnay_title(); ?></title>
  <?php include('include-css.php'); ?>
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">

    <?php include('include-header.php'); ?>
    
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1><?= !empty($this->lang->line('label_settings'))?$this->lang->line('label_settings'):'Settings'; ?></h1>
          </div>

          <div class="section-body">

            <div class="row">
              <div class="col-lg-6">
                <div class="card card-large-icons">
                  <div class="card-icon bg-primary text-white">
                    <i class="fas fa-cog"></i>
                  </div>
                  <div class="card-body">
                    <h4><?= !empty($this->lang->line('label_general'))?$this->lang->line('label_general'):'General'; ?></h4>
                    <p>General settings such as, site title, site description, address and so on.</p>
                    <a href="<?= base_url('settings/setting-detail'); ?>" class="card-cta"><?= !empty($this->lang->line('label_change_settings'))?$this->lang->line('label_change_settings'):'Change Setting'; ?> <i class="fas fa-chevron-right"></i></a>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="card card-large-icons">
                  <div class="card-icon bg-primary text-white">
                    <i class="fas fa-envelope"></i>
                  </div>
                  <div class="card-body">
                    <h4><?= !empty($this->lang->line('label_email'))?$this->lang->line('label_email'):'Email'; ?></h4>
                    <p>Email SMTP settings, notifications and others related to email.</p>
                    <a href="<?= base_url('settings/setting-detail'); ?>" class="card-cta"><?= !empty($this->lang->line('label_change_settings'))?$this->lang->line('label_change_settings'):'Change Setting'; ?> <i class="fas fa-chevron-right"></i></a>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="card card-large-icons">
                  <div class="card-icon bg-primary text-white">
                    <i class="fas fa-power-off"></i>
                  </div>
                  <div class="card-body">
                    <h4><?= !empty($this->lang->line('label_system'))?$this->lang->line('label_system'):'System'; ?></h4>
                    <p>FCM and other important settings</p>
                    <a href="<?= base_url('settings/setting-detail'); ?>" class="card-cta"><?= !empty($this->lang->line('label_change_settings'))?$this->lang->line('label_change_settings'):'Change Setting'; ?> <i class="fas fa-chevron-right"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
      
      <?php include('include-footer.php'); ?>

    </div>
  </div>

  <?php include('include-js.php'); ?>

</body>

</html>