<!-- Page Content -->
<div class="right_col" role="main">
    <div class="page-title">
        <div class="title_left">
            <h3><?= $title ?> Management</h3>
        </div>
        <div class="title_right">
            <div class="form-group pull-right top_search">
                <div class="btn-group btn-group-sm" role="group">
                    <a href="<?= base_url() ?>/partner/add_partner" class="btn btn-sm btn-secondary">Add New Partner</a>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12  ">
            <div class="x_panel">
                <div class="x_content">
                    <table id="partners" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Partner Name</th>
                                <th>Total Investment</th>
                                <th>Total Profit</th>
                                <th>Status</th>
                                <th>Creation Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Partner Name</th>
                                <th>Total Investment</th>
                                <th>Total Profit</th>
                                <th>Status</th>
                                <th>Creation Date</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End of Page Content -->
<script>
    jQ.push(function () {
        $('#partners').DataTable({
            ajax: '<?= base_url() ?>/partner/partner_datatable',
            dom: 'Bfrtip',
            order: [[0 ,'desc']],
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            order: [0, 'desc']
        });
    });
</script>