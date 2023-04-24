<!-- Page Content -->
<div class="right_col" role="main">
    <div class="page-title">
        <div class="title_left">
            <h3><?php echo $title ?></h3>
        </div>
        <div class="title_right">
            <div class="form-group pull-right top_search">
                <div class="btn-group btn-group-sm" role="group">
                    <a href="<?php echo base_url() ?>/dashboard/roles_permissions" class="btn btn-secondary btn-xs">Manage Role & Permission</a>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <form id="role" method="post" class="form-horizontal form-label-left">
                <div class="x_panel">
                    <div class="x_content">
                        <div id="notificationArea"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Role Name <span class="required">*</span></label>
                                <input type="text" name="name" required="required" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Role Description</label>
                                <textarea name="description" class="form-control no-resize"></textarea>
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
        $('#submit').click(function (e) {
            e.preventDefault();
            $('#submit').attr('disabled', true);
            $('#submit').html('Processing..');
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>/dashboard/save_role',
                data: $('#role').serialize(),
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