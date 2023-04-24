<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="robots" content="noindex" />
    <meta name="googlebot" content="noindex">
    <meta name="googlebot-news" content="nosnippet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Evis Secure Login</title>
    <!-- Favicon -->
    <link href="<?= base_url() ?>/assets/frontend/img/favicon.ico" rel="icon">
    <!-- Bootstrap -->
    <link href="<?= base_url() ?>/assets/backend/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?= base_url() ?>/assets/backend/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="<?= base_url() ?>/assets/backend/css/style.css" rel="stylesheet">
</head>

<body class="login">
    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <form id="login">
                    <h1>Login</h1>
                    <?php $session = \Config\Services::session() ?>
                    <?php if ($session->getFlashdata('warning')) : ?>
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="alert alert-warning">
                                    <?= $session->getFlashdata('warning') ?>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                    <div id="notificationArea"></div>
                    <div class="form-group">
                        <input type="email" name="email" required class="form-control" placeholder="Email" />
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" pattern="[0-9a-fA-F]{6,32}" class="form-control" placeholder="Password" />
                    </div>
                    <div class="form-group">
                        <?php
                        if ($locked) {
                        ?>
                            <div class='alert alert-danger'>
                                <p>Please wait 30 Sec</p>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div>
                                <button type="button" id="submit" class="btn btn-success btn-sm m-1">Login</button>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="clearfix"></div>
                    <div class="separator">
                        <div>
                            <h1>Evis Technology</h1>
                            <p>© 2013- <?php echo date('Y') ?> All Rights Reserved.</p>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
    <script src="<?= base_url() ?>/assets/backend/vendor/jquery/jquery-3.5.1.js"></script>
    <script>
        $(function() {
            $('#submit').click(function(e) {
                e.preventDefault();
                $('#submit').attr("disabled", true);
                $('#submit').html('Processing..');
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>/login/admin_auth',
                    data: $('#login').serialize(),
                    success: function(data) {
                        if (data === 'locked') {
                            $('#submit').remove()
                            $('#notificationArea').html("<div class='alert alert-danger' role='alert'>Your account has locked</div>");
                        } else if (data === 'success') {
                            window.location = '<?= base_url() ?>/dashboard';
                        } else {
                            $('#notificationArea').html("<div class='alert alert-danger' role='alert'>" + data + "</div>");
                        }
                        $('#submit').attr("disabled", false);
                        $('#submit').html('Login');
                    }
                });
            });
        });
    </script>
</body>

</html>