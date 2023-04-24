<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php echo isset($title) ? $title : $settings['project_name'] ?>
    </title>
    <meta name="description"
        content="<?php echo isset($meta_description) ? $meta_description : $settings['meta_description'] ?>" />
    <!-- Favicon -->
    <link href="<?= base_url() ?>/assets/frontend/img/favicon.ico" rel="icon">
    <!-- Vendor CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300&display=swap" rel="stylesheet" />
    <!-- Template Main CSS File -->
    <link href="<?= base_url() ?>/assets/frontend/css/style.css" rel="stylesheet" />
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

</head>

<body>
    <script>
        var jQ = new Array();
    </script>





    <div class="container mt-3">
        <div class="row">
            <div class="col-sm-8">
                <h3>B2B</h3>
            </div>
            <div class="col-sm-4">


                <nav class="navbar navbar-expand-sm">

                    <div class="container-fluid">

                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="#">Join</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Login</a>
                            </li>

                        </ul>
                    </div>

                </nav>


            </div>
        </div>

        <div class="searchbar">
            <div class="select_wrapper">
                <select name="ms">
                    <option value="0" selected="selected">
                        <font style="vertical-align: inherit;">
                            <font style="vertical-align: inherit;">In all offers</font>
                        </font>
                    </option>
                    <option value="1">
                        <font style="vertical-align: inherit;">
                            <font style="vertical-align: inherit;">Search in offers</font>
                        </font>
                    </option>
                    <option value="2">
                        <font style="vertical-align: inherit;">
                            <font style="vertical-align: inherit;">Offer in offers</font>
                        </font>
                    </option>
                    <option value="4">
                        <font style="vertical-align: inherit;">
                            <font style="vertical-align: inherit;">In export offers</font>
                        </font>
                    </option>
                </select>
            </div>
            <div class="searchtext">
                <input type="text" name="srch" value="" placeholder="What are you looking for?">
            </div>
            <div class="searchbutton">
                <button type="submit" class="search">
                    <i class="material-icons">
                        <font style="vertical-align: inherit;">
                            <font style="vertical-align: inherit;">search</font>
                        </font>
                    </i>
                </button>
            </div>
        </div>

        <!-- <div class="row">
            <div class="col-sm-3">


                <select class="form-select form-select-lg">
                    <option>All Offer</option>
                    <option>Demand</option>
                    <option>Supply</option>
                    <option>Export</option>
                    <option>Import</option>
                </select>



            </div>
            <div class="col-sm-3">

                <div class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </div>

            </div>
            <div class="col-sm-3">col-sm</div>
            <div class="col-sm-3">col-sm</div>
        </div> -->
    </div>



    <!-- Vendor JS Files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>

    <!-- Template Main JS File -->
    <script src="<?= base_url() ?>/assets/frontend/js/main.js"></script>

    <script>
        for (var i in jQ) {
            jQ[i]();
        }
    </script>
</body>

</html>





<!-- ======= Contact Section ======= -->
<!-- <section id="contact" class="contact">
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
                                    <input type="text" name="name" required placeholder="Your Name"
                                        class="form-control">
                                </div>
                                <div class="col-md-6 ">
                                    <input type="email" name="email" required placeholder="Your Email"
                                        class="form-control">
                                </div>
                                <div class="col-md-12">
                                    <input type="text" name="subject" required placeholder="Subject"
                                        class="form-control">
                                </div>
                                <div class="col-md-12">
                                    <textarea name="message" required rows="6" placeholder="Message"
                                        class="form-control"></textarea>
                                </div>
                                <div class="col-md-12 text-center">
                                    <input type="hidden" id="contact_email_recaptcha_response" name="recaptcha_response"
                                        value="">
                                    <button type="submit" id="contactFormSubmit">Send Message</button>
                                    <div id="contactFormMessage" class="col-md-12 mt-2"></div>
                                </div>
                            </div>
                        </form>
                        <script>
                            jQ.push(function () {
                                $('#contactFormSubmit').click(function (e) {
                                    e.preventDefault();

                                    grecaptcha.ready(function () {
                                        grecaptcha.execute("<?= $settings['recaptcha_sitekey'] ?>", {
                                            action: 'submit'
                                        }).then(function (token) {
                                            $("#contact_email_recaptcha_response").val(token);

                                            $("#contactFormSubmit").attr("disabled", true);
                                            $("#contactFormSubmit").html('Processing..');
                                            $.ajax({
                                                type: 'POST',
                                                url: '<?php echo base_url() ?>/home/contact_email',
                                                data: $('#contactForm').serialize(),
                                                success: function (data) {
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
        </section> -->
<!-- End Contact Section -->