<main id="main" class="mt-5">
    <section class="breadcrumbs">
        <div class="container">
            <ol>
                <li><a href="<?= base_url() ?>">Home</a></li>
                <li>Login</li>
            </ol>
            <h2>Login</h2>
        </div>
    </section>
    <section class="contact">
        <div class="container" data-aos="fade-up">
            <header class="section-header">
                <h2>Manage Your Products</h2>
                <p>Login</p>
            </header>
            <div class="row gy-4">
                <div class="col-lg-6">
                    <?php $session = \Config\Services::session() ?>

                    <?php if ($session->getFlashdata('warning')) : ?>
                        <div class="col-md-12">
                            <div class="alert alert-warning">
                                <?= $session->getFlashdata('warning') ?>
                            </div>
                        </div>
                    <?php endif ?>
                    <form id="login" class="requires-validation php-email-form" novalidate>
                        <div class="row gy-4">
                            <div class="col-md-12">
                                <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                                <div class="invalid-feedback">Please enter valid Email</div>
                            </div>
                            <div class="col-md-12">
                                <input type="password" name="password" class="form-control" placeholder="Your Password" required>
                                <div class="invalid-feedback">Please enter valid Password</div>
                            </div>
                            <div class="col-md-12">
                                <div class="loading"></div>
                                <input type="hidden" id="recaptcha_response" name="recaptcha_response" value="">
                                <button type="submit" id="submit">Login</button>
                                <div id="message" class="mt-2"></div>
                            </div>
                        </div>
                    </form>
                    <script>
                        jQ.push(function() {
                            $('#submit').click(function(e) {
                                e.preventDefault();

                                grecaptcha.ready(function() {
                                    grecaptcha.execute("<?= $settings['recaptcha_sitekey'] ?>", {
                                        action: 'submit'
                                    }).then(function(token) {
                                        $("#recaptcha_response").val(token);

                                        $('#loading').show();
                                        $("#submit").attr("disabled", true);
                                        $("#submit").html('Processing..');
                                        $.ajax({
                                            type: 'POST',
                                            url: '<?php echo base_url() ?>/login/auth',
                                            data: $('#login').serialize(),
                                            success: function(data) {
                                                $('.loading').css('display', 'block');
                                                if (data === 'locked') {
                                                    $("#submit").remove()
                                                    $('#message').html("<div class='alert alert-danger' role='alert'>Your account has locked</div>");
                                                } else if (data === 'success') {
                                                    window.location = '<?php echo base_url() ?>/client';
                                                } else {
                                                    $('#message').html("<div class='alert alert-danger' role='alert'>" + data + "</div>");
                                                }
                                                $("#submit").attr("disabled", false);
                                                $("#submit").html('Login');
                                                $('.loading').css('display', 'none');
                                            }
                                        });
                                    });
                                });
                            });
                        });
                    </script>
                </div>
                <div class="col-lg-6">
                    <img src="<?= base_url() ?>/assets/frontend/img/client-area-login.jpg" alt="Evis Technology Client Area Login" class="img-thumbnail" />
                </div>
            </div>
        </div>
    </section>
</main>