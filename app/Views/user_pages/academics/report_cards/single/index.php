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
                    <?php echo h_session('current_page') ? h_session('current_page') :'' ?></div>
                <div class="ms-auto"><a class="d-block tx-20" data-placement="top" data-bs-toggle="tooltip"
                        title="<?php echo h_session('current_page') ? h_session('current_page') :'' ?>"
                        href="javascript:void(0);"><i class="si si-plus text-muted"></i></a></div>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->
<div id="generate-report-card-html-div">
    <form method="post" action="" enctype="multipart/form-data">
        <div class="row row-sm">
            <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
                <div class="form-group mb-0">
                    <label class="form-label" for="department_name">Search Student Name<span class="tx-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="search-student-report-card" name="name" autocomplete="off" required>
                </div>
                <div id="search-student-report-card-results" style="display:none; margin-left: 10px; position: absolute; top: 100%; left: 0; width: 95%; background: white; border: 1px solid #ccc; z-index: 1000; max-height: 250px; overflow-y: auto;"
                > </div>
                <input type="hidden" class="form-control form-control-sm" id="search-student-report-card-id">
            </div>
            <div class="col-lg-2 col-xl-2 col-md-2 col-sm-2">
                <div class="form-group">
                    <label class="form-label" for="department_name">Academic Year<span class="tx-danger">*</span></label>
                    <select class="form-control form-select form-control-sm" id="student-report-card-yr" data-bs-placeholder="Select Status" required>
                        <option value="">---- Select ----- </option>
                        <?php foreach ($academic_years as $key => $academic_year) : ?>
                            <option id="student_report_cd_academic_years_<?= esc($academic_year->id); ?>" data-terms="<?= esc(json_encode($academic_year->terms)); ?>" value="<?= esc($academic_year->id); ?>"><?= esc($academic_year->name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-2 col-xl-2 col-md-2 col-sm-2">
                <div class="form-group">
                    <label class="form-label" for="department_name">Term<span class="tx-danger">*</span></label>
                    <select class="form-control form-select form-control-sm" id="student-report-card-yr-term" data-bs-placeholder="Select Status" required>
                        <option value="">---- Select ----- </option>
                    </select>
                </div>
            </div>
            <div class="col-lg-2 col-xl-2 col-md-2 col-sm-2">
                <div class="form-group">
                    <label class="form-label" for="department_name">Exam<span class="tx-danger">*</span></label>
                    <select class="form-control form-select form-control-sm" id="student-report-card-yr-term-exam" data-bs-placeholder="Select Status" required>
                        <option value="">---- Select ----- </option>
                    </select>
                </div>
            </div>
            <div class="col-lg-2 col-xl-2 col-md-2 col-sm-2 pt-3">
                <button class="btn ripple btn-primary mt-4 btn-sm" id="btn-fetch-student-report-card"
                type="button">Fetch Report Card</button>
            </div>
        </div>
    </form>

    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div id="fetch-student-report-card-container"></div>
        </div>
    </div>

</div>

<?= $this->endSection('content'); ?>