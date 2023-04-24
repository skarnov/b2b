<main id="main" class="mt-5">
    <section class="breadcrumbs">
        <div class="container">
            <h2>Client Area</h2>
        </div>
    </section>
    <section class="contact">
        <div class="container" data-aos="fade-up">
            <header class="section-header">
                <h2>Manage Your Products</h2>
                <p class="text-capitalize"><?= $user_name ?>'S Area</p>
            </header>
            <div class="row gy-4">
                <?php if (isset($admin_reply)) : ?>
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Ticket Reply</strong> <?php echo $admin_reply['ticket_content'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif ?>
                <section id="counts" class="counts">
                    <div class="container" data-aos="fade-up">
                        <div class="row gy-4">
                            <div class="col-lg-3 col-md-6">
                                <div class="count-box">
                                    <i class="bi bi-border-all"></i>
                                    <a href="<?= base_url() ?>/client/domain">
                                        <div>
                                            <span data-purecounter-start="0" data-purecounter-end="<?= $domains['total_domains'] ?>" data-purecounter-duration="1" class="purecounter"></span>
                                            <p>Your Domain</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="count-box">
                                    <i class="bi bi-flag" style="color: #ee6c20;"></i>
                                    <a href="<?= base_url() ?>/client/hosting">
                                        <div>
                                            <span data-purecounter-start="0" data-purecounter-end="<?= $hostings['total_hostings'] ?>" data-purecounter-duration="1" class="purecounter"></span>
                                            <p>Your Hosting</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="count-box">
                                    <i class="bi bi-window" style="color: #861e5e;"></i>
                                    <a href="<?= base_url() ?>/client/projects">
                                        <div>
                                            <span data-purecounter-start="0" data-purecounter-end="<?= $projects['total_projects'] ?>" data-purecounter-duration="1" class="purecounter"></span>
                                            <p>Your Projects</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="count-box">
                                    <i class="bi bi-headset" style="color: #15be56;"></i>
                                    <a href="<?= base_url() ?>/client/tickets">
                                        <div>
                                            <span data-purecounter-start="0" data-purecounter-end="<?= $tickets['total_tickets'] ?>" data-purecounter-duration="1" class="purecounter"></span>
                                            <p>Support Tickets</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="count-box">
                                    <i class="bi bi-graph-up" style="color: #ff0404;"></i>
                                    <a href="<?= base_url() ?>/client/invoices">
                                        <div>
                                            <span data-purecounter-start="0" data-purecounter-end="<?= $invoices['total_invoices'] ?>" data-purecounter-duration="1" class="purecounter"></span>
                                            <p>Invoices</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="count-box">
                                    <i class="bi bi-arrow-up-circle" style="color: #ff0404;"></i>
                                    <a href="<?= base_url() ?>/client/user_info">
                                        <div>
                                            <p class="text-capitalize">Profile Info</p>
                                            <p>You can change your password</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="count-box">
                                    <i class="bi bi-arrow-left" style="color: #ff0404;"></i>
                                    <a href="<?= base_url() ?>/login/logout">
                                        <div>
                                            <p class="text-capitalize">Logout From <?= $user_name ?>'S Client Area</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</main>