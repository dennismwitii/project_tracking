<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Estimates &mdash; <?= get_compnay_title(); ?></title>
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
            <h1><?= !empty($this->lang->line('label_estimates')) ? $this->lang->line('label_estimates') : 'Estimates'; ?></h1>
            <div class="section-header-breadcrumb">
            <div class="btn-group mr-2 no-shadow">
                <a class="btn btn-primary text-white" href="<?= base_url('estimates/create-estimate') ?>" class="btn"><i class="fas fa-plus"></i> <?= !empty($this->lang->line('label_add_estimate')) ? $this->lang->line('label_add_estimate') : 'Create Estimate'; ?></a>
              </div>

            </div>

          </div>
          <div class="section-body">
          <div class="row">
              <div class="col-12">
                <div class="card mb-0">
                  <div class="card-body">
                    <ul class="nav nav-pills">
                      <li class="nav-item">
                        <a class="nav-link active" data-id=""><?= !empty($this->lang->line('label_all')) ? $this->lang->line('label_all') : 'All'; ?> <span class="badge badge-white"><?=$total?></span></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" data-id="2"><?= !empty($this->lang->line('label_accepted')) ? $this->lang->line('label_accepted') : 'Accepted'; ?> <span class="badge badge-primary"><?=$accepted?></span></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" data-id="1"><?= !empty($this->lang->line('label_sent')) ? $this->lang->line('label_sent') : 'Sent'; ?> <span class="badge badge-primary"><?=$sent?></span></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" data-id="3"><?= !empty($this->lang->line('label_draft')) ? $this->lang->line('label_draft') : 'Draft'; ?> <span class="badge badge-primary"><?=$draft?></span></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" data-id="4"><?= !empty($this->lang->line('label_declined')) ? $this->lang->line('label_declined') : 'Declined'; ?> <span class="badge badge-primary"><?=$declined?></span></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" data-id="5"><?= !empty($this->lang->line('label_expired')) ? $this->lang->line('label_expired') : 'Expired'; ?> <span class="badge badge-primary"><?=$expired?></span></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" data-id="0"><?= !empty($this->lang->line('label_n_a')) ? $this->lang->line('label_n_a') : 'N/A'; ?> <span class="badge badge-primary"><?=$not_assigned?></span></a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <input type="hidden" name="status" id="status">
            <div class="section-body">
            <div class="row">
              <div class='col-md-12'>
                <div class="card">
                  <div class="card-body">
                    <table class='table-striped' id='estimate_list' data-toggle="table" data-url="<?= base_url('estimates/get_estimates_list') ?>" data-click-to-select="true" data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true" data-show-refresh="true" data-trim-on-search="false" data-sort-name="id" data-sort-order="desc" data-mobile-responsive="true" data-toolbar="" data-show-export="true" data-maintain-selected="true" data-export-types='["txt","excel"]' data-export-options='{
                      "fileName": "estimate-list"
                    }' data-query-params="queryParams">
                      <thead>
                        <tr>
                          <th data-field="id" data-sortable="true"><?= !empty($this->lang->line('label_estimate')) ? $this->lang->line('label_estimate') : 'Estimate'; ?></th>
                          <th data-field="workspace_id" data-visible="false" data-sortable="true"><?= !empty($this->lang->line('label_workspace_id')) ? $this->lang->line('label_workspace_id') : 'Workspace ID'; ?></th>
                          <th data-field="name" data-sortable="true"><?= !empty($this->lang->line('label_client')) ? $this->lang->line('label_client') : 'Client'; ?></th>

                          <th data-field="amount" data-sortable="true"><?= !empty($this->lang->line('label_amount')) ? $this->lang->line('label_amount') : 'Amount('.get_currency_symbol().')';?></th>
                          <th data-field="estimate_date" data-sortable="true"><?= !empty($this->lang->line('label_from_date')) ? $this->lang->line('label_from_date') : 'From Date'; ?></th>
                          <th data-field="valid_upto_date" data-sortable="true"><?= !empty($this->lang->line('label_due_date')) ? $this->lang->line('label_due_date') : 'Due Date'; ?></th>

                          <th data-field="created_on" data-sortable="false" data-visible="false"><?= !empty($this->lang->line('label_date_created')) ? $this->lang->line('label_date_created') : 'Date Created'; ?></th>
                          <th data-field="status" data-sortable="true"><?= !empty($this->lang->line('label_status')) ? $this->lang->line('label_status') : 'Status'; ?></th>

                        </tr>
                      </thead>
                    </table>
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
<script src="<?= base_url('assets/js/page/components-estimate.js'); ?>"></script>

</html>