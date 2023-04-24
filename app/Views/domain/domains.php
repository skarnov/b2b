<!-- Page Content -->
<div class="right_col" role="main">
    <div class="page-title">
        <div class="title_left">
            <h3><?= $title ?> Management</h3>
        </div>
        <div class="title_right">
            <div class="form-group pull-right top_search">
                <div class="btn-group btn-group-sm" role="group">
                    <a href="<?= base_url() ?>/domain/add_domain" class="btn btn-secondary btn-xs">Add New Domain</a>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12  ">
            <div class="x_panel">
                <div class="x_content">
                    <table id="domains" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Expiry Date</th>
                                <th>Domain</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Expiry Date</th>
                                <th>Domain</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Status</th>
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
        $('#domains').DataTable({
            ajax: '<?= base_url() ?>/domain/domain_datatable',
            dom: 'Bfrtip',
            order: [[0 ,'desc']],
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>