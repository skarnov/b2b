<main id="main" class="mt-5">
    <section class="breadcrumbs">
        <div class="container">
            <ol>
                <li><a href="<?= base_url() ?>/client">Client Area</a></li>
                <li>Customer Info</li>
            </ol>
            <h2>Customer Info</h2>
        </div>
    </section>
    <section class="contact">
        <div class="container" data-aos="fade-up">
            <header class="section-header">
                <h2>Manage Your Information</h2>
                <p>Customer Info</p>
            </header>
            <div class="row gy-4">
                <form id="userForm">
                    <div class="row gy-4">
                        <div class="col-md-6">
                            <div class="mt-1">
                                <lable class="mb-1">Current Password</lable>
                                <input type="password" name="current_password" class="form-control">
                            </div>
                            <div class="mt-2">
                                <lable class="mb-1">New Password</lable>
                                <input type="password" name="new_password" class="form-control">
                            </div>
                            <div class="mt-2">
                                <lable class="mb-1">Confirm New Password</lable>
                                <input type="password" name="confirm_password" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" id="userFormSubmit">Submit</button>
                            <div id="userFormMessage" class="col-md-12 mt-2"></div>
                        </div>
                    </div>
                </form>
                <script>
                    jQ.push(function() {
                        $('#userFormSubmit').click(function(e) {
                            e.preventDefault();
                            $("#userFormSubmit").attr("disabled", true);
                            $("#userFormSubmit").html('Processing..');
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo base_url() ?>/client/update_userinfo',
                                data: $('#userForm').serialize(),
                                success: function(data) {
                                    if (data === 'success') {
                                        $("#userFormSubmit").attr("disabled", true);
                                        $("#userFormSubmit").html('Submit');
                                        $('#userFormMessage').html("<div class='alert alert-success' role='alert'>Success! Password Changed</div>");
                                    } else {
                                        $("#userFormSubmit").attr("disabled", false);
                                        $("#userFormSubmit").html('Submit');
                                        $('#userFormMessage').html("<div class='alert alert-danger' role='alert'>" + data + "</div>");
                                    }
                                }
                            });
                        });
                    });
                </script>
            </div>
        </div>
    </section>
</main>