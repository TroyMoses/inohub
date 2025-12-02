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
                <div class="main-content-label mb-0 mg-t-8 school-navigation-header"><?php echo h_session('current_page') ? h_session('current_page') : '' ?></div>
                <div class="ms-auto"><a class="d-block tx-20" data-placement="top" data-bs-toggle="tooltip"
                        title="<?php echo h_session('current_page') ? h_session('current_page') : '' ?>" href="javascript:void(0);"><i class="si si-plus text-muted"></i></a></div>
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
                                <th class="border-bottom-0">Chart</th>
                                <th class="border-bottom-0">Description</th>
                                <th class="border-bottom-0 call-action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($fees_types)) : ?>
                                <?php foreach ($fees_types as $key => $fees_type) : ?>
                                    <tr>
                                        <td><?= $key + 1; ?></td>
                                        <td><?= esc($fees_type->name); ?></td>
                                        <td><?= $fees_type->chart_name ? esc($fees_type->code) . ' ' . esc($fees_type->chart_name) : ''; ?></td>
                                        <td><?= esc($fees_type->description); ?></td>
                                        <td class="call-action"><button type="button" data-chartid="<?= esc($fees_type->chart_id); ?>" data-typekey="<?= esc($fees_type->type_key); ?>" data-name="<?= esc($fees_type->name); ?>" data-description="<?= esc($fees_type->description); ?>" class="btn btn-primary btn-sm edit-fees-type" data-id="<?= esc($fees_type->id); ?>">Edit</button> <button type="button" class="btn btn-danger btn-sm delete-fees-type" data-heading="<?= esc($fees_type->name); ?>" data-id="<?= esc($fees_type->id); ?>">Delete</button></td>
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

<div class="modal fade school-large-modal" id="update-fees-type-modal" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Update Fees Type</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="update-fees-type-registration-form" method="post" action="<?= base_url('/Sys/FeesPayment/submitFeesTypesEdit'); ?>">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="id" id="update-fees-type-id">
                    <div class="row row-sm">
                        <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="user_username">Name: <span class="tx-danger">*</span></label>
                                <input type="text" id="update-fees-type-name" class="form-control form-control-sm" autocomplete="off" name="name" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="user_username">Description: <span class="tx-danger">*</span></label>
                                <textarea class="form-control" id="update-fees-type-description" placeholder="" name="description" rows="2" required></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="">Select fee category</label>
                                <select name="type_key" id="update-fees-type-key" class="form-control form-select form-control-sm" data-bs-placeholder="">
                                    <option value="">---- Select ----- </option>
                                    <option value="school_fees">School Fees</option>
                                    <option value="admission_fee">Admission Fee </option>
                                    <option value="boarding_fee">Boarding Fee</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="register_std_fees_payment_mtd">Select Chart <span class="tx-danger">*</span></label>
                                <select id="update-fees-type-chart-id" name="chart_id" class="form-control form-select form-control-sm" data-bs-placeholder="" required>
                                    <option value="">---- Select ----- </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-save-update-fees-type" type="button">Save</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>