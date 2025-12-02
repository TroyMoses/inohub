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
                <form enctype="multipart/form-data" id="filter-boarding-students-form">
                    <div class="row row-sm">
                        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
                            <div class="form-group">
                                <label class="form-label" for="identity_type">Academic Year:<span
                                class="tx-danger">*</span></label>
                                <select name="term-boarding-students" class="form-control form-select form-control-sm"
                                    id="term-boarding-students" data-bs-placeholder="Select Status" required>
                                    <option value="">---- Select ----- </option>
                                    <?php foreach ($academic_years as $key => $academic_year) : ?>
                                        <option id="boarding-students-yr-<?= esc($academic_year->id); ?>" data-terms="<?= esc(json_encode($academic_year->terms)); ?>" value="<?= esc($academic_year->id); ?>"><?= esc($academic_year->name); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="identity_type">Term:<span
                                class="tx-danger">*</span></label>
                                <select name="term-boarding-students-terms" class="form-control form-select form-control-sm"
                                    id="term-boarding-students-terms" data-bs-placeholder="Select Status" required>
                                    <option value="">---- Select ----- </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="identity_type">Class:<span
                                        class="tx-danger">*</span></label>
                                <select name="term-boarding-students-term-classes" class="form-control form-select form-control-sm"
                                    id="term-boarding-students-term-classes" data-bs-placeholder="Select Year" required>
                                    <option value="0"> All classes </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-2 col-xl-2 col-md-2 col-sm-2 my-auto">
                            <button type="button" id="fetch-boarding-students-btn" class="btn btn-primary btn-sm mt-3">Fetch Students</button>
                        </div>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->

<div class="row row-sm">
    <div class="col-lg-12" id="boarding-students-list-container">
        
    </div>
</div>
<!-- End Row -->

<?= $this->endSection('content'); ?>