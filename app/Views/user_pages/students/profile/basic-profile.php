<?php helper('h_date'); ?>
<div class="row row-sm">
    <div class="col-lg-7 col-xl-7 col-md-7 col-sm-7">
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
                <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">GENDER:</span><span class="span-label-value"><?= esc( $student->gender ) ?></span></p>
                <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">DOB:</span><span class="span-label-value"><?= $student->dob ? esc( h_format_date_display($student->dob) ):''?></span></p>
            </div>
        </div>
        <div>
            <div class="divider">OTHER DETAILS</div>
            <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">BLOOD GROUP:</span><span class="span-label-value"><?= esc( $student->blood_group ) ?></span></p>
            <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">RELIGION:</span><span class="span-label-value"><?= esc( $student->religion ) ?></span></span></p>
            <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">HOUSE:</span><span class="span-label-value"> </span></span></p>
            <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">DORMITRY:</span><span class="span-label-value"> </span><?= $student->accomodation ? esc( $student->accomodation->name ):''?> </span></p>
            <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">BED NUMBER:</span><span class="span-label-value"> </span><?= $student->accomodation ? esc( $student->accomodation->bed_number ):''?> </span></p>
        </div>
        <div>
            <div class="divider">CLASS DETAILS</div>
            <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">ACADEMIC YEAR:</span><span class="span-label-value"><?= $student->current_class?  esc( $student->current_class->year_name ):'' ?></span></p>
            <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">TERM:</span><span class="span-label-value"><?= $student->current_class ? esc( $student->current_class->term_name ):'' ?></span></p>
            <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">CLASS:</span><span class="span-label-value"> <?= $student->current_class ? ($student->current_class->class_name . ($student->current_class->class_short_name ? '('. $student->current_class->class_short_name . ')' :'' ) ) : ($student->admission ? $student->admission->class_name . ( $student->admission->class_short_name ? '('. $student->admission->class_short_name . ')' :'' ): '') ?> </span></span></p>
            <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">STREAM:</span><span class="span-label-value"> <?= $student->current_class ? ($student->current_class->stream_name ) : ($student->admission ? $student->admission->stream_name: '') ?> </span></span></p>
        </div>
    </div>
    <div class="col-lg-5 col-xl-5 col-md-5 col-sm-5">
        <div>
            <div class="divider">FATHER DETAILS</div>
        </div>
        <div class="mt-4">
            <div class="prof-details">
                <p class="text-muted ms-md-3 ms-0 mb-2"><span class="font-weight-semibold me-2">NAME:</span><span class="span-label-value"><?= esc( $student->father ? $student->father->name : '' ) ?></span></p>
                <p class="text-muted ms-md-3 ms-0 mb-2"><span class="font-weight-semibold me-2">TELEPHONE:</span><span class="span-label-value"><?= esc( $student->father ? $student->father->phone : '' ) ?></span></p>
                <p class="text-muted ms-md-3 ms-0 mb-2"><span class="font-weight-semibold me-2">OCCUPATION:</span><span class="span-label-value"><?= esc( $student->father ? $student->father->occupation : '' ) ?></span></p>

                <div class="divider">MOTHER DETAILS</div>

                <p class="text-muted ms-md-3 ms-0 mb-2"><span class="font-weight-semibold me-2">NAME:</span><span class="span-label-value"><?= esc( $student->mother ? $student->mother->name: '' ) ?></span></p>
                <p class="text-muted ms-md-3 ms-0 mb-2"><span class="font-weight-semibold me-2">TELEPHONE:</span><span class="span-label-value"><?= esc( $student->mother ? $student->mother->phone: '') ?></span></p>
                <p class="text-muted ms-md-3 ms-0 mb-2"><span class="font-weight-semibold me-2">OCCUPATION:</span><span class="span-label-value"><?= esc($student->mother ? $student->mother->occupation: '' ) ?></span></p>

                <div class="divider">GUARDIAN DETAILS</div>
                <p class="text-muted ms-md-3 ms-0 mb-2"><span class="font-weight-semibold me-2">NAME:</span><span class="span-label-value"><?= esc( $student->guardian ? $student->guardian->name: '' ) ?></span></p>
                <p class="text-muted ms-md-3 ms-0 mb-2"><span class="font-weight-semibold me-2">TELEPHONE:</span><span class="span-label-value"><?= esc( $student->guardian ? $student->guardian->phone : '' ) ?></span></p>
                <p class="text-muted ms-md-3 ms-0 mb-2"><span class="font-weight-semibold me-2">OCCUPATION:</span><span class="span-label-value"><?= esc( $student->guardian? $student->guardian->occupation: '' ) ?></span></p>
                
            </div>
        </div>
    </div>
</div>