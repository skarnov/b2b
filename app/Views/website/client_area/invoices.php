<main id="main" class="mt-5">
    <section class="breadcrumbs">
        <div class="container">
            <ol>
                <li><a href="<?= base_url() ?>/client">Client Area</a></li>
                <li>Invoice</li>
            </ol>
            <h2>Invoice</h2>
        </div>
    </section>
    <section class="contact">
        <div class="container" data-aos="fade-up">
            <header class="section-header">
                <h2>Manage Your Invoices</h2>
                <p>Invoice Management</p>
            </header>
            <div class="row gy-4">
                <table class="table table-bordered border-primary">
                    <thead>
                        <tr>
                            <th scope="col">Description</th>
                            <th scope="col">Sale Due</th>
                            <th scope="col" class="text-right">Download</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($invoices as $invoice): ?>
                            <tr>
                                <td><?php echo $invoice['sale_description'] ?></td>
                                <td><?php echo date($settings['date_format'], strtotime($invoice['due_date'])) ?></td>
                                <td class="text-right"><a href="<?php echo base_url() . '/client/invoice_download/' . $invoice['sale_id'] ?>" target="_blank" class="btn btn-success btn-sm">Click Here</a></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>