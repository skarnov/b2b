<!-- Page Content -->
<div class="right_col" role="main">
    <div class="page-title">
        <div class="title_left">
            <h3><?= $title ?></h3>
        </div>
        <div class="title_right">
            <div class="form-group pull-right top_search">
                <div class="btn-group btn-group-sm" role="group">
                    <a href="<?= base_url() ?>/domain/transactions" class="btn btn-secondary btn-xs">Manage Transactions</a>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <form id="transaction" method="post" data-parsley-validate class="form-horizontal form-label-left">
                <div class="x_panel">
                    <div class="x_content">
                        <div id="notificationArea"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sale <span class="required">*</span></label>
                                <select name="sale_id" required class="form-control" onchange="findSaleDue(this.value)">
                                    <option value="">Select Sale</option>
                                    <?php foreach ($all_sales as $value) : ?>
                                        <option value="<?= $value['sale_id'] ?>"><?= $value['sale_description'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Transaction Date <span class="required">*</span></label>
                                <input type="date" name="transaction_date" required="required" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Paid <span class="required">*</span></label>
                                <input type="number" id="addTransaction" name="add_transaction" required="required" class="filter form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sale Due</label>
                                <input type="number" id="balance" name="balance" class="filter form-control">
                            </div>
                            <div class="form-group">
                                <label>Current Due</label>
                                <input type="number" id="totalBalance" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <button type="submit" id="submit" class="btn btn-sm btn-success">Save</button>
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
        var $form = $('#transaction'),
                hideShow = function () {
                    var balance = $('#balance').val();
                    var addTransaction = $('#addTransaction').val();

                    var total = Number(balance) - Number(addTransaction);
                    $('#totalBalance').val(total);
                };

        $form.find('.filter').on('keyup', hideShow);

        $('#submit').click(function (e) {
            e.preventDefault();
            $("#submit").attr("disabled", true);
            $("#submit").html('Processing..');
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>/domain/save_transaction',
                data: $('#transaction').serialize(),
                success: function (data)
                {
                    if (data === 'success') {
                        $("#submit").attr("disabled", true);
                        $('#notificationArea').html("<div class='alert alert-success' role='alert'>Saved!</div>");
                    } else {
                        $("#submit").attr("disabled", false);
                        $('#notificationArea').html("<div class='alert alert-danger' role='alert'>" + data + "</div>");
                    }
                    $("#submit").html('Save');
                }
            });
        });
    });
</script>