<!-- Page Content -->
<div class="right_col" role="main">
    <div class="page-title">
        <div class="title_left">
            <h3><?= $title ?></h3>
        </div>
        <div class="title_right">
            <div class="form-group pull-right top_search">
                <div class="btn-group btn-group-sm" role="group">
                    <a href="<?= base_url() ?>/service" class="btn btn-secondary btn-xs">Service Management</a>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <form id="service" class="form-horizontal form-label-left">
                <div class="x_panel">
                    <div class="x_content">
                        <div id="notificationArea"></div>
                        <div class="col-md-2">
                            <div class="nav nav-tabs flex-column bar_tabs" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active" id="v-pills-basic-tab" data-toggle="pill" href="#v-pills-basic" role="tab" aria-controls="v-pills-basic" aria-selected="true">Basic</a>
                                <a class="nav-link" id="v-pills-panel-tab" data-toggle="pill" href="#v-pills-panel" role="tab" aria-controls="v-pills-panel" aria-selected="false">Panel</a>
                                <a class="nav-link" id="v-pills-comment-tab" data-toggle="pill" href="#v-pills-comment" role="tab" aria-controls="v-pills-comment" aria-selected="false">Comments</a>
                                <a class="nav-link" id="v-pills-sale-tab" data-toggle="pill" href="#v-pills-sale" role="tab" aria-controls="v-pills-sale" aria-selected="false">Sale</a>
                                <a class="nav-link" id="v-pills-transaction-tab" data-toggle="pill" href="#v-pills-transaction" role="tab" aria-controls="v-pills-transaction" aria-selected="false">Transaction</a>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-basic" role="tabpanel" aria-labelledby="v-pills-basic-tab">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Service Name <span class="required">*</span></label>
                                            <input type="text" name="service_name" required class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Service URL <span class="required">*</span></label>
                                            <input type="text" name="service_url" required class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Customer <span class="required">*</span></label>
                                            <select name="user_id" required class="form-control">
                                                <option value="">Select Customer</option>
                                                <?php foreach ($all_users as $value) : ?>
                                                    <option value="<?php echo $value['user_id'] ?>"><?php echo $value['first_name'] . ' ' . $value['last_name'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Expiry Date</label>
                                            <input type="date" name="expiry_date" required class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="status" class="form-control">
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-panel" role="tabpanel" aria-labelledby="v-pills-panel-tab">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Service Username</label>
                                            <input type="text" name="service_username" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Service Password</label>
                                            <input type="text" name="service_password" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-comment" role="tabpanel" aria-labelledby="v-pills-comment-tab">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Note</label>
                                            <textarea name="note" id="note" class="form-control no-resize"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-sale" role="tabpanel" aria-labelledby="v-pills-sale-tab">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Buying Price</label>
                                            <input type="number" id="buyingPrice" name="buying_price" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Sale Price</label>
                                            <input type="number" id="netPrice" name="net_price" class="calculate form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Discount Amount</label>
                                            <input type="number" id="discountAmount" name="discount_amount" class="calculate form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Sale Due</label>
                                            <input type="number" id="saleDue" name="sale_due" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-transaction" role="tabpanel" aria-labelledby="v-pills-transaction-tab">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Transaction Date <span class="required">*</span></label>
                                            <input type="date" name="transaction_date" required class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Paid Amount</label>
                                            <input type="number" id="paidAmount" name="paid_amount" class="calculate form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Due Amount</label>
                                            <input type="number" id="dueAmount" name="due_amount" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Transaction Amount</label>
                                            <input type="number" id="transactionAmount" name="transaction_amount" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Income Amount</label>
                                            <input type="number" id="incomeAmount" name="income_amount" class="form-control">
                                        </div>
                                    </div>
                                </div>
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
    jQ.push(function() {
        tinymce.init({
            selector: 'textarea#note',
            plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
            imagetools_cors_hosts: ['picsum.photos'],
            menubar: 'file edit view insert format tools table help',
            toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
            toolbar_sticky: true,
            autosave_ask_before_unload: true,
            autosave_interval: "30s",
            autosave_prefix: "{path}{query}-{id}-",
            autosave_restore_when_empty: false,
            autosave_retention: "2m",
            image_advtab: true,
            importcss_append: true,
            height: 400,
            image_caption: true,
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
            noneditable_noneditable_class: "mceNonEditable",
            toolbar_mode: 'sliding',
            contextmenu: "link image imagetools table",
            setup: function(editor) {
                editor.on('change', function() {
                    editor.save();
                });
            }
        });

        var $form = $('#service'),
            hideShow = function() {
                var discountAmount = $('#discountAmount').val();
                var netPrice = $('#netPrice').val();

                var total = Number(netPrice) - Number(discountAmount);
                $('#saleDue').val(total);

                $('#transactionAmount').val(total);
                var paidAmount = $('#paidAmount').val();
                $('#dueAmount').val(total - Number(paidAmount));

                var buyingPrice = $('#buyingPrice').val();
                $('#incomeAmount').val(paidAmount - buyingPrice);
            };

        $form.find('.calculate').on('keyup', hideShow);

        $('#submit').click(function(e) {
            e.preventDefault();
            $("#submit").attr("disabled", true);
            $("#submit").html('Processing..');
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>/service/save_service',
                data: $('#service').serialize(),
                success: function(data) {
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