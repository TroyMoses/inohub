<?= $this->extend('layouts/switcher-main'); ?>

<?= $this->section('styles'); ?>

<?= $this->endSection('styles'); ?>

<?= $this->section('content'); ?>

<?php helper('h_date'); ?>

<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/44.1.0/ckeditor5.css">
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

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card custom-card overflow-hidden">
            <div class="card-body">
                <form  method="post"
                    action="" enctype="multipart/form-data">
                    <div class="row row-sm">
                        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
                            <div class="form-group">
                                <label class="form-label" for="identity_type">Academic Year:<span
                                        class="tx-danger">*</span></label>
                                <select class="form-control form-select form-control-sm"
                                    id="template_academic_years" data-bs-placeholder="Select Year" required>
                                    <option value="">---- Select ----- </option>
                                    <?php foreach ($academic_years as $key => $academic_year) : ?>
                                        <option id="template_academic_years_<?= esc($academic_year->id); ?>" data-terms="<?= esc(json_encode($academic_year->terms)); ?>" value="<?= esc($academic_year->id); ?>"><?= esc($academic_year->name); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
                            <div class="form-group">
                                <label class="form-label" for="identity_type">Academic Term:<span
                                        class="tx-danger">*</span></label>
                                <select class="form-control form-select form-control-sm"
                                    id="template_academic_year_terms" data-bs-placeholder="Select Status" required>
                                    <option value="">---- Select ----- </option>
                                </select>
                            </div>
                        </div>

                        <!-- <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4 my-auto">
                            <button type="button" class="btn btn-primary btn-sm mt-3">Import Academic Year Settings</button>
                            <button type="button" class="btn btn-primary btn-sm mt-3">Import Term Settings</button>
                        </div> -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->

<div id="templates-view-page-view-container">
    
</div>

<?= $this->endSection('content'); ?>