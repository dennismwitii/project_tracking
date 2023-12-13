<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Project Details &mdash; <?= get_compnay_title(); ?></title>
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
            <h1><?= !empty($this->lang->line('label_project_details'))?$this->lang->line('label_project_details'):'Project Details'; ?></h1>
            <div class="section-header-breadcrumb">
            <a href="<?= base_url('projects/tasks/'.$projects['id']); ?>" class="btn btn-primary btn-rounded no-shadow"><?= !empty($this->lang->line('label_project_tasks'))?$this->lang->line('label_project_tasks'):'Project Tasks'; ?></a>
            </div>
          </div>

          <div class="section-body">
            <div class="row">
            <div class="modal-edit-milestone"></div>
                <?php 
                    // print_r($files); 
                    $now = date('Y-m-d'); // or your date as well
                    $your_date = strtotime($projects['end_date']);
                    $curdate=strtotime($now);
                    $mydate= $your_date ;
                    if($curdate > $mydate)
                    {
                        $dayleft = 0;
                    }else{
                        $dayleft = $your_date - $curdate;
                        $dayleft = round($dayleft / (60 * 60 * 24));
                        
                        
                    }   
                ?>
                <div class="col-md-4"> 
                    <div class="card">
                        <div class="card-header">
                        <h4><?= !empty($this->lang->line('label_task_overview'))?$this->lang->line('label_task_overview'):'Tasks Overview'; ?></h4>
                        </div>
                        <div class="card-body">
                        <canvas id="task-area-chart" height="290"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card author-box card-<?= $projects['class']; ?>">
                        <div class="card-body">
                            <div class="author-box-name">
                                <h4><?= $projects['title']; ?></h4>
                            </div>
                            <div class="author-box-job">
                                <div class="badge badge-<?= $projects['class']; ?> projects-badge"><?= $projects['status']; ?></div>
                                <div class="float-right mt-sm-1">
                                <b><?= !empty($this->lang->line('label_start_date'))?$this->lang->line('label_start_date'):'Start Date'; ?>: </b><?= $projects['start_date']; ?> <b><?= !empty($this->lang->line('label_end_date'))?$this->lang->line('label_end_date'):'End Date'; ?>: </b><?= $projects['end_date']; ?>
                            </div>
                            </div>
                            <div class="author-box-description">
                                <p><?= $projects['description']; ?></p>
                            </div>
                            
                            <div class="row">
                                    <?php if(!empty($projects['projects_clients'])){ ?>
                                    <div class="col-md-6">
                                    <h6><?= !empty($this->lang->line('label_clients'))?$this->lang->line('label_clients'):'Clients'; ?></h6>
                                    <?php foreach($projects['projects_clients'] as $projects_clients){ 

                                        if(isset($projects_clients['profile']) && !empty($projects_clients['profile'])){ ?>
                                        <a href="<?=base_url('users/detail/'.$projects_clients['id'])?>">
                                        <figure class="avatar avatar-md" data-toggle="tooltip" data-title="<?= $projects_clients['first_name'] ?>">
                                            <img alt="image" src="<?= base_url('assets/profiles/'.$projects_clients['profile']); ?>" class="rounded-circle">
                                        </figure>
                                        </a>
                                    <?php }else{ ?>
                                        <a href="<?=base_url('users/detail/'.$projects_clients['id'])?>">
                                        <figure data-toggle="tooltip" data-title="<?= $projects_clients['first_name'] ?>" class="avatar avatar-md" data-initial="<?= mb_substr($projects_clients['first_name'], 0, 1).''.mb_substr($projects_clients['last_name'], 0, 1); ?>">
                                        </figure>
                                        </a>
                                    <?php } } ?>
                                    </div>
                                    <?php } ?>
                                    <div class="col-md-6">
                                    <h6 class="mt-1"><?= !empty($this->lang->line('label_users'))?$this->lang->line('label_users'):'Users'; ?></h6>
                                    <?php foreach($projects['projects_users'] as $projects_users){ 

                                        if(isset($projects_users['profile']) && !empty($projects_users['profile'])){ ?>
                                        <a href="<?=base_url('users/detail/'.$projects_users['id'])?>">
                                        <figure class="avatar avatar-md" data-toggle="tooltip" data-title="<?= $projects_users['first_name'] ?>">
                                            <img alt="image" src="<?= base_url('assets/profiles/'.$projects_users['profile']); ?>" class="rounded-circle">
                                        </figure>
                                        </a>
                                    <?php }else{ ?>
                                        <a href="<?=base_url('users/detail/'.$projects_users['id'])?>">
                                        <figure data-toggle="tooltip" data-title="<?= $projects_users['first_name'] ?>" class="avatar avatar-md" data-initial="<?= mb_substr($projects_users['first_name'], 0, 1).''.mb_substr($projects_users['last_name'], 0, 1); ?>">
                                        </figure>
                                        </a>
                                    <?php } } ?>
                                    </div>
                                </div>

                        </div>
                    </div>

                    <div class="row">
                        <?php if(!hide_budget()){ ?>
                        <div class="col-md-6">
                            <div class="card card-statistic-2">
                                <div class="card-icon bg-mid-dark m-3">
                                    <i class="fas"><?=get_currency_symbol();?></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4><?= !empty($this->lang->line('label_budget'))?$this->lang->line('label_budget'):'Budget'; ?></h4>
                                    </div>
                                    <div class="card-body">
                                    <?= $projects['budget']; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="col-md-6">
                            <div class="card card-statistic-2">
                                <div class="card-icon bg-mid-dark m-3">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4><?= !empty($this->lang->line('label_days_left'))?$this->lang->line('label_days_left'):'Days Left'; ?></h4>
                                    </div>
                                    <div class="card-body">
                                        <?= $dayleft ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-statistic-2">
                                <div class="card-icon bg-mid-dark m-3">
                                    <i class="fas fa-tasks"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4><?= !empty($this->lang->line('label_total_tasks'))?$this->lang->line('label_total_tasks'):'Total Tasks'; ?></h4>
                                    </div>
                                    <div class="card-body">
                                    <?= $projects['task_count']; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-statistic-2">
                                <div class="card-icon bg-mid-dark m-3">
                                    <i class="fas fa-comments"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4><?= !empty($this->lang->line('label_comments'))?$this->lang->line('label_comments'):'Comments'; ?></h4>
                                    </div>
                                    <div class="card-body">
                                    <?= $projects['comment_count']; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                </div>

            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card author-box">
                        <div class="card-body">
                            <div class="author-box-name mb-4">
                            <?= !empty($this->lang->line('label_upload_files'))?$this->lang->line('label_upload_files'):'Upload Files'; ?>
                               
                            </div>
                            <input type="hidden" id="workspace_id" value="<?= $projects['workspace_id'] ?>">
                            <input type="hidden" id="project_id" value="<?= $projects['id'] ?>">
                            <div class="dropzone dz-clickable" id="project-files-dropzone"><div class="dz-default dz-message"><span>
                            <?= !empty($this->lang->line('label_drop_files_here_to_upload'))?$this->lang->line('label_drop_files_here_to_upload'):'Drop files here to upload'; ?>
                            </span></div></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                        <h4>
                        <?= !empty($this->lang->line('label_uploaded_files'))?$this->lang->line('label_uploaded_files'):'Uploaded Files'; ?>
                        </h4>
                        </div>
                        <div class="card-body p-0">
                        <div class="table-responsive table-invoice">
                            <table class="table table-striped">
                            <tr>
                                <th><?= !empty($this->lang->line('label_preview'))?$this->lang->line('label_preview'):'Preview'; ?></th>
                                <th><?= !empty($this->lang->line('label_name'))?$this->lang->line('label_name'):'Name'; ?></th>
                                <th><?= !empty($this->lang->line('label_size'))?$this->lang->line('label_size'):'Size'; ?></th>
                                <th><?= !empty($this->lang->line('label_action'))?$this->lang->line('label_action'):'Action'; ?></th>
                            </tr>
                            <?php foreach($files as $file){ ?>
                                <tr>
                                    <td><?= $file['file_extension'] ?></td>
                                    <td><?= $file['original_file_name'] ?></td>
                                    <td class="font-weight-600"><?= $file['file_size'] ?></td>
                                    <td>
                                        <a download="<?= $file['original_file_name'] ?>" href="<?= base_url('assets/project/'.$file['file_name']); ?>" class="btn btn-primary btn-action mt-1 "><i class="fas fa-download"></i></a>
                                        <a class="btn btn-danger btn-action mt-1 delete-file-alert" data-file_id="<?= $file['id'] ?>"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            
                            </table>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                        <h4><?= !empty($this->lang->line('label_milestones'))?$this->lang->line('label_milestones'):'Milestones'; ?></h4>
                        <div class="card-header-action">
                            <?php if(!hide_budget()){ ?>
                            <a href="#" class="btn btn-primary" id="modal-add-milestone"><?= !empty($this->lang->line('label_create'))?$this->lang->line('label_create'):'Create'; ?></a>
                            <?php } ?>
                        </div>
                        </div>
                        <div class="card-body p-0">
                        <div class="table-responsive table-invoice">
                            <table class="table table-striped">
                            <tr>
                                <th><?= !empty($this->lang->line('label_title'))?$this->lang->line('label_title'):'Title'; ?></th>
                                <th><?= !empty($this->lang->line('label_status'))?$this->lang->line('label_status'):'Status'; ?></th>
                                <th><?= !empty($this->lang->line('label_summary'))?$this->lang->line('label_summary'):'Summary'; ?></th>
                                <?php if(!hide_budget()){ ?>
                                <th><?= !empty($this->lang->line('label_cost'))?$this->lang->line('label_cost'):'Cost'; ?></th>
                                <th><?= !empty($this->lang->line('label_action'))?$this->lang->line('label_action'):'Action'; ?></th>
                                <?php } ?>
                            </tr>
                            <?php foreach($milestones as $milestone){ ?>
                                <tr>
                                    <td><?= $milestone['title'] ?></td>
                                    <td><div class="badge badge-<?= $milestone['class'] ?> projects-badge"><?= $milestone['status'] ?></div></td>
                                    <td><?= $milestone['description'] ?></td>
                                    <?php if(!hide_budget()){ ?>
                                    <td class="font-weight-600"><?=get_currency_symbol();?> <?= $milestone['cost'] ?></td>
                                    <td>
                                        <a class="btn btn-primary btn-action mt-1 modal-edit-milestone-ajax" data-id="<?= $milestone['id'] ?>" ><i class="fas fa-pencil-alt"></i></a>
                                        <a class="btn btn-danger btn-action mt-1 delete-milestone-alert" data-milestone_id="<?= $milestone['id'] ?>" data-project_id="<?= $projects['id'] ?>" href="<?= base_url('projects/delete_milestone/'.$milestone['id'].'/'.$projects['id']); ?>"><i class="fas fa-trash"></i></a>
                                    </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                            
                            </table>
                        </div>
                        </div>
                    </div>
                </div>

            </div>


          </div>
        </section>
      </div>
      
        <form action="<?= base_url('projects/create_milestone/'.$projects['id']); ?>" method="post" class="modal-part" id="modal-add-milestone-part">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label><?= !empty($this->lang->line('label_title'))?$this->lang->line('label_title'):'Title'; ?></label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="title" name="title">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status"><?= !empty($this->lang->line('label_status'))?$this->lang->line('label_status'):'Status'; ?></label>
                                <select id="status" name="status" class="form-control">
                                    <option value="incomplete"><?= !empty($this->lang->line('label_incomplete'))?$this->lang->line('label_incomplete'):'Incomplete'; ?></option>
                                    <option value="complete"><?= !empty($this->lang->line('label_complete'))?$this->lang->line('label_complete'):'Complete'; ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="budget"><?= !empty($this->lang->line('label_cost'))?$this->lang->line('label_cost'):'Cost'; ?></label>
                                <div class="input-group">
                                    <span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend"><span class="input-group-text"><?=get_currency_symbol();?></span></span>
                                    <input class="form-control" type="number" min="0" id="cost" name="cost" value="">
                                </div>
                            </div>
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
            </div>
        </form>

        <form action="<?= base_url('projects/edit_milestone'); ?>" method="post" class="modal-part" id="modal-edit-milestone-part">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label><?= !empty($this->lang->line('label_title'))?$this->lang->line('label_title'):'Title'; ?></label>
                        <div class="input-group">
                            <input type="hidden" name="update_id" id="update_id">
                            <input type="text" class="form-control" placeholder="title" id="update_title" name="title">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status"><?= !empty($this->lang->line('label_status'))?$this->lang->line('label_status'):'Status'; ?></label>
                                <select id="update_status" name="status" class="form-control">
                                    <option value="incomplete"><?= !empty($this->lang->line('label_incomplete'))?$this->lang->line('label_incomplete'):'Incomplete'; ?></option>
                                    <option value="complete"><?= !empty($this->lang->line('label_complete'))?$this->lang->line('label_complete'):'Complete'; ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="budget">Cost</label>
                                <div class="input-group">
                                    <span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend"><span class="input-group-text"><?=get_currency_symbol();?></span></span>
                                    <input class="form-control" type="number" min="0" id="update_cost" name="cost" value="150" placeholder="Project Budget">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label><?= !empty($this->lang->line('label_description'))?$this->lang->line('label_description'):'Description'; ?></label>
                        <div class="input-group">
                            <textarea type="textarea" class="form-control" placeholder="description" id="update_description" name="description"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        
      <?php include('include-footer.php'); ?>

    </div>
  </div>
  
<script>
    label_todo = "<?= !empty($this->lang->line('label_todo'))?$this->lang->line('label_todo'):'Todo'; ?>";
    label_in_progress = "<?= !empty($this->lang->line('label_in_progress'))?$this->lang->line('label_in_progress'):'In Progress'; ?>";
    label_review = "<?= !empty($this->lang->line('label_review'))?$this->lang->line('label_review'):'Review'; ?>";
    label_done = "<?= !empty($this->lang->line('label_done'))?$this->lang->line('label_done'):'Done'; ?>";
    label_tasks = "<?= !empty($this->lang->line('label_tasks'))?$this->lang->line('label_tasks'):'Tasks'; ?>";
    
    todo_task = "<?= $todo_task ?>";
    inprogress_task = "<?= $inprogress_task ?>";
    review_task = "<?= $review_task ?>";
    done_task = "<?= $done_task ?>";
    dictDefaultMessage = "<?= !empty($this->lang->line('label_drop_files_here_to_upload'))?$this->lang->line('label_drop_files_here_to_upload'):'Drop Files Here To Upload'; ?>";
</script>

<?php include('include-js.php'); ?>
  <!-- Page Specific JS File -->
<script src="<?= base_url('assets/js/page/components-user.js'); ?>"></script>
<script src="<?= base_url('assets/js/page/project-details.js'); ?>"></script>

</body>
</html>