<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Estimate &mdash; <?= get_compnay_title(); ?></title>
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
                        <h1><?= !empty($this->lang->line('label_estimate')) ? $this->lang->line('label_estimate') : 'Estimate'; ?></h1>
                        <div class="section-header-breadcrumb">
                            <div class="btn-group mr-2 no-shadow">
                                <a class="btn btn-primary text-white" href="<?= base_url('estimates') ?>" class="btn"><i class="fas fa-list"></i> <?= !empty($this->lang->line('label_estimates')) ? $this->lang->line('label_estimates') : 'Estimates'; ?></a>
                            </div>
                        </div>
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
                                            <div class="invoice-number">Estimate <?= '#ESTMT-' . $estimate['id'] ?></div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <address>
                                                    <strong><?= !empty($this->lang->line('label_billing_details')) ? $this->lang->line('label_billing_details') : 'Billing Details:' ?></strong><br>
                                                    <?= $estimate['name'] ?><br>
                                                    <?= $estimate['address'] ?><br>
                                                    <?= $estimate['city'] . ', ' . $estimate['state'] . ', ' . $estimate['country'] . ', ' . $estimate['zip_code'] ?><br>
                                                    <?= $estimate['contact'] ?>
                                                </address>
                                            </div>
                                            <div class="col-md-6 text-md-right">
                                                <address>
                                                    <strong><?=!empty($this->lang->line('label_estimate_no')) ? $this->lang->line('label_estimate_no') : 'Estimate No'?>.:</strong><br>
                                                    <?= '#ESTMT-' . $estimate['id'] ?><br>
                                                    <strong><?=!empty($this->lang->line('label_estimate_date')) ? $this->lang->line('label_estimate_date') : 'Estimate Date'?>:</strong><br>
                                                    <?= date("d-M-Y", strtotime($estimate['created_on'])) ?><br>
                                                </address>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div class="section-title"><?=!empty($this->lang->line('label_estimate_summary')) ? $this->lang->line('label_estimate_summary') : 'Estimate Summary'?></div>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover table-md">
                                                <tr>
                                                    <th data-width="40">#</th>
                                                    <th><?=!empty($this->lang->line('label_product_service')) ? $this->lang->line('label_product_service') : 'Product / Service'?></th>
                                                    <th class="text-center"><?=!empty($this->lang->line('label_quantity')) ? $this->lang->line('label_quantity') : 'Quantity'?></th>
                                                    <th class="text-center"><?=!empty($this->lang->line('label_unit')) ? $this->lang->line('label_unit') : 'Unit'?></th>
                                                    <th class="text-center"><?=!empty($this->lang->line('label_rate')) ? $this->lang->line('label_rate') : 'Rate'?> <?='('.get_currency_symbol().')'?></th>
                                                    <th class="text-center"><?=!empty($this->lang->line('label_tax')) ? $this->lang->line('label_tax') : 'Tax'?></th>
                                                    <th class="text-center"><?=!empty($this->lang->line('label_amount')) ? $this->lang->line('label_amount') : 'Amount'?> <?='('.get_currency_symbol().')'?></th>
                                                </tr>
                                                <?php
                                                $sub_total = 0;
                                                $total_tax = 0;
                                                $i = 1;
                                                foreach ($estimate_items as $estimate_item) {
                                                    $amount = $estimate_item['rate'] * $estimate_item['qty'];
                                                    $sub_total += $amount;
                                                    $total_tax += $amount / 100 * $estimate_item['tax_percentage'];
                                                    $unit = !empty($estimate_item['unit_title']) ? $estimate_item['unit_title'] : "-";
                                                    $tax_title = !empty($estimate_item['tax_title']) ? $estimate_item['tax_title'] . ' (' . $estimate_item['tax_percentage'] . '%)' : "N/A";
                                                ?>
                                                <tr>
                                                    <td><?=$i?></td>
                                                    <td><?=$estimate_item['title']?></td>
                                                    <td class="text-center"><?=$estimate_item['qty']?></td>
                                                    <td class="text-center"><?=$unit?></td>
                                                    <td class="text-center"><?=$estimate_item['rate']?></td>
                                                    <td class="text-center"><?=$tax_title?></td>
                                                    <td class="text-center"><?=number_format((float)$amount, 2)?></td>
                                                </tr>
                                                <?php $i++; }
                                                ?>
                                            </table>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-lg-8">

                                            </div>
                                            <div class="col-lg-4 text-right">
                                                <div class="invoice-detail-item">
                                                    <div class="invoice-detail-name"><?=!empty($this->lang->line('label_subtotal')) ? $this->lang->line('label_subtotal') : 'Subtotal'?></div>
                                                    <div class="invoice-detail-value"><?=get_currency_symbol().number_format((float)$sub_total, 2)?></div>
                                                </div>
                                                <div class="invoice-detail-item">
                                                    <div class="invoice-detail-name"><?= !empty($this->lang->line('label_tax')) ? $this->lang->line('label_tax') : 'Tax'?></div>
                                                    <div class="invoice-detail-value"><?=get_currency_symbol().number_format((float)$total_tax, 2)?></div>
                                                </div>
                                                <hr class="mt-2 mb-2">
                                                <div class="invoice-detail-item">
                                                    <div class="invoice-detail-name"><?= !empty($this->lang->line('label_total')) ? $this->lang->line('label_total') : 'Total'?></div>
                                                    <div class="invoice-detail-value invoice-detail-value-lg"><?=get_currency_symbol().number_format((float)$sub_total+$total_tax, 2)?></div>
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

            <?php include('include-footer.php'); ?>

        </div>
    </div>
    <?php include('include-js.php'); ?>
</body>
<script src="<?= base_url('assets/js/page/components-estimate.js'); ?>"></script>

</html>