<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Mail Details &mdash; <?= get_compnay_title(); ?></title>

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
                        <h1><?= !empty($this->lang->line('label_mail_details')) ? $this->lang->line('label_mail_details') : 'Mail Details'; ?></h1>
                    </div>

                    <div class="section-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="list-group">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h5 class="mb-1"><?= $mail['subject'] ?></h5>
                                                <small><?= date("d-M-Y H:i A", strtotime($mail['date_sent'])); ?></small>
                                            </div>
                                            <p class="mb-1"><?= $mail['message']; ?></p>
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6>To : <small><?= $mail['to']; ?></small></h6>
                                                <?php
                                                if ($mail['status'] == 1) {
                                                    $status = "<div class='badge badge-success'>Sent</label>";
                                                } elseif ($mail['status'] == 2) {
                                                    $status = "<div class='badge badge-danger'>Failed</label>";
                                                } elseif ($mail['status'] == 3) {
                                                    $status = "<div class='badge badge-success'>Draft</label>";
                                                } else {
                                                    $status = "";
                                                }
                                                ?>
                                                <?= $status ?>
                                            </div>
                                        </div><hr>
                                        <h5><?= !empty($this->lang->line('label_attachments')) ? $this->lang->line('label_attachments') : 'Attachments'; ?></h5>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-md">
                                                <?php
                                                if (!empty($mail['attachments'])) {
                                                    $attachments = explode(",", $mail['attachments']); ?>
                                                    <tr>
                                                        <th>#</th>
                                                        <th><?= !empty($this->lang->line('label_name')) ? $this->lang->line('label_name') : 'Name'; ?></th>
                                                        <th><?= !empty($this->lang->line('label_action')) ? $this->lang->line('label_action') : 'Action'; ?></th>
                                                    </tr>
                                                    <?php for ($i = 0; $i < count($attachments); $i++) { ?>
                                                        <tr>
                                                            <td><?= $i + 1; ?></td>
                                                            <td><?= $attachments[$i]; ?></td>
                                                            <td><a download="<?= $attachments[$i] ?>" href="<?= base_url('assets/attachments/' . $attachments[$i]); ?>" class="btn btn-primary btn-action mt-1 "><i class="fas fa-download"></i></a></td>
                                                        </tr>
                                                    <?php }
                                                } else { ?>
                                                    <tr><?= !empty($this->lang->line('label_no_attachments_found')) ? $this->lang->line('label_no_attachments_found') : 'No attachments found'; ?>!</tr>
                                                <?php }
                                                ?>
                                            </table>
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

</html>