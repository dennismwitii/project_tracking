<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Announcements &mdash; <?= get_compnay_title(); ?></title>
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
                        <h1><?= !empty($this->lang->line('label_announcements')) ? $this->lang->line('label_announcements') : 'Announcements'; ?></h1>
                        <?php
                        if (is_admin()) { ?>
                            <div class="section-header-breadcrumb">
                                <i class="btn btn-primary btn-rounded no-shadow" id="modal-add-announcement"><?= !empty($this->lang->line('label_create_announcement')) ? $this->lang->line('label_create_announcement') : 'Create Announcement'; ?></i>
                            </div>
                        <?php } ?>
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
                                                    <option value="">All</option>
                                                    <option value="pinned"><?= !empty($this->lang->line('label_pinned_announcement')) ? $this->lang->line('label_pinned_announcement') : 'Pinned'; ?></option>
                                                    <option value="unpinned"><?= !empty($this->lang->line('label_unpinned_announcement')) ? $this->lang->line('label_unpinned_announcement') : 'Un-Pinned'; ?></option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <i class="btn btn-primary btn-rounded no-shadow" id="filter"><?= !empty($this->lang->line('label_filter')) ? $this->lang->line('label_filter') : 'Filter'; ?></i>
                                            </div>
                                        </div>
                                        <table class='table-striped' id='announcements_list' data-toggle="table"
                                            data-url="<?= base_url('announcements/get_announcements_list') ?>"
                                            data-click-to-select="true"
                                            data-side-pagination="server" data-pagination="true"
                                            data-page-list="[5, 10, 20, 50, 100, 200]"
                                            data-search="true" data-show-columns="true"
                                            data-show-refresh="true" data-trim-on-search="false"
                                            data-sort-name="id" data-sort-order="desc"
                                            data-mobile-responsive="false" data-toolbar="" 
                                            data-show-export="true" data-maintain-selected="true"
                                            data-export-types='["txt","excel"]' data-export-options='{
                                                "fileName": "announcements-list",
                                                "ignoreColumn": ["state"]
                                            }'
                                            data-query-params="queryParams">
                                            <thead>
                                                <tr>
                                                    <th data-field="id" data-sortable="true" data-visible="false"><?= !empty($this->lang->line('label_id')) ? $this->lang->line('label_id') : 'ID'; ?></th>
                                                    <th data-field="workspace_id" data-sortable="true" data-visible="false"><?= !empty($this->lang->line('label_workspace_id')) ? $this->lang->line('label_workspace_id') : 'Workspace ID'; ?></th>
                                                    <th data-field="user_id" data-sortable="true" data-visible="false"><?= !empty($this->lang->line('label_user_id')) ? $this->lang->line('label_user_id') : 'User ID'; ?></th>
                                                    <th data-field="user_name" data-sortable="true" data-visible="false"><?= !empty($this->lang->line('label_user_name')) ? $this->lang->line('label_user_name') : 'User Name'; ?></th>
                                                    <th data-field="announcement" data-sortable="false"><?= !empty($this->lang->line('label_announcement')) ? $this->lang->line('label_announcement') : 'Announcement'; ?></th>
                                                    <th data-field="title" data-sortable="true" data-visible="false"><?= !empty($this->lang->line('label_title')) ? $this->lang->line('label_title') : 'Title'; ?></th>
                                                    <th data-field="description" data-sortable="true" data-visible="false"><?= !empty($this->lang->line('label_description')) ? $this->lang->line('label_description') : 'Description'; ?></th>
                                                    <th data-field="date_created" data-sortable="true" data-visible="false"><?= !empty($this->lang->line('label_date_created')) ? $this->lang->line('label_event_date_created') : 'Date Created'; ?></th>
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
            <form action="<?= base_url('announcements/create'); ?>" method="post" class="modal-part" id="modal-add-announcement-part">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><?= !empty($this->lang->line('label_title')) ? $this->lang->line('label_title') : 'Title'; ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="title" name="title">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><?= !empty($this->lang->line('label_description')) ? $this->lang->line('label_description') : 'Description'; ?></label>
                            <div class="input-group">
                                <textarea type="textarea" class="form-control" placeholder="description" name="description" id="description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="alert-message"></div>
            </form>
            <div class="modal-edit-announcement"></div>
            <form action="<?= base_url('announcements/edit'); ?>" method="post" class="modal-part" id="modal-edit-announcement-part">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><?= !empty($this->lang->line('label_title')) ? $this->lang->line('label_title') : 'Title'; ?></label>
                            <div class="input-group">
                                <input type="hidden" name="update_id" id="update_announcement_id">
                                <input type="text" class="form-control" placeholder="title" name="title" id="update_announcement_title">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><?= !empty($this->lang->line('label_description')) ? $this->lang->line('label_description') : 'Description'; ?></label>
                            <div class="input-group">
                                <textarea type="textarea" class="form-control" placeholder="description" name="description" id="update_announcement_description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="alert-message"></div>
            </form>
            <?php include('include-footer.php'); ?>
        </div>
    </div>
    <?php include('include-js.php'); ?>
    <script src="<?= base_url('assets/js/page/components-announcements.js'); ?>"></script>
    <!-- Page Specific JS File -->
</body>

</html>