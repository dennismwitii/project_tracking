<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Notifications &mdash; <?= get_compnay_title(); ?></title>
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
                        <h1><?= !empty($this->lang->line('label_notifications')) ? $this->lang->line('label_notifications') : 'Notifications'; ?></h1>
                        <div class="section-header-breadcrumb">
                        </div>
                    </div>
                    <div class="section-body">
                        <div class="row">
                            <div class='col-md-12'>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <!-- <label>Default Select</label> -->
                                                <select id="type" name="type" class="form-control">
                                                    <option value="">Select Type</option>
                                                    <option value="project"><?= !empty($this->lang->line('label_projects')) ? $this->lang->line('label_projects') : 'Projects'; ?></option>
                                                    <option value="task"><?= !empty($this->lang->line('label_tasks')) ? $this->lang->line('label_tasks') : 'Tasks'; ?></option>
                                                    <option value="event"><?= !empty($this->lang->line('label_events')) ? $this->lang->line('label_events') : 'Events'; ?></option>
                                                    <option value="announcement"><?= !empty($this->lang->line('label_announcements')) ? $this->lang->line('label_announcements') : 'Announcements'; ?></option>
                                                </select>
                                            </div>
                                            <?php if (is_admin()) { ?>
                                                <div class="form-group col-md-3">
                                                    <!-- <label>Default Select</label> -->
                                                    <select id="user_type" name="user_type" class="form-control">
                                                        <option value=""><?= !empty($this->lang->line('label_all')) ? $this->lang->line('label_all') : 'All'; ?> <?= !empty($this->lang->line('label_notifications')) ? $this->lang->line('label_notifications') : 'Notifications'; ?></option>
                                                        <option value="1">My <?= !empty($this->lang->line('label_notifications')) ? $this->lang->line('label_notifications') : 'Notifications'; ?></option>
                                                    </select>
                                                </div>
                                            <?php } ?>
                                            <div class="form-group col-md-2">
                                                <i class="btn btn-primary btn-rounded no-shadow" id="filter-type"><?= !empty($this->lang->line('label_filter')) ? $this->lang->line('label_filter') : 'Filter'; ?></i>
                                            </div>
                                        </div>
                                        <table class='table-striped' id='notifications_list' data-toggle="table" data-url="<?= base_url('notifications/get_notifications_list') ?>" data-click-to-select="true" data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true" data-show-refresh="true" data-trim-on-search="false" data-sort-name="id" data-sort-order="desc" data-mobile-responsive="true" data-toolbar="" data-show-export="true" data-maintain-selected="true" data-export-types='["txt","excel"]' data-export-options='{
                                                "fileName": "notifications-list",
                                                "ignoreColumn": ["state"] 
                                                }' data-query-params="queryParams">
                                            <thead>
                                                <tr>
                                                    <th data-field="id" data-sortable="true" data-visible="false"><?= !empty($this->lang->line('label_id')) ? $this->lang->line('label_id') : 'ID'; ?></th>
                                                    <th data-field="notification" data-sortable="true" data-visible="true"><?= !empty($this->lang->line('label_notification')) ? $this->lang->line('label_notification') : 'Notification'; ?></th>
                                                    <th data-field="date_created" data-sortable="true"><?= !empty($this->lang->line('label_date_created')) ? $this->lang->line('label_date_created') : 'Date'; ?></th>
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
    <script src="<?= base_url('assets/js/page/components-notifications.js'); ?>"></script>
</body>

</html>