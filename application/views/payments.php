<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Payments &mdash; <?= get_compnay_title(); ?></title>
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
            <h1><?= !empty($this->lang->line('label_payments')) ? $this->lang->line('label_payments') : 'Payments'; ?></h1>
            <div class="section-header-breadcrumb">
              <div class="btn-group mr-2 no-shadow">
                <a class="btn btn-primary text-white" href="<?= base_url('payments/payment-modes') ?>" class="btn"><i class="fas fa-list"></i> <?= !empty($this->lang->line('label_payment_modes')) ? $this->lang->line('label_payment_modes') : 'Payment Modes'; ?></a>
              </div>
              <i class="btn btn-primary btn-rounded no-shadow" id="modal-add-payment" data-value="add"><?= !empty($this->lang->line('label_add_payment')) ? $this->lang->line('label_add_payment') : 'Add Payment'; ?></i>

            </div>

          </div>
          <div class="section-body">
            <div class="row">
              <div class='col-md-12'>
                <div class="card">
                  <div class="card-body">
                    <table class='table-striped' id='payment_list' data-toggle="table" data-url="<?= base_url('payments/get_payments_list') ?>" data-click-to-select="true" data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true" data-show-columns="true" data-show-refresh="true" data-trim-on-search="false" data-sort-name="id" data-sort-order="desc" data-mobile-responsive="true" data-toolbar="" data-show-export="true" data-maintain-selected="true" data-export-types='["txt","excel"]' data-export-options='{
                      "fileName": "payments-list"
                    }' data-query-params="queryParams">
                      <thead>
                        <tr>
                          <th data-field="id" data-visible="false" data-sortable="true"><?= !empty($this->lang->line('label_id')) ? $this->lang->line('label_id') : 'ID'; ?></th>
                          <th data-field="workspace_id" data-visible="false" data-sortable="true"><?= !empty($this->lang->line('label_workspace_id')) ? $this->lang->line('label_workspace_id') : 'Workspace ID'; ?></th>
                          <th data-field="invoice_id" data-sortable="true"><?= !empty($this->lang->line('label_invoice')) ? $this->lang->line('label_invoice') : 'Invoice'; ?></th>
                          <th data-field="user_id" data-sortable="true" data-visible="false"><?= !empty($this->lang->line('label_user_id')) ? $this->lang->line('label_user_id') : 'User ID'; ?></th>
                          <th data-field="payment_mode_id" data-sortable="true" data-visible="false"><?= !empty($this->lang->line('label_payment_mode_id')) ? $this->lang->line('label_payment_mode_id') : 'Payment Mode ID'; ?></th>
                          <th data-field="user_name" data-sortable="false"><?= !empty($this->lang->line('label_user')) ? $this->lang->line('label_user') : 'User'; ?></th>
                          <th data-field="payment_mode" data-sortable="true"><?= !empty($this->lang->line('label_payment_mode')) ? $this->lang->line('label_payment_mode') : 'Payment Mode'; ?></th>
                          <th data-field="note" data-sortable="true"><?= !empty($this->lang->line('label_note')) ? $this->lang->line('label_note') : 'Note'; ?></th>
                          <th data-field="amount" data-sortable="true"><?= !empty($this->lang->line('label_amount')) ? $this->lang->line('label_amount') : 'Amount('.get_currency_symbol().')'; ?></th>
                          <th data-field="payment_date" data-sortable="false"><?= !empty($this->lang->line('label_payment_date')) ? $this->lang->line('label_payment_date') : 'Payment Date'; ?></th>
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

      <?= form_open('payments/create_payment', 'id="modal-add-payment-part"', 'class="modal-part"'); ?>

      <div class="row">
      <div class="col-md-4">
          <div class="form-group">
            <label><?= !empty($this->lang->line('label_select_user')) ? $this->lang->line('label_select_user') : 'Select User'; ?></label>
            <select class="form-control select2" name="user_id" id="user_id">
              <option value="" selected><?= !empty($this->lang->line('label_choose')) ? $this->lang->line('label_choose') : 'Choose'; ?>...</option>
              <?php foreach ($all_user as $all_users) { ?>
                <option value="<?= $all_users->id ?>"><?= $all_users->first_name ?> <?= $all_users->last_name ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label><?= !empty($this->lang->line('label_select_invoice')) ? $this->lang->line('label_select_invoice') : 'Select Invoice'; ?></label>
            <select class="form-control select2" name="invoice_id" id="invoice_id">
              <option value="" selected><?= !empty($this->lang->line('label_choose')) ? $this->lang->line('label_choose') : 'Choose'; ?>...</option>
              <?php foreach ($invoices as $invoice) { ?>
                <option value="<?= $invoice['id'] ?>"><?= "INVOC-".$invoice['id'] ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="type"><?= !empty($this->lang->line('label_payment_mode')) ? $this->lang->line('label_payment_mode') : 'Payment Mode'; ?></label><span class="asterisk"> *</span>

            <div class="input-group">
              <select class="custom-select select2" id="payment_mode_id" name="payment_mode_id">
                <option value="" selected><?= !empty($this->lang->line('label_choose')) ? $this->lang->line('label_choose') : 'Choose'; ?>...</option>
                <?php
                foreach($payment_modes as $payment_mode){?>
                  <option value="<?=$payment_mode['id']?>"><?=$payment_mode['title']?></option>
                <?php } ?>
              </select>
              <div class="wrapper" id="wrp" style="display: none;">
                <hr><a href="#" id="modal-add-payment-mode" style="text-decoration: none;">+ <?= !empty($this->lang->line('label_add_payment_mode')) ? $this->lang->line('label_add_payment_mode') : 'Add New Mode'; ?></a>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-md-4">
          <div class="form-group">
            <label for="amount"><?= !empty($this->lang->line('label_amount')) ? $this->lang->line('label_amount') : 'Amount'; ?></label><span class="asterisk"> *</span>
            <div class="input-group">
                <span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend"><span class="input-group-text"><?= get_currency_symbol(); ?></span></span>
                <input class="form-control" type="number" min="0" id="amount" name="amount" value="" placeholder="Payment Amount">
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="note"><?= !empty($this->lang->line('label_note')) ? $this->lang->line('label_note') : 'Note'; ?></label>
            <textarea type="textarea" class="form-control" placeholder="Note" name="note" id="note"></textarea>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="date"><?= !empty($this->lang->line('label_payment_date')) ? $this->lang->line('label_payment_date') : 'Payment Date'; ?></label><span class="asterisk"> *</span>
            <input class="form-control" type="datetime-local" id="payment_date" name="payment_date" value="" autocomplete="off">
          </div>
        </div>


      </div>
      </form>
      <div class="modal-edit-payment"></div>
      <?= form_open('payments/edit_payment', 'id="modal-edit-payment-part"', 'class="modal-part"'); ?>

      <div class="row">
      <div class="col-md-4">
          <div class="form-group">
            <label><?= !empty($this->lang->line('label_select_user')) ? $this->lang->line('label_select_user') : 'Select User'; ?></label>
            <select class="form-control select2" name="user_id" id="update_user_id">
              <option value="" selected><?= !empty($this->lang->line('label_choose')) ? $this->lang->line('label_choose') : 'Choose'; ?>...</option>
              <?php foreach ($all_user as $all_users) { ?>
                <option value="<?= $all_users->id ?>"><?= $all_users->first_name ?> <?= $all_users->last_name ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label><?= !empty($this->lang->line('label_select_invoice')) ? $this->lang->line('label_select_invoice') : 'Select Invoice'; ?></label>
            <select class="form-control select2" name="invoice_id" id="update_invoice_id">
              <option value="" selected><?= !empty($this->lang->line('label_choose')) ? $this->lang->line('label_choose') : 'Choose'; ?>...</option>
              <?php foreach ($invoices as $invoice) { ?>
                <option value="<?= $invoice['id'] ?>"><?= "INVOC-".$invoice['id'] ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="type"><?= !empty($this->lang->line('label_payment_mode')) ? $this->lang->line('label_payment_mode') : 'Payment Mode'; ?></label><span class="asterisk"> *</span>

            <div class="input-group">
              <select class="custom-select select2" id="update_payment_mode_id" name="payment_mode_id">
                <option value="" selected><?= !empty($this->lang->line('label_choose')) ? $this->lang->line('label_choose') : 'Choose'; ?>...</option>
                <?php
                foreach($payment_modes as $payment_mode){?>
                  <option value="<?=$payment_mode['id']?>"><?=$payment_mode['title']?></option>
                <?php } ?>
              </select>
              
            </div>
          </div>
        </div>
        
        <div class="col-md-4">
          <div class="form-group">
            <label for="amount"><?= !empty($this->lang->line('label_amount')) ? $this->lang->line('label_amount') : 'Amount'; ?></label><span class="asterisk"> *</span>
            <div class="input-group">
                <span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend"><span class="input-group-text"><?= get_currency_symbol(); ?></span></span>
                <input class="form-control" type="number" min="0" id="update_amount" name="amount" value="" placeholder="Payment Amount">
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="note"><?= !empty($this->lang->line('label_note')) ? $this->lang->line('label_note') : 'Note'; ?></label>
            <textarea type="textarea" class="form-control" placeholder="Note" name="note" id="update_note"></textarea>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="date"><?= !empty($this->lang->line('label_payment_date')) ? $this->lang->line('label_payment_date') : 'Payment Date'; ?></label><span class="asterisk"> *</span>
            <input class="form-control" type="datetime-local" id="update_payment_date" name="payment_date" value="" autocomplete="off">
          </div>
        </div>

         <input type="hidden" name="id" id="id">           
      </div>
      </form>
      <?= form_open('payments/create_payment_mode', 'id="modal-add-payment-mode-part"', 'class="modal-part"'); ?>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label><?= !empty($this->lang->line('label_title')) ? $this->lang->line('label_title') : 'Title'; ?></label><span class="asterisk"> *</span>
            <div class="input-group">
              <?= form_input(['name' => 'title', 'placeholder' => 'Title', 'class' => 'form-control', 'id' => 'title']) ?>
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
<script src="<?= base_url('assets/js/page/components-payments.js'); ?>"></script>

</html>