<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Workspaces &mdash; <?= get_compnay_title(); ?></title>
  <?php 
    require_once(APPPATH.'views/include-css.php');
  ?>

</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">      
    <?php 
    require_once(APPPATH.'views/include-header.php');
    ?>
    
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
          <h1><?= !empty($this->lang->line('label_workspaces')) ? $this->lang->line('label_workspaces') : 'Workspaces'; ?></h1>
            <div class="section-header-breadcrumb">
              <i class="btn btn-primary btn-rounded no-shadow" id="btn-add-workspace">
                <?= !empty($this->lang->line('label_create'))?$this->lang->line('label_create'):'Create'; ?></i>
            </div>
            
          </div>
          <div class="section-body">
            <div class="row">
            <div class='col-md-12'>
              <div class="card">
                <div class="card-body">                
                  <table class='table-striped' id='item_list'
                    data-toggle="table"
                    data-url="<?=base_url('workspace/get_workspace_list')?>"
                    data-click-to-select="true"
                    data-side-pagination="server"
                    data-pagination="true"
                    data-page-list="[5, 10, 20, 50, 100, 200]"
                    data-search="true" data-show-columns="true"
                    data-show-refresh="true" data-trim-on-search="false"
                    data-sort-name="id" data-sort-order="desc"
                    data-mobile-responsive="true"
                    data-toolbar="" data-show-export="true"
                    data-maintain-selected="true"
                    data-export-types='["txt","excel"]'
                    data-export-options='{
                      "fileName": "workspace-list"
                    }'
                    data-query-params="queryParams">
                    <thead>
                      <tr>
                        <th data-field="id" data-visible="false" data-sortable="true"><?= !empty($this->lang->line('label_id'))?$this->lang->line('label_id'):'ID'; ?></th>
                        <th data-field="title" data-sortable="true"><?= !empty($this->lang->line('label_title'))?$this->lang->line('label_title'):'Title'; ?></th>
                        <th data-field="users" data-sortable="false"><?= !empty($this->lang->line('label_users'))?$this->lang->line('label_users'):'Users'; ?></th>
                        <th data-field="clients" data-sortable="false"><?= !empty($this->lang->line('label_clients'))?$this->lang->line('label_clients'):'Clients'; ?></th>
                        <th data-field="status"><?= !empty($this->lang->line('label_status'))?$this->lang->line('label_status'):'Status'; ?></th>
                        <th data-field="date_created" data-sortable="true" data-visible="false"><?= !empty($this->lang->line('label_date_created'))?$this->lang->line('label_date_created'):'Date Created'; ?></th>
                        <?php if($this->ion_auth->is_admin()){ ?>
                        <th data-field="action" data-sortable="false"><?= !empty($this->lang->line('label_action'))?$this->lang->line('label_action'):'Action'; ?></th>
                        <?php } ?>                        
                      </tr>
                    </thead>
                  </table>
                </div>
            </div>
          </div>
            </div>
            <div class="modal-workspace-users"></div>    
            <div class="row" id="modal-workspace-users-part">
              <div class='col-md-12'>
                <div class="card">
                  <div class="card-body">
                    <input type="hidden" name="workspace_id" id="workspace_id">     
                    <table class='table-striped' id='users_list' data-toggle="table" data-url="<?= base_url('users/get_users_list') ?>" data-click-to-select="true" data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true" data-show-refresh="true" data-trim-on-search="false" data-sort-name="first_name" data-sort-order="asc" data-mobile-responsive="true" data-toolbar="" data-show-export="true" data-maintain-selected="true" data-export-types='["txt","excel"]' data-export-options='{
                      "fileName": "users-list",
                      "ignoreColumn": ["state"] 
                    }' data-query-params="queryParams">
                      <thead>
                        <tr>
                          <th data-field="id" data-visible="false" data-sortable="true"><?= !empty($this->lang->line('label_id')) ? $this->lang->line('label_id') : 'ID'; ?></th>

                          <th data-field="first_name" data-sortable="true"><?= !empty($this->lang->line('label_users')) ? $this->lang->line('label_users') : 'Users'; ?></th>

                          <th data-field="role" data-sortable="false"><?= !empty($this->lang->line('label_role')) ? $this->lang->line('label_role') : 'Role'; ?></th>
                          <th data-field="assigned" data-sortable="false"><?= !empty($this->lang->line('label_assigned')) ? $this->lang->line('label_assigned') : 'Assigned'; ?></th>
                          <?php if ($this->ion_auth->is_admin()) { ?>
                            <th data-field="active" data-sortable="false"><?= !empty($this->lang->line('label_status')) ? $this->lang->line('label_status') : 'Status'; ?></th>
                          <?php } ?>

                          <?php if ($this->ion_auth->is_admin()) { ?>
                            <th data-field="action" data-sortable="false"><?= !empty($this->lang->line('label_action')) ? $this->lang->line('label_action') : 'Action'; ?></th>
                          <?php } ?>

                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-workspace-clients"></div>
            <div class="row" id="modal-workspace-clients-part">
              <div class='col-md-12'>
                <div class="card">
                  <div class="card-body">
                  <input type="hidden" name="clients_workspace_id" id="clients_workspace_id">
                    <table class='table-striped' id='clients_list' data-toggle="table" data-url="<?= base_url('clients/get_users_list') ?>" data-click-to-select="true" data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true" data-show-refresh="true" data-trim-on-search="false" data-sort-name="first_name" data-sort-order="asc" data-mobile-responsive="true" data-toolbar="" data-show-export="true" data-maintain-selected="true" data-export-types='["txt","excel"]' data-export-options='{
                      "fileName": "clients-list",
                      "ignoreColumn": ["state"] 
                    }' data-query-params="queryParams1">
                      <thead>
                        <tr>
                          <th data-field="id" data-visible="false" data-sortable="true"><?= !empty($this->lang->line('label_id')) ? $this->lang->line('label_id') : 'ID'; ?></th>

                          <th data-field="first_name" data-sortable="true"><?= !empty($this->lang->line('label_clients')) ? $this->lang->line('label_clients') : 'Clients'; ?></th>

                          <th data-field="company" data-sortable="true"><?= !empty($this->lang->line('label_company')) ? $this->lang->line('label_company') : 'Company'; ?></th>

                          <th data-field="phone" data-visible="false" data-sortable="true"><?= !empty($this->lang->line('label_phone')) ? $this->lang->line('label_phone') : 'Phone'; ?></th>

                          <th data-field="assigned" data-sortable="false"><?= !empty($this->lang->line('label_assigned')) ? $this->lang->line('label_assigned') : 'Assigned'; ?></th>
                          <?php if ($this->ion_auth->is_admin()) { ?>
                            <th data-field="active" data-sortable="false"><?= !empty($this->lang->line('label_status')) ? $this->lang->line('label_status') : 'Status'; ?></th>
                          <?php } ?>
                          <?php if ($this->ion_auth->is_admin()) { ?>
                            <th data-field="action" data-sortable="false"><?= !empty($this->lang->line('label_action')) ? $this->lang->line('label_action') : 'Action'; ?></th>
                          <?php } ?>
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
      <?php 
      require_once(APPPATH.'views/include-footer.php');
      ?>
    </div>
  </div>
<?php 
require_once(APPPATH.'views/include-js.php');
?>
  
<!-- Page Specific JS File -->
<script src="<?= base_url('assets/js/page/components-workspace.js'); ?>"></script>
  
</body>
</html>