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
                <div class="main-content-label mb-0 mg-t-8 school-navigation-header">
                    <?php echo h_session('current_page') ? h_session('current_page') : '' ?></div>
                <div class="ms-auto"><a class="d-block tx-20" data-placement="top" data-bs-toggle="tooltip"
                        title="<?php echo h_session('current_page') ? h_session('current_page') : '' ?>"
                        href="javascript:void(0);"><i class="si si-plus text-muted"></i></a></div>
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
                                <th class="border-bottom-0">Group Name</th>
                                <th class="border-bottom-0">Group Desc</th>
                                <th class="border-bottom-0 call-action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($userGroups)) : ?>
                                <?php foreach ($userGroups as $key => $userGroup) : ?>
                                    <tr>
                                        <td><?= $key + 1; ?></td>
                                        <td><?= esc($userGroup->group_name); ?></td>
                                        <td><?= esc($userGroup->group_descr); ?></td>
                                        <td class="call-action">
                                            <button type="button" class="btn btn-primary btn-sm btn-edit-user-group"
                                                data-id="<?= esc($userGroup->id); ?>"
                                                data-name="<?= esc($userGroup->group_name); ?>"
                                                data-description="<?= esc($userGroup->group_descr); ?>">Edit</button>

                                            <button type="button" class="ml-1 btn btn-primary btn-sm btn-view-user-group-components"
                                                data-id="<?= esc($userGroup->id); ?>">View</button>
                                        </td>
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

<div class="modal fade" id="list-user-group-components" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">User Group</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" id="list-user-group-components-html">

            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-save-user-group-components" type="button">Save Changes</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>

<?= view('user_pages/users/edit-user-group'); ?>

<?= $this->endSection('content'); ?>