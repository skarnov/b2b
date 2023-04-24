<!-- Page Content -->
<div class="right_col" role="main">
    <div class="page-title">
        <div class="title_left">
            <h3><?= $title ?></h3>
        </div>
        <div class="title_right">
            <div class="form-group pull-right top_search">
                <div class="btn-group btn-group-sm" role="group">
                    <a href="<?= base_url() ?>/user" class="btn btn-secondary btn-xs">Users Database</a>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <form id="user" method="post" enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">
                <div class="x_panel">
                    <div class="x_content">
                        <div id="notificationArea"></div>
                        <div class="col-md-2">
                            <div class="nav nav-tabs flex-column bar_tabs" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active" id="v-pills-basic-tab" data-toggle="pill" href="#v-pills-basic" role="tab" aria-controls="v-pills-basic" aria-selected="true">Basic</a>
                                <a class="nav-link" id="v-pills-contact-tab" data-toggle="pill" href="#v-pills-contact" role="tab" aria-controls="v-pills-contact" aria-selected="false">Contact Info</a>
                                <a class="nav-link" id="v-pills-comment-tab" data-toggle="pill" href="#v-pills-comment" role="tab" aria-controls="v-pills-comment" aria-selected="false">Comments</a>
                                <a class="nav-link" id="v-pills-social-tab" data-toggle="pill" href="#v-pills-social" role="tab" aria-controls="v-pills-social" aria-selected="false">Social Media</a>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-basic" role="tabpanel" aria-labelledby="v-pills-basic-tab">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>First Name <span class="required">*</span></label>
                                            <input type="text" name="first_name" required="required" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>User Name <span class="required">*</span></label>
                                            <input type="text" name="user_name" required="required" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Password <span class="required">*</span></label>
                                            <input type="password" name="user_password" required="required" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Sex</label>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" class="flat" checked name="sex" value="male"> Male<br />
                                                    <input type="radio" class="flat" name="sex" value="female"> Female
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Image</label>
                                            <input type="file" id="uploadImage" name="image" class="file-upload form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Last Name <span class="required">*</span></label>
                                            <input type="text" name="last_name" required="required" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Mobile <span class="required">*</span></label>
                                            <input type="number" name="user_mobile" required="required" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Email <span class="required">*</span></label>
                                            <input type="text" name="user_email" required="required" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Status</label>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" class="flat" checked name="status" value="active"> Active<br />
                                                    <input type="radio" class="flat" name="status" value="inactive"> Inactive<br />
                                                    <input type="radio" class="flat" name="status" value="archive"> Archive
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Address</label>
                                            <textarea name="user_address" class="no-resize form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-contact" role="tabpanel" aria-labelledby="v-pills-contact-tab">
                                    <div class="card">
                                        <div class="card-body">
                                            <a href="javascript:;" id="addFile" class="btn btn-sm btn-primary">+ Add File</a>
                                            <div id="fileForm"></div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <a href="javascript:;" id="addEmail" class="btn btn-sm btn-primary">+ Add Additional Email</a>
                                            <div id="emailForm"></div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <a href="javascript:;" id="addMobile" class="btn btn-sm btn-primary">+ Add Additional Mobile</a>
                                            <div id="mobileForm"></div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <a href="javascript:;" id="addAddress" class="btn btn-sm btn-primary">+ Add Additional Address</a>
                                            <div id="addressForm"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-comment" role="tabpanel" aria-labelledby="v-pills-comment-tab">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Office Name</label>
                                            <input type="text" name="meta[office_name]" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Note</label>
                                            <textarea name="meta[note]" id="note" class="form-control"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Comments</label>
                                            <textarea name="meta[comments]" class="no-resize form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-social" role="tabpanel" aria-labelledby="v-pills-social-tab">
                                    <div class="form-group">
                                        <label>Facebook Link</label>
                                        <input type="text" name="meta[facebook_url]" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>LinkedIn Link</label>
                                        <input type="text" name="meta[linkedin_url]" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>WhatsApp Number</label>
                                        <input type="number" name="meta[whatsapp_number]" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>IMO Number</label>
                                        <input type="number" name="meta[imo_number]" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="ln_solid"></div>
                        <div class="form-group progress" id="progressDivId">
                            <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            <div class='percent' id='percent'>0%</div>
                        </div>
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

        $('#addFile').one('click', function(event) {
            event.preventDefault();
            var fileForm = "<br/><div class='form-group'>\
                                <label>File Name</label>\
                                <input type='text' name='file_name' class='form-control'>\
                            </div>\
                            <div class='form-group'>\
                                <label>Upload File</label>\
                                <input type='file' name='file_upload' class='form-control'>\
                            </div>";

            $('#fileForm').append(fileForm);
            $(this).prop('disable', true);
        });

        $('#addEmail').one('click', function(event) {
            event.preventDefault();
            var emailForm = "<br/><div class='form-group'>\
                                <label>Email Owner Name</label>\
                                <input type='text' name='more[email_owner]' class='form-control'>\
                            </div>\
                            <div class='form-group'>\
                                <label>Email Address</label>\
                                <input type='email' name='more[email_address]' class='form-control'>\
                            </div>";

            $('#emailForm').append(emailForm);
            $(this).prop('disable', true);
        });

        $('#addMobile').one('click', function(event) {
            event.preventDefault();
            var mobileForm = "<br/><div class='form-group'>\
                                <label>Mobile Owner Name</label>\
                                <input type='text' name='more[mobile_owner]' class='form-control'>\
                            </div>\
                            <div class='form-group'>\
                                <label>Mobile Number</label>\
                                <input type='number' name='more[mobile_number]' class='form-control'>\
                            </div>";

            $('#mobileForm').append(mobileForm);
            $(this).prop('disable', true);
        });

        $('#addAddress').one('click', function(event) {
            event.preventDefault();
            var addressForm = "<br/><div class='form-group'>\
                                <label>Address Type</label>\
                                <input type='text' name='more[address_type]' class='form-control'>\
                            </div>\
                            <div class='form-group'>\
                                <label>Address Name</label>\
                                <textarea name='more[address_name]' class='no-resize form-control'></textarea>\
                            </div>";

            $('#addressForm').append(addressForm);
            $(this).prop('disable', true);
        });

        $('#submit').click(function() {
            $('#user').ajaxForm({
                target: '#notificationArea',
                url: '<?= base_url() ?>/user/save_user',
                beforeSubmit: function() {
                    var percentValue = '0%';
                    $('#notificationArea').hide();
                    $('#progressDivId').css('display', 'block');
                    $('#progressBar').width(percentValue);
                    $('#percent').html(percentValue);
                    $('#submit').attr('disabled', true);
                    $('#submit').html('Processing..');
                },
                uploadProgress: function(event, position, total, percentComplete) {
                    var percentValue = percentComplete + '%';
                    $('#progressBar').animate({
                        width: '' + percentValue + ''
                    }, {
                        duration: 5000,
                        easing: 'linear',
                        step: function(x) {
                            percentText = Math.round(x * 100 / percentComplete);
                            $('#percent').text(percentText + "%");
                            if (percentText == '100') {
                                $('#notificationArea').show();
                                $('#submit').html('Save');
                            }
                        }
                    });
                },
                error: function(xhr) {
                    $('#progressDivId').hide();
                    $('#notificationArea').html("<div class='alert alert-danger'>" + xhr.responseText + "</div>");
                },
            });
        });
    });
</script>