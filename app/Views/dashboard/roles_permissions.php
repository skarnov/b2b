<!-- Page Content -->
<div class="right_col" role="main">
    <div class="page-title">
        <div class="title_left">
            <h3><?= $title ?> Management</h3>
        </div>
        <div class="title_right">
            <div class="form-group pull-right top_search">
                <div class="btn-group btn-group-sm" role="group">
                    <a href="<?= base_url() ?>/dashboard/add_role" class="btn btn-secondary btn-xs">Add Role</a>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12  ">
            <div class="x_panel">
                <div class="x_content">
                    <?php $session = \Config\Services::session() ?>
                    <?php if ($session->getFlashdata('warning')): ?>
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="alert alert-warning">
                                    <?= $session->getFlashdata('warning') ?>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th style="width: 20%">Role Name</th>
                                <th style="width: 40%">Description</th>
                                <th class="text-right" style="width:30%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($all_roles as $v_role): ?>
                                <tr>
                                    <td><?= $v_role['role_name'] ?></td>
                                    <td><?= $v_role['role_description'] ?></td>
                                    <td class="text-right" style="width:12%">
                                        <a href="<?= base_url() ?>/dashboard/edit_role/<?= $v_role['role_id'] ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> Edit</a>
                                        <a href="<?= base_url() ?>/dashboard/edit_permission/<?= $v_role['role_id'] ?>" class="btn btn-primary btn-xs"><i class="fa fa-cogs"></i> Permissions</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End of Page Content -->