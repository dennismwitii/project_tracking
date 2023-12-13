<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Profile &mdash; <?= get_compnay_title(); ?></title>
  <?php include('include-css.php'); ?>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropper/3.0.0-rc/cropper.min.css" />

  <style type="text/css">
    /* Limit image width to avoid overflow the container */
    img {
      max-width: 100%; /* This rule is very important, please do not ignore this! */
    }
  </style>
</head>

</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">

          <?php include('include-header.php'); ?>
      <!-- Main Content -->
      <div class="main-content"> 
        <section class="section">
          <div class="section-header">
            <h1><?= !empty($this->lang->line('label_profile'))?$this->lang->line('label_profile'):'Profile'; ?></h1>
          </div>
          <div class="section-body">

            <div class="row mt-sm-4">
              <div class="col-md-12">
                <div class="card">
                <?=form_open('auth/edit_user/'.$user->id, 'id="update_user_profile"', 'class="needs-validation"' ); ?>
                    <div class="card-header">
                      <h4><?= !empty($this->lang->line('label_edit'))?$this->lang->line('label_edit'):'Edit '; ?> <?= !empty($this->lang->line('label_profile'))?$this->lang->line('label_profile'):'Profile'; ?></h4>
                    </div>
                    <div class="card-body">

                        <div class="row justify-content-center">
                          <div class="avatar-item col-md-3">

                            <?php if(isset($user->profile) && !empty($user->profile)){ ?>
                              <img alt="image" id="profile_image" src="<?= base_url('assets/profiles/'.$user->profile); ?>" class="img-fluid mb-2">
                            <?php }else{ ?>
                              <figure class="avatar mb-2 avatar-xl" data-initial="<?= mb_substr($user->first_name, 0, 1).''.mb_substr($user->last_name, 0, 1); ?>"></figure>
                            <?php } ?>
                            
                            <div class="custom-file">
                              <input type="file" name="test" class="custom-file-input" id="customFile">
                              <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>

                          </div>
                          <div class="col-md-4">
                                <canvas id="canvas">
                                  Your browser does not support the HTML5 canvas element.
                                </canvas>
                            </div>
                        </div>

                        <div class="row">                               
                          <div class="form-group col-md-4 col-12">
                            <label><?= !empty($this->lang->line('label_first_name'))?$this->lang->line('label_first_name'):'First Name'; ?></label>
                            <input name="id" type="hidden" id="id" value="<?= $user->id ?>" >
                            <input type="hidden" name="old_profile" value="<?= !empty($user->profile)?$user->profile:'' ?>">
                            <input name="first_name" class="form-control" value="<?= $user->first_name ?>">    
                          </div>
                          <div class="form-group col-md-4 col-12">
                            <label><?= !empty($this->lang->line('label_last_name'))?$this->lang->line('label_last_name'):'Last Name'; ?></label>
                            <input name="last_name" class="form-control" value="<?= $user->last_name ?>">
                          </div>
                          <div class="form-group col-md-4 col-12">
                            <label><?= !empty($this->lang->line('label_contact'))?$this->lang->line('label_contact'):'Phone'; ?></label>
                            <input name="phone" class="form-control" value="<?= $user->phone ?>">
                          </div>
                          <?php if(is_client()){ ?>
                          <div class="form-group col-md-4 col-12">
                            <label><?= !empty($this->lang->line('label_company'))?$this->lang->line('label_company'):'Company'; ?></label>
                            <input name="company" class="form-control" value="<?= $user->company ?>">
                          </div>
                          <?php } ?>
                        </div>
                        
                        <div class="row">  
                        
                          <div class="form-group col-md-12">
                              
                            <label><?= !empty($this->lang->line('label_chat_theme'))?$this->lang->line('label_chat_theme'):'Chat Theme'; ?></label>
                            
                            <select class="form-control" name="chat_theme_preference" id="chat_theme_preference">
                              <?php $chat_theme = get_chat_theme();
                                if($chat_theme != false){

                                  if($chat_theme == 'chat-theme-light'){ ?>
                                    <option value="chat-theme-light" selected>Light Theme</option>
                                    <option value="chat-theme-dark" >Dark Theme</option>
                                    <?php }else{ ?>
                                    <option value="chat-theme-light" >Light Theme</option>
                                    <option value="chat-theme-dark" selected>Dark Theme</option>
                                    <?php } }else{ ?>
                                  <option value="chat-theme-light" selected>Light Theme</option>
                                  <option value="chat-theme-dark" >Dark Theme</option>

                                <?php } ?>
                                
                              </select>
                              
                          </div>
                          
                          
                        </div>
                        
                          
                        <div class="row">
                          <div class="form-group col-md-6 col-12">
                            <label><?= !empty($this->lang->line('label_password'))?$this->lang->line('label_password'):'Password'; ?> (Leave it blank for no changes)</label>
                            <input name="password" class="form-control" value="">
                          </div>
                          <div class="form-group col-md-6 col-12">
                            <label><?= !empty($this->lang->line('label_confirm_password'))?$this->lang->line('label_confirm_password'):'Confirm Password'; ?></label>
                            <input name="password_confirm" class="form-control" value="">
                          </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                      <button class="btn btn-primary"><?= !empty($this->lang->line('label_save_changes'))?$this->lang->line('label_save_changes'):'Save Changes'; ?></button>
                    </div>
                  </form>
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
  
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropper/3.0.0-rc/cropper.min.js"></script>

</body>

</html>