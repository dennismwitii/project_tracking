<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Activity Log &mdash; <?= get_compnay_title(); ?></title>
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
                        <h1><?= !empty($this->lang->line('label_activity_logs')) ? $this->lang->line('label_activity_logs') : 'Activity Log'; ?></h1>
                    </div>
                    <div class="section-body">
                        <div class="row">
                            <div class='col-md-12'>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <!-- <label>Default Select</label> -->
                                                <select id="activity_type" name="activity_type" class="form-control">
                                                    <option value="">Select Type</option>
                                                    <option value="Project">Project</option>
                                                    <option value="Project File">Project File</option>
                                                    <option value="Project Milestone">Project Milestone</option>
                                                    <option value="Task">Task</option>
                                                    <option value="Comment">Comment</option>
                                                    <option value="Task Status">Task Status</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <!-- <label>Default Select</label> -->
                                                <select id="activity" name="activity" class="form-control">
                                                    <option value="">Select Activity</option>
                                                    <option value="Created">Created</option>
                                                    <option value="Updated">Updated</option>
                                                    <option value="Deleted">Deleted</option>
                                                    <option value="Uploaded">Uploaded</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <i class="btn btn-primary btn-rounded no-shadow" id="filter-activity">Filter</i>
                                            </div>
                                        </div>
                                        <table class='table-striped' id='activity_log_list' data-toggle="table" data-url="<?= base_url('activity_logs/get_activity_logs_list') ?>" data-click-to-select="true" data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true" data-show-refresh="true" data-trim-on-search="false" data-sort-name="id" data-sort-order="desc" data-mobile-responsive="true" data-toolbar="" data-show-export="true" data-maintain-selected="true" data-export-types='["txt","excel"]' 
                                        data-export-options='{
                                            "fileName": "activity-list",
                                            "ignoreColumn": ["state"] 
                                            }' 
                                        data-query-params="queryParams">
                                            <thead>
                                                <tr>
                                                    <th data-field="id" data-sortable="true" data-visible="false"><?= !empty($this->lang->line('label_id')) ? $this->lang->line('label_id') : 'ID'; ?></th>
                                                    <th data-field="workspace_id" data-sortable="true" data-visible="false"><?= !empty($this->lang->line('label_workspace_id')) ? $this->lang->line('label_workspace_id') : 'Workspace ID'; ?></th>
                                                    <th data-field="user_id" data-sortable="true" data-visible="false"><?= !empty($this->lang->line('label_user_id')) ? $this->lang->line('label_user_id') : 'User ID'; ?></th>
                                                    <th data-field="user_name" data-sortable="true" data-visible="true"><?= !empty($this->lang->line('label_user_name')) ? $this->lang->line('label_user_name') : 'User Name'; ?></th>
                                                    <th data-field="activity" data-sortable="true"><?= !empty($this->lang->line('label_activity')) ? $this->lang->line('label_activity') : 'Activity'; ?></th>
                                                    <th data-field="type" data-sortable="true"><?= !empty($this->lang->line('label_type')) ? $this->lang->line('label_type') : 'Type'; ?></th>
                                                    <th data-field="project_id" data-sortable="true" data-visible="false"><?= !empty($this->lang->line('label_project_id')) ? $this->lang->line('label_project_id') : 'Project ID'; ?></th>
                                                    <th data-field="project_title" data-sortable="true" data-visible="true"><?= !empty($this->lang->line('label_project_title')) ? $this->lang->line('label_project_title') : 'Project'; ?></th>
                                                    <th data-field="task_id" data-sortable="true" data-visible="false"><?= !empty($this->lang->line('label_task_id')) ? $this->lang->line('label_task_id') : 'Task ID'; ?></th>
                                                    <th data-field="task_title" data-sortable="true" data-visible="true"><?= !empty($this->lang->line('label_task_title')) ? $this->lang->line('label_task_title') : 'Task'; ?></th>
                                                    <th data-field="comment_id" data-sortable="true" data-visible="false"><?= !empty($this->lang->line('label_comment_id')) ? $this->lang->line('label_comment_id') : 'Comment ID'; ?></th>
                                                    <th data-field="comment" data-sortable="true" data-visible="true"><?= !empty($this->lang->line('label_comment')) ? $this->lang->line('label_comment') : 'Comment'; ?></th>
                                                    <th data-field="file_id" data-sortable="true" data-visible="false"><?= !empty($this->lang->line('label_file_id')) ? $this->lang->line('label_file_id') : 'File ID'; ?></th>
                                                    <th data-field="file_name" data-sortable="true" data-visible="true"><?= !empty($this->lang->line('label_file')) ? $this->lang->line('label_file') : 'File'; ?></th>
                                                    <th data-field="milestone_id" data-sortable="true" data-visible="false"><?= !empty($this->lang->line('label_milestone_id')) ? $this->lang->line('label_milestone_id') : 'Milestone ID'; ?></th>
                                                    <th data-field="milestone" data-sortable="true" data-visible="true"><?= !empty($this->lang->line('label_milestone')) ? $this->lang->line('label_milestone') : 'Milestone'; ?></th>
                                                    <th data-field="date_created" data-sortable="true"><?= !empty($this->lang->line('label_date_created')) ? $this->lang->line('label_date_created') : 'Date Time'; ?></th>
                                                    <th data-field="action" data-sortable="false"><?= !empty($this->lang->line('label_action')) ? $this->lang->line('label_action') : 'Action'; ?></th>
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
            <?php include('include-footer.php'); ?>
        </div>
    </div>
    <?php include('include-js.php'); ?>
    <!-- Page Specific JS File -->
    <script src="<?= base_url('assets/js/page/components-activity.js'); ?>"></script>
</body>
</html>