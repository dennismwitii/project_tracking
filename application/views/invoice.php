<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Invoice &mdash; <?= get_compnay_title(); ?></title>
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
                        <h1><?= !empty($this->lang->line('label_invoice')) ? $this->lang->line('label_invoice') : 'Invoice'; ?></h1>
                        <div class="section-header-breadcrumb">
                            <div class="btn-group mr-2 no-shadow">
                                <a class="btn btn-primary text-white" href="<?= base_url('invoices') ?>" class="btn"><i class="fas fa-list"></i> <?= !empty($this->lang->line('label_invoices')) ? $this->lang->line('label_invoices') : 'Invoices'; ?></a>
                            </div>
                        </div>
                        <i class="btn btn-primary btn-rounded no-shadow" id="modal-add-payment" data-value="add" data-id="<?= $invoice['id'] ?>"><?= !empty($this->lang->line('label_create_payment')) ? $this->lang->line('label_create_payment') : 'Create Payment'; ?></i>
                    </div>
                    <div class="section-body">
                        <div class="invoice">
                            <div class="invoice-print">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="invoice-title">
                                            <?php
                                            $full_logo = get_compnay_logo();
                                            ?>
                                            <img alt="Task Hub" src="<?= !empty($full_logo) ? base_url('assets/icons/' . $full_logo) : base_url('assets/icons/logo.png'); ?>" width="200px">
                                            <div class="invoice-number">Invoice <?= '#INVOC-' . $invoice['id'] ?></div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <address>
                                                    <strong><?= !empty($this->lang->line('label_billing_details')) ? $this->lang->line('label_billing_details') : 'Billing Details:' ?></strong><br>
                                                    <?= $invoice['name'] ?><br>
                                                    <?= $invoice['address'] ?><br>
                                                    <?= $invoice['city'] . ', ' . $invoice['state'] . ', ' . $invoice['country'] . ', ' . $invoice['zip_code'] ?><br>
                                                    <?= $invoice['contact'] ?>
                                                </address>
                                            </div>
                                            <div class="col-md-6 text-md-right">
                                                <address>
                                                    <strong><?= !empty($this->lang->line('label_invoice_no')) ? $this->lang->line('label_invoice_no') : 'Invoice No' ?>.:</strong><br>
                                                    <?= '#INVOC-' . $invoice['id'] ?><br>
                                                    <strong><?= !empty($this->lang->line('label_invoice_date')) ? $this->lang->line('label_invoice_date') : 'Invoice Date' ?>:</strong><br>
                                                    <?= date("d-M-Y", strtotime($invoice['created_on'])) ?><br>
                                                    <strong><?= !empty($this->lang->line('label_project')) ? $this->lang->line('label_project') : 'Project' ?>:</strong><br>
                                                    <?php $project_title = $invoice['project_title'] != '' ? $invoice['project_title'] : '-'; ?>
                                                    <?= $project_title ?>
                                                </address>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div class="section-title"><?= !empty($this->lang->line('label_invoice_summary')) ? $this->lang->line('label_invoice_summary') : 'Invoice Summary' ?></div>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover table-md">
                                                <tr>
                                                    <th data-width="40">#</th>
                                                    <th><?= !empty($this->lang->line('label_product_service')) ? $this->lang->line('label_product_service') : 'Product / Service' ?></th>
                                                    <th class="text-center"><?= !empty($this->lang->line('label_quantity')) ? $this->lang->line('label_quantity') : 'Quantity' ?></th>
                                                    <th class="text-center"><?= !empty($this->lang->line('label_unit')) ? $this->lang->line('label_unit') : 'Unit' ?></th>
                                                    <th class="text-center"><?= !empty($this->lang->line('label_rate')) ? $this->lang->line('label_rate') : 'Rate' ?> <?= '(' . get_currency_symbol() . ')' ?></th>
                                                    <th class="text-center"><?= !empty($this->lang->line('label_tax')) ? $this->lang->line('label_tax') : 'Tax' ?></th>
                                                    <th class="text-center"><?= !empty($this->lang->line('label_amount')) ? $this->lang->line('label_amount') : 'Amount' ?> <?= '(' . get_currency_symbol() . ')' ?></th>
                                                </tr>
                                                <?php
                                                $sub_total = 0;
                                                $total_tax = 0;
                                                $i = 1;
                                                foreach ($invoice_items as $invoice_item) {
                                                    $amount = $invoice_item['rate'] * $invoice_item['qty'];
                                                    $sub_total += $amount;
                                                    $total_tax += $amount / 100 * $invoice_item['tax_percentage'];
                                                    $unit = !empty($invoice_item['unit_title']) ? $invoice_item['unit_title'] : "-";
                                                    $tax_title = !empty($invoice_item['tax_title']) ? $invoice_item['tax_title'] . ' (' . $invoice_item['tax_percentage'] . '%)' : "N/A";
                                                ?>
                                                    <tr>
                                                        <td><?= $i ?></td>
                                                        <td><?= $invoice_item['title'] ?></td>
                                                        <td class="text-center"><?= $invoice_item['qty'] ?></td>
                                                        <td class="text-center"><?= $unit ?></td>
                                                        <td class="text-center"><?= $invoice_item['rate'] ?></td>
                                                        <td class="text-center"><?= $tax_title ?></td>
                                                        <td class="text-center"><?= number_format((float)$amount, 2) ?></td>
                                                    </tr>
                                                <?php $i++;
                                                }
                                                ?>
                                            </table>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-lg-8">
                                            <div class="section-title mt-0"><?= !empty($this->lang->line('label_payment_summary')) ? $this->lang->line('label_payment_summary') : 'Payment Summary' ?></div>
                                            <?php if(!empty($payments)){?>
                                                <table class="table table-striped table-hover table-md">
                                                <tr>
                                                    <th data-width="40">#</th>
                                                    <th class="text-center"><?= !empty($this->lang->line('label_amount')) ? $this->lang->line('label_amount') : 'Amount('.get_currency_symbol().')' ?></th>
                                                    <th class="text-center"><?= !empty($this->lang->line('label_payment_mode')) ? $this->lang->line('label_payment_mode') : 'Payment Mode' ?></th>
                                                    <th class="text-center"><?= !empty($this->lang->line('label_note')) ? $this->lang->line('label_note') : 'Note' ?></th>
                                                    <th class="text-center"><?= !empty($this->lang->line('label_payment_date')) ? $this->lang->line('label_payment_date') : 'Payment Date' ?></th>
                                                    <th class="text-center"><?= !empty($this->lang->line('label_amount_left')) ? $this->lang->line('label_amount_left') : 'Amount Left('.get_currency_symbol().')' ?></th>
                                                </tr>
                                                <?php
                                                $i = 1;
                                                $paid_amount = 0;
                                                foreach ($payments as $payment) {
                                                 $paid_amount += $payment['amount'];
                                                 $amount_left = $payment['total_amount'] - $paid_amount;
                                                ?>
                                                    <tr>
                                                        <td><?= $i ?></td>
                                                        <td class="text-center"><?= number_format((float)$payment['amount'], 2) ?></td>
                                                        <td class="text-center"><?= $payment['payment_mode'] ?></td>
                                                        <td class="text-center"><?= $payment['note'] ?></td>
                                                        <td class="text-center"><?= date("d-M-Y H:i:s", strtotime($payment['payment_date'])) ?></td>
                                                        <td class="text-center"><b><?= number_format((float)$amount_left, 2) ?></b></td>
                                                    </tr>
                                                <?php $i++;
                                                }
                                                ?>
                                            </table>
                                            <?php } else {?>
                                                <div class="alert alert-primary"><?=!empty($this->lang->line('label_no_payments_found')) ? $this->lang->line('label_no_payments_found') : 'No payments found'.'!'?></div>
                                            <?php }?>
                                            </div>
                                            <div class="col-lg-4 text-right">
                                                <div class="invoice-detail-item">
                                                    <div class="invoice-detail-name"><?= !empty($this->lang->line('label_subtotal')) ? $this->lang->line('label_subtotal') : 'Subtotal' ?></div>
                                                    <div class="invoice-detail-value"><?= get_currency_symbol() . number_format((float)$sub_total, 2) ?></div>
                                                </div>
                                                <div class="invoice-detail-item">
                                                    <div class="invoice-detail-name"><?= !empty($this->lang->line('label_tax')) ? $this->lang->line('label_tax') : 'Tax' ?></div>
                                                    <div class="invoice-detail-value"><?= get_currency_symbol() . number_format((float)$total_tax, 2) ?></div>
                                                </div>
                                                <hr class="mt-2 mb-2">
                                                <div class="invoice-detail-item">
                                                    <div class="invoice-detail-name"><?= !empty($this->lang->line('label_total')) ? $this->lang->line('label_total') : 'Total' ?></div>
                                                    <div class="invoice-detail-value invoice-detail-value-lg"><?= get_currency_symbol() . number_format((float)$sub_total + $total_tax, 2) ?></div>
                                                </div>
                                            </div>
                                        </div>
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
                                <option value="<?= $invoice['id'] ?>"><?= "INVOC-" . $invoice['id'] ?></option>
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
                                foreach ($payment_modes as $payment_mode) { ?>
                                    <option value="<?= $payment_mode['id'] ?>"><?= $payment_mode['title'] ?></option>
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
                        <input type="number" class="form-control" placeholder="Amount" name="amount" id="amount">
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
<script>
    invoice_id = <?= $invoice['id']; ?>
</script>
<script src="<?= base_url('assets/js/page/components-invoice.js'); ?>"></script>

</html>