<main id="main" class="mt-5">
    <section class="breadcrumbs">
        <div class="container">
            <ol>
                <li><a href="<?= base_url() ?>">Home</a></li>
                <li>Hosting Package</li>
            </ol>
            <h2>Hosting Package</h2>
        </div>
    </section>
    <!-- End Breadcrumbs -->

    <section id="hosting" class="pricing">
        <div class="container" data-aos="fade-up">
            <header class="section-header">
                <h2>Hosting</h2>
                <p>Check our Hosting Package</p>
                <h3 class="mt-3">We also provide custom Hosting Package</h3>
            </header>
            <div class="row gy-4" data-aos="fade-left">
                <?php
                $all_colors = array('07d5c0', '65c600', 'ff901c', 'ff0071');
                $i = 0;
                foreach ($all_packages as $package) :
                ?>
                    <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="100">
                        <div class="box">
                            <?= ($all_colors[$i] == 1) ? '<span class="featured">New</span>' : '' ?>
                            <h3 style="color: #<?= $all_colors[$i] ?>;"><?= $package['package_name'] ?></h3>
                            <div class="price"><sup>&#2547; </sup><?= $package['package_price'] ?><span> / yr</span></div>
                            <img src="<?= base_url() ?>/assets/frontend/img/pricing-free.png" class="img-fluid" alt="">
                            <ul>
                                <li><?= $package['website_host'] ?> Website</li>
                                <li><?= $package['database_host'] ?> Database</li>
                                <li><?= $package['package_storage'] ?> GB Storage</li>
                                <li><?= $package['ftp_account'] ?> FTP Account</li>
                                <li><?= $package['email_account'] ?> Email Accounts</li>
                            </ul>
                            <a href="javascript;" data-name="personal" data-bs-toggle="modal" data-bs-target="#buyHostingModal" class="package btn-buy">Buy Now</a>
                        </div>
                    </div>
                <?php endforeach;
                $i++ ?>
            </div>
        </div>
    </section>

    <div class="modal fade" id="buyHostingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="buyHostingModalLabel">Hosting Package Order <span id="packageName" class="text-capitalize"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="hostingOrder">
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="hidden" name="package_name" id="packageNameForm">
                            <label class="col-form-label">Your Name:</label>
                            <input type="text" required name="name" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Your Mobile:</label>
                            <input type="number" required name="mobile" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Describe Your Desire Custom Package (If Any):</label>
                            <textarea name="note" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Website Address:</label>
                            <input type="text" required name="website" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Your Email:</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="hidden" id="hosting_order_recaptcha_response" name="recaptcha_response" value="">
                        <button type="submit" id="hostingOrderButton" class="btn btn-danger">Confirm Order</button>
                        <div id="hostingOrdermessage" class="col-md-12"></div>
                    </div>
                </form>
                <script>
                    jQ.push(function() {
                        $(document).on('click', '.package', function() {
                            var packageName = $(this).attr('data-name');
                            $(".modal-header #packageName").html(packageName);
                            $(".modal-body #packageNameForm").val(packageName);
                        });

                        $('#hostingOrderButton').click(function(e) {
                            e.preventDefault();

                            grecaptcha.ready(function() {
                                grecaptcha.execute("<?= $settings['recaptcha_sitekey'] ?>", {
                                    action: 'submit'
                                }).then(function(token) {
                                    $("#hosting_order_recaptcha_response").val(token);

                                    $("#hostingOrderButton").attr("disabled", true);
                                    $("#hostingOrderButton").html('Processing..');
                                    $.ajax({
                                        type: 'POST',
                                        url: '<?php echo base_url() ?>/home/hosting_order',
                                        data: $('#hostingOrder').serialize(),
                                        success: function(data) {
                                            if (data === 'success') {
                                                $("#hostingOrderButton").html('Confirm');
                                                $("#hostingOrderButton").attr("disabled", true);
                                                $('#hostingOrdermessage').html("<div class='alert alert-success' role='alert'>Congratulations! Hosting order has been placed. We will get back to you shortly.</div>");
                                            } else {
                                                $("#hostingOrderButton").html('Confirm');
                                                $("#hostingOrderButton").attr("disabled", false);
                                                $('#hostingOrdermessage').show();
                                                $('#hostingOrdermessage').html("<div class='alert alert-danger' role='alert'>" + data + "</div>");
                                            }
                                        }
                                    });
                                });
                            });
                        });
                    });
                </script>
            </div>
        </div>
    </div>

    <section id="features" class="features">
        <div class="container aos-init aos-animate" data-aos="fade-up">
            <header class="section-header">
                <h2>Features</h2>
                <p>We provide white label affordable hosting</p>
            </header>
            <div class="row">
                <div class="col-lg-6">
                    <img src="<?= base_url() ?>/assets/frontend/img/features.png" class="img-fluid" alt="">
                </div>
                <div class="col-lg-6 mt-5 mt-lg-0 d-flex">
                    <div class="row align-self-center gy-4">
                        <div class="col-md-6 aos-init aos-animate" data-aos="zoom-out" data-aos-delay="200">
                            <div class="feature-box d-flex align-items-center">
                                <i class="bi bi-check"></i>
                                <h3>cPanel</h3>
                            </div>
                        </div>
                        <div class="col-md-6 aos-init aos-animate" data-aos="zoom-out" data-aos-delay="200">
                            <div class="feature-box d-flex align-items-center">
                                <i class="bi bi-check"></i>
                                <h3>FULL SSD Server</h3>
                            </div>
                        </div>
                        <div class="col-md-12 aos-init aos-animate" data-aos="zoom-out" data-aos-delay="300">
                            <div class="feature-box d-flex align-items-center">
                                <i class="bi bi-check"></i>
                                <h3>PHP Versions: 5.6, 7.2, 7.4, 8.0, 8.2</h3>
                            </div>
                        </div>
                        <div class="col-md-6 aos-init aos-animate" data-aos="zoom-out" data-aos-delay="400">
                            <div class="feature-box d-flex align-items-center">
                                <i class="bi bi-check"></i>
                                <h3>Modern PHP Extensions</h3>
                            </div>
                        </div>
                        <div class="col-md-6 aos-init aos-animate" data-aos="zoom-out" data-aos-delay="500">
                            <div class="feature-box d-flex align-items-center">
                                <i class="bi bi-check"></i>
                                <h3>Ruby Support</h3>
                            </div>
                        </div>
                        <div class="col-md-6 aos-init aos-animate" data-aos="zoom-out" data-aos-delay="600">
                            <div class="feature-box d-flex align-items-center">
                                <i class="bi bi-check"></i>
                                <h3>Python Support</h3>
                            </div>
                        </div>
                        <div class="col-md-6 aos-init aos-animate" data-aos="zoom-out" data-aos-delay="700">
                            <div class="feature-box d-flex align-items-center">
                                <i class="bi bi-check"></i>
                                <h3>NodeJS Support</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>