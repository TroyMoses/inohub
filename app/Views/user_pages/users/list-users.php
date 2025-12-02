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
                                <th class="border-bottom-0">Staff Name</th>
                                <th class="border-bottom-0">UserName</th>
                                <th class="border-bottom-0">Branch</th>
                                <th class="border-bottom-0">User Group</th>
                                <th class="border-bottom-0">2FA</th>
                                <th class="border-bottom-0">Online</th>
                                <th class="border-bottom-0">Logout Time</th>
                                <th class="border-bottom-0">Status</th>
                                <th class="border-bottom-0 call-action">Action</th> 
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($users)) : ?>
                                <?php foreach ($users as $key => $user) : ?>
                                    <tr>
                                        <td><?= $key + 1; ?></td>
                                        <td><?= esc($user->name); ?></td>
                                        <td><?= esc($user->user_name); ?></td>
                                        <td><?= esc(h_session('branch_name')); ?></td>
                                        <td><?= esc($user->group_name); ?></td>
                                        <td><?= esc($user->is_2fa); ?></td> 
                                        <td></td>
                                        <td></td>
                                        <td><?= esc(ucwords($user->status)); ?></td> 
                                        <td class="call-action"><button type="button" class="btn btn-primary btn-sm edit-user-account-btn" data-id="<?= esc($user->id); ?>">--- view ---</button></td>
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

<div class="modal fade " id="edit-branch-user" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Edit User</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" id="edit-user-account-details-div">
                
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-save-edit-user" type="button">Save User</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>