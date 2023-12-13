<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Edit Invoice &mdash; <?= get_compnay_title(); ?></title>
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
                        <h1><?= !empty($this->lang->line('label_edit_invoice')) ? $this->lang->line('label_edit_invoice') : 'Edit Invoice'; ?></h1>
                        <div class="section-header-breadcrumb">
                            <div class="btn-group mr-2 no-shadow">
                                <a class="btn btn-primary text-white" href="<?= base_url('invoices') ?>" class="btn"><i class="fas fa-list"></i> <?= !empty($this->lang->line('label_invoices')) ? $this->lang->line('label_invoices') : 'Invoices'; ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="section-body">
                        <div class="row mt-sm-4">
                            <div class='col-md-12'>
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <form action="<?= base_url('invoices/edit')?>" id="edit_invoice_form">
                                        <input type="hidden" name="invoice_id" id="invoice_id">
                                        <input type="hidden" name="deleted_item_ids" id="deleted_item_ids">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label><?= !empty($this->lang->line('label_select_client')) ? $this->lang->line('label_select_client') : 'Select Client'; ?></label><span class="asterisk"> *</span>
                                                    <select class="form-control select2" name="client_id" id="client_id">
                                                        <option value="" selected><?= !empty($this->lang->line('label_choose')) ? $this->lang->line('label_choose') : 'Choose'; ?>...</option>
                                                        <?php foreach ($all_user as $all_users) {
                                                        ?>
                                                            <option value="<?= $all_users->id ?>"><?= $all_users->first_name ?> <?= $all_users->last_name ?></option>
                                                        <?php
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label><?= !empty($this->lang->line('label_select_project')) ? $this->lang->line('label_select_project') : 'Select Project'; ?></label>
                                                    <select class="form-control select2" name="project_id" id="project_id">
                                                        <option value="" selected>Choose...</option>
                                                        <?php foreach ($projects as $project) {
                                                        ?>
                                                            <option value="<?= $project['id'] ?>"><?= $project['title'] ?></option>
                                                        <?php 
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label><?= !empty($this->lang->line('label_status')) ? $this->lang->line('label_status') : 'Status'; ?></label>
                                                    <select class="form-control select2" name="status" id="status">
                                                        <option value="" selected>Choose...</option>
                                                        <option value="1"><?= !empty($this->lang->line('label_fully_paid')) ? $this->lang->line('label_fully_paid') : 'Fully paid'; ?></option>
                                                        <option value="2"><?= !empty($this->lang->line('label_partially_paid')) ? $this->lang->line('label_partially_paid') : 'Partially paid'; ?></option>
                                                        <option value="3"><?= !empty($this->lang->line('label_draft')) ? $this->lang->line('label_draft') : 'Draft'; ?></option>
                                                        <option value="4"><?= !empty($this->lang->line('label_cancelled')) ? $this->lang->line('label_cancelled') : 'Cancelled'; ?></option>
                                                        <option value="5"><?= !empty($this->lang->line('label_due')) ? $this->lang->line('label_due') : 'Due'; ?></option>  
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- </div> -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="billing_details"><?= !empty($this->lang->line('label_billing_details')) ? $this->lang->line('label_billing_details') : 'Billing Details'; ?></label>
                                                    <a href="#" class="btn btn-icon btn-sm" id="modal-edit-billing-address"><i class="far fa-edit"></i></a>
                                                    <address>
                                                        <span class="billing_name">--</span><br>
                                                        <span class="billing_address">--</span><br>
                                                        <span class="billing_city">--</span>,
                                                        <span class="billing_state">--</span>
                                                        <br>
                                                        <span class="billing_country">--</span>,
                                                        <span class="billing_zip">--</span><br>
                                                        <span class="billing_contact">--</span>
                                                    </address>
                                                </div>
                                            </div>
                                            <input type="hidden" name="name" id="name" value="">
                                            <textarea name="address" id="address" style="display:none;"></textarea>
                                            <input type="hidden" name="city" id="city" value="">
                                            <input type="hidden" name="state" id="state" value="">
                                            <input type="hidden" name="country" id="country" value="">
                                            <input type="hidden" name="zip_code" id="zip_code" value="">
                                            <input type="hidden" name="contact" id="contact" value="">


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="note"><?= !empty($this->lang->line('label_note')) ? $this->lang->line('label_note') : 'Note'; ?></label>
                                                    <textarea type="textarea" class="form-control" placeholder="Note" name="note" id="note"></textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="invoice_date"><?= !empty($this->lang->line('label_invoice_date')) ? $this->lang->line('label_invoice_date') : 'Invoice Date'; ?></label>
                                                    <input class="form-control" type="datetime-local" id="invoice_date" name="invoice_date" value="" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="due_date"><?= !empty($this->lang->line('label_due_date')) ? $this->lang->line('label_due_date') : 'Due Date'; ?></label>
                                                    <input class="form-control" type="datetime-local" id="due_date" name="due_date" value="" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="note"><?= !empty($this->lang->line('label_personal_note')) ? $this->lang->line('label_personal_note') : 'Personal Note'; ?></label>
                                                    <textarea type="textarea" class="form-control" placeholder="Personal Note" name="personal_note" id="personal_note"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <select class="custom-select select2" id="item_id" name="item_id">
                                                            <option value="" selected><?= !empty($this->lang->line('label_choose_item')) ? $this->lang->line('label_choose_item') : 'Choose Item'; ?>...</option>
                                                            <?php
                                                            foreach ($items as $item) { ?>
                                                                <option value="<?= $item['id'] ?>"><?= $item['title'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <div class="wrapper" id="wrp" style="display: none;">
                                                            <hr><a href="#" id="modal-add-item" style="text-decoration: none;">+ <?= !empty($this->lang->line('label_add_item')) ? $this->lang->line('label_add_item') : 'Add Item'; ?></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="item_ids" id="item_ids">
                                            </div>
                                            <div class="col-md-12">
                                <!-- <div class="card"> -->
                                    <!-- <div class="card-body"> -->
                                        
                                        <div class="container-fluid">
                                            <div class="row custom-table-header">

                                                <div class="col-md-3 custom-col">
                                                    <?= !empty($this->lang->line('label_product_service')) ? $this->lang->line('label_product_service') : 'Product / Service'; ?>
                                                </div>
                                                <div class="col-md-3 custom-col">
                                                    <?= !empty($this->lang->line('label_description')) ? $this->lang->line('label_description') : 'Description'; ?>
                                                </div>
                                                <div class="col-md-1 custom-col">
                                                    <?= !empty($this->lang->line('label_quantity')) ? $this->lang->line('label_quantity') : 'Quantity'; ?>
                                                </div>
                                                <div class="col-md-1 custom-col">
                                                    <?= !empty($this->lang->line('label_unit')) ? $this->lang->line('label_unit') : 'Unit'; ?>
                                                </div>
                                                <div class="col-md-1 custom-col">
                                                    <?= !empty($this->lang->line('label_rate')) ? $this->lang->line('label_rate') : 'Rate'; ?>
                                                </div>
                                                <div class="col-md-1 custom-col">
                                                    <?= !empty($this->lang->line('label_tax')) ? $this->lang->line('label_tax') : 'Tax'; ?> %
                                                </div>
                                                <div class="col-md-1 custom-col">
                                                    <?= !empty($this->lang->line('label_amount')) ? $this->lang->line('label_amount') : 'Amount' . '(' . $currency . ')'; ?>
                                                </div>
                                                <div class="col-md-1 custom-col">
                                                    <?= !empty($this->lang->line('label_action')) ? $this->lang->line('label_action') : 'Action'; ?>
                                                </div>
                                                <!-- </div> -->
                                            </div><br>

                                                 <div id="invoice_items">               
                                                <div class="invoice-item py-1">
                                                    <div class="row">
                                                        <div class="col-md-3 custom-col">
                                                            <input type="text" class="form-control" id="title" placeholder="Title">
                                                        </div>
                                                        <div class="col-md-3 custom-col">
                                                            <textarea type="textarea" class="form-control" placeholder="Description" id="description"></textarea>
                                                        </div>
                                                        <div class="col-md-1 custom-col">
                                                            <input type="number" class="form-control" id="quantity" min="1" placeholder="Qty">

                                                        </div>
                                                        <div class="col-md-1 custom-col">
                                                            <select class="form-control" id="unit">
                                                                <option value=""><?= !empty($this->lang->line('label_n_a')) ? $this->lang->line('label_n_a') : 'N/A'; ?></option>
                                                                <?php

                                                                foreach ($units as $unit) { ?>
                                                                    <option value="<?= $unit['id'] ?>"><?= $unit['title'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-1 custom-col">
                                                            <input type="number" class="form-control" id="rate" min="0" placeholder="Rate">
                                                        </div>
                                                        <div class="col-md-1 custom-col">
                                                            <select class="form-control" id="tax">
                                                                <option value="">0</option>
                                                                <?php
                                                                foreach ($taxes as $tax) { ?>
                                                                    <option value="<?= $tax['id'] ?>"><?= $tax['percentage'] ?></option>
                                                                <?php } ?>
                                                            </select>

                                                        </div>
                                                        <div class="col-md-1 custom-col">
                                                            <input type="number" class="form-control" id="amount" min="0" placeholder="<?= get_currency_symbol(); ?>">
                                                        </div>
                                                        <div class="col-md-1 custom-col">
                                                            <a href="#" class="btn btn-icon btn-success add-invoice-item"><i class="fas fa-check"></i></a>
                                                        </div>
                                                        
                                                    </div>
                                                    

                                                </div>
                                                <?php 
                                                $sub_total = 0;
                                                $total_tax = 0;
                                                $taxes_applied = array();
                                                for($j=0;$j<count($invoice_items);$j++){
                                                    $sub_total += $invoice_items[$j]['rate']*$invoice_items[$j]['qty'];
                                                    $amount = $invoice_items[$j]['rate']*$invoice_items[$j]['qty'];
                                                    $amount = number_format((float)$amount, 2, '.', '');
                                                    $total_tax += $amount / 100 * $invoice_items[$j]['tax_percentage'];
                                                    if (!empty($invoice_items[$j]['tax_title'])) {
                                                        $tax_applied = $invoice_items[$j]['tax_title'] . '(' . $invoice_items[$j]['tax_percentage'] . '%)';
                                                    }else{
                                                        $tax_applied = '';
                                                    }
                                                ?>
                                                <div class="invoice-item py-1">
                                                    <div class="row">
                                                        <input type="hidden" name="item[]" value="<?=$invoice_items[$j]['item_id']?>">
                                                        <input type="hidden" name="invoice_item_id[]" id="invoice_item_<?=$j?>_id" value="<?=$invoice_items[$j]['id']?>">
                                                        <div class="col-md-3 custom-col">
                                                            <input type="text" class="form-control" name="title[]" id="item_<?=$j?>_title" value="<?=$invoice_items[$j]['title']?>" placeholder="Title">
                                                        </div>
                                                        <div class="col-md-3 custom-col">
                                                            <textarea type="textarea" class="form-control" placeholder="Description" name="description[]" id="item_<?=$j?>_description"><?=$invoice_items[$j]['description']?></textarea>
                                                        </div>
                                                        <div class="col-md-1 custom-col">
                                                            <input type="number" class="form-control" name="quantity[]" id="item_<?=$j?>_quantity" onchange="update_amount(<?=$j?>)" value="<?=$invoice_items[$j]['qty']?>" min="1" placeholder="Qty">

                                                        </div>
                                                        <div class="col-md-1 custom-col">
                                                            <select class="form-control" name="unit[]" id="item_<?=$j?>_unit">
                                                                <option value=""><?= !empty($this->lang->line('label_n_a')) ? $this->lang->line('label_n_a') : 'N/A'; ?></option>
                                                                <?php

                                                                foreach ($units as $unit) { ?>
                                                                    <option value="<?= $unit['id'] ?>" <?=$invoice_items[$j]['unit_id']==$unit['id']?'selected':''?>><?= $unit['title'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-1 custom-col">
                                                            <input type="number" class="form-control" name="rate[]" id="item_<?=$j?>_rate" onchange="update_amount(<?=$j?>)" value="<?=$invoice_items[$j]['rate']?>" min="0" placeholder="Rate">
                                                        </div>
                                                        <div class="col-md-1 custom-col">
                                                            <select class="form-control" name="tax[]" id="item_<?=$j?>_tax" onchange="update_amount(<?=$j?>);update_tax_title(<?=$j?>)">
                                                                <option value="">0</option>
                                                                <?php
                                                                foreach ($taxes as $tax) { ?>
                                                                    <option value="<?= $tax['id'] ?>" <?=$invoice_items[$j]['tax_id']==$tax['id']?'selected':''?>><?= $tax['percentage'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <div class="item_<?= $j ?>_tax_title"><?=$tax_applied?></div>

                                                        </div>

                                                        <div class="col-md-1 custom-col">
                                                            <input type="number" class="form-control" name="amount[]" id="item_<?=$j?>_amount" value="<?=$amount?>" onchange="update_amount1(<?= $j ?>)" min="0" placeholder="<?= get_currency_symbol(); ?>">
                                                        </div>
                                                        <div class="col-md-1 custom-col">
                                                            <a href="#" class="btn btn-icon btn-danger remove-invoice-item" data-count='<?=$j?>' data-id='<?=$invoice_items[$j]['id']?>'><i class="fas fa-trash"></i></a>
                                                        </div>
                                                        
                                                    </div>
                                                    

                                                </div>
                                                <?php }?>
                                                </div>
                                                <hr>
                                            
                                            <div class="row">
                                            <div class="col-md-7"></div>
                                            <div class="col-md-5">
                                                <div class="form-group row align-items-center">
                                                    <label for="site-title" class="form-control-label col-sm-3 text-md-right"><?= !empty($this->lang->line('label_subtotal')) ? $this->lang->line('label_subtotal') : 'Subtotal'; ?></label>
                                                    <div class="col-sm-6 col-md-9">
                                                    <input type="number" class="form-control" name="sub_total" id="sub_total" placeholder="0.00">
                                                    </div>
                                                </div>
                                                <div class="form-group row align-items-center">
                                                    <label for="site-title" class="form-control-label col-sm-3 text-md-right"><?= !empty($this->lang->line('label_tax')) ? $this->lang->line('label_tax') : 'Tax'; ?></label>
                                                    <div class="col-sm-6 col-md-9">
                                                    <input type="number" class="form-control" name="total_tax" id="total_tax" placeholder="0.00">
                                                    <div class="taxes_applied"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group row align-items-center">
                                                    <label for="site-title" class="form-control-label col-sm-3 text-md-right"><?= !empty($this->lang->line('label_total')) ? $this->lang->line('label_total') : 'Total'; ?></label>
                                                    <div class="col-sm-6 col-md-9">
                                                    <input type="number" class="form-control" name="final_total" id="final_total" placeholder="0.00">
                                                    </div>
                                                </div>
                                            </div>
                                            </div>

                                        </div>
                                        <hr>
                                        <div class="row text-center">
                                            <div class="col-md-3"></div>
                                        <div class="card-footer col-md-6">
                                            <button class="btn btn-primary mb-2" id="submit_button">Submit</button>
                                            <div id="result" style="display: none;"></div>
                                        </div>
                                        </div>
                            </div>
                                        </div>
                                        
                                                      
                                    </div>
                                    
                                </div>
                                
                            </div>
                            
                            
                            
                        </div>
                        
                        </form>
                    </div>


            </div>
        </div>
    </div>

    </section>
    <?= form_open('items/create', 'id="modal-add-item-part"', 'class="modal-part"'); ?>
    <input type="hidden" name="is_reload" id="is_reload" value="0">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label><?= !empty($this->lang->line('label_title')) ? $this->lang->line('label_title') : 'Title'; ?></label><span class="asterisk"> *</span>
                <div class="input-group">
                    <?= form_input(['name' => 'title', 'placeholder' => 'Title', 'class' => 'form-control']) ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label><?= !empty($this->lang->line('label_description')) ? $this->lang->line('label_description') : 'Description'; ?></label>
                <div class="input-group">
                    <?= form_textarea(['name' => 'description', 'placeholder' => 'Description', 'class' => 'form-control']) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><?= !empty($this->lang->line('label_unit')) ? $this->lang->line('label_unit') : 'Unit'; ?></label>
                <select class="form-control" name="unit">
                    <option value="">N/A</option>
                    <?php
                    foreach ($units as $unit) { ?>
                        <option value="<?= $unit['id'] ?>"><?= $unit['title'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><?= !empty($this->lang->line('label_price')) ? $this->lang->line('label_price') : 'Price'; ?></label><span class="asterisk"> *</span>
                <div class="input-group">
                    <?= form_input(['type' => 'number', 'name' => 'price', 'placeholder' => 'Price', 'class' => 'form-control']) ?>
                </div>
            </div>
        </div>
    </div>
    </form>

    <form id="modal-edit-billing-address-part" class="modal-part">
        <div class="row">
            <!-- <div class="col-md-12"> -->
            <div class="form-group col-md-6">
                <label for="name"><?= !empty($this->lang->line('label_name')) ? $this->lang->line('label_name') : 'Name'; ?></label>
                <input name="update_name" id="update_name" class="form-control" placeholder="Name" value="">
            </div>
            <div class="form-group col-md-6">
                <label for="contact"><?= !empty($this->lang->line('label_contact')) ? $this->lang->line('label_contact') : 'Contact'; ?></label>
                <input name="update_contact" id="update_contact" class="form-control" placeholder="Contact" value="">
            </div>
            <div class="form-group col-md-12">
                <label for="address"><?= !empty($this->lang->line('label_address')) ? $this->lang->line('label_address') : 'Address'; ?></label>
                <textarea type="textarea" class="form-control" placeholder="Address" name="update_address" id="update_address"></textarea>
            </div>
            <!-- </div> -->

            <div class="form-group col-md-6 col-12">
                <label><?= !empty($this->lang->line('label_city')) ? $this->lang->line('label_city') : 'City'; ?></label>
                <input name="update_city" id="update_city" class="form-control" placeholder="City" value="">
            </div>

            <div class="form-group col-md-6 col-12">
                <label><?= !empty($this->lang->line('label_state')) ? $this->lang->line('label_state') : 'State'; ?></label>
                <input name="update_state" id="update_state" class="form-control" placeholder="State" value="">
            </div>

            <div class="form-group col-md-6 col-12">
                <label><?= !empty($this->lang->line('label_country')) ? $this->lang->line('label_country') : 'Country'; ?></label>
                <input name="update_country" id="update_country" class="form-control" placeholder="Country" value="">
            </div>

            <div class="form-group col-md-6 col-12">
                <label><?= !empty($this->lang->line('label_zip_code')) ? $this->lang->line('label_zip_code') : 'Zip Code'; ?></label>
                <input type="number" name="update_zip_code" id="update_zip_code" class="form-control" placeholder="Zip Code" value="">
            </div>
        </div>
    </form>

    <?php include('include-footer.php'); ?>

    </div>
    </div>
    <?php include('include-js.php'); ?>
</body>

<script>
    taxes = '<?php
                echo "<option value=>0</option>";
                foreach ($taxes as $tax) {

                    echo "<option value=" . $tax['id'] . ">" . $tax['percentage'] . "</option>";
                } ?>';
    units = '<?php
                echo "<option value=>N/A</option>";
                foreach ($units as  $unit) {
                    echo "<option value=" . $unit['id'] . ">" . $unit['title'] . "</option>";
                }
                ?>';
    currency = <?= "'$currency'"; ?>;
    invoice_id = <?= $invoice_id; ?>;
    sub_total = <?= $sub_total; ?>;
    total_tax = <?= $total_tax; ?>;
    j = <?=count($invoice_items)?>;
   
</script>
<script src="<?= base_url('assets/js/page/components-edit-invoice.js'); ?>"></script>
</html>