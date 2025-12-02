<?php helper('h_date'); ?>

<div class="row row-sm">
    <div class="col-lg-5 col-xl-5 col-md-5 col-sm-5">
        <div>
            <div class="divider">BASIC PROFILE DATA </div>
        </div>
        <div class="d-md-flex mt-4">
            <div class="">
                <span class="profile-image pos-relative sch-img-thumbnail">
                    <img class="br-5 student-profile-image" alt=""
                        src="<?php echo $student->image_url ? base_url($student->image_url) :base_url('assets/img/brand/user-img.png'); ?>">
                    <span
                        class="bg-success text-white wd-1 ht-1 rounded-pill profile-online"></span> 
                </span>
            </div>
            <div class="prof-details">
                <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">FULL NAME:</span><span class="span-label-value"><?= esc( $student->name ) ?></span></p>
                <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">FIRST NAME:</span><span class="span-label-value"><?= esc( $student->first_name ) ?></span></p>
                <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">LAST NAME:</span><span class="span-label-value"><?= esc( $student->last_name ) ?></span></p>
                <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">STUDENT NO:</span><span class="span-label-value"><?= esc( $student->people_number ) ?></span></p>
                <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">ADMISSION NO:</span><span class="span-label-value"><?= $student->admission ? esc( $student->admission->admission_no ):'' ?></span></p>
            </div>
        </div>
        
    </div>
    <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
        <div>
            <div class="divider">BASIC PROFILE DATA</div>
        </div>
        <div class="mt-4">
            <div class="prof-details">
                <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">GENDER:</span><span class="span-label-value"><?= esc( $student->gender ) ?></span></p>
                <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">DOB:</span><span class="span-label-value"><?= esc( h_format_date_display($student->dob) ) ?></span></p>
                <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">DORMITRY:</span><span class="span-label-value"> </span><?= $student->accomodation ? esc( $student->accomodation->name ):''?> </span></p>
                <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">BED NUMBER:</span><span class="span-label-value"> </span><?= $student->accomodation ? esc( $student->accomodation->bed_number ):''?> </span></p>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
        <div>
            <div class="divider">CURRENT CLASS DETAILS</div>
        </div>
        <div class="mt-4">
            <div class="prof-details">
            <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">ACADEMIC YEAR:</span><span class="span-label-value"><?= $student->current_class?  esc( $student->current_class->year_name ):'' ?></span></p>
            <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">TERM:</span><span class="span-label-value"><?= $student->current_class ? esc( $student->current_class->term_name ):'' ?></span></p>
            <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">CLASS:</span><span class="span-label-value"> <?= $student->current_class ? ($student->current_class->class_name . ($student->current_class->class_short_name ? '('. $student->current_class->class_short_name . ')' :'' ) ) : ($student->admission ? $student->admission->class_name . ( $student->admission->class_short_name ? '('. $student->admission->class_short_name . ')' :'' ): '') ?> </span></span></p>
            <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">STREAM:</span><span class="span-label-value"> <?= $student->current_class ? ($student->current_class->stream_name ) : ($student->admission ? $student->admission->stream_name: '') ?> </span></span></p>
            </div>
        </div>
        
    </div>
</div>

<form id="register-students-term-reporting-form" method="post"
                    action="<?= base_url('Sys/Students/submitStudentReportingForm'); ?>">
    <input name="people_id" type="hidden" value="<?= esc($peopleId); ?>" autofocus="true"> 
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="divider">REPORTING FOR CLASS DETAILS</div>

            <div class="row">
                <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                    <div class="form-group">
                        <label class="form-label" for="student_stream">Academic Year:<span class="tx-danger">*</span></label>
                        <select name="year_id" class="form-control form-control-sm form-select"
                            id="student-reporting-academic-year" data-bs-placeholder="Select Stream" required>
                            <option value="">---- Select ----- </option>
                            <?php foreach ($academic_years as $key => $academic_year) : ?>
                                <option id="student_reporting_academic_years_<?= esc($academic_year->id); ?>" data-terms="<?= esc(json_encode($academic_year->terms)); ?>" value="<?= esc($academic_year->id); ?>"><?= esc($academic_year->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                    <div class="form-group">
                        <label class="form-label" for="student_stream">Term:<span class="tx-danger">*</span></label>
                        <select name="term_id" class="form-control form-control-sm form-select"
                            id="student-reporting-academic-year-terms" data-bs-placeholder="Select Stream" required>
                            <option value=""> ---- Select ---- </option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                    <div class="form-group">
                        <label class="form-label" for="student_stream">Class:<span class="tx-danger">*</span></label>
                        <select name="class_id" class="form-control form-control-sm form-select"
                            id="reporting-student-classes-select" data-bs-placeholder="Select Stream" required>
                            <option value=""> ---- Select ---- </option>
                            <?php foreach ($classes as $key => $class) : ?>
                                <option id="reporting_student_classes_<?= esc($class->id) ?>"
                                    value="<?= esc($class->id); ?>"
                                    data-streams="<?= esc( json_encode($class->streams) ) ?>">
                                    <?= esc($class->name); ?>(<?= esc($class->short_name); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                    <div class="form-group">
                        <label class="form-label" for="student_stream">Stream:<span class="tx-danger">*</span></label>
                        <select name="stream_id" class="form-control form-control-sm form-select"
                            id="reporting-student-class-streams" data-bs-placeholder="Select Stream" required>
                            <option value=""> ---- Select ---- </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="divider">RESIDANCE INFORMATION</div>

            <div class="row row-sm">
                <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6">
                    <div class="form-group">
                        <label class="form-label" for="student_house">Dormitory:</label>
                        <select name="dormitry" class="form-control form-control-sm form-select"
                            data-bs-placeholder="Select Dormitory">
                            <option value="">---- select ----</option>
                            <?php foreach ($accomodations as $key => $accomodation) : ?>
                                <option value="<?= esc($accomodation->id); ?>"><?= esc($accomodation->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6">
                    <div class="form-group">
                        <label class="form-label" for="bed_number">Bed Number:</label>
                        <input type="text" class="form-control form-control-sm"
                            autocomplete="off" name="bed_number">
                    </div>
                </div>
            </div>

            <!-- <div class="divider">REPORTING REQUIREMENTS</div>
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 d-flex">
                    <label class="ckbox"><input name="roles[]" value="school_teacher" type="checkbox"><span>1. Ream of paper</span></label> &nbsp; &nbsp; &nbsp;
                    <label class="ckbox"><input name="roles[]" value="school_bursar" type="checkbox"><span>1. Broom</span></label>&nbsp; &nbsp; &nbsp;
                </div>
            </div> -->

        </div>
    </div>
</form>