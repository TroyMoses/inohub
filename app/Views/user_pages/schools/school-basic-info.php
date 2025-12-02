<?php helper('h_date'); ?>
<div class="row row-sm">
    <div class="col-lg-7 col-xl-7 col-md-7 col-sm-7">
        <div>
            <div class="divider">BASIC PROFILE DATA </div>
        </div>
        <div class="d-md-flex mt-4">
            <div class="">
                <span class="profile-image pos-relative sch-img-thumbnail">
                    <img class="br-5 school-profile-image" alt="" src="<?php echo $school->school_logo ? base_url($school->school_logo) :base_url('assets/img/brand/logo.png'); ?>">
                    <span class="bg-success text-white wd-1 ht-1 rounded-pill profile-online"></span>
                </span>
            </div>
            <div class="prof-details">
                <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">SCH. NAME:</span><span class="span-label-value"><?= esc( $school->school_name ) ?></span></p>
                <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">SHORT NAME:</span><span class="span-label-value"><?= esc( $school->short_name  ) ?></span></p>
                <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">REGISTRATION NO:</span><span class="span-label-value"></span></p>
                <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">SCH. CODE:</span><span class="span-label-value"></span></p>
                <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">SCH. OWNED:</span><span class="span-label-value"></span></p>
                <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">SCH. SECTION:</span><span class="span-label-value"></span></p>
                <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">SCH. TYPE:</span><span class="span-label-value"></span></p>
                <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">SCH. EMAIL:</span><span class="span-label-value"><?= esc(  $school->email )?></span></p>
                <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">ESTABLISHED:</span><span class="span-label-value"><?= esc( h_format_date_display( $school->date_established ) ); ?></span></span></p>
                <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">COLOR CODE:</span><span class="span-label-value"><?= esc( $school->color_hex_code ); ?></span></p>
                <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">BOX ADDRESS:</span><span class="span-label-value"></span></p> 
                <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">SCH. GENDER:</span><span class="span-label-value"></span></p>
            </div>
        </div>
    </div>
    <div class="col-lg-5 col-xl-5 col-md-5 col-sm-5">
        <div>
            <div class="divider">BASIC PROFILE DATA</div>
        </div>
        <div class="mt-4">
            <div class="prof-details">
                <p class="text-muted ms-md-3 ms-0 mb-2"><span class="font-weight-semibold me-2">CITY:</span><span class="span-label-value"><?= esc( $school->city ) ?></span></p>
                <p class="text-muted ms-md-3 ms-0 mb-2"><span class="font-weight-semibold me-2">ADDRESS:</span><span class="span-label-value"><?= esc( $school->physical_address ) ?></span></p>
                <p class="text-muted ms-md-3 ms-0 mb-2"><span class="font-weight-semibold me-2">COUNTRY:</span><span class="span-label-value"><?= esc( $school->country ) ?></span></p>
                <p class="text-muted ms-md-3 ms-0 mb-2"><span class="font-weight-semibold me-2">REGION:</span><span class="span-label-value"><?= esc( $school->region ) ?></span></p>
                <p class="text-muted ms-md-3 ms-0 mb-2"><span class="font-weight-semibold me-2">TELEPHONE:</span><span class="span-label-value"><?= esc( $school->phone ) ?></span></p>

                <div class="divider">MANAGEMENT DATA</div>

                <p class="text-muted ms-md-3 ms-0 mb-2"><span class="font-weight-semibold me-2">HT. NAME:</span><span class="span-label-value"></span></p>
                <p class="text-muted ms-md-3 ms-0 mb-2"><span class="font-weight-semibold me-2">HT. PHONE:</span><span class="span-label-value"></span></p>
                <p class="text-muted ms-md-3 ms-0 mb-2"><span class="font-weight-semibold me-2">HT. EMAIL:</span><span class="span-label-value"></span></p>

                <div class="divider">SYSTEM ADMIN DATA</div>

                <p class="text-muted ms-md-3 ms-0 mb-2"><span class="font-weight-semibold me-2">ADMIN NAME:</span><span class="span-label-value"></span></p>
                <p class="text-muted ms-md-3 ms-0 mb-2"><span class="font-weight-semibold me-2">ADMIN PHONE:</span><span class="span-label-value"></span></p>
                <p class="text-muted ms-md-3 ms-0 mb-2"><span class="font-weight-semibold me-2">ADMIN USERNAME:</span><span class="span-label-value"></span></p>
                <p class="text-muted ms-md-3 ms-0 mb-2"><span class="font-weight-semibold me-2">ADMIN EMAIL:</span><span class="span-label-value"></span></p>
            </div>
        </div>
    </div>
</div>