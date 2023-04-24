<!-- Page Content -->
<div class="right_col" role="main">
    <div class="page-title">
        <div class="title_left">
            <h3><?= $title ?></h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <form id="admin_form" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left">
                <div class="x_panel">
                    <div class="x_content">
                        <div class="col-md-12">
                            <div id="notificationArea"></div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name <span class="required">*</span></label>
                                    <input type="text" name="first_name" required value="<?= $admin_info['first_name'] ?>" class="form-control">
                                    <input type="hidden" name="previous_image" value="<?= $admin_info['admin_image'] ?>">
                                </div>
                                <div class="form-group">
                                    <label>User Name <span class="required">*</span></label>
                                    <input type="text" name="user_name" required value="<?= $admin_info['user_name'] ?>" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Password <span class="required">*</span></label>
                                    <input type="password" name="admin_password" required value="<?= $admin_info['admin_password'] ?>" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Sex</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="sex" value="male" <?= $admin_info['admin_sex'] == 'male' ? 'checked' : '' ?> class="flat"> Male<br/>
                                            <input type="radio" name="sex" value="female" <?= $admin_info['admin_sex'] == 'female' ? 'checked' : '' ?> class="flat"> Female
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Image</label>
                                    <?php if ($admin_info['admin_image']): ?>
                                        <img src="<?= base_url() . '/uploads/profile_image/' . $admin_info['admin_image'] ?>" class="img-thumbnail"/>
                                    <?php else: ?>
                                        <img src="<?= base_url() . '/assets/backend/img/default/user.png' ?>" class="img-thumbnail"/>
                                    <?php endif ?>
                                    <input type="file" id="uploadImage" name="image" class="file-upload form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Last Name <span class="required">*</span></label>
                                    <input type="text" name="last_name" required value="<?= $admin_info['last_name'] ?>" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Mobile <span class="required">*</span></label>
                                    <input type="number" name="admin_mobile" required value="<?= $admin_info['admin_mobile'] ?>" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Email <span class="required">*</span></label>
                                    <input type="text" name="admin_email" required value="<?= $admin_info['admin_email'] ?>" required class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="status" value="active" <?= $admin_info['admin_status'] == 'active' ? 'checked' : '' ?>  class="flat"> Active<br/>
                                            <input type="radio" name="status" value="inactive" <?= $admin_info['admin_status'] == 'inactive' ? 'checked' : '' ?>  class="flat"> Inactive
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea name="admin_address" class="no-resize form-control"><?= $admin_info['admin_address'] ?></textarea>
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
        $('#submit').click(function () {
            $('#admin_form').ajaxForm({
                target: '#notificationArea',
                url: '<?= base_url() ?>/dashboard/update_profile',
                beforeSubmit: function () {
                    var percentValue = '0%';
                    $('#notificationArea').hide();
                    $('#progressDivId').css('display', 'block');
                    $('#progressBar').width(percentValue);
                    $('#percent').html(percentValue);
                    $('#submit').attr('disabled', true);
                    $('#submit').html('Processing..');
                },
                uploadProgress: function (event, position, total, percentComplete) {
                    var percentValue = percentComplete + '%';
                    $('#progressBar').animate({
                        width: '' + percentValue + ''
                    }, {
                        duration: 5000,
                        easing: 'linear',
                        step: function (x) {
                            percentText = Math.round(x * 100 / percentComplete);
                            $('#percent').text(percentText + "%");
                            if (percentText == '100') {
                                $('#notificationArea').show();
                                $('#submit').html('Update');
                                $('#submit').attr('disabled', false);
                            }
                        }
                    });
                },
                error: function (xhr) {
                    $('#progressDivId').hide();
                    $('#notificationArea').html("<div class='alert alert-danger'>" + xhr.responseText + "</div>");
                },
            });
        });
    });
</script>