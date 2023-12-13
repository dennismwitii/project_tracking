<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Notification Details &mdash; <?= get_compnay_title(); ?></title>
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
                        <h1><?= !empty($this->lang->line('label_notification_details')) ? $this->lang->line('label_notification_details') : 'Notification Details'; ?></h1>
                    </div>
                    <div class="section-body">
                        <div class="row">
                            <div class="modal-edit-milestone"></div>
                            <div class="col-md-12">
                                <div class="card author-box card-info">
                                    <div class="card-body">
                                        <div class="author-box-name">
                                            <?php
                                            if ($notification_data['type'] == 'project') {
                                                $title = 'New project assigned.';
                                            }
                                            if ($notification_data['type'] == 'task') {
                                                $title = 'New task assigned.';
                                            }
                                            if ($notification_data['type'] == 'announcement') {
                                                $title = 'New announcement posted.';
                                            }
                                            if ($notification_data['type'] == 'event') {
                                                $title = 'Event created / updated.';
                                            }
                                            ?>
                                            <h4><?= $title; ?></h4>
                                        </div>
                                        <?php
                                        if ($notification_data['type'] == 'project') {
                                            $badge = 'Project';
                                        }
                                        if ($notification_data['type'] == 'task') {
                                            $badge = 'Task';
                                        }
                                        if ($notification_data['type'] == 'announcement') {
                                            $badge = 'Announcement';
                                        }
                                        if ($notification_data['type'] == 'event') {
                                            $badge = 'Event';
                                        }
                                        ?>
                                        <div class="announcement-date"><a href="<?= base_url('users/detail/' . $notification_data['user_id']) ?>"><?= $user_name ?></a>
                                            <div class="bullet"></div> <a><?= date("d-M-Y H:i A", strtotime($notification_data['date_created'])); ?></a>
                                        </div>
                                        <div class="author-box-job">
                                            <div class="badge badge-info projects-badge"><?= $badge; ?></div>
                                        </div>
                                        <div class="author-box-description">
                                            <h6><?= $notification_data['notification']; ?></h6>
                                        </div>

                                        <div class="row" style="display: none;">
                                            <div class="col-md-6">
                                                <h6 class="mt-1"><?= !empty($this->lang->line('label_users')) ? $this->lang->line('label_users') : 'Users'; ?></h6>
                                                <?php foreach ($notification_users as $notification_user) {
                                                    if (isset($notification_user['profile']) && !empty($notification_user['profile'])) { ?>
                                                        <a href="<?= base_url('users/detail/' . $notification_user['id']) ?>">
                                                            <figure class="avatar avatar-md" data-toggle="tooltip" data-title="<?= $notification_user['first_name'] ?>">
                                                                <img alt="image" src="<?= base_url('assets/profiles/' . $notification_user['profile']); ?>" class="rounded-circle">
                                                            </figure>
                                                        </a>
                                                    <?php } else { ?>
                                                        <a href="<?= base_url('users/detail/' . $notification_user['id']) ?>">
                                                            <figure data-toggle="tooltip" data-title="<?= $notification_user['first_name'] ?>" class="avatar avatar-md" data-initial="<?= mb_substr($notification_user['first_name'], 0, 1) . '' . mb_substr($notification_user['last_name'], 0, 1); ?>">
                                                            </figure>
                                                        </a>
                                                <?php }
                                                } ?>
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
    <!-- Page Specific JS File -->

</body>
</html>