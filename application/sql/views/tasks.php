<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
        <title>Tasks &mdash; <?= get_compnay_title(); ?></title>
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
                            <h1> <a href="<?=base_url('projects/details/'.$current_project['id']);?>"><?= $current_project['title'] ?></a> > <?= !empty($this->lang->line('label_tasks'))?$this->lang->line('label_tasks'):'Tasks'; ?></h1>
                            <?php if(!is_client()){ ?>
                            <div class="section-header-breadcrumb">
                                <i class="btn btn-primary btn-rounded no-shadow" id="modal-add-task"><?= !empty($this->lang->line('label_create_task'))?$this->lang->line('label_create_task'):'Create Task'; ?></i>
                            </div>
                            <?php } ?>
                        </div>
                        
                        <div class="section-body">
                            <div class="row">
                            <div class="modal-edit-task "></div>
                            <div class="modal-add-task-details"></div>
                            
                                <div class="col-12">
                                    <div class="board" <?=!is_client()?'data-plugin="dragula"':''?> data-containers="[&quot;task-list-todo&quot;,&quot;task-list-in_progress&quot;,&quot;task-list-review&quot;,&quot;task-list-done&quot;]">
                                        
                                    <div class="tasks animated" data-sr-id="1" >
                                            <div class="mt-0 task-header text-uppercase"><?= !empty($this->lang->line('label_todo'))?$this->lang->line('label_todo'):'Todo'; ?> (<span class="count"><?= !empty($todo)?$todo:0; ?></span>)</div>
                                            <div id="task-list-todo" data-status="todo" class="task-list-items">

                                            <?php foreach($tasks as $task){ 
                                                if(($task['status'] == 'todo') && (in_array($user->id, $admin_ids) || in_array($user->id, explode(",",$task['user_id'])) || is_client() 
                                                )
                                                ){
                                                    
                                            ?>
                                                
                                                <div class="card mb-0" id="<?= $task['id'] ?>">
                                                    <div class="card-body p-3">
                                                        <?php if(!is_client()){ ?>
                                                        <div class="card-header-action float-right">
                                                            <div class="dropdown card-widgets">
                                                                <a href="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-cog"></i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item has-icon modal-edit-task-ajax" data-id="<?= $task['id'] ?>" href="#"><i class="fas fa-pencil-alt"></i> <?= !empty($this->lang->line('label_edit'))?$this->lang->line('label_edit'):'Edit'; ?></a>
                                                                    <a class="dropdown-item has-icon delete-task-alert" data-task_id="<?= $task['id'] ?>" data-project_id="<?= $current_project['id'] ?>" href="<?= base_url('projects/delete_task/'.$task['id'].'/'.$current_project['id']); ?>"><i class="far fa-trash-alt"></i> <?= !empty($this->lang->line('label_delete'))?$this->lang->line('label_delete'):'Delete'; ?></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                        <div>
                                                            <a href="#" data-id="<?= $task['id'] ?>" class="text-body modal-add-task-details-ajax"><?= $task['title'] ?></a>
                                                        </div>
                                                        <span class="badge badge-<?= $task['class'] ?> projects-badge"><?= $task['priority'] ?></span>
                                                        <p class="mt-2 mb-2">
                                                            <span class="text-nowrap d-inline-block">
                                                            <i class="fas fa-comments text-muted"></i>
                                                            <b><?= $task['comment_count'] ?></b> <?= !empty($this->lang->line('label_comments'))?$this->lang->line('label_comments'):'Comments'; ?>
                                                            </span>
                                                        </p>
                                                        <small class="float-right text-muted mt-2"><?= $task['due_date'] ?></small>

                                                        <?php $i = 0; $j = 0; foreach($task['task_users'] as $task_user){
                                                            if($i < 2){ 
                                                            if(isset($task_user['profile']) && !empty($task_user['profile'])){ 
                                                        ?>
                                                            <figure class="avatar mr-2 avatar-sm" data-toggle="tooltip" data-title="<?= $task_user['first_name'] ?>">
                                                                <img alt="image" src="<?= base_url('assets/profiles/'.$task_user['profile']); ?>" class="rounded-circle">
                                                            </figure>
                                                        <?php }else{ ?>
                                                            <figure data-toggle="tooltip" data-title="<?= $task_user['first_name'] ?>" class="avatar mr-2 avatar-sm" data-initial="<?= mb_substr($task_user['first_name'], 0, 1).''.mb_substr($task_user['last_name'], 0, 1); ?>">
                                                            </figure>
                                                        <?php } }else{ 
                                                            if($j == 0){
                                                        ?>
                                                            <figure data-toggle="tooltip" data-title="More" class="avatar mr-2 avatar-sm" data-initial="+">
                                                            </figure>
                                                        <?php $j++; } } $i++; } ?>

                                                    </div>
                                                </div>
                                            <?php } } ?>
                                
                                            </div>
                                        </div>

                                        <div class="tasks animated" data-sr-id="2">
                                            <div class="mt-0 task-header text-uppercase"></b> <?= !empty($this->lang->line('label_in_progress'))?$this->lang->line('label_in_progress'):'In Progress'; ?> (<span class="count"><?= !empty($inprogress)?$inprogress:0; ?></span>)</div>
                                            <div id="task-list-in_progress" data-status="inprogress" class="task-list-items">
                                                
                                                
                                            <?php foreach($tasks as $task){ 
                                                if(($task['status'] == 'inprogress') && (in_array($user->id, $admin_ids) || in_array($user->id, explode(",",$task['user_id'])) || is_client())){
                                            ?>
                                                
                                                <div class="card mb-0" id="<?= $task['id'] ?>">
                                                    <div class="card-body p-3">
                                                        <?php if(!is_client()){ ?>
                                                        <div class="card-header-action float-right">
                                                            <div class="dropdown card-widgets">
                                                                <a href="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-cog"></i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item has-icon modal-edit-task-ajax" data-id="<?= $task['id'] ?>" href="#"><i class="fas fa-pencil-alt"></i> <?= !empty($this->lang->line('label_edit'))?$this->lang->line('label_edit'):'Edit'; ?></a>
                                                                    <a class="dropdown-item has-icon delete-task-alert" data-task_id="<?= $task['id'] ?>" data-project_id="<?= $current_project['id'] ?>" href="<?= base_url('projects/delete_task/'.$task['id'].'/'.$current_project['id']); ?>"><i class="far fa-trash-alt"></i> <?= !empty($this->lang->line('label_delete'))?$this->lang->line('label_delete'):'Delete'; ?></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                        <div>
                                                            <a href="#" data-id="<?= $task['id'] ?>" class="text-body modal-add-task-details-ajax"><?= $task['title'] ?></a>
                                                        </div>
                                                        <span class="badge badge-<?= $task['class'] ?> projects-badge"><?= $task['priority'] ?></span>
                                                        <p class="mt-2 mb-2">
                                                            <span class="text-nowrap d-inline-block">
                                                            <i class="fas fa-comments text-muted"></i>
                                                            <b><?= $task['comment_count'] ?></b> <?= !empty($this->lang->line('label_comments'))?$this->lang->line('label_comments'):'Comments'; ?>
                                                            </span>
                                                        </p>
                                                        <small class="float-right text-muted mt-2"><?= $task['due_date'] ?></small>

                                                        <?php $i = 0; $j = 0; foreach($task['task_users'] as $task_user){
                                                            if($i < 2){ 
                                                            if(isset($task_user['profile']) && !empty($task_user['profile'])){ 
                                                        ?>
                                                            <figure class="avatar mr-2 avatar-sm" data-toggle="tooltip" data-title="<?= $task_user['first_name'] ?>">
                                                                <img alt="image" src="<?= base_url('assets/profiles/'.$task_user['profile']); ?>" class="rounded-circle">
                                                            </figure>
                                                        <?php }else{ ?>
                                                            <figure data-toggle="tooltip" data-title="<?= $task_user['first_name'] ?>" class="avatar mr-2 avatar-sm" data-initial="<?= mb_substr($task_user['first_name'], 0, 1).''.mb_substr($task_user['last_name'], 0, 1); ?>">
                                                            </figure>
                                                        <?php } }else{ 
                                                            if($j == 0){
                                                        ?>
                                                            <figure data-toggle="tooltip" data-title="More" class="avatar mr-2 avatar-sm" data-initial="+">
                                                            </figure>
                                                        <?php $j++; } } $i++; } ?>

                                                    </div>
                                                </div>
                                            <?php } }?>

                                            </div>
                                        </div>

                                        <div class="tasks animated" data-sr-id="3">
                                            <div class="mt-0 task-header text-uppercase"><?= !empty($this->lang->line('label_review'))?$this->lang->line('label_review'):'Review'; ?> (<span class="count"><?= !empty($review)?$review:0; ?></span>)</div>
                                            <div id="task-list-review" data-status="review" class="task-list-items">
                                                
                                            <?php foreach($tasks as $task){ 
                                                if(($task['status'] == 'review') && (in_array($user->id, $admin_ids) || in_array($user->id, explode(",",$task['user_id'])) || is_client())){
                                            ?>
                                                
                                                <div class="card mb-0" id="<?= $task['id'] ?>">
                                                    <div class="card-body p-3">
                                                        <?php if(!is_client()){ ?>
                                                        <div class="card-header-action float-right">
                                                            <div class="dropdown card-widgets">
                                                                <a href="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-cog"></i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item has-icon modal-edit-task-ajax" data-id="<?= $task['id'] ?>" href="#"><i class="fas fa-pencil-alt"></i> <?= !empty($this->lang->line('label_edit'))?$this->lang->line('label_edit'):'Edit'; ?></a>
                                                                    <a class="dropdown-item has-icon delete-task-alert" data-task_id="<?= $task['id'] ?>" data-project_id="<?= $current_project['id'] ?>" href="<?= base_url('projects/delete_task/'.$task['id'].'/'.$current_project['id']); ?>"><i class="far fa-trash-alt"></i> <?= !empty($this->lang->line('label_delete'))?$this->lang->line('label_delete'):'Delete'; ?></a></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                        <div>
                                                            <a href="#" data-id="<?= $task['id'] ?>" class="text-body modal-add-task-details-ajax"><?= $task['title'] ?></a>
                                                        </div>
                                                        <span class="badge badge-<?= $task['class'] ?> projects-badge"><?= $task['priority'] ?></span>
                                                        <p class="mt-2 mb-2">
                                                            <span class="text-nowrap d-inline-block">
                                                            <i class="fas fa-comments text-muted"></i>
                                                            <b><?= $task['comment_count'] ?></b> <?= !empty($this->lang->line('label_comments'))?$this->lang->line('label_comments'):'Comments'; ?>
                                                            </span>
                                                        </p>
                                                        <small class="float-right text-muted mt-2"><?= $task['due_date'] ?></small>
                                       
                                                        <?php $i = 0; $j = 0; foreach($task['task_users'] as $task_user){
                                                            if($i < 2){ 
                                                            if(isset($task_user['profile']) && !empty($task_user['profile'])){ 
                                                        ?>
                                                            <figure class="avatar mr-2 avatar-sm" data-toggle="tooltip" data-title="<?= $task_user['first_name'] ?>">
                                                                <img alt="image" src="<?= base_url('assets/profiles/'.$task_user['profile']); ?>" class="rounded-circle">
                                                            </figure>
                                                        <?php }else{ ?>
                                                            <figure data-toggle="tooltip" data-title="<?= $task_user['first_name'] ?>" class="avatar mr-2 avatar-sm" data-initial="<?= mb_substr($task_user['first_name'], 0, 1).''.mb_substr($task_user['last_name'], 0, 1); ?>">
                                                            </figure>
                                                        <?php } }else{ 
                                                            if($j == 0){
                                                        ?>
                                                            <figure data-toggle="tooltip" data-title="More" class="avatar mr-2 avatar-sm" data-initial="+">
                                                            </figure>
                                                        <?php $j++; } } $i++; } ?>

                                                    </div>
                                                </div>

                                                <?php } }?>

                                            </div>
                                        </div>
                                        
                                        <div class="tasks animated" data-sr-id="4">
                                            <div class="mt-0 task-header text-uppercase"><?= !empty($this->lang->line('label_done'))?$this->lang->line('label_done'):'Done'; ?> (<span class="count"><?= !empty($done)?$done:0; ?></span>)</div>
                                            <div id="task-list-done" data-status="done" class="task-list-items">
                                                
                                            <?php foreach($tasks as $task){ 
                                                if(($task['status'] == 'done') && (in_array($user->id, $admin_ids) || in_array($user->id, explode(",",$task['user_id'])) || is_client())){
                                            ?>
                                                
                                                <div class="card mb-0" id="<?= $task['id'] ?>">
                                                    <div class="card-body p-3">
                                                        <?php if(!is_client()){ ?>
                                                        <div class="card-header-action float-right">
                                                            <div class="dropdown card-widgets">
                                                                <a href="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-cog"></i></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item has-icon modal-edit-task-ajax" data-id="<?= $task['id'] ?>" href="#"><i class="fas fa-pencil-alt"></i> <?= !empty($this->lang->line('label_edit'))?$this->lang->line('label_edit'):'Edit'; ?></a>
                                                                    <a class="dropdown-item has-icon delete-task-alert" data-task_id="<?= $task['id'] ?>" data-project_id="<?= $current_project['id'] ?>" href="<?= base_url('projects/delete_task/'.$task['id'].'/'.$current_project['id']); ?>"><i class="far fa-trash-alt"></i> <?= !empty($this->lang->line('label_delete'))?$this->lang->line('label_delete'):'Delete'; ?></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                        <div> 
                                                            <a href="#" data-id="<?= $task['id'] ?>" class="text-body modal-add-task-details-ajax"><?= $task['title'] ?></a>
                                                        </div>
                                                        <span class="badge badge-<?= $task['class'] ?> projects-badge"><?= $task['priority'] ?></span>
                                                        <p class="mt-2 mb-2">
                                                            <span class="text-nowrap d-inline-block">
                                                            <i class="fas fa-comments text-muted"></i>
                                                            <b><?= $task['comment_count'] ?></b> <?= !empty($this->lang->line('label_comments'))?$this->lang->line('label_comments'):'Comments'; ?>
                                                            </span>
                                                        </p>
                                                        <small class="float-right text-muted mt-2"><?= $task['due_date'] ?></small>
                                                       
                                                        <?php $i = 0; $j = 0; foreach($task['task_users'] as $task_user){
                                                            if($i < 2){ 
                                                            if(isset($task_user['profile']) && !empty($task_user['profile'])){ 
                                                        ?>
                                                            <figure class="avatar mr-2 avatar-sm" data-toggle="tooltip" data-title="<?= $task_user['first_name'] ?>">
                                                                <img alt="image" src="<?= base_url('assets/profiles/'.$task_user['profile']); ?>" class="rounded-circle">
                                                            </figure>
                                                        <?php }else{ ?>
                                                            <figure data-toggle="tooltip" data-title="<?= $task_user['first_name'] ?>" class="avatar mr-2 avatar-sm" data-initial="<?= mb_substr($task_user['first_name'], 0, 1).''.mb_substr($task_user['last_name'], 0, 1); ?>">
                                                            </figure>
                                                        <?php } }else{ 
                                                            if($j == 0){
                                                        ?>
                                                            <figure data-toggle="tooltip" data-title="More" class="avatar mr-2 avatar-sm" data-initial="+">
                                                            </figure>
                                                        <?php $j++; } } $i++; } ?>
                                                        
                                                    </div>
                                                </div>

                                                <?php } }?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <form  action="<?= base_url('projects/create_task/'.$current_project['id']); ?>" method="post" class="modal-part" id="modal-add-task-part">
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
                                        <label for="milestone_id"><?= !empty($this->lang->line('label_milestone'))?$this->lang->line('label_milestone'):'Milestone'; ?></label>
                                        <select id="milestone_id" name="milestone_id" class="form-control">
                                        <option value="" selected><?= !empty($this->lang->line('label_select_milestone'))?$this->lang->line('label_select_milestone'):'Select Milestone'; ?></option>
                                        <?php foreach($milestones as $milestone){ ?>
                                            <option value="<?= $milestone['id'] ?>"><?= $milestone['title'] ?></option> 
                                        <?php } ?>
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="priority"><?= !empty($this->lang->line('label_priority'))?$this->lang->line('label_priority'):'Priority'; ?></label>
                                        <select id="priority" name="priority" class="form-control">
                                            <option value="low"><?= !empty($this->lang->line('label_low'))?$this->lang->line('label_low'):'Low'; ?></option>
                                            <option value="medium"><?= !empty($this->lang->line('label_medium'))?$this->lang->line('label_medium'):'Medium'; ?></option>
                                            <option value="high"><?= !empty($this->lang->line('label_high'))?$this->lang->line('label_high'):'High'; ?></option>
                                        </select>
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
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?= !empty($this->lang->line('label_assign_to'))?$this->lang->line('label_assign_to'):'Assign To'; ?></label>
                                <select class="form-control select2" multiple="" name="user_id[]" id="user_id">
                                <?php foreach($all_user as $all_users){ if(!is_client($all_users->id)){ ?>
                                    <option value="<?= $all_users->id?>"><?= $all_users->first_name?> <?= $all_users->last_name?></option>
                                <?php } } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end_date"><?= !empty($this->lang->line('label_due_date'))?$this->lang->line('label_due_date'):'Due Date'; ?></label>
                                <input class="form-control datepicker" type="text" id="due_date" name="due_date" value="" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </form>


                <form action="<?= base_url('projects/edit_task'); ?>" method="post" class="modal-part" id="modal-edit-task-part">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?= !empty($this->lang->line('label_title'))?$this->lang->line('label_title'):'Title'; ?></label>
                                <div class="input-group">
                                <input type="hidden" name="update_id" id="update_id">
                                    <input type="text" class="form-control" placeholder="title" name="title" id="update_title">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="milestone_id"><?= !empty($this->lang->line('label_milestone'))?$this->lang->line('label_milestone'):'Milestone'; ?></label>
                                        <select id="update_milestone_id" name="milestone_id" class="form-control">
                                        <option value="" selected><?= !empty($this->lang->line('label_select_milestone'))?$this->lang->line('label_select_milestone'):'Select Milestone'; ?></option>
                                        <?php foreach($milestones as $milestone){ ?>
                                            <option value="<?= $milestone['id'] ?>"><?= $milestone['title'] ?></option> 
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="budget"><?= !empty($this->lang->line('label_priority'))?$this->lang->line('label_priority'):'Priority'; ?></label>
                                        <select id="update_priority" name="priority" class="form-control">
                                            <option value="low"><?= !empty($this->lang->line('label_low'))?$this->lang->line('label_low'):'Low'; ?></option>
                                            <option value="medium"><?= !empty($this->lang->line('label_medium'))?$this->lang->line('label_medium'):'Medium'; ?></option>
                                            <option value="high"><?= !empty($this->lang->line('label_high'))?$this->lang->line('label_high'):'High'; ?></option>
                                        </select>
                                    </div>
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

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?= !empty($this->lang->line('label_assign_to'))?$this->lang->line('label_assign_to'):'Assign To'; ?></label>
                                <select class="form-control select2" multiple="" name="user_id[]" id="update_user_id">
                                <?php foreach($all_user as $all_users){ if(!is_client($all_users->id)){ ?>
                                    <option value="<?= $all_users->id?>"><?= $all_users->first_name?> <?= $all_users->last_name?></option>
                                <?php } } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end_date"><?= !empty($this->lang->line('label_due_date'))?$this->lang->line('label_due_date'):'Due Date'; ?></label>
                                <input class="form-control datepicker" type="text"id="update_due_date" name="due_date"  autocomplete="off">
                            </div>
                        </div>
                    </div>
                </form>

                <form  action="<?= base_url('projects/add_task_details'); ?>" enctype="multipart/form-data" class="modal-part" id="modal-add-task-details-part">
                    <input type="hidden" name="workspace_id" id="workspace_id_details">
                    <input type="hidden" name="project_id" id="project_id_details">
                    <input type="hidden" name="task_id" id="task_id_details">
                    <input type="hidden" name="user_id" id="user_id_details">
                    <div class="p-2">
                        <div class="row">
                            <div class="col-md-12 font-weight-bold">
                            <?= !empty($this->lang->line('label_description'))?$this->lang->line('label_description'):'Description'; ?>
                            </div>
                            <div class="col-md-12" id="task_details_description">
                                
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <div class="font-weight-bold"><?= !empty($this->lang->line('label_create_date'))?$this->lang->line('label_create_date'):'Create Date'; ?></div>
                                <p class="mt-1" id="task_details_date_created"></p>
                            </div>
                            <div class="col-md-3">
                                <div class="font-weight-bold"><?= !empty($this->lang->line('label_due_date'))?$this->lang->line('label_due_date'):'Due Date'; ?></div>
                                <p class="mt-1" id="task_details_due_date"></p>
                            </div>
                            <div class="col-md-3">
                                <div class="font-weight-bold"><?= !empty($this->lang->line('label_assign_to'))?$this->lang->line('label_assign_to'):'Assign To'; ?></div>
                                <span id="asigned_to_name"></span>
                                
                            </div>
                            <div class="col-md-3">
                                <div class="font-weight-bold"><?= !empty($this->lang->line('label_milestone'))?$this->lang->line('label_milestone'):'Milestone'; ?></div>
                                <p class="mt-1" id="task_details_milestone"> </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="card col-md-12">
                                <div class="card-body">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="comments-tab" data-toggle="tab" href="#comments" role="tab" aria-controls="comments" aria-selected="true"><?= !empty($this->lang->line('label_comments'))?$this->lang->line('label_comments'):'Comments'; ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="files-tab" data-toggle="tab" href="#files" role="tab" aria-controls="files" aria-selected="false"><?= !empty($this->lang->line('label_files'))?$this->lang->line('label_files'):'Files'; ?></a>
                                    </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="comments" role="tabpanel" aria-labelledby="comments-tab">
                                        <textarea class="form-control form-control-light mb-2" name="comment" placeholder="Write message" id="example-textarea" rows="3" required=""></textarea>
                                        <div class="card-body">
                                            <ul class="list-unstyled list-unstyled-border" id="comments_list">

                                            
                                            </ul>
                                        </div>    
                                    </div>
                                    <div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="files-tab">                  
                                        <input type="file" class="form-control mb-2" name="file" id="file">
                                        <span id="project_media_list">
                                            
                                        </span>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                
                <?php include('include-footer.php'); ?>
            </div>
        </div>

<?php include('include-js.php'); ?>
        <!-- Page Specific JS File -->
<script src="<?= base_url('assets/js/page/components-user.js'); ?>"></script>
<script src="<?= base_url('assets/js/page/tasks.js'); ?>"></script>
        
    </body>
</html>