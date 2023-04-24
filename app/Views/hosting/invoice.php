<!-- Page Content -->
<div class="right_col" role="main">
    <div class="page-title">
        <div class="title_left">
            <h3><?= $title ?></h3>
        </div>
        <div class="title_right">
            <div class="form-group pull-right top_search">
                <div class="btn-group btn-group-sm" role="group">
                    <a href="<?= base_url() ?>/hosting" class="btn btn-secondary btn-xs">Hosting Management</a>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="x_panel">
                <div class="x_content">
                    <?php foreach ($all_invoices as $invoice) : ?>
                        <div class="col-md-4 col-sm-4 profile_details">
                            <div class="col-sm-12">
                                <h2><b>Date: </b><?php echo date($settings['date_format'], strtotime($invoice['create_date'])) ?></h2>
                                <hr/>
                                <p class="text-invoice"><b>Buying Price:</b> <?php echo $invoice['buying_price'] ?></p>
                                <p class="text-invoice"><b>Net Price:</b> <?php echo $invoice['net_price'] ?></p>
                                <p class="text-invoice"><b>VAT Amount:</b> <?php echo $invoice['vat_amount'] ?></p>
                                <p class="text-invoice"><b>Discount Amount:</b> <?php echo $invoice['discount_amount'] ?></p>
                                <p class="text-invoice"><b>Grand Total:</b> <?php echo $invoice['grand_total'] ?></p>
                                <p class="text-invoice"><b>Sale Due:</b> <?php echo $invoice['sale_due'] ?></p>
                            </div>
                            <div class="profile-bottom text-center">
                                <a href="<?= base_url() ?>/account/invoice_download/<?php echo $invoice['sale_id'] ?>" class="btn btn-primary btn-xs">
                                    <i class="fa fa-file-text-o"> </i> View Invoice
                                </a>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End of Page Content -->