<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>General Settings &mdash; <?= get_compnay_title(); ?></title>
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
            <h1><?= !empty($this->lang->line('label_settings'))?$this->lang->line('label_settings'):'Settings'; ?> (<?= !empty($this->lang->line('label_version'))?$this->lang->line('label_version'):'Version'; ?> <?=get_system_version();?>) </h1> <a href="<?=base_url('updater');?>"> <?= !empty($this->lang->line('label_update'))?$this->lang->line('label_update'):'Update'; ?></a>
          </div>

          <div class="section-body">

            <div id="output-status"></div>
            <div class="row">
              <div class="col-md-4">
                <div class="card">
                  <div class="card-header">
                    <h4><?= !empty($this->lang->line('label_jump_to'))?$this->lang->line('label_jump_to'):'Jump To'; ?></h4>
                  </div>
                  <div class="card-body">
                    <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="general-tab4" data-toggle="tab" href="#general-settings" role="tab" aria-controls="general" aria-selected="true"><?= !empty($this->lang->line('label_general'))?$this->lang->line('label_general'):'General'; ?></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="email-tab4" data-toggle="tab" href="#email-settings" role="tab" aria-controls="email" aria-selected="false"><?= !empty($this->lang->line('label_email'))?$this->lang->line('label_email'):'Email'; ?></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="system-tab4" data-toggle="tab" href="#system-settings" role="tab" aria-controls="system" aria-selected="false"><?= !empty($this->lang->line('label_system'))?$this->lang->line('label_system'):'System'; ?></a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <div class="tab-content no-padding" id="myTab2Content">


                  <div class="tab-pane fade show active" id="general-settings" role="tabpanel" aria-labelledby="general-tab4">
                    <form action="<?= base_url('settings/save_settings'); ?>" method="POST" id="general-setting-form" autocomplete="off">
                      <div class="card" id="general-settings-card">
                        <div class="card-header">
                          <h4><?= !empty($this->lang->line('label_general_settings'))?$this->lang->line('label_general_settings'):'General Settings'; ?></h4>
                        </div>
                        
                        <div class="card-body">
                          <p class="text-muted">General settings such as, company title, company logo and so on.</p>

                          <div class="form-group row align-items-center">
                            <label for="company_title" class="form-control-label col-sm-3 text-md-right"><?= !empty($this->lang->line('label_company_title'))?$this->lang->line('label_company_title'):'Company Title'; ?></label>
                            <div class="col-sm-6 col-md-9">
                                
                              <input type="hidden" name="<?= $this->security->get_csrf_token_name();
                              ?>" class="form-control"  value="<?= $this->security->get_csrf_hash(); ?>">
                              
                              <input type="hidden" name="setting_type" class="form-control"  value="general">
                              
                              <input type="text" name="company_title" class="form-control" id="company_title" value="<?= !empty($data->company_title)?$data->company_title:'' ?>" required>
                              
                            </div>
                          </div>

                          <div class="form-group row align-items-center">
                            <label for="app_url" class="form-control-label col-sm-3 text-md-right"><?= !empty($this->lang->line('label_app_url'))?$this->lang->line('label_app_url'):'App URL'; ?></label>
                            <div class="col-sm-6 col-md-9">
                              <input type="text" name="app_url" class="form-control" id="app_url" value="<?= !empty($data->app_url)?$data->app_url:'' ?>" required>
                              
                            </div>
                          </div>

                          <div class="form-group row align-items-center">
                            <label class="form-control-label col-sm-3 text-md-right"><?= !empty($this->lang->line('label_full_logo'))?$this->lang->line('label_full_logo'):'Full Logo'; ?></label>
                            <div class="col-sm-6 col-md-9">
                              <div class="custom-file">
                                <input type="file" name="full_logo" class="custom-file-input" id="full_logo">
                                <input type="hidden" name="full_logo_old" class="custom-file-input" id="full_logo_old" value="<?= !empty($data->full_logo)?$data->full_logo:'' ?>">
                                <label class="custom-file-label"><?= !empty($this->lang->line('label_choose_file'))?$this->lang->line('label_choose_file'):'Choose File'; ?></label>
                              </div>
                              <div class="form-text text-muted">The image must have a maximum size of 1MB</div>
                            </div>
                          </div>
                          <div class="form-group row align-items-center">
                            <label class="form-control-label col-sm-3 text-md-right"><?= !empty($this->lang->line('label_half_logo'))?$this->lang->line('label_half_logo'):'Half Logo'; ?></label>
                            <div class="col-sm-6 col-md-9">
                              <div class="custom-file">
                                <input type="file" name="half_logo" class="custom-file-input" id="half_logo">
                                <input type="hidden" name="half_logo_old" class="custom-file-input" id="half_logo_old" value="<?= !empty($data->half_logo)?$data->half_logo:''; ?>">
                                <label class="custom-file-label"><?= !empty($this->lang->line('label_choose_file'))?$this->lang->line('label_choose_file'):'Choose File'; ?></label>
                              </div>
                              <div class="form-text text-muted">The image must have a maximum size of 1MB</div>
                            </div>
                          </div>
                          <div class="form-group row align-items-center">
                            <label class="form-control-label col-sm-3 text-md-right"><?= !empty($this->lang->line('label_favicon'))?$this->lang->line('label_favicon'):'Favicon'; ?></label>
                            <div class="col-sm-6 col-md-9">
                              <div class="custom-file">
                                <input type="file" name="favicon" class="custom-file-input" id="favicon">
                                <input type="hidden" name="favicon_old" class="custom-file-input" id="favicon_old" value="<?= !empty($data->favicon)?$data->favicon:''; ?>">
                                <label class="custom-file-label"><?= !empty($this->lang->line('label_choose_file'))?$this->lang->line('label_choose_file'):'Choose File'; ?></label>
                              </div>
                              <div class="form-text text-muted">The image must have a maximum size of 1MB</div>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label class="form-control-label col-sm-3 mt-3 text-md-right"><?= !empty($this->lang->line('label_timezone'))?$this->lang->line('label_timezone'):'Timezone'; ?></label>
                            <div class="col-sm-6 col-md-9">
                            <input type="hidden" id="mysql_timezone" name="mysql_timezone" value="<?php if(!empty($data->mysql_timezone)){ echo $data->mysql_timezone; }else{echo '+05:30';} ?>">
                              <select class="form-control select2" name="php_timezone" id="php_timezone">
                              <?php $options = getTimezoneOptions(); ?>
                                <?php foreach($options as $option){ ?>
                                <option value="<?=$option[2]?>" data-gmt="<?=$option['1'];?>" <?=(isset($data->php_timezone) && $data->php_timezone == $option[2])?'selected':'';?>><?=$option[2]?> - GMT <?=$option[1]?> - <?=$option[0]?></option>
                                <?php } ?>
                              </select>

                            </div>
                          </div>
                          
                          <div class="form-group row">
                            <label class="form-control-label col-sm-3 mt-3 text-md-right"><?= !empty($this->lang->line('label_system_fonts'))?$this->lang->line('label_system_fonts'):'System Fonts'; ?> <br><a href="#" id="modal-add-fonts"><?= !empty($this->lang->line('label_manage'))?$this->lang->line('label_manage'):'Manage'; ?></a></label>
                            
                            <div class="col-sm-6 col-md-9">
                            
                              <select class="form-control select2" name="system_fonts" id="system_fonts">
                                <option value="default">Default</option>
                                <?php
                                $my_system_fonts = get_system_fonts();
                                  $my_fonts = json_decode($my_fonts);
                                  if(!empty($my_fonts) && is_array($my_fonts)){
                                    foreach($my_fonts as $my_font){
                                    if(!empty($my_font->id) && !empty($my_font->font_cdn) && !empty($my_font->font_name) && !empty($my_font->font_family) && !empty($my_font->class)){ ?>
                                    <option value="<?=$my_font->id?>" <?=($my_system_fonts != 'default' && $my_system_fonts->id == $my_font->id)?'selected':''?>><?=$my_font->font_name?></option>
                                <?php } } }?>
                              </select>
                            </div>
                          </div>


                          <div class="form-group row align-items-center">
                            <label for="currency_full_form" class="form-control-label col-md-3 text-md-right"><?= !empty($this->lang->line('currency_full_form'))?$this->lang->line('currency_full_form'):'Currency Full Form'; ?></label>
                            <div class="col-md-9">
                              
                              <input type="text" name="currency_full_form" class="form-control" id="currency_full_form" value="<?= !empty($data->currency_full_form)?$data->currency_full_form:'' ?>" required>
                              
                            </div>
                          </div>

                          
                          <div class="form-group row align-items-center">
                            <label for="currency_symbol" class="form-control-label col-md-3 text-md-right"><?= !empty($this->lang->line('label_currency_symbol'))?$this->lang->line('label_currency_symbol'):'Currency Symbol'; ?></label>
                            <div class="col-md-3">
                              
                              <input type="text" name="currency_symbol" class="form-control" id="currency_symbol" value="<?= !empty($data->currency_symbol)?$data->currency_symbol:'' ?>" required>
                              
                            </div>

                            <label for="currency_shortcode" class="form-control-label col-md-3 text-md-right"><?= !empty($this->lang->line('label_currency_shortcode'))?$this->lang->line('label_currency_shortcode'):'Currency Shortcode'; ?></label>
                            <div class="col-md-3">
                              
                              <input type="text" name="currency_shortcode" class="form-control" id="currency_shortcode" value="<?= !empty($data->currency_shortcode)?$data->currency_shortcode:'' ?>" required>
                              
                            </div>
                          </div>
                          
                          
                          <div class="form-group row align-items-center">
                            <label class="form-control-label col-sm-3 text-md-right"></label>
                            <div class="col-sm-6 col-md-9">
                                <div class="form-check">
                                    <input class="form-check-input" name="hide_budget" type="checkbox" id="defaultCheck1" <?= (isset($data->hide_budget) && !empty($data->hide_budget) && $data->hide_budget==1)?'checked':''; ?>>
                                    <label class="form-check-label" for="defaultCheck1">
                                        <?= !empty($this->lang->line('label_hide_budget_costs_from_users?'))?$this->lang->line('label_hide_budget_costs_from_users'):'Hide Budget/Costs From Users?'; ?>
                                    </label>
                                 </div>
                            </div>
                          </div>
                            
                         
                        </div>
                        <div class="row d-none setting-result"></div>
                        <div class="card-footer bg-whitesmoke text-md-right">
                          <button class="btn btn-primary" id="general-save-btn"><?= !empty($this->lang->line('label_save_changes'))?$this->lang->line('label_save_changes'):'Save Changes'; ?></button>
                        </div>
                      </div>
                    </form>
                  </div>

                  <?php $data = get_system_settings('email');
                    $dataemail = json_decode($data[0]['data']);
                  ?>
                  <div class="tab-pane fade" id="email-settings" role="tabpanel" aria-labelledby="email-tab4">
                                    
                    <form action="<?= base_url('settings/save_settings'); ?>" id="email-setting-form" autocomplete="off">
                      <div class="card" id="email-settings-card">
                        <div class="card-header">
                          <h4><?= !empty($this->lang->line('label_email_settings'))?$this->lang->line('label_email_settings'):'Email Settings'; ?></h4>
                        </div>
                        
                        <div class="card-body">
                          <p class="text-muted">Email SMTP settings, notifications and others related to email.</p>


                          <div class="form-group row align-items-center">
                            <label for="email-set" class="form-control-label col-sm-3 text-md-right"><?= !empty($this->lang->line('label_email'))?$this->lang->line('label_email'):'Email'; ?></label>
                            <div class="col-sm-6 col-md-9">
                                  
                              <input type="hidden" name="<?= $this->security->get_csrf_token_name();
                              ?>" class="form-control"  value="<?= $this->security->get_csrf_hash(); ?>">
                              
                              <input type="hidden" name="setting_type" class="form-control"  value="email">
                              
                              <input type="text" name="email" class="form-control" id="email-set" value="<?= !empty($dataemail->email)?$dataemail->email:'' ?>" required>
                              <div class="form-text text-muted">This is the email address that the contact and report emails will be sent to, aswell as being the from address in signup and notification emails.</div>
                            </div>
                            
                          </div>
                          
                          <div class="form-group row align-items-center">
                            <label for="password" class="form-control-label col-sm-3 text-md-right"><?= !empty($this->lang->line('label_password'))?$this->lang->line('label_password'):'Password'; ?></label>
                            <div class="col-sm-6 col-md-9">
                              <input type="text" name="password" class="form-control" id="password" value="<?= !empty($dataemail->password)?$dataemail->password:'' ?>" required>
                              <div class="form-text text-muted">Password of above given email.</div>
                            </div>
                          </div>
                          
                          
                          <div class="form-group row align-items-center">
                            <label for="smtp_host" class="form-control-label col-sm-3 text-md-right"><?= !empty($this->lang->line('label_smtp_host'))?$this->lang->line('label_smtp_host'):'SMTP Host'; ?></label>
                            <div class="col-sm-6 col-md-9">
                              <input type="text" name="smtp_host" class="form-control" id="smtp_host" value="<?= !empty($dataemail->smtp_host)?$dataemail->smtp_host:'' ?>" required>
                              <div class="form-text text-muted">This is the host address for your smtp server, this is only needed if you are using SMTP as the Email Send Type.</div>
                            </div>
                          </div>
                          
                          
                          <div class="form-group row align-items-center">
                            <label for="smtp_port" class="form-control-label col-sm-3 text-md-right"><?= !empty($this->lang->line('label_smtp_port'))?$this->lang->line('label_smtp_port'):'SMTP Port'; ?></label>
                            <div class="col-sm-6 col-md-9">
                              <input type="text" name="smtp_port" class="form-control" id="smtp_port" value="<?= !empty($dataemail->smtp_port)?$dataemail->smtp_port:'' ?>" required>
                              <div class="form-text text-muted">SMTP port this will provide your service provider.</div>
                            </div>
                          </div>
                          
                          <div class="form-group row">
                            <label class="form-control-label col-sm-3 mt-3 text-md-right"><?= !empty($this->lang->line('label_email_content_type'))?$this->lang->line('label_email_content_type'):'Email Content Type'; ?></label>
                            <div class="col-sm-6 col-md-9">
                            
                              <select class="form-control" name="mail_content_type" id="mail_content_type">
                              <?php
                                if(!empty($dataemail->mail_content_type)){

                                  if($dataemail->mail_content_type == 'text'){ ?>
                                    <option value="text" selected>Text</option>
                                    <option value="html" >HTML</option>
                                    <?php }else{ ?>
                                    <option value="text" >Text</option>
                                    <option value="html" selected>HTML</option>
                                    <?php } }else{ ?>
                                  <option value="text" selected>Text</option>
                                  <option value="html" >HTML</option>

                                <?php } ?>
                                
                              </select>
                              <div class="form-text text-muted">Text-plain or HTML content chooser.</div>
                            </div>
                          </div>

                          
                          <div class="form-group row">
                            <label class="form-control-label col-sm-3 mt-3 text-md-right"><?= !empty($this->lang->line('label_smtp_encryption'))?$this->lang->line('label_smtp_encryption'):'SMTP Encryption'; ?></label>
                            <div class="col-sm-6 col-md-9">
                            
                              <select class="form-control" name="smtp_encryption" id="smtp_encryption">
                              <?php
                                if(!empty($dataemail->smtp_encryption)){

                                  if($dataemail->smtp_encryption == 'ssl'){ ?>
                                    <option value="off">off</option>
                                    <option value="ssl" selected>SSL</option>
                                    <option value="tls" >TLS</option>
                                    <?php }elseif($dataemail->smtp_encryption == 'tls'){ ?>
                                    <option value="off">off</option>
                                    <option value="ssl">SSL</option>
                                    <option value="tls" selected>TLS</option>
                                    <?php }else{  ?>
                                    <option value="off" selected>off</option>
                                    <option value="ssl">SSL</option>
                                    <option value="tls">TLS</option>
                                  <?php   } 
                                  
                                  }else{ ?>
                                  <option value="off" selected>off</option>
                                    <option value="ssl">SSL</option>
                                    <option value="tls">TLS</option>

                                <?php } ?>
                                
                              </select>
                              <div class="form-text text-muted">If your e-mail service provider supported secure connections, you can choose security method on list.</div>
                            </div>
                          </div>
                          
                        </div>
                        <div class="row d-none setting-result"></div>
                        <div class="card-footer bg-whitesmoke text-md-right">
                          <button class="btn btn-primary" id="eamil-save-btn"><?= !empty($this->lang->line('label_save_changes'))?$this->lang->line('label_save_changes'):'Save Changes'; ?></button>
                        </div>
                      </div>
                    </form>


                  </div>

                  
                  <?php $data = get_system_settings('web_fcm_settings');
                    $datasystem = json_decode($data[0]['data']);
                  ?>

                  <div class="tab-pane fade" id="system-settings" role="tabpanel" aria-labelledby="system-tab4">
                  
                    <form action="<?= base_url('settings/save_settings'); ?>" id="system-setting-form" autocomplete="off">
                      <div class="card" id="system-settings-card">
                        <div class="card-header">
                          <h4><?= !empty($this->lang->line('label_system_settings'))?$this->lang->line('label_system_settings'):'System Settings'; ?></h4>
                        </div>
                        
                        <div class="card-body">
                          <p class="text-muted">FCM and other important settings.</p>

                          
                          <div class="form-group row align-items-center">
                            <label for="fcm_server_key" class="form-control-label col-sm-3 text-md-right">FCM Server Key</label>
                            <div class="col-sm-6 col-md-9">
                              <input type="text" name="fcm_server_key" class="form-control" id="fcm_server_key" value="<?= !empty($datasystem->fcm_server_key)?$datasystem->fcm_server_key:'' ?>" required>
                            </div>
                          </div>
                          

                          <div class="form-group row align-items-center">
                            <label for="apiKey" class="form-control-label col-sm-3 text-md-right">Web API Key</label>
                            <div class="col-sm-6 col-md-9">
                                  
                              <input type="hidden" name="<?= $this->security->get_csrf_token_name();
                              ?>" class="form-control"  value="<?= $this->security->get_csrf_hash(); ?>">
                              
                              <input type="hidden" name="setting_type" class="form-control"  value="system">
                              
                              <input type="text" name="apiKey" class="form-control" id="apiKey" value="<?= !empty($datasystem->apiKey)?$datasystem->apiKey:'' ?>" required>
                            </div>
                          </div>
                          
                          <div class="form-group row align-items-center">
                            <label for="projectId" class="form-control-label col-sm-3 text-md-right"><?= !empty($this->lang->line('label_project_id'))?$this->lang->line('label_project_id'):'Project ID'; ?></label>
                            <div class="col-sm-6 col-md-9">
                              <input type="text" name="projectId" class="form-control" id="projectId" value="<?= !empty($datasystem->projectId)?$datasystem->projectId:'' ?>" required>
                            </div>
                          </div>
                          
                          
                          <div class="form-group row align-items-center">
                            <label for="messagingSenderId" class="form-control-label col-sm-3 text-md-right"><?= !empty($this->lang->line('label_sender_id'))?$this->lang->line('label_sender_id'):'Sender ID'; ?></label>
                            <div class="col-sm-6 col-md-9">
                              <input type="text" name="messagingSenderId" class="form-control" id="messagingSenderId" value="<?= !empty($datasystem->messagingSenderId)?$datasystem->messagingSenderId:'' ?>" required>
                            </div>
                          </div>
                          
                        </div>
                        <div class="row d-none setting-result"></div>
                        <div class="card-footer bg-whitesmoke text-md-right">
                          <button class="btn btn-primary" id="system-save-btn"><?= !empty($this->lang->line('label_save_changes'))?$this->lang->line('label_save_changes'):'Save Changes'; ?></button>
                        </div>
                      </div>
                    </form>

                  </div>


                </div>
                <div id="result"></div>
              </div>

            </div>
          </div>
        </section>
      </div>
      
      <?php include('include-footer.php'); ?>

    </div>
  </div>

  <form  action="<?= base_url('settings/create_fonts/'); ?>" method="post" class="modal-part" id="modal-add-font-part">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group mb-3">
                <div class="input-group">
                    <textarea type="textarea" class="form-control codeeditor" placeholder='Add Font in below given format.' name="fonts"><?php 
                        $file_get_contents_data = file_get_contents("assets/fonts/my-fonts.json");
                        echo $file_get_contents_data;
                      ?>
                    </textarea>
                </div>
            </div>
        </div>
        <div class="col-md-12">
        <label class="form-control-label"><?= !empty($this->lang->line('label_font_format'))?$this->lang->line('label_font_format'):'Example Font Format : '; ?> 
          <small><a href="https://fonts.google.com/" target="_blank">Find more fonts here <i class="fas fa-external-link-alt"></i></a></small>
        </label><br>
        <pre>
[
  {
    "id": "1",
    "font_cdn": "https://fonts.googleapis.com/css?family=Roboto&display=swap",
    "font_name": "Roboto",
    "font_family": "'Roboto', sans-serif",
    "class": "roboto"
  },
  {
    "id": "2",
    "font_cdn": "https://fonts.googleapis.com/css?family=Noto+Sans&display=swap",
    "font_name": "Nato Sans",
    "font_family": "'Noto Sans', sans-serif",
    "class": "nato_sans"
  }
]

Explaination : 
    id - Give unique id to the font you add
    font_cdn - CDN or Server URL of the font
    font_name - Name of the font, you can give any name you want. Example : Noto Sans
    font_family - Font family of that font. Example : " 'Noto Sans', sans-serif "
    class - A valid class name for CSS, It should be without white spaces and not using 
            any special characters. Example : "noto_sans"
    </pre>
  </div>
</div>
</form>
  
<?php include('include-js.php'); ?>

<!-- Page Specific JS File -->
<script src="<?= base_url('assets/js/page/features-setting-detail.js'); ?>"></script>

</body>
</html>