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
                    <li><a class="nav-link scrollto" href="<?= base_url() ?>#home">Home</a></li>
                    <li><a class="nav-link scrollto" href="<?= base_url() ?>#softwareDevelopment">Software Development</a></li>
                    <li><a class="nav-link scrollto" href="<?= base_url() ?>#webDevelopment">Web Development</a></li>
                    <li><a class="nav-link scrollto" href="<?= base_url() ?>#domain">Domain</a></li>
                    <li><a class="nav-link scrollto" href="<?= base_url() ?>#hosting">Hosting</a></li>
                    <li><a class="getstarted scrollto" href="<?= base_url() ?>/client">Client Area</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav>
        </div>
    </header>
    <!-- End Header -->

    <?= $content ?>

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