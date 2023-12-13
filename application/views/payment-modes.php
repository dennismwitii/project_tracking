<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Payment Modes &mdash; <?= get_compnay_title(); ?></title>
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
            <h1><?= !empty($this->lang->line('label_payment_modes')) ? $this->lang->line('label_payment_modes') : 'Payment Modes'; ?></h1>
            <div class="section-header-breadcrumb">
              <div class="btn-group mr-2 no-shadow">
                <a class="btn btn-primary text-white" href="<?= base_url('payments') ?>" class="btn"><i class="fas fa-list"></i> <?= !empty($this->lang->line('label_payments')) ? $this->lang->line('label_payments') : 'Payments'; ?></a>
              </div>
              <i class="btn btn-primary btn-rounded no-shadow" id="modal-add-payment-mode" data-value="add"><?= !empty($this->lang->line('label_add_payment_mode')) ? $this->lang->line('label_add_payment_mode') : 'Add Payment Mode'; ?></i>

            </div>

          </div>
          <div class="section-body">
            <div class="row">
            <div class='col-md-12'>
              <div class="card">
                <div class="card-body">                
                  <table class='table-striped' id='payment_mode_list'
                    data-toggle="table"
                    data-url="<?=base_url('payments/get_payment_mode_list')?>"
                    data-click-to-select="true"
                    data-side-pagination="server"
                    data-pagination="true"
                    data-page-list="[5, 10, 20, 50, 100, 200]"
                    data-search="true" data-show-columns="true"
                    data-show-refresh="true" data-trim-on-search="false"
                    data-sort-name="title" data-sort-order="asc"
                    data-mobile-responsive="true"
                    data-toolbar="" data-show-export="true"
                    data-maintain-selected="true"
                    data-export-types='["txt","excel"]'
                    data-export-options='{
                      "fileName": "Payment-Mode-list"
                    }'
                    data-query-params="queryParams">
                    <thead>
                      <tr>
                        <th data-field="id" data-visible="false" data-sortable="true"><?= !empty($this->lang->line('label_id'))?$this->lang->line('label_id'):'ID'; ?></th>
                        <th data-field="title" data-sortable="true"><?= !empty($this->lang->line('label_title'))?$this->lang->line('label_title'):'Title'; ?></th>
                        <th data-field="created_on" data-sortable="true" data-visible="false"><?= !empty($this->lang->line('label_date_created'))?$this->lang->line('label_date_created'):'Date Created'; ?></th>
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
          </div>
        </section>
      </div>
        <?= form_open('payments/create_payment_mode', 'id="modal-add-payment-mode-part"', 'class="modal-part"'); ?>
            <div class="row">
                <div class="col-md-12" id="title">
                    <div class="form-group">
                      <label><?= !empty($this->lang->line('label_title'))?$this->lang->line('label_title'):'Title'; ?></label><span class="asterisk"> *</span>
                      <div class="input-group">
                        <?=form_input(['name'=>'title','placeholder'=>'Title','class'=>'form-control'])?>
                      </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="modal-edit-payment-mode"></div>
        <?= form_open('payments/edit_payment_mode', 'id="modal-edit-payment-mode-part"', 'class="modal-part"'); ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                      <label><?= !empty($this->lang->line('label_title'))?$this->lang->line('label_title'):'Title'; ?></label><span class="asterisk"> *</span>
                      <div class="input-group">
                        <input name="update_id" type="hidden" id="update_id" value="">
                        <?=form_input(['name'=>'title','placeholder'=>'Title','class'=>'form-control', 'id'=>'update_title'])?>
                      </div>
                    </div>
                </div>
            </div>
        </form>
      <?php 
      require_once(APPPATH.'views/include-footer.php');
      ?>
    </div>
  </div>

<?php 
require_once(APPPATH.'views/include-js.php');
?>
  
<!-- Page Specific JS File -->

<script src="<?=base_url('assets/js/page/components-payments.js');?>"></script>
  
</body>
</html>