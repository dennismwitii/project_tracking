<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>User Details &mdash; <?= get_compnay_title(); ?></title>

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
            <h1><?= !empty($this->lang->line('label_user_detail'))?$this->lang->line('label_user_detail'):'User Detail'; ?></h1>
          </div>

          <div class="section-body">
            <div class="row">
            <?php
              // print_r($user_detail);
            ?>

            <div class="col-md-12">
                  <div class="card profile-widget">
                    <div class="profile-widget-header">   
                      <?php if(isset($user_detail->profile) && !empty($user_detail->profile)){ ?>
                        <img src="<?= base_url('assets/profiles/'.$user_detail->profile); ?>" class="rounded-circle profile-widget-picture">
                      <?php }else{ ?>
                        <div class="user-avtar rounded-circle"><?= mb_substr($user_detail->first_name, 0, 1).''.mb_substr($user_detail->last_name, 0, 1); ?></div>
                      <?php } ?>

                      <?php 
                        $tasks_count =  get_count('id','tasks','FIND_IN_SET('.$user_detail->id.', user_id)');
                        $leaves_count = get_count('id','notes','user_id='.$user_detail->id);
                        if(is_client($user_detail->id)){ 
                          $projects_count = get_count('id','projects','FIND_IN_SET('.$user_detail->id.', client_id)');
                        }else{
                          $projects_count = get_count('id','projects','FIND_IN_SET('.$user_detail->id.', user_id)');
                        }
                       ?>

                      <div class="profile-widget-items">
                        <div class="profile-widget-item">
                          <div class="profile-widget-item-label"><?= !empty($this->lang->line('label_projects'))?$this->lang->line('label_projects'):'Projects'; ?></div>
                          <div class="profile-widget-item-value"><?=$projects_count?></div>
                        </div>
                        <div class="profile-widget-item">
                          <div class="profile-widget-item-label"><?= !empty($this->lang->line('label_tasks'))?$this->lang->line('label_tasks'):'Tasks'; ?></div>
                          <div class="profile-widget-item-value"><?=$tasks_count?></div>
                        </div>
                        
                        <div class="profile-widget-item">
                          <div class="profile-widget-item-label"><?= !empty($this->lang->line('label_notes'))?$this->lang->line('label_notes'):'Notes'; ?></div>
                          <div class="profile-widget-item-value"><?=$leaves_count?></div>
                        </div>

                      </div>
                    </div>
                    <div class="profile-widget-description pb-0">
                      
                      <div class="profile-widget-name">
                        <?= !empty($this->lang->line('label_name'))?$this->lang->line('label_name'):'Name'; ?>: 
                        <div class="text-muted d-inline font-weight-normal mr-5"><?=$user_detail->first_name?> <?=$user_detail->last_name?></div>

                        <?= !empty($this->lang->line('label_user_type'))?$this->lang->line('label_user_type'):'User Type'; ?>: 
                        <div class="text-muted d-inline font-weight-normal mr-5">
                        <?php
                          if($this->ion_auth->is_admin($user_detail->id)){
                            echo  "Super Admin";
                          }elseif(is_editor($user_detail->id)){
                            echo  "Admin";
                          }elseif(is_client($user_detail->id)){
                            echo  "Client";
                          }else{
                            echo  "Team Member";
                          }
                        ?>
                        </div>

                        <?= !empty($this->lang->line('label_contact'))?$this->lang->line('label_contact'):'Contact'; ?>: 
                        <div class="text-muted d-inline font-weight-normal mr-5"><?=$user_detail->email?></div>

                        <?= !empty($this->lang->line('label_status'))?$this->lang->line('label_status'):'Status'; ?>: 
                        <div class="text-muted d-inline font-weight-normal"><div class="badge badge-success projects-badge"><?=($user_detail->active == 1)?'Active':'Deactive'?></div></div>
                        
                        <?php if(is_client($user_detail->id)){ ?> 
                          <br>
                          <?= !empty($this->lang->line('label_company'))?$this->lang->line('label_company'):'Company'; ?>: 
                          <div class="text-muted d-inline font-weight-normal mr-5"><?=$user_detail->company?></div>

                          <?= !empty($this->lang->line('label_phone'))?$this->lang->line('label_phone'):'Phone'; ?>: 
                          <div class="text-muted d-inline font-weight-normal mr-5"><?=$user_detail->phone?></div>
                        <?php } ?>

                      </div>
                    </div>

                    <div class="card-body">
                      <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="projects-tab" data-toggle="tab" href="#projects" role="tab" aria-controls="projects" aria-selected="true"><?= !empty($this->lang->line('label_projects'))?$this->lang->line('label_projects'):'Projects'; ?></a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="tasks-tab" data-toggle="tab" href="#tasks" role="tab" aria-controls="tasks" aria-selected="false"><?= !empty($this->lang->line('label_tasks'))?$this->lang->line('label_tasks'):'Tasks'; ?></a>
                        </li>
                        <?php if(!is_client($user_detail->id) && ($this->ion_auth->is_admin() || is_editor() || $user_detail->id == $this->session->userdata('user_id'))){ ?>
                          <li class="nav-item">
                            <a class="nav-link" id="leaves-tab" data-toggle="tab" href="#leaves" role="tab" aria-controls="leaves" aria-selected="false"><?= !empty($this->lang->line('label_leave_requests'))?$this->lang->line('label_leave_requests'):'Leave Requests'; ?>
                            </span></a></a>
                          </li>
                        <?php } ?>
                      </ul>
                      <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="projects" role="tabpanel" aria-labelledby="projects-tab">
                          <table class='table-striped' id='projects_list'
                            data-toggle="table"
                            data-url="<?=base_url('projects/get_projects_list/'.$user_detail->id.'/')?>"
                            data-click-to-select="true"
                            data-side-pagination="server"
                            data-pagination="true"
                            data-page-list="[5, 10, 20, 50, 100, 200]"
                            data-search="false" data-show-columns="false"
                            data-show-refresh="false" data-trim-on-search="false"
                            data-sort-name="id" data-sort-order="desc"
                            data-mobile-responsive="true"
                            data-toolbar="" data-show-export="false"
                            data-maintain-selected="true"
                            data-export-types='["txt","excel"]'
                            data-export-options='{
                              "fileName": "projects-list",
                              "ignoreColumn": ["state"] 
                            }'
                            data-query-params="queryParams">
                            <thead>
                              <tr>
                                <th data-field="id" data-visible="false" data-sortable="true"><?= !empty($this->lang->line('label_id'))?$this->lang->line('label_id'):'ID'; ?></th>
                                
                                
                                <th data-field="title" data-sortable="true"><?= !empty($this->lang->line('label_projects'))?$this->lang->line('label_projects'):'Project'; ?></th>
                                
                                <th data-field="description" data-visible="false" data-sortable="true"><?= !empty($this->lang->line('label_description'))?$this->lang->line('label_description'):'Description'; ?></th>
                                
                                <th data-field="task_count" data-sortable="true"><?= !empty($this->lang->line('label_tasks'))?$this->lang->line('label_tasks'):'Tasks'; ?></th>
                                
                                <th data-field="projects_userss" data-sortable="true"><?= !empty($this->lang->line('label_users'))?$this->lang->line('label_users'):'Users'; ?></th>

                                <th data-field="projects_clientss" data-sortable="true"><?= !empty($this->lang->line('label_clients'))?$this->lang->line('label_clients'):'Clients'; ?></th>
                                
                                <th data-field="status" data-sortable="true"><?= !empty($this->lang->line('label_status'))?$this->lang->line('label_status'):'Status'; ?></th>
                                
                              </tr>
                            </thead>
                          </table>
                        </div>
                        <div class="tab-pane fade" id="tasks" role="tabpanel" aria-labelledby="tasks-tab">
                          <table class='table-striped' id='tasks_list'
                            data-toggle="table"
                            data-url="<?=base_url('home/get_tasks_list/'.$user_detail->id.'/')?>"
                            data-click-to-select="true"
                            data-side-pagination="server"
                            data-pagination="true"
                            data-page-list="[5, 10, 20, 50, 100, 200]"
                            data-search="false" data-show-columns="false"
                            data-show-refresh="false" data-trim-on-search="false"
                            data-sort-name="id" data-sort-order="desc"
                            data-mobile-responsive="true"
                            data-toolbar="" data-show-export="false"
                            data-maintain-selected="true"
                            data-export-types='["txt","excel"]'
                            data-export-options='{
                              "fileName": "tasks-list",
                              "ignoreColumn": ["state"] 
                            }'
                            data-query-params="queryParams">
                            <thead>
                              <tr>
                                <th data-field="id" data-visible='false' data-sortable="true"><?= !empty($this->lang->line('label_id'))?$this->lang->line('label_id'):'ID'; ?></th>
                                <th data-field="project_id" data-visible='false' data-sortable="true"><?= !empty($this->lang->line('label_id'))?$this->lang->line('label_id'):'Project ID'; ?></th>
                                <th data-field="project_title" data-sortable="true"><?= !empty($this->lang->line('label_projects'))?$this->lang->line('label_projects'):'Project'; ?></th>
                                <th data-field="title" data-sortable="true"><?= !empty($this->lang->line('label_tasks'))?$this->lang->line('label_tasks'):'Tasks'; ?></th>
                                <th data-field="description"  data-visible='false' data-sortable="true"><?= !empty($this->lang->line('label_description'))?$this->lang->line('label_description'):'Description'; ?></th>
                                <th data-field="priority" data-sortable="true"><?= !empty($this->lang->line('label_priority'))?$this->lang->line('label_priority'):'Priority'; ?></th>
                                <th data-field="status" data-sortable="true"><?= !empty($this->lang->line('label_status'))?$this->lang->line('label_status'):'Status'; ?></th>
                                <th data-field="due_date" data-sortable="true"><?= !empty($this->lang->line('label_due_date'))?$this->lang->line('label_due_date'):'Due Date'; ?></th>
                                
                              </tr>
                            </thead>
                          </table>
                        </div>
                        <div class="tab-pane fade" id="leaves" role="tabpanel" aria-labelledby="leaves-tab">
                          <table class='table-striped' id='leaves_list'
                            data-toggle="table"
                            data-url="<?=base_url('leaves/get_leaves_list/'.$user_detail->id.'/')?>"
                            data-click-to-select="true"
                            data-side-pagination="server"
                            data-pagination="true"
                            data-page-list="[5, 10, 20, 50, 100, 200]"
                            data-search="false" data-show-columns="false"
                            data-show-refresh="false" data-trim-on-search="false"
                            data-sort-name="id" data-sort-order="desc"
                            data-mobile-responsive="true"
                            data-toolbar="" data-show-export="false"
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
                                
                              </tr>
                            </thead>
                          </table>
                        </div>
                      </div>
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