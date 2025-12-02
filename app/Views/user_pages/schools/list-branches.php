<?= $this->extend('layouts/switcher-main'); ?>

<?= $this->section('styles'); ?>

<?= $this->endSection('styles'); ?>

<?= $this->section('content'); ?>

<?php helper('h_date'); ?>

<!-- Row -->
<div class="row row-sm">
    <!-- col -->
    <div class="col-lg-12">
        <div class="card mg-b-20">
            <div class="card-body d-flex p-1">
                <div class="main-content-label mb-0 mg-t-8 school-navigation-header"><?php echo h_session('current_page') ? h_session('current_page') :'' ?></div>
                <div class="ms-auto"><a class="d-block tx-20" data-placement="top" data-bs-toggle="tooltip"
                    title="<?php echo h_session('current_page') ? h_session('current_page') :'' ?>" href="javascript:void(0);"><i class="si si-plus text-muted"></i></a></div>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card custom-card overflow-hidden">
            <div class="card-body">
                <div class="table-responsive  export-table">
                    <table id="pending-schools-datatable"
                        class="table table-bordered text-nowrap key-buttons border-bottom"> 
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">Name</th>
                                <th class="border-bottom-0">Phone</th>
                                <th class="border-bottom-0">Email</th>
                                <th class="border-bottom-0">Branch No</th>
                                <th class="border-bottom-0">Prefix</th>
                                <th class="border-bottom-0">Address</th>
                                <th class="border-bottom-0">Region</th>
                                <th class="border-bottom-0 call-action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($branches)) : ?>
                                <?php foreach ($branches as $key => $branch) : ?>
                                    <tr>
                                        <td><?= $key + 1; ?></td>
                                        <td><?= esc($branch->branch_name); ?></td>
                                        <td><?= esc($branch->phone); ?></td>
                                        <td><?= esc($branch->email); ?></td>
                                        <td><?= esc($branch->branch_no); ?></td>
                                        <td><?= esc($branch->prefix); ?></td>
                                        <td><?= esc($branch->physical_address); ?></td>
                                        <td><?= esc($branch->region); ?></td>
                                        <td class="call-action"><button type="button" class="btn btn-primary btn-sm btn-edit-branch"
                                        data-id="<?= esc($branch->id); ?>">Edit</button></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->

<div class="modal fade school-large-modal" id="edit-branch-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Edit Branch Details</h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="edit-branch-body">
                <!-- Content loaded via AJAX -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="btn-update-branch">Update Branch</button>
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>