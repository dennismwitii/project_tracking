<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Expense Types &mdash; <?= get_compnay_title(); ?></title>
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
          <h1><?= !empty($this->lang->line('label_expense_types')) ? $this->lang->line('label_expense_types') : 'Expense Types'; ?></h1>
            <div class="section-header-breadcrumb">
            <div class="btn-group mr-2 no-shadow">
                <a class="btn btn-primary text-white" href="<?= base_url('expenses') ?>" class="btn"><i class="fas fa-list"></i> <?= !empty($this->lang->line('label_expenses')) ? $this->lang->line('label_expenses') : 'Expenses'; ?></a>
              </div>
              <i class="btn btn-primary btn-rounded no-shadow" id="modal-add-expense-type">
                <?= !empty($this->lang->line('label_add_expense_type'))?$this->lang->line('label_add_expense_type'):'Add Expense Type'; ?></i>
            </div>
            
          </div>
          <div class="section-body">
            <div class="row">
            <div class='col-md-12'>
              <div class="card">
                <div class="card-body">                
                  <table class='table-striped' id='expense_type_list'
                    data-toggle="table"
                    data-url="<?=base_url('expenses/get_expense_type_list')?>"
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
                      "fileName": "expense-type-list"
                    }'
                    data-query-params="queryParams">
                    <thead>
                      <tr>
                        <th data-field="id" data-visible="false" data-sortable="true"><?= !empty($this->lang->line('label_id'))?$this->lang->line('label_id'):'ID'; ?></th>
                        <th data-field="title" data-sortable="true"><?= !empty($this->lang->line('label_title'))?$this->lang->line('label_title'):'Title'; ?></th>
                        <th data-field="description" data-sortable="false"><?= !empty($this->lang->line('label_description'))?$this->lang->line('label_description'):'Description'; ?></th>
                        <th data-field="created_on" data-sortable="false"><?= !empty($this->lang->line('label_date_created')) ? $this->lang->line('label_date_created') : 'Date Created'; ?></th>
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
        
        <div class="modal-edit-expense-type"></div>       
        <?= form_open('expenses/edit_expense_type', 'id="modal-edit-expense-type-part"', 'class="modal-part"'); ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                      <label><?= !empty($this->lang->line('label_title'))?$this->lang->line('label_title'):'Title'; ?></label><span class="asterisk"> *</span>
                      <div class="input-group">
                        
                        <?=form_input(['name'=>'update_title','placeholder'=>'Title','class'=>'form-control', 'id'=>'update_title'])?>
                      </div>
                    </div>
                </div>                
                <div class="col-md-6">
                  <div class="form-group">
                    <label><?= !empty($this->lang->line('label_description'))?$this->lang->line('label_description'):'Description'; ?></label><span class="asterisk"> *</span>
                    <div class="input-group">
                      <?=form_textarea(['name'=>'update_description','placeholder'=>'Description','class'=>'form-control', 'id'=>'update_description'])?>
                    </div>
                  </div>
                </div>
                <input type="hidden" name="update_id" id="update_id">
            </div>
        </form>
        <?= form_open('expenses/create_expense_type', 'id="modal-add-expense-type-part"', 'class="modal-part"'); ?>
        <input type="hidden" name="is_reload" id="is_reload" value="1">
            <div class="row">
                <div class="col-md-6" id="title">
                    <div class="form-group">
                      <label><?= !empty($this->lang->line('label_title'))?$this->lang->line('label_title'):'Title'; ?></label><span class="asterisk"> *</span>
                      <div class="input-group">
                        <?=form_input(['name'=>'title','placeholder'=>'Title','class'=>'form-control'])?>
                      </div>
                    </div>
                </div>
                
                <div class="col-md-6" id="description">
                  <div class="form-group">
                    <label><?= !empty($this->lang->line('label_description'))?$this->lang->line('label_description'):'Description'; ?></label><span class="asterisk"> *</span>
                    <div class="input-group">
                      <?=form_textarea(['name'=>'description','placeholder'=>'Description','class'=>'form-control'])?>
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
</body>
<script src="<?= base_url('assets/js/page/components-expense-types.js'); ?>"></script>
</html>