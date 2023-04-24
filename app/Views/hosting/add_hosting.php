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
            <form id="hosting" method="post" data-parsley-validate class="form-horizontal form-label-left">
                <div class="x_panel">
                    <div class="x_content">
                        <div id="notificationArea"></div>
                        <div class="col-md-2">
                            <div class="nav nav-tabs flex-column bar_tabs" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active" id="v-pills-basic-tab" data-toggle="pill" href="#v-pills-basic" role="tab" aria-controls="v-pills-basic" aria-selected="true">Basic</a>
                                <a class="nav-link" id="v-pills-cpanel-tab" data-toggle="pill" href="#v-pills-cpanel" role="tab" aria-controls="v-pills-cpanel" aria-selected="false">Hosting Panel</a>
                                <a class="nav-link" id="v-pills-email-tab" data-toggle="pill" href="#v-pills-email" role="tab" aria-controls="v-pills-email" aria-selected="false">Email Panel</a>
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
                                            <label>Partner <span class="required">*</span></label>
                                            <select name="partner_id" required class="form-control">
                                                <option value="">Select Partner</option>
                                                <?php foreach ($all_partners as $value) : ?>
                                                    <option value="<?= $value['partner_id'] ?>"><?= $value['partner_name'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Primary Domain <span class="required">*</span></label>
                                            <input type="text" name="primary_domain" required="required" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Hosting Space <span class="required">*</span></label>
                                            <input type="text" name="hosting_space" required="required" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Renew Date <span class="required">*</span></label>
                                            <input type="date" name="renew_date" required="required" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Hosting Email <span class="required">*</span></label>
                                            <input type="text" name="hosting_email" required="required" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Customer <span class="required">*</span></label>
                                            <select name="user_id" required class="form-control">
                                                <option value="">Select Customer</option>
                                                <?php foreach ($all_users as $value) : ?>
                                                    <option value="<?= $value['user_id'] ?>"><?= $value['first_name'] . ' ' . $value['last_name'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Hosting Mobile <span class="required">*</span></label>
                                            <input type="number" name="hosting_mobile" required="required" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Renew For</label>
                                            <select name="renew_for" class="form-control">
                                                <option value="1 Year">1 Year</option>
                                                <?php for ($i = 2; $i <= 10; $i++) : ?>
                                                    <option value="<?= $i . ' Years' ?>"><?= $i ?> Years</option>
                                                <?php endfor ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Expiry Date <span class="required">*</span></label>
                                            <input type="date" name="expiry_date" required="required" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Package</label>
                                            <select name="package_id" class="form-control">
                                                <option value="">Select Package</option>
                                                <?php foreach ($all_packages as $value) : ?>
                                                    <option value="<?= $value['package_id'] ?>"><?= $value['package_name'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="status" class="form-control">
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                                <option value="deleted">Deleted</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-cpanel" role="tabpanel" aria-labelledby="v-pills-cpanel-tab">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Hosting Panel Access URL</label>
                                            <input type="text" name="cpanel_url" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Hosting Panel Username</label>
                                            <input type="text" name="cpanel_username" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Hosting Panel Password</label>
                                            <input type="text" name="cpanel_password" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-email" role="tabpanel" aria-labelledby="v-pills-email-tab">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Email Panel Access URL</label>
                                            <input type="text" name="email_url" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Email Panel Username</label>
                                            <input type="text" name="email_username" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Email Panel Password</label>
                                            <input type="text" name="email_password" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-comment" role="tabpanel" aria-labelledby="v-pills-comment-tab">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Note</label>
                                            <textarea name="note" id="note" class="form-control"></textarea>
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
                                            <input type="number" id="netPrice" name="net_price" class="filter form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Discount Amount</label>
                                            <input type="number" id="discountAmount" name="discount_amount" class="filter form-control">
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
                                            <input type="date" name="transaction_date" required="required" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Paid Amount</label>
                                            <input type="number" id="paidAmount" name="paid_amount" class="filter form-control">
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

        var $form = $('#hosting'),
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
        $form.find('.filter').on('keyup', hideShow);

        $('#submit').click(function(e) {
            e.preventDefault();
            $("#submit").attr("disabled", true);
            $("#submit").html('Processing..');
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>/hosting/save_hosting',
                data: $('#hosting').serialize(),
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