<main id="main" class="mt-5">
    <section class="breadcrumbs">
        <div class="container">
            <ol>
                <li><a href="<?= base_url() ?>">Home</a></li>
                <li>Domain Registration</li>
            </ol>
            <h2>Domain Registration</h2>
        </div>
    </section>
    <section id="domain" class="features">
        <div class="container" data-aos="fade-up">
            <header class="section-header">
                <h2>We provide domain control panel</h2>
                <p>Domain Registration</p>
            </header>
            <div class="row gy-4">
                <div class="col-lg-6">
                    <div class="feture-tabs" data-aos="fade-up">
                        <!-- Tabs -->
                        <ul class="nav nav-pills">
                            <li>
                                <a class="nav-link active" data-bs-toggle="pill" href="#tab1">Domain Registration</a>
                            </li>
                            <li>
                                <a class="nav-link" data-bs-toggle="pill" href="#tab2">Domain Transfer</a>
                            </li>
                        </ul>
                        <!-- End Tabs -->
                        <!-- Tab Content -->
                        <div class="tab-content">
                            <!-- Start Domain Registration -->
                            <div class="tab-pane fade show active" id="tab1">
                                <form id="domainCheck">
                                    <div class="form-group mt-3">
                                        <input type="text" name="domain_name" id="domainSearch" class="form-control" placeholder="Write Your Desire Domain Name" required>
                                    </div>
                                    <div class="form-group mt-3">
                                        <input type="hidden" id="domain_availability_recaptcha_response" name="recaptcha_response" value="">
                                        <button type="submit" id="domainCheckButton" class="btn btn-dark">Check Availability</button>
                                    </div>
                                </form>
                                <div class="form-group mt-3">
                                    <div id="domainCheckMessage" style="display: none"></div>
                                </div>
                                <form id="domainOrder" style="display: none">
                                    <div class="row gy-4">
                                        <div class="col-md-12">
                                            <div class="alert alert-success" role="alert"><b><span id="domainFindSuccess"></span></b> domain is available! Please register as soon as possible</div>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="hidden" name="domain_name" id="domainOrderConfirm">
                                            <input type="text" name="name" required placeholder="Your Name" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="email" name="email" required placeholder="Your Email" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" name="mobile" required placeholder="Your Mobile Number" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <select name="validity" required class="form-control">
                                                <option name="">Select Validity</option>
                                                <option name="1">1 Yr</option>
                                                <option name="2">2 Yr</option>
                                                <option name="3">3 Yr</option>
                                                <option name="4">4 Yr</option>
                                                <option name="5">5 Yr</option>
                                                <option name="6">6 Yr</option>
                                                <option name="7">7 Yr</option>
                                                <option name="8">8 Yr</option>
                                                <option name="9">9 Yr</option>
                                                <option name="10">10 Yr</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12">
                                            <textarea name="address" required placeholder="Your Address" class="form-control"></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="hidden" id="domain_order_recaptcha_response" name="recaptcha_response" value="">
                                            <button type="submit" id="domainOrderButton" class="btn btn-danger">Confirm Order</button>
                                            <div id="domainOrderMessage" class="col-md-12 mt-2"></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <script>
                                jQ.push(function() {
                                    $('#domainCheckButton').click(function(e) {
                                        e.preventDefault();

                                        grecaptcha.ready(function() {
                                            grecaptcha.execute("<?= $settings['recaptcha_sitekey'] ?>", {
                                                action: 'submit'
                                            }).then(function(token) {
                                                $("#domain_availability_recaptcha_response").val(token);

                                                var domainSearch = $("#domainSearch").val();

                                                $("#domainCheckButton").attr("disabled", true);
                                                $("#domainCheckButton").html('Processing..');
                                                $.ajax({
                                                    type: 'POST',
                                                    url: '<?php echo base_url() ?>/home/domain_availability',
                                                    data: $('#domainCheck').serialize(),
                                                    success: function(data) {
                                                        if (data === 'success') {
                                                            $('#domainCheckMessage').html('');
                                                            $('#domainOrder').show();
                                                            $("#domainFindSuccess").html(domainSearch);
                                                            $("#domainOrderConfirm").val(domainSearch);
                                                        } else {
                                                            $("#domainCheckButton").html('Check Availability');
                                                            $("#domainCheckButton").attr("disabled", false);
                                                            $('#domainCheckMessage').show();
                                                            $('#domainCheckMessage').html("<div class='alert alert-danger' role='alert'>" + data + "</div>");
                                                        }
                                                    }
                                                });
                                            });
                                        });
                                    });

                                    $('#domainOrderButton').click(function(e) {
                                        e.preventDefault();

                                        grecaptcha.ready(function() {
                                            grecaptcha.execute("<?= $settings['recaptcha_sitekey'] ?>", {
                                                action: 'submit'
                                            }).then(function(token) {
                                                $("#domain_order_recaptcha_response").val(token);

                                                $("#domainOrderButton").attr("disabled", true);
                                                $("#domainOrderButton").html('Processing..');
                                                $.ajax({
                                                    type: 'POST',
                                                    url: '<?php echo base_url() ?>/home/domain_order',
                                                    data: $('#domainOrder').serialize(),
                                                    success: function(data) {
                                                        if (data === 'success') {
                                                            $("#domainOrderButton").html('Confirm Order');
                                                            $("#domainOrderButton").attr("disabled", true);
                                                            $('#domainOrderMessage').show();
                                                            $('#domainOrderMessage').html("<div class='alert alert-success mt-3' role='alert'>Congratulations! Domain Order Successful!</div>");
                                                        } else {
                                                            $("#domainOrderButton").html('Confirm Order');
                                                            $("#domainOrderButton").attr("disabled", false);
                                                            $('#domainOrderMessage').show();
                                                            $('#domainOrderMessage').html("<div class='alert alert-danger' role='alert'>" + data + "</div>");
                                                        }
                                                    }
                                                });
                                            });
                                        });
                                    });
                                });
                            </script>
                            <!-- End Domain Registration -->
                            <!-- Start Domain Transfer -->
                            <div class="tab-pane fade show" id="tab2">
                                <form id="domainTransfer">
                                    <div class="form-group mt-3">
                                        <input type="text" name="transfer_domain" id="transferDomain" class="form-control" placeholder="Write Your Domain Name" required>
                                    </div>
                                    <div class="form-group mt-3">
                                        <input type="hidden" id="domain_transfer_recaptcha_response" name="recaptcha_response" value="">
                                        <button type="submit" id="domainTransferButton" class="btn btn-dark">Start The Process</button>
                                    </div>
                                </form>
                                <div class="form-group mt-3">
                                    <div id="domainTransferMessage" style="display: none"></div>
                                </div>
                                <form id="domainTransferOrder" style="display: none">
                                    <div class="row gy-4">
                                        <div class="col-md-12">
                                            <div class="alert alert-success" role="alert">Congratulation! <b><span id="domainTransferSuccess"></span></b> is available for transfer!</div>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="hidden" name="domain_name" id="domainTransferOrderConfirm">
                                            <input type="text" name="name" required placeholder="Your Name" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="email" name="email" required placeholder="Your Email" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" name="mobile" required placeholder="Your Mobile Number" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <select name="validity" required class="form-control">
                                                <option name="">Select Validity</option>
                                                <option name="1">1 Yr</option>
                                                <option name="2">2 Yr</option>
                                                <option name="3">3 Yr</option>
                                                <option name="4">4 Yr</option>
                                                <option name="5">5 Yr</option>
                                                <option name="6">6 Yr</option>
                                                <option name="7">7 Yr</option>
                                                <option name="8">8 Yr</option>
                                                <option name="9">9 Yr</option>
                                                <option name="10">10 Yr</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12">
                                            <textarea name="address" required placeholder="Your Address" class="form-control"></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="hidden" id="domain_transfer_order_recaptcha_response" name="recaptcha_response" value="">
                                            <button type="submit" id="domainTransferOrderButton" class="btn btn-danger">Confirm Order</button>
                                            <div id="domainTransferOrderMessage" class="col-md-12 mt-2"></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <script>
                                jQ.push(function() {
                                    $('#domainTransferButton').click(function(e) {
                                        e.preventDefault();

                                        grecaptcha.ready(function() {
                                            grecaptcha.execute("<?= $settings['recaptcha_sitekey'] ?>", {
                                                action: 'submit'
                                            }).then(function(token) {
                                                $("#domain_transfer_recaptcha_response").val(token);

                                                var transferDomain = $("#transferDomain").val();

                                                $("#domainTransferButton").attr("disabled", true);
                                                $("#domainTransferButton").html('Processing..');
                                                $.ajax({
                                                    type: 'POST',
                                                    url: '<?php echo base_url() ?>/home/domain_transfer',
                                                    data: $('#domainTransfer').serialize(),
                                                    success: function(data) {
                                                        if (data === 'success') {
                                                            $('#domainTransferOrder').show();
                                                            $('#domainTransferMessage').html('');
                                                            $("#domainTransferSuccess").html(transferDomain);
                                                            $("#domainTransferOrderConfirm").val(transferDomain);
                                                        } else {
                                                            $("#domainTransferButton").html('Check Availability');
                                                            $("#domainTransferButton").attr("disabled", false);
                                                            $('#domainTransferMessage').show();
                                                            $('#domainTransferMessage').html("<div class='alert alert-danger' role='alert'>" + data + "</div>");
                                                        }
                                                    }
                                                });
                                            });
                                        });
                                    });

                                    $('#domainTransferOrderButton').click(function(e) {
                                        e.preventDefault();

                                        grecaptcha.ready(function() {
                                            grecaptcha.execute("<?= $settings['recaptcha_sitekey'] ?>", {
                                                action: 'submit'
                                            }).then(function(token) {
                                                $("#domain_transfer_order_recaptcha_response").val(token);

                                                $("#domainTransferOrderButton").attr("disabled", true);
                                                $("#domainTransferOrderButton").html('Processing..');
                                                $.ajax({
                                                    type: 'POST',
                                                    url: '<?php echo base_url() ?>/home/domain_transfer_order',
                                                    data: $('#domainTransferOrder').serialize(),
                                                    success: function(data) {
                                                        if (data === 'success') {
                                                            $("#domainTransferOrderButton").html('Confirm Order');
                                                            $("#domainTransferOrderButton").attr("disabled", true);
                                                            $('#domainTransferOrderMessage').show();
                                                            $('#domainTransferOrderMessage').html("<div class='alert alert-success mt-3' role='alert'>Congratulations! Domain Order Successful!</div>");
                                                        } else {
                                                            $("#domainTransferOrderButton").html('Confirm Order');
                                                            $("#domainTransferOrderButton").attr("disabled", false);
                                                            $('#domainTransferOrderMessage').show();
                                                            $('#domainTransferOrderMessage').html("<div class='alert alert-danger' role='alert'>" + data + "</div>");
                                                        }
                                                    }
                                                });
                                            });
                                        });
                                    });
                                });
                            </script>
                            <!-- End Domain Transfer -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h2>Desire online presence starts with domain name</h2>
                    <p>We are a registered domain company. So, we provide the domain panel where you can fully control your domain names.</p>
                    <a href="https://evistechnology.manage-orders.com/" class="btn btn-dark" title="Evis Technology Domain Panel" target="_blank">See Our Domain Panel</a>
                </div>
            </div>
        </div>
    </section>
</main>