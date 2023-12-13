<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Items &mdash; <?= get_compnay_title(); ?></title>
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
          <h1><?= !empty($this->lang->line('label_items')) ? $this->lang->line('label_items') : 'Items'; ?></h1>
            <div class="section-header-breadcrumb">
              <i class="btn btn-primary btn-rounded no-shadow" id="modal-add-item">
                <?= !empty($this->lang->line('label_add_item'))?$this->lang->line('label_add_item'):'Add Item'; ?></i>
            </div>
            
          </div>
          <div class="section-body">
            <div class="row">
            <div class='col-md-12'>
              <div class="card">
                <div class="card-body">                
                  <table class='table-striped' id='item_list'
                    data-toggle="table"
                    data-url="<?=base_url('items/get_item_list')?>"
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
                      "fileName": "item-list"
                    }'
                    data-query-params="queryParams">
                    <thead>
                      <tr>
                        <th data-field="id" data-visible="false" data-sortable="true"><?= !empty($this->lang->line('label_id'))?$this->lang->line('label_id'):'ID'; ?></th>
                        <th data-field="workspace_id" data-visible="false" data-sortable="true"><?= !empty($this->lang->line('label_workspace_id')) ? $this->lang->line('label_workspace_id') : 'Workspace ID'; ?></th>
                        <th data-field="unit_id" data-visible="false" data-sortable="true"><?= !empty($this->lang->line('label_unit_id')) ? $this->lang->line('label_unit_id') : 'Unit ID'; ?></th>
                        <th data-field="title" data-sortable="true"><?= !empty($this->lang->line('label_title'))?$this->lang->line('label_title'):'Title'; ?></th>
                        <th data-field="description" data-sortable="true"><?= !empty($this->lang->line('label_description'))?$this->lang->line('label_description'):'Description'; ?></th>
                        <th data-field="price" data-sortable="true"><?= !empty($this->lang->line('label_price'))?$this->lang->line('label_price'):'Price('.get_currency_symbol().')'; ?></th>
                        <th data-field="unit" data-sortable="true"><?= !empty($this->lang->line('label_unit'))?$this->lang->line('label_unit'):'Unit'; ?></th>
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
        <?= form_open('items/create', 'id="modal-add-item-part"', 'class="modal-part"'); ?>
        <input type="hidden" name="is_reload" id="is_reload" value="1">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                      <label><?= !empty($this->lang->line('label_title'))?$this->lang->line('label_title'):'Title'; ?></label><span class="asterisk"> *</span>
                      <div class="input-group">
                        <?=form_input(['name'=>'title','placeholder'=>'Title','class'=>'form-control'])?>
                      </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                  <div class="form-group">
                    <label><?= !empty($this->lang->line('label_description'))?$this->lang->line('label_description'):'Description'; ?>
                    <div class="input-group">
                      <?=form_textarea(['name'=>'description','placeholder'=>'Description','class'=>'form-control'])?>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                      <label><?= !empty($this->lang->line('label_unit'))?$this->lang->line('label_unit'):'Unit'; ?></label>
                      <select class="form-control" name="unit">
                        <option value="">N/A</option>
                        <?php
                        foreach ($units as $unit){ ?>
                          <option value="<?=$unit['id']?>"><?=$unit['title']?></option>
                        <?php }?>
                      </select>
                    </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label><?= !empty($this->lang->line('label_price'))?$this->lang->line('label_price'):'Price'; ?></label><span class="asterisk"> *</span>
                    <div class="input-group">
                      <?=form_input(['type'=>'number','name'=>'price','placeholder'=>'Price','class'=>'form-control'])?>
                    </div>
                  </div>
                </div>   
            </div>
        </form>
        <div class="modal-edit-item"></div>        
        <?= form_open('items/edit', 'id="modal-edit-item-part"', 'class="modal-part"'); ?>
        <input name="update_id" type="hidden" id="update_id" value="">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                      <label><?= !empty($this->lang->line('label_title'))?$this->lang->line('label_title'):'Title'; ?></label><span class="asterisk"> *</span>
                      <div class="input-group">
                        <?=form_input(['name'=>'title','placeholder'=>'Title','class'=>'form-control', 'id'=>'update_title'])?>
                      </div>
                    </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label><?= !empty($this->lang->line('label_description'))?$this->lang->line('label_description'):'Description'; ?>
                    <div class="input-group">
                      <?=form_textarea(['name'=>'description','placeholder'=>'Description','class'=>'form-control', 'id'=>'update_description'])?>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                      <label><?= !empty($this->lang->line('label_unit'))?$this->lang->line('label_unit'):'Unit'; ?></label>
                      <select class="form-control" name="unit" id="update_unit">
                        <option value="">N/A</option>
                        <?php
                        foreach ($units as $unit){ ?>
                          <option value="<?=$unit['id']?>"><?=$unit['title']?></option>
                        <?php }?>
                      </select>
                    </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label><?= !empty($this->lang->line('label_price'))?$this->lang->line('label_price'):'Price'; ?></label><span class="asterisk"> *</span>
                    <div class="input-group">
                    <?=form_input(['type'=>'number','id'=>'update_price','name'=>'price','placeholder'=>'Price','class'=>'form-control'])?>
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
<script src="assets/js/page/components-items.js"></script>
  
</body>
</html>