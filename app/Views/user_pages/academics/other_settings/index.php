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

<div class="row row-sm">
    <div class="col-lg-3">
        <div class="mg-b-20">
            <div class="main-content-left main-content-left-mail">
                <a class="btn btn-primary btn-compose" href="" id="btnCompose">OTHER SETTINGS PORTAL:</a>
                <div class="main-mail-menu">
                    <nav class="nav main-nav-column mg-b-20">

                        <a class="nav-link thumb active" data-bs-toggle="tab" href="#tabTermGradeRanges"><i
                            class="fa fa-cog"></i> Grade Ranges </a>

                        <a class="nav-link thumb" data-bs-toggle="tab" href="#tabTermGrading"><i
                                class="fa fa-cog"></i> Term Grading/Positioning </a>
                        
                    </nav>
                </div>
                <!-- main-mail-menu -->
            </div>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="tab-content">

            <div class="tab-pane active show" id="tabTermGradeRanges">
                <div class="table-responsive  export-table">
                    <table id="pending-schools-datatable"
                        class="table table-bordered text-nowrap key-buttons border-bottom"> 
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">Grade</th>
                                <th class="border-bottom-0">Short Name</th>
                                <th class="border-bottom-0">Range</th>
                                <th class="border-bottom-0">HM comment</th>
                                <th class="border-bottom-0">Teacher comment</th>
                                <th class="border-bottom-0 call-action">Action</th>
                            </tr>
                        </thead>
                        <tbody> 
                            <?php if (!empty($grade_ranges)) : ?>
                                <?php foreach ($grade_ranges as $key => $range) : ?>
                                <tr>
                                    <td><?= $key + 1; ?></td>
                                    <td><?= esc($range->name); ?></td>
                                    <td><?= esc($range->short_name); ?></td>
                                    <td><?= esc($range->min); ?> - <?= esc($range->max); ?></td>
                                    <td><?= esc($range->hm_comment); ?></td>
                                    <td><?= esc($range->teacher_comment); ?></td>
                                    <td class="call-action"><button type="button" class="btn btn-primary btn-sm">Edit</button></td>
                                </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>

                        </tbody>
                    </table>
                </div>                                      
            </div>

            <div class="tab-pane" id="tabTermGrading">
                <div class="row row-sm">
                    <div class="col-lg-12">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body">
                                <form method="post"
                                    action="" enctype="multipart/form-data">
                                    <div class="row row-sm">
                                        <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label" for="identity_type">Academic Year:<span
                                                        class="tx-danger">*</span></label>
                                                <select name="term_school_req_academic_years" class="form-control form-select form-control-sm"
                                                    id="term_grading_academic_years" data-bs-placeholder="Select Year" required>
                                                    <option value="">---- Select ----- </option>
                                                    <?php foreach ($academic_years as $key => $academic_year) : ?>
                                                        <option id="term_grading_academic_years_<?= esc($academic_year->id); ?>" data-terms="<?= esc(json_encode($academic_year->terms)); ?>" value="<?= esc($academic_year->id); ?>"><?= esc($academic_year->name); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label" for="identity_type">Academic Term:<span
                                                        class="tx-danger">*</span></label>
                                                <select name="" class="form-control form-select form-control-sm"
                                                    id="term_grading_academic_year_terms" data-bs-placeholder="Select Status" required>
                                                    <option value="">---- Select ----- </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="term-grading-details-container"></div>

            </div>

            

        </div>
    </div>
</div>
<!-- End Row -->

<?= $this->endSection('content'); ?>