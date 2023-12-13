<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Expenses &mdash; <?= get_compnay_title(); ?></title>
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
            <h1><?= !empty($this->lang->line('label_expenses')) ? $this->lang->line('label_expenses') : 'Expenses'; ?></h1>
            <div class="section-header-breadcrumb">
              <div class="btn-group mr-2 no-shadow">
                <a class="btn btn-primary text-white" href="<?= base_url('expenses/expense-types') ?>" class="btn"><i class="fas fa-list"></i> <?= !empty($this->lang->line('label_expense_types')) ? $this->lang->line('label_expense_types') : 'Expense Types'; ?></a>
              </div>
              <i class="btn btn-primary btn-rounded no-shadow" id="modal-add-expense" data-value="add"><?= !empty($this->lang->line('label_add_expense')) ? $this->lang->line('label_add_expense') : 'Add Expense'; ?></i>

            </div>

          </div>
          <div class="section-body">
            <div class="row">
              <div class='col-md-12'>
                <div class="card">
                  <div class="card-body">
                    <table class='table-striped' id='expense_list' data-toggle="table" data-url="<?= base_url('expenses/get_expense_list') ?>" data-click-to-select="true" data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true" data-show-refresh="true" data-trim-on-search="false" data-sort-name="title" data-sort-order="asc" data-mobile-responsive="true" data-toolbar="" data-show-export="true" data-maintain-selected="true" data-export-types='["txt","excel"]' data-export-options='{
                      "fileName": "expense-list"
                    }' data-query-params="queryParams">
                      <thead>
                        <tr>
                          <th data-field="id" data-visible="false" data-sortable="true"><?= !empty($this->lang->line('label_id')) ? $this->lang->line('label_id') : 'ID'; ?></th>
                          <th data-field="workspace_id" data-visible="false" data-sortable="true"><?= !empty($this->lang->line('label_workspace_id')) ? $this->lang->line('label_workspace_id') : 'Workspace ID'; ?></th>

                          <th data-field="user_id" data-sortable="true" data-visible="false"><?= !empty($this->lang->line('label_user_id')) ? $this->lang->line('label_user_id') : 'User ID'; ?></th>
                          <th data-field="expense_type_id" data-sortable="true" data-visible="false"><?= !empty($this->lang->line('label_expense_type_id')) ? $this->lang->line('label_expense_type_id') : 'Expence Type ID'; ?></th>
                          <th data-field="user_name" data-sortable="true" data-visible="false"><?= !empty($this->lang->line('label_user_name')) ? $this->lang->line('label_user_name') : 'User Name'; ?></th>


                          <th data-field="title" data-sortable="true"><?= !empty($this->lang->line('label_title')) ? $this->lang->line('label_title') : 'Title'; ?></th>

                          <th data-field="expense_type" data-sortable="true"><?= !empty($this->lang->line('label_expense_type')) ? $this->lang->line('label_expense_type') : 'Expense Type'; ?></th>


                          <th data-field="note" data-sortable="false"><?= !empty($this->lang->line('label_note')) ? $this->lang->line('label_note') : 'Note'; ?></th>
                          <th data-field="amount" data-sortable="false"><?= !empty($this->lang->line('label_amount')) ? $this->lang->line('label_amount') : 'Amount('.get_currency_symbol().')'; ?></th>

                          <th data-field="expense_date" data-sortable="false"><?= !empty($this->lang->line('label_expense_date')) ? $this->lang->line('label_expense_date') : 'Expense Date'; ?></th>
                          <th data-field="created_on" data-sortable="false" data-visible="false"><?= !empty($this->lang->line('label_date_created')) ? $this->lang->line('label_date_created') : 'Date Created'; ?></th>

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

      <?= form_open('expenses/create', 'id="modal-add-expense-part"', 'class="modal-part"'); ?>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="title"><?= !empty($this->lang->line('label_title')) ? $this->lang->line('label_title') : 'Title'; ?></label><span class="asterisk"> *</span>
            <div class="input-group">
              <?= form_input(['name' => 'title', 'placeholder' => 'Title', 'class' => 'form-control']) ?>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="type"><?= !empty($this->lang->line('label_expense_type')) ? $this->lang->line('label_expense_type') : 'Expense Type'; ?></label><span class="asterisk"> *</span>

            <div class="input-group">
              <select class="custom-select select2" id="expense_type_id" name="expense_type_id">
                <option value="" selected><?= !empty($this->lang->line('label_choose')) ? $this->lang->line('label_choose') : 'Choose'; ?>...</option>
                <?php
                foreach($expense_types as $expense_type){?>
                  <option value="<?=$expense_type['id']?>"><?=$expense_type['title']?></option>
                <?php } ?>
              </select>
              <div class="wrapper" id="wrp" style="display: none;">
                <hr><a href="#" id="modal-add-expense-type" style="text-decoration: none;">+ <?= !empty($this->lang->line('label_add_new_type')) ? $this->lang->line('label_add_new_type') : 'Add New Type'; ?></a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label><?= !empty($this->lang->line('label_select_user')) ? $this->lang->line('label_select_user') : 'Select User'; ?></label><span class="asterisk"> *</span>
            <select class="form-control select2" name="user_id" id="user_id">
              <option value="" selected><?= !empty($this->lang->line('label_choose')) ? $this->lang->line('label_choose') : 'Choose'; ?>...</option>
              <?php foreach ($all_user as $all_users) { ?>
                <option value="<?= $all_users->id ?>"><?= $all_users->first_name ?> <?= $all_users->last_name ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="amount"><?= !empty($this->lang->line('label_amount')) ? $this->lang->line('label_amount') : 'Amount'; ?></label><span class="asterisk"> *</span>
            <div class="input-group">
                <span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend"><span class="input-group-text"><?= get_currency_symbol(); ?></span></span>
                <input class="form-control" type="number" min="0" id="amount" name="amount" value="" placeholder="Expense Amount">
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="note"><?= !empty($this->lang->line('label_note')) ? $this->lang->line('label_note') : 'Note'; ?></label>
            <textarea type="textarea" class="form-control" placeholder="Note" name="note" id="note"></textarea>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="date"><?= !empty($this->lang->line('label_expense_date')) ? $this->lang->line('label_expense_date') : 'Expense Date'; ?></label><span class="asterisk"> *</span>
            <input class="form-control" type="datetime-local" id="expense_date" name="expense_date" value="" autocomplete="off">
          </div>
        </div>


      </div>
      </form>
      <div class="modal-edit-expense"></div>
      <?= form_open('expenses/edit', 'id="modal-edit-expense-part"', 'class="modal-part"'); ?>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="title"><?= !empty($this->lang->line('label_title')) ? $this->lang->line('label_title') : 'Title'; ?></label><span class="asterisk"> *</span>
            <div class="input-group">
              <?= form_input(['name' => 'update_title', 'id' => 'update_title', 'placeholder' => 'Title', 'class' => 'form-control']) ?>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="type"><?= !empty($this->lang->line('label_expense_type')) ? $this->lang->line('label_expense_type') : 'Expense Type'; ?></label><span class="asterisk"> *</span>

            <div class="input-group">
              <select class="custom-select select2" id="update_expense_type_id" name="update_expense_type_id">
                <option value="" selected>Choose...</option>
                <?php
                foreach($expense_types as $expense_type){?>
                  <option value="<?=$expense_type['id']?>"><?=$expense_type['title']?></option>
                <?php } ?>
              </select>
              <div class="wrapper" id="wrp1" style="display: none;">
                <hr><a href="#" id="modal-add-expense-type" style="text-decoration: none;">+ <?= !empty($this->lang->line('label_add_new_type')) ? $this->lang->line('label_add_new_type') : 'Add New Type'; ?></a>
              </div>
              <!-- <div class="input-group-append">
                <button class="btn btn-primary" type="button">+</button>
              </div> -->
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label><?= !empty($this->lang->line('label_select_user')) ? $this->lang->line('label_select_user') : 'Select User'; ?></label><span class="asterisk"> *</span>
            <select class="form-control select2" name="update_user_id" id="update_user_id">
              <option value="" selected><?= !empty($this->lang->line('label_choose')) ? $this->lang->line('label_choose') : 'Choose'; ?>...</option>
              <?php foreach ($all_user as $all_users) { ?>
                <option value="<?= $all_users->id ?>"><?= $all_users->first_name ?> <?= $all_users->last_name ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="amount"><?= !empty($this->lang->line('label_amount')) ? $this->lang->line('label_amount') : 'Amount'; ?></label><span class="asterisk"> *</span>
            <div class="input-group">
                <span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend"><span class="input-group-text"><?= get_currency_symbol(); ?></span></span>
                <input class="form-control" type="number" min="0" id="update_amount" name="update_amount" value="" placeholder="Expense Amount">
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="note"><?= !empty($this->lang->line('label_note')) ? $this->lang->line('label_note') : 'Note'; ?></label>
            <textarea type="textarea" class="form-control" placeholder="Note" name="update_note" id="update_note"></textarea>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="date"><?= !empty($this->lang->line('label_expense_date')) ? $this->lang->line('label_expense_date') : 'Expense Date'; ?></label><span class="asterisk"> *</span>
            <input class="form-control" type="datetime-local" id="update_expense_date" name="update_expense_date" value="" autocomplete="off">
          </div>
        </div>
        <input type="hidden" name="update_id" id="update_id">


      </div>
      </form>
      <?= form_open('expenses/create_expense_type', 'id="modal-add-expense-type-part"', 'class="modal-part"'); ?>
      <input type="hidden" name="is_reload" id="is_reload" value="0">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label><?= !empty($this->lang->line('label_title')) ? $this->lang->line('label_title') : 'Title'; ?></label><span class="asterisk"> *</span>
            <div class="input-group">
              <?= form_input(['name' => 'title', 'placeholder' => 'Title', 'class' => 'form-control', 'id' => 'title']) ?>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label><?= !empty($this->lang->line('label_description')) ? $this->lang->line('label_description') : 'Description'; ?></label><span class="asterisk"> *</span>
            <div class="input-group">
              <?= form_textarea(['name' => 'description', 'placeholder' => 'Description', 'class' => 'form-control']) ?>
            </div>
          </div>
        </div>
      </div>
      </form>

      <?php include('include-footer.php'); ?>

    </div>
  </div>
  <?php include('include-js.php'); ?>
</body>
<script src="<?= base_url('assets/js/page/components-expenses.js'); ?>"></script>

</html>