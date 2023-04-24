<main id="main" class="mt-5">
    <section class="breadcrumbs">
        <div class="container">
            <ol>
                <li><a href="<?= base_url() ?>/client">Client Area</a></li>
                <li>Project</li>
            </ol>
            <h2>Project</h2>
        </div>
    </section>
    <section class="contact">
        <div class="container" data-aos="fade-up">
            <header class="section-header">
                <h2>Manage Your Projects</h2>
                <p>Projects Management</p>
            </header>
            <div class="row gy-4">
                <table class="table table-bordered border-primary">
                    <thead>
                        <tr>
                            <th scope="col">Project Name</th>
                            <th scope="col">Support Expiry Date</th>
                            <th scope="col">Project URL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($projects as $project): ?>
                            <tr>
                                <td><?php echo $project['service_name'] ?></td>
                                <td><?php echo date($settings['date_format'], strtotime($project['expiry_date'])) ?></td>
                                <td><a href="https://<?php echo $project['service_url'] ?>" class="btn btn-success btn-sm" target="_blank">Click Here</a></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>