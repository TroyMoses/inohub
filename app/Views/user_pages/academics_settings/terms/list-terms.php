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
                                <th class="border-bottom-0">Term</th>
                                <th class="border-bottom-0">Start Date</th>
                                <th class="border-bottom-0">End Date</th>
                                <th class="border-bottom-0">Academic Year</th>
                                <th class="border-bottom-0">Order No</th>
                                <th class="border-bottom-0">Date Added</th>
                                <th class="border-bottom-0 call-action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($academic_year_terms)) : ?>
                                <?php foreach ($academic_year_terms as $key => $academic_year_term) : ?>
                                    <tr>
                                        <td><?= $key + 1; ?></td>
                                        <td><?= esc($academic_year_term->name); ?></td>
                                        <td><?= esc($academic_year_term->start_date); ?></td>
                                        <td><?= esc($academic_year_term->end_date); ?></td>
                                        <td><?= esc($academic_year_term->academic_year_name); ?></td>
                                        <td><?= esc($academic_year_term->order_number); ?></td>
                                        <td><?= esc($academic_year_term->date_added); ?></td>
                                        <td class="call-action"><button type="button" data-enddate="<?= esc($academic_year_term->end_date); ?>" data-startdate="<?= esc($academic_year_term->start_date); ?>" data-name="<?= esc($academic_year_term->name); ?>" data-id="<?= esc($academic_year_term->id); ?>" class="btn btn-primary btn-sm btn-edit-academic-yr-term">Edit</button></td>
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

<div class="modal fade" id="edit-academic-year-term-modal" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Edit Term</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="edit-academic-year-term-reg-form" method="post" action="<?= base_url('/Sys/AcademicSettings/submitEditAcademicYearTermForm'); ?>">
                    <div class="row row-sm">
                        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="term_label">Term Label: <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="edit_term_label" name="term_label" required>
                                <input type="hidden" class="form-control form-control-sm" autocomplete="off" id="edit_term_id" name="id">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="start_date">Start Date: <span class="tx-danger">*</span></label>
                                <input type="date" class="form-control form-control-sm" autocomplete="off" id="edit_start_date" name="start_date" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="end_date">End Date: <span class="tx-danger">*</span></label>
                                <input type="date" class="form-control form-control-sm" autocomplete="off" id="edit_end_date" name="end_date" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-save-edit-academic-year-term" type="button">Save Term</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>