<main id="main" class="mt-5">
    <section class="breadcrumbs">
        <div class="container">
            <ol>
                <li><a href="<?= base_url() ?>/client">Client Area</a></li>
                <li><a href="<?= base_url() ?>/client/tickets">Support Ticket</a></li>
            </ol>
            <h2><?= $ticket_info['service_name'] ?></h2>
        </div>
    </section>
    <section id="blog" class="blog">
        <div class="container aos-init aos-animate" data-aos="fade-up">
            <header class="section-header">
                <p style="font-size: 23px; line-height: 20px;">Support Ticket Details</p>
            </header>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-2">
                        <div class="card-header bg-primary text-white text-center" style="background-color: #012970 !important;">
                            <span class="text-capitalize text-bold">Problem Description / </span>
                            <time><?php echo date($settings['date_format'], strtotime($ticket_info['create_date'])) . ', ' . date($settings['time_format'], strtotime($ticket_info['create_time'])) ?></time>
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
                                    <span class="text-capitalize text-bold"><?= $user_name ?> / </span>
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
                    <?php if ($ticket_info['ticket_status'] == 'open') : ?>
                        <form id="editTicket">
                            <div class="row gy-4">
                                <div class="col-md-12 mt-5">
                                    <label class="mb-2">Customer Reply:</label>
                                    <input type="hidden" name="ticket_id" value="<?= $ticket_info['ticket_id'] ?>">
                                    <input type="hidden" name="service_name" value="<?= $ticket_info['service_name'] ?>">
                                    <textarea name="reply" class="form-control"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" id="editTicketButton" class="btn btn-danger btn-sm">Submit</button>
                                    <div id="editTicketMessage" class="col-md-12 mt-2"></div>
                                </div>
                            </div>
                        </form>
                    <?php endif ?>
                    <script>
                        jQ.push(function() {
                            $('#editTicketButton').click(function(e) {
                                e.preventDefault();
                                $("#editTicketButton").attr("disabled", true);
                                $("#editTicketButton").html('Processing..');
                                $.ajax({
                                    type: 'POST',
                                    url: '<?php echo base_url() ?>/client/update_reply',
                                    data: $('#editTicket').serialize(),
                                    success: function(data) {
                                        if (data === 'success') {
                                            $("#editTicketButton").attr("disabled", true);
                                            $("#editTicketButton").html('Submit');
                                            $('#editTicketMessage').html("<div class='alert alert-success' role='alert'>Thank you! We will get back to you shortly</div>");
                                        } else {
                                            $("#editTicketButton").attr("disabled", false);
                                            $("#editTicketButton").html('Submit');
                                            $('#editTicketMessage').html("<div class='alert alert-danger' role='alert'>" + data + "</div>");
                                        }
                                    }
                                });
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </section>
</main>