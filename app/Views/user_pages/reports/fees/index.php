<?= $this->extend('layouts/switcher-main'); ?>

<?= $this->section('styles'); ?>

<?= $this->endSection('styles'); ?>

<?= $this->section('content'); ?>

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
                <form id="filter-school-term-fees-form" method="post" action="" enctype="multipart/form-data">
                    <div class="row row-sm">
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="identity_type">Academic Year:<span class="tx-danger">*</span></label>
                                <select name="fees-academic-year" class="form-control form-select form-control-sm"
                                    id="fees-academic-year" data-bs-placeholder="Select Status" required>
                                    <option value="">---- Select ----- </option>
                                    <?php foreach ($academic_years as $key => $academic_year) : ?>
                                        <option id="fees-academic-year-<?= esc($academic_year->id); ?>" data-terms="<?= esc(json_encode($academic_year->terms)); ?>" value="<?= esc($academic_year->id); ?>"><?= esc($academic_year->name); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-xl-2 col-md-2 col-sm-2">
                            <div class="form-group">
                                <label class="form-label" for="identity_type">Term:<span class="tx-danger">*</span> </label>
                                <select name="fees-academic-year-terms" class="form-control form-select form-control-sm"
                                    id="fees-academic-year-terms" data-bs-placeholder="Select Status" required>
                                    <option value="">---- Select ----- </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-2 col-xl-2 col-md-2 col-sm-2">
                            <div class="form-group">
                                <label class="form-label" for="identity_type">Class:<span class="tx-danger">*</span> </label>
                                <select name="fees-academic-year-term-class" class="form-control form-select form-control-sm"
                                    id="fees-academic-year-term-class" data-bs-placeholder="Select Status" required>
                                    <option value="">---- Select ----- </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-2 col-xl-2 col-md-2 col-sm-2">
                            <div class="form-group">
                                <label class="form-label">Start Date: <span class="tx-danger">*</span></label>
                                <input type="date" value="<?= date('Y-m-d'); ?>" class="form-control form-control-sm" name="start_date" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="col-lg-2 col-xl-2 col-md-2 col-sm-2">
                            <div class="form-group">
                                <label class="form-label">End Date: <span class="tx-danger">*</span></label>
                                <input type="date" value="<?= date('Y-m-d'); ?>" class="form-control form-control-sm" name="end_date" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="col-lg-1 col-xl-1 col-md-1 col-sm-1 my-auto">
                            <button type="button" id="fees-academic-year-term-btn" class="btn btn-primary btn-sm mt-3">Fetch</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->

<div class="row row-sm">
    <div class="col-lg-12">
        <div id="fetch-academic-year-fees-container"></div>
    </div>
</div>
<!-- End Row -->

<?= $this->endSection('content'); ?>