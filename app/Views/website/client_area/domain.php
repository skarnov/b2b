<main id="main" class="mt-5">
    <section class="breadcrumbs">
        <div class="container">
            <ol>
                <li><a href="<?= base_url() ?>/client">Client Area</a></li>
                <li>Domain</li>
            </ol>
            <h2>Domain</h2>
        </div>
    </section>
    <section class="contact">
        <div class="container" data-aos="fade-up">
            <header class="section-header">
                <h2>Manage Your Domains</h2>
                <p>Domain Management</p>
            </header>
            <div class="row gy-4">
                <table class="table table-bordered border-primary">
                    <thead>
                        <tr>
                            <th scope="col">Domain Name</th>
                            <th scope="col">Expiry Date</th>
                            <th scope="col">Panel Login</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($domains as $domain): ?>
                            <tr>
                                <td><?php echo $domain['domain_name'] ?></td>
                                <td><?php echo date($settings['date_format'], strtotime($domain['expiry_date'])) ?></td>
                                <td><a href="https://evistechnology.manage-orders.com/" class="btn btn-success btn-sm" target="_blank">Click Here</a></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>