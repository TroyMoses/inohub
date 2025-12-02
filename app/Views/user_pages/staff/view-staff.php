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
                        src="<?php echo $staff->image_url ? base_url($staff->image_url) :base_url('assets/img/brand/user-img.png'); ?>">
                    <span
                        class="bg-success text-white wd-1 ht-1 rounded-pill profile-online"></span> 
                </span>
            </div>
            <div class="prof-details">
                <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">FULL NAME:</span><span class="span-label-value"><?= esc( $staff->name ) ?></span></p>
                <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">STAFF NO:</span><span class="span-label-value"><?= esc( $staff->people_number ) ?></span></p>
                <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">GENDER:</span><span class="span-label-value"><?= esc( $staff->gender ) ?></span></p>
                <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">DOB:</span><span class="span-label-value"><?= esc( h_format_date_display($staff->dob) ) ?></span></p>
                <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">DEP:</span><span class="span-label-value"><?= esc( $staff->dep_name ) ?></span></p>

                <div class="row row-sm">
                    <div class="form-group">
                        <label class="form-label" for="ht_phone">SELECT ROLES THAT APPLY TO STAFF:</label>
                        <div class="row row-sm">
                            <div class="col-lg-12">
                                <?php if ($staff->roles && in_array('school_teacher', $staff->roles )) : ?>
                                    <label class="ckbox mt-1"><input checked name="roles[]" value="school_teacher" type="checkbox"><span>Teacher</span></label>
                                <?php endif; ?>
                                <?php if ($staff->roles && in_array('school_bursar', $staff->roles )) : ?>
                                    <label class="ckbox mt-1"><input checked name="roles[]" value="school_bursar" type="checkbox"><span>Bursar</span></label>
                                <?php endif; ?>
                                <?php if ($staff->roles && in_array('school_none_teaching', $staff->roles )) : ?>
                                    <label class="ckbox mt-1"><input checked name="roles[]" value="school_none_teaching" type="checkbox"><span>Non Teaching</span></label>
                                <?php endif; ?>
                                <?php if ($staff->roles && in_array('school_board_member', $staff->roles )) : ?>
                                    <label class="ckbox mt-1"><input checked name="roles[]" value="school_board_member" type="checkbox"><span>Board Member</span></label>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-lg-5 col-xl-5 col-md-5 col-sm-5">
        <div>
            <div class="divider">OTHER DETAILS</div>
            <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">PHYSICAL ADDRESS:</span><span class="span-label-value"><?= esc( $staff->physical_address ) ?></span></p>
            <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">PHONE:</span><span class="span-label-value"><?= esc( $staff->phone ) ?></span></span></p>
            <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">INDENTITY TYPE:</span><span class="span-label-value"><?= esc( $staff->id_type ) ?></span></span></p>
            <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">INDENTITY NO:</span><span class="span-label-value"><?= esc( $staff->id_no ) ?></span></span></p>
        </div>
    </div>
</div>
