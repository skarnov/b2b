<!-- Page Content -->
<div class="right_col" role="main">
    <div class="page-title">
        <div class="title_left">
            <h3><?= $title ?></h3>
        </div>
        <div class="title_right">
            <div class="form-group pull-right top_search">
                <div class="btn-group btn-group-sm" role="group">
                    <a href="<?= base_url() ?>/user/manage_funds" class="btn btn-secondary btn-xs">Manage Funds</a>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <form id="fund" method="post" data-parsley-validate class="form-horizontal form-label-left">
                <div class="x_panel">
                    <div class="x_content">
                        <div id="notificationArea"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Customer <span class="required">*</span></label>
                                <select name="user_id" required class="form-control" onchange="findCustomerBalance(this.value)">
                                    <option value="">Select Customer</option>
                                    <?php foreach ($all_users as $value) : ?>
                                        <option value="<?= $value['user_id'] ?>"><?= $value['first_name'] . ' ' . $value['last_name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Transaction Date <span class="required">*</span></label>
                                <input type="date" name="transaction_date" required="required" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Add Fund</label>
                                <input type="number" id="addFund" name="add_fund" class="filter form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Balance</label>
                                <input type="number" id="balance" name="balance" class="filter form-control">
                            </div>
                            <div class="form-group">
                                <label>Total Balance</label>
                                <input type="number" id="totalBalance" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <button type="submit" id="submit" class="btn btn-sm btn-success">Execute</button>
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
        var $form = $('#fund'),
                hideShow = function () {
                    var balance = $('#balance').val();
                    var addFund = $('#addFund').val();

                    var total = Number(balance) + Number(addFund);
                    $('#totalBalance').val(total);
                };

        $form.find('.filter').on('keyup', hideShow);

        $('#submit').click(function (e) {
            e.preventDefault();
            $('#submit').attr('disabled', true);
            $('#submit').html('Processing..');
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>/user/save_fund',
                data: $('#fund').serialize(),
                success: function (data)
                {
                    if (data === 'success') {
                        $('#submit').attr('disabled', true);
                        $('#notificationArea').html("<div class='alert alert-success' role='alert'>Saved!</div>");
                    } else {
                        $('#submit').attr('disabled', false);
                        $('#notificationArea').html("<div class='alert alert-danger' role='alert'>" + data + "</div>");
                    }
                    $('#submit').html('Save');
                }
            });
        });
    });
</script>