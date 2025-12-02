<form id="edit-school-registration-form" method="post" action="<?= base_url('Sys/Schools/submitNewSchoolForm'); ?>"
    enctype="multipart/form-data">
    <div class="row row-sm">
        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
            <div>
                <div class="divider">BASIC INPUT</div>
            </div>
            <div class="form-group">
                <label class="form-label" for="school_name">School Name <span class="tx-danger">*</span></label>
                <input type="text" class="form-control form-control-sm" value="<?= esc( $school->school_name ) ?>" id="school_name" name="school_name" autocomplete="off"
                    required>
            </div>
            <div class="form-group">
                <label class="form-label" for="school_short_name">Short Name:</label>
                <input type="text" value="<?= esc( $school->short_name ) ?>" class="form-control form-control-sm" autocomplete="off" id="school_short_name"
                    name="school_short_name">
            </div>
            <div class="form-group">
                <label class="form-label" for="registration_number">Registration Number:<span
                        class="tx-danger">*</span></label>
                <input type="text" value="<?= esc( $school->reg_no ) ?>" class="form-control form-control-sm" autocomplete="off" id="registration_number"
                    name="registration_number" required>
            </div>
            <div class="form-group"> 
                <label class="form-label" for="school_code">School Code:<span class="tx-danger">*</span></label>
                <input type="text" value="<?= esc( $school->school_code ) ?>" class="form-control form-control-sm" autocomplete="off" id="school_code" name="school_code" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="school_owner">School Owned:<span class="tx-danger">*</span></label>
                <select name="school_owner" class="form-control form-select form-control-sm" id="school_owner"
                    data-bs-placeholder="Select Owner" required>
                    <option value="Private">Private</option>
                    <option value="Government_Aided">Government Aided</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" for="edit_school_sections">School Sections:<span
                        class="tx-danger">*</span></label>
                <select name="school_sections" class="form-control form-select form-control-sm"
                    id="edit_school_sections" data-bs-placeholder="Select Sections" required>
                    <option value="Nursury">Nursury</option>
                    <option value="Primary">Primary</option>
                    <option value="Secondary">Secondary</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" for="school_type">School Type:<span class="tx-danger">*</span></label>
                <select name="school_type" class="form-control form-select form-control-sm" id="school_type"
                    data-bs-placeholder="Select Type" required>
                    <option value="">----- select -----</option>
                    <option value="Day">Day</option>
                    <option value="Boarding">Boarding</option>
                    <option value="Both">Both</option>
                </select>
            </div>
        </div>

        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
            <div class="divider">BASIC INPUT</div>
            <div class="form-group">
                <label class="form-label" for="contact_email">School Email Address:</label>
                <input type="email" value="<?= esc( $school->email ) ?>" class="form-control form-control-sm" autocomplete="off" id="contact_email" name="contact_email">
            </div>
            <div class="form-group">
                <label class="form-label" for="date_established">Date Established:<span
                        class="tx-danger">*</span></label>
                <input type="date" value="<?= esc( $school->date_established ) ?>" class="form-control form-control-sm" autocomplete="off" id="date_established" name="date_established"
                    max="<?= date('Y-m-d'); ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="school_color_code">School Color Hex Code: EG: #000000:<span
                        class="tx-danger">*</span></label>
                <input type="text" value="<?= esc( $school->color_hex_code ) ?>" class="form-control form-control-sm" autocomplete="off" id="school_color_code"
                    name="school_color_code" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="school_po_box">Box Address:</label>
                <input type="text" value="<?= esc( $school->po_box ) ?>" class="form-control form-control-sm" autocomplete="off" id="school_po_box" name="school_po_box">
            </div>
            <div class="form-group">
                <label class="form-label" for="school_gender">Gender:<span class="tx-danger">*</span></label>
                <select name="school_gender" class="form-control form-select form-control-sm" id="school_gender"
                    data-bs-placeholder="Select Gender" required>
                    <option value="">--- select ---</option>
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                    <option value="B">Both</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" for="school_logo">Upload School Logo:<span class="tx-danger">*</span></label>
                <input type="file" class="dropify" data-height="110" id="school_logo" name="school_logo" required>
            </div>
        </div>

        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
            <div class="divider">LOCATION INPUT</div>
            <div class="form-group">
                <label class="form-label" for="district">City/District:<span class="tx-danger">*</span></label>
                <input type="text" value="<?= esc( $school->city ) ?>" class="form-control form-control-sm" autocomplete="off" id="district" name="district" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="school_address">Physical Address:<span class="tx-danger">*</span></label>
                <input type="text" value="<?= esc( $school->physical_address ) ?>" class="form-control form-control-sm" autocomplete="off" id="school_address" name="address" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="school_country">Country:<span class="tx-danger">*</span></label>
                <select name="country" class="form-control form-select form-control-sm" id="school_country"
                    data-bs-placeholder="Select Country" required>
                    <option <?= $school->country == 'Uganda' ? 'selected': '' ?> value="Uganda">Uganda</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" for="school_region">Region:<span class="tx-danger">*</span></label>
                <select name="region" class="form-control form-select form-control-sm" id="school_region"
                    data-bs-placeholder="Select Region" required>
                    <option <?= $school->region == 'Central' ? 'selected': '' ?> value="Central">Central</option>
                    <option <?= $school->region == 'Western' ? 'selected': '' ?> value="Western">Western</option>
                    <option <?= $school->region == 'Eastern' ? 'selected': '' ?> value="Eastern">Eastern</option>
                    <option <?= $school->region == 'Northern' ? 'selected': '' ?> value="Northern">Northern</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" for="contact_phone">Contact Telephone:<span class="tx-danger">*</span></label>
                <input type="text" value="<?= esc( $school->phone ) ?>" class="form-control form-control-sm" autocomplete="off" id="contact_phone" name="contact_phone"
                    required>
            </div>

            <div class="form-group">
                <label class="form-label" for="student_no_prefix">Student No Prefix:</label>
                <input type="text" value="<?= esc( $school->student_no_prefix ) ?>" class="form-control form-control-sm" autocomplete="off" id="student_no_prefix" name="student_no_prefix">
            </div>

            <div class="form-group">
                <label class="form-label" for="admission_no_prefix">Admission No Prefix:</label>
                <input type="text" value="<?= esc( $school->admission_no_prefix ) ?>" class="form-control form-control-sm" autocomplete="off" id="admission_no_prefix" name="admission_no_prefix">
            </div>

            <div class="form-group">
                <label class="form-label" for="staff_no_prefix">Staff No Prefix:</label>
                <input type="text" value="<?= esc( $school->staff_no_prefix ) ?>" class="form-control form-control-sm" autocomplete="off" id="staff_no_prefix" name="staff_no_prefix">
            </div>

        </div>

    </div>
    <div class="row row-sm mt-4">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="divider">MANAGEMENT INPUT</div>
        </div>
    </div>
    <div class="row row-sm">
        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
            <div class="form-group">
                <label class="form-label" for="ht_name">Head Teacher Name: <span class="tx-danger">*</span></label>
                <input type="text" value="<?= esc( $school->head_teacher_name ) ?>" class="form-control form-control-sm" autocomplete="off" id="ht_name" name="ht_name" required>
            </div>
        </div>
        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
            <div class="form-group">
                <label class="form-label" for="ht_phone">Head Teacher Phone: <span class="tx-danger">*</span></label>
                <input type="text" value="<?= esc( $school->head_teacher_phone ) ?>" class="form-control form-control-sm" autocomplete="off" id="ht_phone" name="ht_phone" required>
            </div>
        </div>
        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
            <div class="form-group">
                <label class="form-label" for="ht_email">Head Teacher Email:</label>
                <input type="email" value="<?= esc( $school->head_teacher_email ) ?>" class="form-control form-control-sm" autocomplete="off" id="ht_email" name="ht_email">
            </div>
        </div>
        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
            <div class="form-group">
                <label class="form-label" for="ht_signiture">Head Teacher Signature:</label>
                <input type="file" class="form-control form-control-sm" autocomplete="off" id="ht_signiture" name="ht_signiture">
            </div>
        </div>
    </div>
    <div class="row row-sm">
        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
            <div class="form-group">
                <label class="form-label" for="sys_admin_name">Admin Name: <span
                        class="tx-danger">*</span></label>
                <input type="text" class="form-control form-control-sm" autocomplete="off" id="sys_admin_name" name="sys_admin_name"
                    required>
            </div>
        </div>
        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
            <div class="form-group">
                <label class="form-label" for="sys_admin_phone">Admin Phone: <span
                        class="tx-danger">*</span></label>
                <input type="text" class="form-control form-control-sm" autocomplete="off" id="sys_admin_phone" name="sys_admin_phone"
                    required>
            </div>
        </div>
        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
            <div class="form-group">
                <label class="form-label" for="sys_admin_username">Admin Username: <span
                        class="tx-danger">*</span></label>
                <input type="text" class="form-control form-control-sm" autocomplete="off" id="sys_admin_username"
                    name="sys_admin_username" required>
            </div>
        </div>
        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
            <div class="form-group">
                <label class="form-label" for="sys_admin_email">Admin Email:</label>
                <input type="email" class="form-control form-control-sm" autocomplete="off" id="sys_admin_email" name="sys_admin_email">
            </div>
        </div>
    </div>
</form>

<div class="modal-footer">
    <button class="btn ripple btn-primary" id="btn-save-edit-school" type="button">Save School Details</button>
    <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
</div>