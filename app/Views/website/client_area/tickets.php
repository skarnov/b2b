<main id="main" class="mt-5">
    <section class="breadcrumbs">
        <div class="container">
            <ol>
                <li><a href="<?= base_url() ?>/client">Client Area</a></li>
                <li>Support Ticket</li>
            </ol>
            <h2>Support Ticket</h2>
        </div>
    </section>
    <section class="contact">
        <div class="container" data-aos="fade-up">
            <header class="section-header">
                <h2>Manage Your Support Tickets</h2>
                <p>Support Ticket Management</p>
            </header>
            <?php if (isset($admin_reply)) : ?>
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <strong>Ticket Reply</strong> <?php echo $admin_reply['ticket_content'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif ?>
            <div class="row gy-4">
                <div class="col-md-12">
                    <div class="form-group">
                        <a href="javascript;" data-bs-toggle="modal" data-bs-target="#newTicketModal" class="btn btn-success btn-sm" style="float: right">Create New Ticket</a>
                    </div>
                    <table class="table table-bordered border-primary mt-5">
                        <thead>
                            <tr>
                                <th scope="col">Service</th>
                                <th scope="col">Date</th>
                                <th scope="col">Support Ticket</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tickets as $ticket) : ?>
                                <tr>
                                    <td><?php echo $ticket['service_name'] ?></td>
                                    <td><?php echo date($settings['date_format'], strtotime($ticket['create_date'])) ?></td>
                                    <td><?php echo $ticket['ticket_content'] ?></td>
                                    <td class="text-capitalize">
                                        <?php if ($ticket['ticket_status'] == 'closed') : ?>
                                            <span class='badge badge-success' style="background-color: #198754;"><?php echo $ticket['ticket_status']; ?></span>
                                        <?php else : ?>
                                            <span class='badge badge-primary' style="background-color: #4154f1;"><?php echo $ticket['ticket_status']; ?></span>
                                        <?php endif ?>
                                    </td>
                                    <td class="text-capitalize text-right">
                                        <?php if ($ticket['ticket_status'] == 'closed') : ?>
                                            <a href="<?= base_url() ?>/client/ticket_reply/<?php echo $ticket['ticket_id'] ?>" class="btn btn-dark btn-sm">View</a>
                                        <?php else : ?>
                                            <a href="<?= base_url() ?>/client/ticket_reply/<?php echo $ticket['ticket_id'] ?>" class="btn btn-primary btn-sm">Reply</a>
                                        <?php endif ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="newTicketModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newTicketModalLabel">Create New Ticket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="newTicketForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="col-form-label">Service Name:</label>
                            <select name="service_name" required class="form-control">
                                <option value="">Select Service</option>
                                <?php foreach ($domains as $domain) : ?>
                                    <option value="<?php echo $domain['domain_name'] ?>"><?php echo 'Domain - ' . $domain['domain_name'] ?></option>
                                <?php endforeach ?>
                                <?php foreach ($hostings as $hosting) : ?>
                                    <option value="<?php echo $hosting['primary_domain'] . ' (' . $hosting['hosting_space'] . ')' ?>"><?php echo 'Hosting - ' . $hosting['primary_domain'] . ' (' . $hosting['hosting_space'] . ')' ?></option>
                                <?php endforeach ?>
                                <?php foreach ($services as $service) : ?>
                                    <option value="<?php echo $service['service_name'] ?>"><?php echo $service['service_name'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Problem Description:</label>
                            <textarea name="ticket_content" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                        <button type="submit" id="newTicketSubmit" class="btn btn-success">Submit</button>
                        <div id="newTicketmessage" class="col-md-12"></div>
                    </div>
                </form>
                <script>
                    jQ.push(function() {
                        $('#newTicketSubmit').click(function(e) {
                            e.preventDefault();
                            $("#newTicketSubmit").attr("disabled", true);
                            $("#newTicketSubmit").html('Processing..');
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo base_url() ?>/client/save_ticket',
                                data: $('#newTicketForm').serialize(),
                                success: function(data) {
                                    if (data === 'success') {
                                        $("#newTicketSubmit").html('Submit');
                                        $("#newTicketSubmit").attr("disabled", true);
                                        $('#newTicketmessage').show();
                                        $('#newTicketmessage').html("<div class='alert alert-success' role='alert'>Support ticket has been placed. We will get back to you shortly.</div>");
                                    } else {
                                        $("#newTicketSubmit").html('Submit');
                                        $("#newTicketSubmit").attr("disabled", false);
                                        $('#newTicketmessage').show();
                                        $('#newTicketmessage').html("<div class='alert alert-danger' role='alert'>" + data + "</div>");
                                    }
                                }
                            });
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</main>