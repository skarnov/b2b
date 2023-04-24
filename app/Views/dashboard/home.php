<!-- Page Content -->
<div class="right_col" role="main">
    <?php $session = \Config\Services::session() ?>

    <?php if ($session->getFlashdata('error')): ?>
        <div class="col-md-12">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    <?= $session->getFlashdata('error') ?>
                </div>
            </div>
        </div>
    <?php endif ?>
    <?php if ($session->getFlashdata('warning')): ?>
        <div class="col-md-12">
            <div class="col-md-12">
                <div class="alert alert-warning">
                    <?= $session->getFlashdata('warning') ?>
                </div>
            </div>
        </div>
    <?php endif ?>
    <?php if ($session->getFlashdata('success')): ?>
        <div class="col-md-12">
            <div class="col-md-12">
                <div class="alert alert-success">
                    <?= $session->getFlashdata('success') ?>
                </div>
            </div>
        </div>
    <?php endif ?>

    <div class="col-md-12">
        <div class="col-md-4">
            <div class="card border-secondary mb-3">
                <div class="card-header bg-transparent border-dark"><b>Active User</b></div>
                <div class="card-body text-secondary">
                    <h5 class="card-title"><?= $active_user_stat ?></h5>
                    <p class="card-text">Active User</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-secondary mb-3">
                <div class="card-header bg-transparent border-dark"><b>This Month User</b></div>
                <div class="card-body text-purple">
                    <h5 class="card-title"><?= $user_this_month_stat ?></h5>
                    <p class="card-text">This Month User</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success mb-3">
                <div class="card-header bg-transparent border-dark"><b>Cashbook IN</b></div>
                <div class="card-body text-success">
                    <h5 class="card-title"><?= $settings['currency_sign'] . $cash_in_stat ?></h5>
                    <p class="card-text">Total Cashbook Amount</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-info mb-3">
                <div class="card-header bg-transparent border-info"><b>Cashbook OUT</b></div>
                <div class="card-body text-info">
                    <h5 class="card-title"><?= $settings['currency_sign'] . $cash_out_stat ?></h5>
                    <p class="card-text">Total Cashbook Amount</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-secondary mb-3">
                <div class="card-header bg-transparent border-dark"><b>Total Income</b></div>
                <div class="card-body text-pink">
                    <h5 class="card-title"><?= $settings['currency_sign'] . $total_income_stat ?></h5>
                    <p class="card-text">Total Income</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-secondary mb-3">
                <div class="card-header bg-transparent border-dark"><b><?= date('F') ?> Month Income</b></div>
                <div class="card-body text-purple">
                    <h5 class="card-title"><?= $settings['currency_sign'] ?><?php echo $income_this_month_stat ? $income_this_month_stat : 0 ?></h5>
                    <p class="card-text"><?= date('F') ?> Month Income</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-secondary mb-3">
                <div class="card-header bg-transparent border-dark"><b>Domains</b></div>
                <div class="card-body text-cream">
                    <h5 class="card-title"><?= $domain_stat ?></h5>
                    <p class="card-text">Total Active Domains</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-danger mb-3">
                <div class="card-header bg-transparent border-danger"><b>Domains Warning</b></div>
                <div class="card-body text-danger">
                    <h5 class="card-title"><a href="javascript:;" data-toggle="modal" data-target="#domainWarning"><?= $domain_warning ?></a></h5>
                    <p class="card-text">Total Warning Domains</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-primary mb-3">
                <div class="card-header bg-transparent border-primary"><b>Hostings</b></div>
                <div class="card-body text-primary">
                    <h5 class="card-title"><?= $hosting_stat ?></h5>
                    <p class="card-text">Total Active Hostings</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-danger mb-3">
                <div class="card-header bg-transparent border-danger"><b>Hostings Warning</b></div>
                <div class="card-body text-danger">
                    <h5 class="card-title"><a href="javascript:;" data-toggle="modal" data-target="#hostingWarning"><?= $hosting_warning ?></a></h5>
                    <p class="card-text">Total Warning Hostings</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-danger mb-3">
                <div class="card-header bg-transparent border-danger"><b>New User</b></div>
                <div class="card-body text-danger">
                    <h5 class="card-title"><?= $new_user_stat ?></h5>
                    <p class="card-text">Total New User</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-danger mb-3">
                <div class="card-header bg-transparent border-danger"><b>Support Ticket</b></div>
                <div class="card-body text-danger">
                    <h5 class="card-title"><?= $ticket_stat ?></h5>
                    <p class="card-text">New Support Ticket</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End of Page Content -->

<?php if ($expired_domains) : ?>
    <!-- Start Domain Warning Modal -->
    <div class="modal fade" id="domainWarning" tabindex="-1" aria-labelledby="domainWarningLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Domain Warning</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Expiry Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($expired_domains as $domain):
                                ?>
                                <tr>
                                    <th scope="row"><?= $i ?></th>
                                    <td><?= $domain['domain_name'] ?></td>
                                    <td><?= date($settings['date_format'], strtotime($domain['expiry_date'])) ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Options
                                            </button>
                                            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px);">
                                                <a class="dropdown-item" href="<?= base_url() ?>/domain/edit_domain/<?= $domain['domain_id'] ?>">Edit</a>
                                                <a class="dropdown-item" href="<?= base_url() ?>/domain/renew/<?= $domain['domain_id'] ?>">Renew</a>
                                                <a class="dropdown-item" href="<?= base_url() ?>/account/invoice_download/<?= $domain['domain_id'] ?>">Invoice</a>
                                                <a class="dropdown-item" href="<?= base_url() ?>/email/domain_renew/<?= $domain['domain_id'] ?>">Send Notification</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            endforeach
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Domain Warning Modal -->
<?php endif ?>

<?php if ($expired_hostings) : ?>
    <!-- Start Hosting Warning Modal -->
    <div class="modal fade" id="hostingWarning" tabindex="-1" aria-labelledby="hostingWarningLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hosting Warning</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Domain</th>
                                <th scope="col">Space</th>
                                <th scope="col">Expiry Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $c = 1;
                            foreach ($expired_hostings as $hosting):
                                ?>
                                <tr>
                                    <th scope="row"><?= $c ?></th>
                                    <td><?= $hosting['primary_domain'] ?></td>
                                    <td><?= $hosting['hosting_space'] ?></td>
                                    <td><?= date($settings['date_format'], strtotime($hosting['expiry_date'])) ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Options
                                            </button>
                                            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px);">
                                                <a class="dropdown-item" href="<?= base_url() ?>/hosting/edit_hosting/<?= $hosting['hosting_id'] ?>">Edit</a>
                                                <a class="dropdown-item" href="<?= base_url() ?>/hosting/renew/<?= $hosting['hosting_id'] ?>">Renew</a>
                                                <a class="dropdown-item" href="<?= base_url() ?>/hosting/invoice/<?= $hosting['hosting_id'] ?>">Invoice</a>
                                                <a class="dropdown-item" href="<?= base_url() ?>/email/hosting_renew/<?= $hosting['hosting_id'] ?>">Send Notification</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                $c++;
                            endforeach
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Hosting Warning Modal -->
    <?php
 endif ?>