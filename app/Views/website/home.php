<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title><?php echo isset($title) ? $title : $settings['project_name'] ?></title>
    <meta name="description" content="<?php echo isset($meta_description) ? $meta_description : $settings['meta_description'] ?>" />

    <!-- Favicon -->
    <link href="<?= base_url() ?>/assets/frontend/img/favicon.ico" rel="icon">

    <!-- Vendor CSS Files -->
    <link href="<?= base_url() ?>/assets/frontend/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>/assets/frontend/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= base_url() ?>/assets/frontend/vendor/aos/aos.css" rel="stylesheet">
    <link href="<?= base_url() ?>/assets/frontend/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="<?= base_url() ?>/assets/frontend/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>/assets/frontend/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="<?= base_url() ?>/assets/frontend/css/style.css" rel="stylesheet">

    <!-- Google reCAPTCHA  -->
    <script src="https://www.google.com/recaptcha/api.js?render=<?= $settings['recaptcha_sitekey'] ?>"></script>

    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-L9JN3RPMEL"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-L9JN3RPMEL');
    </script>

    <!--Tawk-->
    <script>
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement('script'),
                s0 = document.getElementsByTagName('script')[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/60fd3df1d6e7610a49ace4da/1fbejjuna';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
</head>

<body>
    <script>
        var jQ = new Array();
    </script>
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top">
        <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
            <a href="<?= base_url() ?>" class="logo d-flex align-items-center">
                <span><?= $settings['project_name'] ?></span>
            </a>
            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto active" href="#home">Home</a></li>
                    <li><a class="nav-link scrollto" href="#softwareDevelopment">Software Development</a></li>
                    <li><a class="nav-link scrollto" href="<?= base_url() ?>#webDevelopment">Web Development</a></li>
                    <li><a class="nav-link scrollto" href="#domain">Domain</a></li>
                    <li><a class="nav-link scrollto" href="#hosting">Hosting</a></li>
                    <li><a class="getstarted scrollto" href="<?= base_url() ?>/client">Client Area</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav>
        </div>
    </header>
    <!-- End Header -->

    <!-- ======= Software Development ======= -->
    <section id="home" class="hero d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 d-flex flex-column justify-content-center">
                    <h1 data-aos="fade-up">We offer modern solutions for growing your business</h1>
                    <h2 data-aos="fade-up" data-aos-delay="400">We are a team of talented designers and developers making software and websites with modern technologies</h2>
                    <div data-aos="fade-up" data-aos-delay="600">
                        <div class="text-center text-lg-start">
                            <a href="#softwareDevelopment" class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                                <span>Get Started</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 hero-img" data-aos="zoom-out" data-aos-delay="200">
                    <img src="<?= base_url() ?>/assets/frontend/img/hero-img.png" class="img-fluid" alt="">
                </div>
            </div>
        </div>
    </section>
    <!-- End Software Development -->

    <main id="main">
        <!-- ======= Software Section ======= -->
        <section id="softwareDevelopment" class="about">
            <div class="container" data-aos="fade-up">
                <div class="row gx-0">
                    <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
                        <div class="content">
                            <h3>Software Development</h3>
                            <h2>We are experienced to provide the best solution for your company. Appropriate software will accelerate your Business. Transform your ideas into the Software and secure your desire Business growth.</h2>
                            <p>It is undoubtedly true that software is made to reduce Business problems and make it easy to operate Business operations. Any Business needs sophisticated software for better Business operation and calculation.</p>
                            <div class="text-center text-lg-start">
                                <a href="<?= base_url() ?>/software-development" class="btn-read-more d-inline-flex align-items-center justify-content-center align-self-center">
                                    <span>Read More</span>
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="200">
                        <img src="<?= base_url() ?>/assets/frontend/img/about.jpg" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </section>
        <!-- End Software Section -->

        <!-- ======= Project Section ======= -->
        <section id="counts" class="counts">
            <div class="container" data-aos="fade-up">
                <div class="row gy-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="count-box">
                            <i class="bi bi-emoji-smile"></i>
                            <div>
                                <span data-purecounter-start="0" data-purecounter-end="232" data-purecounter-duration="1" class="purecounter"></span>
                                <p>Happy Clients</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="count-box">
                            <i class="bi bi-journal-richtext" style="color: #ee6c20;"></i>
                            <div>
                                <span data-purecounter-start="0" data-purecounter-end="521" data-purecounter-duration="1" class="purecounter"></span>
                                <p>Projects</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="count-box">
                            <i class="bi bi-headset" style="color: #15be56;"></i>
                            <div>
                                <span data-purecounter-start="0" data-purecounter-end="1463" data-purecounter-duration="1" class="purecounter"></span>
                                <p>Hours of Support</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="count-box">
                            <i class="bi bi-people" style="color: #bb0852;"></i>
                            <div>
                                <span data-purecounter-start="0" data-purecounter-end="15" data-purecounter-duration="1" class="purecounter"></span>
                                <p>Hard Workers</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Project Section -->

        <!-- ======= Web Development Section ======= -->
        <section id="webDevelopment" class="features">
            <div class="container" data-aos="fade-up">
                <div class="row feature-icons" data-aos="fade-up">
                    <header class="section-header">
                        <h2>Web Development</h2>
                        <p>Bring a effective Website for your Business</p>
                    </header>
                    <div class="row">
                        <div class="col-xl-4 text-center" data-aos="fade-right" data-aos-delay="100">
                            <img src="<?= base_url() ?>/assets/frontend/img/features-3.png" class="img-fluid p-4" alt="Web Development">
                        </div>
                        <div class="col-xl-8 d-flex content">
                            <div class="row align-self-center gy-4">
                                <div class="col-md-6 icon-box" data-aos="fade-up">
                                    <i class="ri-line-chart-line"></i>
                                    <div>
                                        <h4>Consultant Service</h4>
                                        <p class="text-justify">We provide expert advice on design, development, and marketing. Our client enjoys better search engine rankings and higher website traffic.</p>
                                    </div>
                                </div>
                                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="100">
                                    <i class="ri-stack-line"></i>
                                    <div>
                                        <h4>Digital Marketing Ready</h4>
                                        <p class="text-justify">Website is the key to a successful digital marketing strategy because all other digital marketing elements directly connect to your website.</p>
                                    </div>
                                </div>
                                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="200">
                                    <i class="ri-brush-4-line"></i>
                                    <div>
                                        <h4>Modern Technology</h4>
                                        <p class="text-justify">We provide the latest technology to our customers. A modern framework like Laravel, CodeIgniter, NodeJS always ensures your project scalability.
                                        <p>
                                    </div>
                                </div>
                                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="400">
                                    <i class="ri-command-line"></i>
                                    <div>
                                        <h4>UI/UX Development</h4>
                                        <p class="text-justify">The User Interface and User Experience Design help to win the consumer confidence and make them use your application or website providing them what they are looking for.</p>
                                    </div>
                                </div>
                                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="500">
                                    <i class="ri-radar-line"></i>
                                    <div>
                                        <h4>Content Development</h4>
                                        <p class="text-justify">Content improves your website search engine rankings, brings quality visitors to your website, and increases user experience, it can also help convert users into customers or fans.</p>
                                    </div>
                                </div>
                                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="500">
                                    <i class="ri-webcam-line"></i>
                                    <div>
                                        <p class="text-justify">We study the consumer company and analysis their Business goal to select the appropriate technology that perfectly meets client demand.</p>
                                        <a href="<?= base_url() ?>/web-development" class="btn btn-primary btn-sm" style="background-color: #4154f1;border-color: #4154f1;float: right;">
                                            Read More
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Feature Icons -->
            </div>
        </section>
        <!-- End Features Section -->

        <!-- ======= Domain Section ======= -->
        <section id="domain" class="features">
            <div class="container" data-aos="fade-up">
                <header class="section-header">
                    <h2>Domain</h2>
                    <p>Buy Domain From Real Seller</p>
                </header>
                <div class="row gy-4" data-aos="fade-left">
                    <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="100">
                        <img src="<?= base_url() ?>/assets/frontend/img/features-3.png" class="img-fluid p-4" alt="">
                    </div>
                    <div class="col-lg-8" data-aos="zoom-in" data-aos-delay="100">
                        <p>We are a registered domain company. So, we provide the domain panel where you can fully control your domain names.</p>
                        <!-- Feature Tabs -->
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
                                                <input type="text" name="name" placeholder="Your Name" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="email" name="email" placeholder="Your Email" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="number" name="mobile" placeholder="Your Mobile Number" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <select name="validity" class="form-control">
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
                                                <textarea name="address" placeholder="Your Address" class="form-control"></textarea>
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
                </div>
            </div>
        </section>
        <!-- End Domain Section -->

        <!-- ======= Hosting Section ======= -->
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
        <!-- End Hosting Section -->

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

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container" data-aos="fade-up">
                <header class="section-header">
                    <h2>Contact</h2>
                    <p>Contact Us</p>
                </header>
                <div class="row gy-4">
                    <div class="col-lg-6">
                        <div class="row gy-4">
                            <div class="col-md-6">
                                <div class="info-box">
                                    <i class="bi bi-geo-alt"></i>
                                    <h3>Address</h3>
                                    <p>Magura,<br>Magura Sadar, MGA 7600, Bangladesh.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box">
                                    <i class="bi bi-telephone"></i>
                                    <h3>Call Us</h3>
                                    <p>+88 0963 8903899</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box">
                                    <i class="bi bi-envelope"></i>
                                    <h3>Write Us</h3>
                                    <p>info@evistechnology.com</p>
                                    <p>facebook.com/evis.technology</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box">
                                    <i class="bi bi-clock"></i>
                                    <h3>Open Hours</h3>
                                    <p>Sunday - Thursday<br>9:00AM - 05:00PM</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <form id="contactForm">
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <input type="text" name="name" required placeholder="Your Name" class="form-control">
                                </div>
                                <div class="col-md-6 ">
                                    <input type="email" name="email" required placeholder="Your Email" class="form-control">
                                </div>
                                <div class="col-md-12">
                                    <input type="text" name="subject" required placeholder="Subject" class="form-control">
                                </div>
                                <div class="col-md-12">
                                    <textarea name="message" required rows="6" placeholder="Message" class="form-control"></textarea>
                                </div>
                                <div class="col-md-12 text-center">
                                    <input type="hidden" id="contact_email_recaptcha_response" name="recaptcha_response" value="">
                                    <button type="submit" id="contactFormSubmit">Send Message</button>
                                    <div id="contactFormMessage" class="col-md-12 mt-2"></div>
                                </div>
                            </div>
                        </form>
                        <script>
                            jQ.push(function() {
                                $('#contactFormSubmit').click(function(e) {
                                    e.preventDefault();

                                    grecaptcha.ready(function() {
                                        grecaptcha.execute("<?= $settings['recaptcha_sitekey'] ?>", {
                                            action: 'submit'
                                        }).then(function(token) {
                                            $("#contact_email_recaptcha_response").val(token);

                                            $("#contactFormSubmit").attr("disabled", true);
                                            $("#contactFormSubmit").html('Processing..');
                                            $.ajax({
                                                type: 'POST',
                                                url: '<?php echo base_url() ?>/home/contact_email',
                                                data: $('#contactForm').serialize(),
                                                success: function(data) {
                                                    if (data === 'success') {
                                                        $("#contactFormSubmit").attr("disabled", true);
                                                        $("#contactFormSubmit").html('Send Message');
                                                        $('#contactFormMessage').html("<div class='alert alert-success' role='alert'>Thank you! We will get back to you shortly</div>");
                                                    } else {
                                                        $("#contactFormSubmit").attr("disabled", false);
                                                        $("#contactFormSubmit").html('Send Message');
                                                        $('#contactFormMessage').html("<div class='alert alert-danger' role='alert'>" + data + "</div>");
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
        </section>
        <!-- End Contact Section -->
    </main>

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="footer-newsletter">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12 text-center">
                        <h4>Our Newsletter</h4>
                        <p>Keep in touch with our latest innovation</p>
                    </div>
                    <div class="col-lg-6">
                        <form>
                            <input type="email" id="newsletterEmail">
                            <input type="hidden" id="newsletter_recaptcha_response" name="recaptcha_response" value="">
                            <input type="submit" id="newsletterFormSubmit" value="Subscribe">
                        </form>
                        <div id="newsletterFormMessage" class="col-md-12 mt-2"></div>
                        <script>
                            jQ.push(function() {
                                $('#newsletterFormSubmit').click(function(e) {
                                    e.preventDefault();

                                    grecaptcha.ready(function() {
                                        grecaptcha.execute("<?= $settings['recaptcha_sitekey'] ?>", {
                                            action: 'submit'
                                        }).then(function(token) {
                                            $("#newsletter_recaptcha_response").val(token);

                                            $("#newsletterFormSubmit").attr("disabled", true);
                                            $("#newsletterFormSubmit").val('Processing..');

                                            var newsletterEmail = $('#newsletterEmail').val();

                                            $.ajax({
                                                type: 'POST',
                                                url: '<?php echo base_url() ?>/home/save_newsletter',
                                                data: {
                                                    email: newsletterEmail
                                                },
                                                success: function(data) {
                                                    if (data === 'success') {
                                                        $("#newsletterFormSubmit").attr("disabled", true);
                                                        $("#newsletterFormSubmit").val('Subscribe..');
                                                        $('#newsletterFormMessage').html("<div class='alert alert-success' role='alert'>Thank you for subscribing our newsletter!</div>");
                                                    } else {
                                                        $("#newsletterFormSubmit").attr("disabled", false);
                                                        $("#newsletterFormSubmit").val('Subscribe..');
                                                        $('#newsletterFormMessage').html("<div class='alert alert-danger' role='alert'>" + data + "</div>");
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
        </div>
        <div class="footer-top">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-5 col-md-12 footer-info">
                        <a href="<?= base_url() ?>" class="logo d-flex align-items-center">
                            <span><?= $settings['project_name'] ?></span>
                        </a>
                        <p><?= $settings['meta_description'] ?></p>
                        <div class="social-links mt-3">
                            <a href="https://facebook.com/evis.technology" class="facebook" target="_blank"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="linkedin"><i class="bi bi-linkedin bx bxl-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-6 footer-links">
                        <h4>Our Company</h4>
                        <ul>
                            <li><i class="bi bi-chevron-right"></i> <a href="<?= base_url() ?>">Home</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="<?= base_url() ?>#contact">Contact Us</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="<?= base_url() ?>/about-us">About Us</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="<?= base_url() ?>/terms-and-conditions">Terms and Conditions</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="<?= base_url() ?>/privacy-policy">Privacy Policy</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-6 footer-links">
                        <h4>Our Services</h4>
                        <ul>
                            <li><i class="bi bi-chevron-right"></i> <a href="<?= base_url() ?>/domain-registration">Domain</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="<?= base_url() ?>/hosting-package">Hosting</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="<?= base_url() ?>/software-development">Software Development</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="<?= base_url() ?>/web-development">Web Development</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="<?= base_url() ?>/client">Client Area</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
                        <h4>Contact Us</h4>
                        <p>
                            Magura. <br>
                            Magura Sadar, MGA 7600.<br>
                            Bangladesh. <br><br>
                            <strong>Phone:</strong> +88 0963 8903899<br>
                            <strong>Email:</strong> info@evistechnology.com
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong><span><?= $settings['project_name'] ?></span></strong>. All Rights Reserved
            </div>
        </div>
    </footer>
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="<?= base_url() ?>/assets/frontend/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="<?= base_url() ?>/assets/frontend/vendor/aos/aos.js"></script>
    <script src="<?= base_url() ?>/assets/frontend/vendor/php-email-form/validate.js"></script>
    <script src="<?= base_url() ?>/assets/frontend/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="<?= base_url() ?>/assets/frontend/vendor/purecounter/purecounter.js"></script>
    <script src="<?= base_url() ?>/assets/frontend/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="<?= base_url() ?>/assets/frontend/vendor/glightbox/js/glightbox.min.js"></script>

    <!-- Template Main JS File -->
    <script src="<?= base_url() ?>/assets/frontend/js/main.js"></script>

    <!-- jQuery File -->
    <script src="<?= base_url() ?>/assets/frontend/js/jquery-3.6.3.min.js"></script>
    <script>
        for (var i in jQ) {
            jQ[i]();
        }
    </script>
</body>

</html>