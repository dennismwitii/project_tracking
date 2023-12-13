<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Chat Box &mdash; <?= get_compnay_title(); ?></title>
  <?php include('include-css.php'); ?>
  <style type="text/css">

    @media (min-width: 575.98px) {
      html {
        overflow:hidden;
      }
    }
    
    </style>
</head>

<body>
  <div id="app" >
    <div class="main-wrapper main-wrapper-1">
      
    <?php include('include-header.php'); ?>
    
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header mb-1">
            <h1 id='modal-edit-group'><?= !empty($this->lang->line('label_chat_box'))?$this->lang->line('label_chat_box'):'Chat Box'; ?></h1>
            <span id='modal-edit-group'></span>
            <span id='modal-info-group'></span>
            <div class="section-header-breadcrumb">
              <i id="chat-scrn" data-value="min" class="fas fa-arrows-alt chat-scrn"></i>
            </div>
          </div>

          <?php $data_chat = get_system_settings('web_fcm_settings');
                $chat_theme = get_chat_theme();
                
              $data_chat = json_decode($data_chat[0]['data']);
              if(empty($data_chat->messagingSenderId) || empty($data_chat->projectId) || empty($data_chat->apiKey)){ ?>
                <div class="row alert alert-danger justify-content-center"> To use chat system you have to setup web FCM settings first. <a href="<?=base_url('settings');?>"> Go to Settings</a> </div>
          <?php } ?>

          <div class="row alert alert-danger text-center d-none" id="noti_permission">Please enable desktop notifications. We need your permission to <a href="#" id="noti_permission_href"><b>enable desktop notifications (Click Here)</b></a>.
          </div>

          <div class="section-body chat-theme">
            <div class="row justify-content-center unselectable no-gutters">
              <div class="col-12 col-sm-4 col-lg-3">
              <div class="card <?= ($chat_theme != false)?$chat_theme:'chat-theme-light' ?> chat-scroll chat-min">

                <form class="card-header-form">
                  <input type="text" name="search" id="out-chat-search" aria-label="Search" class="form-control chat-search-box m-2 trigger--fire-modal-1" placeholder="Search All">
                </form>

                <div id="add-scroll-js">
                <div class="card-header chat-card-header text-color">
                    <h4><?= !empty($this->lang->line('label_personal_chat'))?$this->lang->line('label_personal_chat'):'Personal Chat'; ?></h4>
                  </div>
                  <div class="chat-card-body">
                      
                    <ul class="list-unstyled list-unstyled-border chat-list-unstyled-border">
                      
                      <?php if(!empty($members)){ foreach ($members as $member){ 
                            if($member['id'] == $user->id){
                      ?>
                        <li class="media">
                          <div class="media-body">
                            <div class="chat-person" data-picture="<?= $member['picture'] ?>" data-type="person" data-id="<?= $member['id'] ?>"><i class="<?= ($member['is_online'] == 1)?'fas fa-circle text-success':'far fa-circle';?> "></i> <?= $member['first_name'] ?> <?= $member['last_name'] ?> (You)</div>
                          </div>
                        </li>
                      <?php } } } ?>

                      <?php if(!empty($members)){ foreach ($members as $member){ 
                            if($member['id'] != $user->id && !is_client($member['id'])){
                      ?>
                        <li class="media"> 
                          <div class="media-body">
                            <div data-unread_msg="<?= $member['unread_msg'] ?>" class="chat-person <?= ($member['unread_msg'] > 0)?'new-msg-rcv':'';?>" data-picture="<?= $member['picture'] ?>" data-type="person" data-id="<?= $member['id'] ?>"><i class="<?= ($member['is_online'] == 1)?'fas fa-circle text-success':'far fa-circle';?> "></i> <?= $member['first_name'] ?> <?= $member['last_name'] ?>
                            <?= ($member['unread_msg'] > 0)?($member['unread_msg'] > 9)?'<div class="badge-chat">9 +</div>':'<div class="badge-chat">'.$member['unread_msg'].'</div>':'';?>
                          </div>
                          </div>
                        </li>
                      <?php } } } ?>

                    </ul>
                  </div>
                  <div class="card-header chat-card-header text-color">
                    <h4><?= !empty($this->lang->line('label_group_chat'))?$this->lang->line('label_group_chat'):'Group Chat'; ?> <a href="#" id="modal-add-group" ><i class="fas fa-plus-circle"></i></a></h4>
                  </div>
                  <div class="chat-card-body">
                    <ul class="list-unstyled list-unstyled-border chat-list-unstyled-border">

                    <?php if(!empty($groups)){ 
                      
                      foreach ($groups as $group){ 
                        // print_r($group);
                    ?>
                   
                      <li class="media">
                        <div class="media-body">
                          <div class="chat-person <?= ($group['is_read']==1)?'new-msg-rcv':''; ?>" data-id="<?= $group['group_id'] ?>" data-type="group" data-not_in_group="false" ># <?= $group['title'] ?></div> 
                        </div>
                      </li>

                    <?php } } ?>

                    <?php if(!empty($groups) && $is_admin == true){ 
                      
                      foreach ($not_in_groups as $not_in_group){ 
                        // print_r($not_in_group);
                    ?>
                
                      <li class="media">
                        <div class="media-body">
                          <div class="chat-person" data-id="<?= $not_in_group['id'] ?>" data-type="group" data-not_in_group="true"># <?= $not_in_group['title'] ?></div> 
                        </div>
                      </li>

                    <?php } } ?>

                    </ul>
                  </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-8 col-lg-9" id="chat_area_wait">
              </div>
              <div class="col-12 col-sm-8 col-lg-9 d-none" id="you_not_in_group">
               
                <div class="pricing pricing-highlight chat-min">
                  <div class="pricing-padding">
                    <div class="pricing-price">
                      <div>You are not in this group</div>
                      <div>Join group and access all the details.</div>
                    </div>
                    <a class="btn btn-success text-white" id="you_not_in_group_btn">Join Group</a>
                  </div>
                </div>

              </div>
              <div class="col-12 col-sm-8 col-lg-9 d-none" id="chat_area">
                <div class="card chat-box <?= ($chat_theme != false)?$chat_theme:'chat-theme-light' ?> chat-min" id="mychatbox2">
                    <div class="card-header chat-card-header">
                        <div class="mr-3" id="chat-avtar-main">#</div>
                        <div class="media-body">
                            <div class="mt-0 mb-1 font-weight-bold text-color" id="chat_title"></div>
                            <div class="text-small font-600-bold" id="chat_online_status"></div>
                        </div>
                        <form class="card-header-form"> 
                          <div class="input-group">
                            <input type="text" name="search" id="modal-search-msg" class="form-control chat-search-box" placeholder="Search">

                          </div>
                        </form>
                    </div>
                  <div id="chat-box-content" class="chat-bg card-body chat-content">
                  <div class="chat_loader">Loading...</div>
                  </div>
                  <div class="card-body d-none" id="chat-dropbox">
                    <div id='myAlbum' class="dropzone"></div>
                      <div class="text-center mt-3">
                        <button class="btn btn-danger shadow-none" onclick="closeDropZone();"><?= !empty($this->lang->line('label_close'))?$this->lang->line('label_close'):'Close'; ?> 
                        </button>
                      </div>
                  </div>
                  <div class="form-control theme-inputs d-none" id="chat-input-textarea-result"></div>

          <div class="card-footer chat-form">
            <form id="chat-form2" autocomplete="off">
              <input type="hidden" id="opposite_user_id" name="opposite_user_id" value="">
              <input type="hidden" id="my_user_id" name="my_user_id" value="<?= $user->id ?>" data-picture="<?= $member['picture'] ?>">
              <input type="hidden" id="chat_type" name="chat_type" value="">
              <textarea class="form-control theme-inputs" id="chat-input-textarea" rows="1" name="chat-input-textarea"></textarea>
              <a Class="chat-preview-btn d-none" id="chat-preview-btn"><?= !empty($this->lang->line('label_preview'))?$this->lang->line('label_preview'):'Preview'; ?></a>
              
              <a class="bg-success go-to-bottom-btn">
                <i class="fas fa-arrow-down"></i>
              </a>

              <button class="btn btn-danger">
                <i class="far fa-paper-plane"></i>
              </button>

              <button class="btn-file btn btn-primary" onclick="showDropZone();">
                <i class="fas fa-paperclip"></i>
              </button>

            </form>
          </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
      
      <form action="<?= base_url('chat/create_group'); ?>" class="modal-part" id="modal-add-group-part">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label><?= !empty($this->lang->line('label_title'))?$this->lang->line('label_title'):'Title'; ?></label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="title" name="title">
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label><?= !empty($this->lang->line('label_description'))?$this->lang->line('label_description'):'Description'; ?></label>
                        <div class="input-group">
                            <textarea type="textarea" class="form-control" placeholder="description" name="description"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label><?= !empty($this->lang->line('label_select_users'))?$this->lang->line('label_select_users'):'Select Users'; ?></label>
                        <select class="form-control select2" multiple="" name="users[]" id="users">
                        <?php foreach($all_user as $all_users){ if($all_users->id != $user->id && !is_client($all_users->id)){ ?>

                            <option value="<?= $all_users->id?>"><?= $all_users->first_name?> <?= $all_users->last_name?></option>
                        <?php } } ?>
                        </select>
                    </div>
                </div>

            </div>
        </form>

        <form action="<?= base_url('chat/edit_group'); ?>" class="modal-part" id="modal-edit-group-part">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label><?= !empty($this->lang->line('label_title'))?$this->lang->line('label_title'):'Title'; ?></label>
                        <div class="input-group">
                            <input type="hidden" name="update_id" id="update_id">
                            <input type="text" class="form-control" placeholder="title" name="title" id="update_title"> 
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label><?= !empty($this->lang->line('label_description'))?$this->lang->line('label_description'):'Description'; ?></label>
                        <div class="input-group">
                            <textarea type="textarea" class="form-control" placeholder="description" name="description" id="update_description"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label><?= !empty($this->lang->line('label_select_users'))?$this->lang->line('label_select_users'):'Select Users'; ?></label>
                        <select class="form-control select2" multiple="" name="users[]" id="update_users">
                        <?php foreach($all_user as $all_users){ if($all_users->id != $user->id && !is_client($all_users->id)){ ?>
                          
                            <option value="<?= $all_users->id?>"><?= $all_users->first_name?> <?= $all_users->last_name?></option>
                        <?php } } ?>
                        </select>
                    </div>
                </div> 

                <div class="col-md-12">
                    <div class="form-group">
                        <label><?= !empty($this->lang->line('label_select_admins'))?$this->lang->line('label_select_admins'):'Select Admins'; ?> (Leave empty if don't want to make admin)</label>
                        <select class="form-control select2" multiple="" name="admins[]" id="update_admins">
                        <?php foreach($all_user as $all_users){ if($all_users->id != $user->id && !is_client($all_users->id)){ ?>
                          
                            <option value="<?= $all_users->id?>"><?= $all_users->first_name?> <?= $all_users->last_name?></option>
                        <?php } } ?>
                        </select>
                    </div>
                </div>
            </div>
        </form>

        <form action="<?= base_url('chat/edit_group'); ?>" class="modal-part" id="modal-info-group-part">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label><?= !empty($this->lang->line('label_title'))?$this->lang->line('label_title'):'Title'; ?></label>
                        <div class="input-group">
                            <input type="hidden" name="update_id" id="update_id_info">
                            <input type="text" class="form-control" placeholder="title" name="title" id="update_title_info" disabled> 
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label><?= !empty($this->lang->line('label_description'))?$this->lang->line('label_description'):'Description'; ?></label>
                        <div class="input-group">
                            <textarea type="textarea" class="form-control" placeholder="description" name="description" id="update_description_info" disabled></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label><?= !empty($this->lang->line('label_users'))?$this->lang->line('label_users'):'Users'; ?></label>
                        <select class="form-control select2" multiple="" name="users[]" id="update_users_info" disabled>
                        <?php foreach($all_user as $all_users){ if($all_users->id != $user->id  && !is_client($all_users->id)){ ?>
                          
                            <option value="<?= $all_users->id?>"><?= $all_users->first_name?> <?= $all_users->last_name?></option>
                        <?php }else{ ?>
                            <option value="<?= $all_users->id?>">You</option>
                        <?php } } ?>
                        </select>
                    </div>
                </div> 

                <div class="col-md-12">
                    <div class="form-group">
                        <label><?= !empty($this->lang->line('label_group_admins'))?$this->lang->line('label_group_admins'):'Group Admins'; ?></label>
                        <select class="form-control select2" multiple="" name="admins[]" id="update_admins_info" disabled>

                        <?php foreach($all_user as $all_users){ if($all_users->id != $user->id  && !is_client($all_users->id)){ ?>
                          
                          <option value="<?= $all_users->id?>"><?= $all_users->first_name?> <?= $all_users->last_name?></option>
                        <?php }else{ ?>
                            <option value="<?= $all_users->id?>">You</option>
                        <?php } } ?>

                        </select>
                    </div>
                </div>
                
            </div>
        </form>

        <form class="modal-part" id="modal-search-msg-part">

            <div class="row">
                <div class="col-md-12 form-group">
          <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text">
                            <i class="fas fa-search"></i>
                          </div>
                        </div>
                        <input type="text" class="form-control" name="in-chat-search" id="in-chat-search">
                    </div>
                </div>

        <div class="col-md-12 d-none" id="show-search-result">
          <div class="card">
            <div class="card-header">
            <h4><?= !empty($this->lang->line('label_search_result'))?$this->lang->line('label_search_result'):'Search Result'; ?></h4>
            </div>
            <div class="card-body">
            <ul class="list-unstyled list-unstyled-border" id="search-result">

            </ul>
            </div>
          </div>
              </div>

            </div>

        </form>

      <?php include('include-footer.php'); ?>

    </div>
  </div>

<?php include('include-js.php'); ?> 

<script type="text/javascript">
    dictDefaultMessage = "<?= !empty($this->lang->line('label_drop_files_here_to_upload'))?$this->lang->line('label_drop_files_here_to_upload'):'Drop Files Here To Upload'; ?>";
</script>

<script src="<?=base_url('assets/modules/ion.sound.min.js');?>"></script>

<script src="<?=base_url('assets/modules/firebase/firebase-app.js');?>"></script>

<script src="<?=base_url('assets/modules/firebase/firebase-messaging.js');?>"></script>

<script src="<?= base_url('assets/js/page/components-chat-box.js'); ?>"></script>

</body>
</html>