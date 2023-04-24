<!-- Page Content -->
<div class="right_col" role="main">
    <div class="page-title">
        <div class="title_left">
            <h3><?= $title ?> Management</h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="x_panel">
                <div class="x_content">
                    <table id="cashbook" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Transaction Date</th>
                                <th>Transaction Amount</th>
                                <th>In Amount</th>
                                <th>Out Amount</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Transaction Date</th>
                                <th>Transaction Amount</th>
                                <th>In Amount</th>
                                <th>Out Amount</th>
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
        $('#cashbook').DataTable({
            ajax: '<?= base_url() ?>/account/cashbook_datatable',
            dom: 'Bfrtip',
            order: [[0 ,'desc']],
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>