<!-- Page Content -->
<div class="right_col" role="main">
    <div class="page-title">
        <div class="title_left">
            <h3><?= $title ?></h3>
        </div>
        <div class="title_right">
            <div class="form-group pull-right top_search">
                <div class="btn-group btn-group-sm" role="group">
                    <a href="<?= base_url() ?>/ticket" class="btn btn-secondary btn-xs">Manage Tickets</a>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <form id="ticket" method="post" data-parsley-validate class="form-horizontal form-label-left">
                <div class="x_panel">
                    <div class="x_content">
                        <div id="notificationArea"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Service Name <span class="required">*</span></label>
                                <input type="hidden" name="ticket_id" value="<?php echo $ticket_info['ticket_id'] ?>" class="form-control">
                                <input type="text" name="service_name" value="<?php echo $ticket_info['service_name'] ?>" class="form-control">
                            </div>
                            <div class="card mb-2">
                                <div class="card-header bg-dark text-white">
                                    <span class="text-capitalize text-bold">Problem Description / </span>
                                    <time style="font-size: 10px;"><?php echo date($settings['date_format'], strtotime($ticket_info['create_date'])) . ', ' . date($settings['time_format'], strtotime($ticket_info['create_time'])) ?></time>
                                </div>
                                <div class="card-body">
                                    <p class="card-text"><?php echo $ticket_info['ticket_content'] ?></p>
                                </div>
                            </div>

                            <?php
                            foreach ($ticket_replies as $value) :
                                if ($value['fk_user_id']) :
                            ?>
                                    <div class="card mb-2">
                                        <div class="card-header bg-primary text-white">
                                            <span class="text-capitalize text-bold">Client / </span>
                                            <time><?php echo date($settings['date_format'], strtotime($value['create_date'])) . ', ' . date($settings['time_format'], strtotime($value['create_time'])) ?></time>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text"><?php echo $value['ticket_content'] ?></p>
                                        </div>
                                    </div>
                                <?php
                                else :
                                ?>
                                    <div class="card mb-2">
                                        <div class="card-header bg-success text-white">
                                            <span class="text-capitalize text-bold">Admin / </span>
                                            <time><?php echo date($settings['date_format'], strtotime($value['create_date'])) . ', ' . date($settings['time_format'], strtotime($value['create_time'])) ?></time>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text"><?php echo $value['ticket_content'] ?></p>
                                        </div>
                                    </div>
                            <?php
                                endif;
                            endforeach
                            ?>
                            <div class="form-group">
                                <label>Status</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" class="flat" <?php echo ($ticket_info['ticket_status'] == 'open') ? 'checked' : '' ?> name="status" value="open"> Open<br />
                                        <input type="radio" class="flat" <?php echo ($ticket_info['ticket_status'] == 'closed') ? 'checked' : '' ?> name="status" value="closed"> Closed
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Admin Reply</label>
                                <textarea name="reply" id="ticketReply" class="form-control" style="min-height: 10em"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <button type="submit" id="submit" class="btn btn-sm btn-primary">Reply</button>
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
            selector: 'textarea#ticketReply',
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

        $('#submit').click(function(e) {
            e.preventDefault();
            $("#submit").attr("disabled", true);
            $("#submit").html('Processing..');
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>/ticket/update_ticket',
                data: $('#ticket').serialize(),
                success: function(data) {
                    if (data === 'success') {
                        $("#submit").attr("disabled", true);
                        $('#notificationArea').html("<div class='alert alert-primary' role='alert'>Replied!</div>");
                    } else {
                        $("#submit").attr("disabled", false);
                        $('#notificationArea').html("<div class='alert alert-danger' role='alert'>" + data + "</div>");
                    }
                    $("#submit").html('Reply');
                }
            });
        });
    });
</script>