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
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-basic" role="tabpanel" aria-labelledby="v-pills-basic-tab">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Service Name <span class="required">*</span></label>
                                            <input type="text" name="service_name" required value="<?= $service_info['service_name'] ?>" class="form-control">
                                            <input type="hidden" name="service_id" required value="<?= $service_info['service_id'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Service URL <span class="required">*</span></label>
                                            <input type="text" name="service_url" required value="<?= $service_info['service_url'] ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Expiry Date</label>
                                            <input type="date" name="expiry_date" required value="<?= $service_info['expiry_date'] ?>" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="status" class="form-control">
                                                <option value="active" <?= $service_info['service_status'] == 'active' ? 'selected' : '' ?>>Active</option>
                                                <option value="inactive" <?= $service_info['service_status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-panel" role="tabpanel" aria-labelledby="v-pills-panel-tab">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Service Username</label>
                                            <input type="text" name="service_username" value="<?= $service_info['service_name'] ?>" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Service Password</label>
                                            <input type="text" name="service_password" value="<?= $service_info['service_password'] ?>" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-comment" role="tabpanel" aria-labelledby="v-pills-comment-tab">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Note</label>
                                            <textarea name="note" id="note" class="form-control no-resize"><?= $service_info['service_note'] ?></textarea>
                                        </div>
                                    </div>
                                </div>  
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

        $('#submit').click(function (e) {
            e.preventDefault();
            $("#submit").attr("disabled", true);
            $("#submit").html('Processing..');
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>/service/update_service',
                data: $('#service').serialize(),
                success: function (data)
                {
                    if (data === 'success') {
                        $("#submit").attr("disabled", true);
                        $('#notificationArea').html("<div class='alert alert-primary' role='alert'>Updated!</div>");
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