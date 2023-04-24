<main id="main" class="mt-5">
    <section class="breadcrumbs">
        <div class="container">
            <ol>
                <li><a href="<?= base_url() ?>/client">Client Area</a></li>
                <li>Hosting</li>
            </ol>
            <h2>Hosting</h2>
        </div>
    </section>
    <section class="contact">
        <div class="container" data-aos="fade-up">
            <header class="section-header">
                <h2>Manage Your Hosting</h2>
                <p>Hosting Management</p>
            </header>
            <div class="row gy-4">
                <table class="table table-bordered border-primary">
                    <thead>
                        <tr>
                            <th scope="col">Storage</th>
                            <th scope="col">Domain Name</th>
                            <th scope="col">Expiry Date</th>
                            <th scope="col">cPanel Login</th>
                            <th scope="col">Webmail Login</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($hostings as $hosting): ?>
                            <tr>
                                <td><?php echo $hosting['hosting_space'] ?></td>
                                <td><?php echo $hosting['primary_domain'] ?></td>
                                <td><?php echo date($settings['date_format'], strtotime($hosting['expiry_date'])) ?></td>
                                <td><a href="https://<?php echo $hosting['cpanel_url'] ?>" class="btn btn-success btn-sm" target="_blank">Click Here</a></td>
                                <td><a href="https://<?php echo $hosting['email_url'] ?>" class="btn btn-success btn-sm" target="_blank">Click Here</a></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>