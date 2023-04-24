<!-- Page Content -->
<div class="right_col" role="main">
    <div class="page-title">
        <div class="title_left">
            <h3><?= $title ?></h3>
        </div>
        <div class="title_right">
            <div class="form-group pull-right top_search">
                <div class="btn-group btn-group-sm" role="group">
                    <a href="<?= base_url() ?>/partner" class="btn btn-secondary">Manage Partners</a>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <form id="partner" method="post" data-parsley-validate class="form-horizontal form-label-left">
                <div class="x_panel">
                    <div class="x_content">
                        <div id="notificationArea"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Partner Name <span class="required">*</span></label>
                                <input type="text" name="name" required="required" value="<?= $partner_info['partner_name'] ?>" class="form-control">
                                <input type="hidden" name="partner_id" value="<?= $partner_info['partner_id'] ?>">
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" class="flat" <?= $partner_info['partner_status'] == 'active' ? 'checked' : '' ?> name="status" value="active"> Active<br/>
                                        <input type="radio" class="flat" <?= $partner_info['partner_status'] == 'inactive' ? 'checked' : '' ?> name="status" value="inactive"> Inactive
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Total Investment</label>
                                <input type="number" value="<?= $partner_info['total_investment'] ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Remaining Investment</label>
                                <input type="number" value="<?= $partner_info['remaining_investment'] ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Total Profit</label>
                                <input type="number" value="<?= $partner_info['total_profit'] ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <button type="submit" id="submit" class="btn btn-sm btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Page Content -->
<script>
    jQ.push(function () {
        $('#submit').click(function (e) {
            e.preventDefault();
            $("#submit").attr("disabled", true);
            $("#submit").html('Processing..');
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>/partner/update_partner',
                data: $('#partner').serialize(),
                success: function (data)
                {
                    if (data === 'success') {
                        $("#submit").attr("disabled", true);
                        $('#notificationArea').html("<div class='alert alert-primary' role='alert'>Updated!</div>");
                    } else {
                        $("#submit").attr("disabled", false);
                        $('#notificationArea').html("<div class='alert alert-danger' role='alert'>" + data + "</div>");
                    }
                    $("#submit").html('Update');
                }
            });
        });
    });
</script>