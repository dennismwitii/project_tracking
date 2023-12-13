<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Leave Requests &mdash; <?= get_compnay_title(); ?></title>

  <?php include('include-css.php'); ?>
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">

    
    <?php include('include-header.php'); ?>
    
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
            <span id="modal-edit-leave"></span>
            <span id="modal-leave-editors"></span>
          <div class="section-header">
              
            <h1><?= !empty($this->lang->line('label_leaves'))?$this->lang->line('label_leaves'):'Leaves'; ?></h1>
            <div class="section-header-breadcrumb">
              <i class="btn btn-primary btn-rounded no-shadow" id="modal-add-leave" data-value="add"><?= !empty($this->lang->line('label_request_leave'))?$this->lang->line('label_request_leave'):'Request Leave'; ?></i>
              <?php if($this->ion_auth->is_admin()){ ?>
              <i class="btn fas fa-cog" id="modal-leave-editors-ajax"></i>
              <?php } ?>
            </div>
          </div>

          <div class="section-body">
            <div class="row">
                
                
                
                
                <div class='col-md-12'>
                <div class="card">
                    
                <div class="card-body">
                    
                  <table class='table-striped' id='leaves_list'
                    data-toggle="table"
                    data-url="<?=base_url('leaves/get_leaves_list')?>"
                    data-click-to-select="true"
                    data-side-pagination="server"
                    data-pagination="true"
                    data-page-list="[5, 10, 20, 50, 100, 200]"
                    data-search="true" data-show-columns="true"
                    data-show-refresh="true" data-trim-on-search="false"
                    data-sort-name="id" data-sort-order="desc"
                    data-mobile-responsive="true"
                    data-toolbar="#toolbar" data-show-export="true"
                    data-maintain-selected="true"
                    data-export-types='["txt","excel"]'
                    data-export-options='{
                      "fileName": "leaves-list",
                      "ignoreColumn": ["state"] 
                    }'
                    data-query-params="queryParams">
                    <thead>
                      <tr>
                        <th data-field="id" data-visible="false" data-sortable="true"><?= !empty($this->lang->line('label_id'))?$this->lang->line('label_id'):'ID'; ?></th>
                        <th data-field="first_name" data-sortable="true"><?= !empty($this->lang->line('label_name'))?$this->lang->line('label_name'):'Name'; ?></th>
                        <th data-field="leave_days" data-sortable="true"><?= !empty($this->lang->line('label_leave_duration'))?$this->lang->line('label_leave_duration'):'Leave Duration'; ?></th>
                        
                        <th data-field="leave_from" data-visible="false" data-sortable="true"><?= !empty($this->lang->line('label_start_date'))?$this->lang->line('label_start_date'):'Start Date'; ?></th>
                        
                        <th data-field="leave_to" data-visible="false" data-sortable="true"><?= !empty($this->lang->line('label_end_date'))?$this->lang->line('label_end_date'):'End Date'; ?></th>
                        
                        <th data-field="reason" data-sortable="true"><?= !empty($this->lang->line('label_reason'))?$this->lang->line('label_reason'):'Reason'; ?></th>
                        <th data-field="status" data-sortable="true"><?= !empty($this->lang->line('label_status'))?$this->lang->line('label_status'):'Status'; ?></th>
                        <?php if($this->ion_auth->is_admin()){ ?>
                        <th data-field="action_by" data-sortable="true"><?= !empty($this->lang->line('label_action_by'))?$this->lang->line('label_action_by'):'Action By'; ?></th>
                        <?php } ?>
                        <th data-field="action" data-sortable="false"><?= !empty($this->lang->line('label_action'))?$this->lang->line('label_action'):'Action'; ?></th>
                      </tr>
                    </thead>
                  </table>
                </div>
            </div>
          </div>
          
          
          
          
            </div>
          </div>
        </section>
      </div>
      
      <form action="<?=base_url('leaves/create');?>" id="modal-add-leave-part" class="modal-part">
        <div class="row">
            <div class="form-group col-md-6">
              <label><?= !empty($this->lang->line('label_no_of_days'))?$this->lang->line('label_no_of_days'):'No. of Days'; ?></label>
              <div class="input-group">
                <input type="number" class="form-control" name="leave_days" value="1" min="1" max="31" required>
              </div>
            </div>
            <div class="form-group  col-md-6">
                <label><?= !empty($this->lang->line('label_leave_date_from_to'))?$this->lang->line('label_leave_date_from_to'):'Leave Date From To'; ?></label>
                <input id="leaves_between" name="leaves_between" type="text" class="form-control" autocomplete="off" required>
                <input id="leave_from" name="leave_from" type="hidden">
                <input id="leave_to" name="leave_to" type="hidden">
            </div>
        </div>
        <div class="form-group">
          <label><?= !empty($this->lang->line('label_reason'))?$this->lang->line('label_reason'):'Reason'; ?></label>
          <div class="input-group">
          <textarea type="textarea" class="form-control" placeholder="<?= !empty($this->lang->line('label_reason_for_leave'))?$this->lang->line('label_reason_for_leave'):'Reason for leave?'; ?>" name="reason" required></textarea>
          </div>
        </div>
      </form>
    
        <form action="<?=base_url('leaves/edit');?>" id="modal-edit-leave-part" class="modal-part">
        <div class="row">
            <div class="form-group col-md-6">
              <label><?= !empty($this->lang->line('label_no_of_days'))?$this->lang->line('label_no_of_days'):'No. of Days'; ?></label>
              <div class="input-group">
                 <input type="hidden" name="update_id" id="update_id" value="" >
                <input type="number" class="form-control" name="leave_days" id="edit_leave_days" value="1" min="1" max="31" required>
              </div>
            </div>
            <div class="form-group  col-md-6">
                <label><?= !empty($this->lang->line('label_leave_date_from_to'))?$this->lang->line('label_leave_date_from_to'):'Leave Date From To'; ?></label>
                <input id="edit_leaves_between" name="leaves_between" type="text" class="form-control" autocomplete="off" required>
                <input id="edit_leave_from" name="leave_from" type="hidden">
                <input id="edit_leave_to" name="leave_to" type="hidden">
            </div>
        </div>
        <div class="form-group">
          <label><?= !empty($this->lang->line('label_reason'))?$this->lang->line('label_reason'):'Reason'; ?></label>
          <div class="input-group">
          <textarea type="textarea" class="form-control" placeholder="<?= !empty($this->lang->line('label_reason_for_leave'))?$this->lang->line('label_reason_for_leave'):'Reason for leave?'; ?>" id="edit_reason" name="reason" required></textarea>
          </div>
        </div>
      </form>

        
        <form action="<?=base_url('leaves/leave_editors');?>" id="modal-leave-editors-part" class="modal-part">
        <div class="row">
            <div class="form-group col-md-12">
              <label><?= !empty($this->lang->line('label_assign_users_to_manage_leave_requests'))?$this->lang->line('label_assign_users_to_manage_leave_requests'):'Assign users to manage leave requests'; ?></label>
                <select class="form-control select2" multiple="" name="users[]" id="update_users">
                <?php foreach($all_user as $all_users){ ?>
                    <option value="<?= $all_users->id?>"><?= $all_users->first_name?> <?= $all_users->last_name?></option>
                <?php } ?>
                </select>
            </div>
        </div>
      </form>
      
      <?php include('include-footer.php'); ?>

    </div>
  </div>

<?php include('include-js.php'); ?>
<script src="<?=base_url('assets/js/page/leaves.js');?>"></script>
</body>

</html>