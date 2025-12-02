<form id="edit-staff-registration-form" method="post" action="<?= base_url('Sys/Staff/submitEditStaffForm'); ?>" enctype="multipart/form-data">
    <input type="hidden" class="form-control form-control-sm" value="<?= esc( $staff->id ) ?>" name="staff_id" autocomplete="off">
    <div class="row row-sm">
        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
            <div>
                <div class="divider">BASIC INPUT</div>
            </div>
            <div class="form-group">
                <label class="form-label" for="staff_name">Full Name <span class="tx-danger">*</span></label>
                <input type="text" class="form-control form-control-sm" id="edit-staff_name" value="<?= esc( $staff->name ) ?>" name="staff_name" autocomplete="off" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="staff_no">Staff No:</label>
                <input type="text" class="form-control form-control-sm" id="edit-staff_no" value="<?= esc( $staff->people_number ) ?>" name="staff_no" autocomplete="off">
            </div>
            <div class="form-group">
                <label class="form-label" for="dob">Date of Birth:<span class="tx-danger">*</span></label>
                <input type="date" class="form-control form-control-sm" autocomplete="off" value="<?= esc( $staff->dob ) ?>" id="edit-dob" name="dob" max="<?= date('Y-m-d'); ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="gender">Gender:<span class="tx-danger">*</span></label>
                <select name="gender" class="form-control form-select form-control-sm" id="edit-gender" data-bs-placeholder="Select Gender" required>
                    <option <?= $staff->gender == 'M' ? 'selected':'' ?> value="M">Male</option>
                    <option <?= $staff->gender == 'F' ? 'selected':'' ?> value="F">Female</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="select-department">Department:<span class="tx-danger">*</span></label>
                <select name="department" class="form-control form-select form-control-sm" id="edit-staff-department-select" data-bs-placeholder="Select department" required>
                    <option value="" value="">---- select ----</option>
                    <?php if (!empty($departments)) : ?>
                        <?php foreach ($departments as $key => $department) : ?>
                            <option <?= $staff->dep_id == $department->id ? 'selected':''  ?> value="<?= esc( $department->id ) ?>"><?= esc( $department->name ) ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
        </div>

        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
            <div class="divider">BASIC INPUT</div>
            <div class="form-group">
                <label class="form-label" for="address">Physical Address:<span class="tx-danger">*</span></label>
                <input type="text" value="<?= esc( $staff->physical_address ) ?>" class="form-control form-control-sm" autocomplete="off" id="edit-address" name="address" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="country">Country:<span class="tx-danger">*</span></label>
                <select name="country" class="form-control form-select form-control-sm" id="edit-country" data-bs-placeholder="Select Country" required>
                    <option <?= $staff->country == 'Uganda' ? 'selected':''  ?> value="Uganda">Uganda</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" for="identity_type">Identity Type:<span class="tx-danger">*</span></label>
                <select name="identity_type" class="form-control form-select form-control-sm" id="edit-identity_type" data-bs-placeholder="Select Identity Type" required>
                    <option value="">---- Select ----- </option>
                    <option <?= $staff->id_type == 'passport' ? 'selected':''  ?> value="passport">PassPort Number</option>
                    <option <?= $staff->id_type == 'nin' ? 'selected':''  ?> value="nin">National Identification No(NIN)</option>
                    <option <?= $staff->id_type == 'other' ? 'selected':''  ?> value="other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" for="identity_no">Identity Number:<span class="tx-danger">*</span></label>
                <input type="text" value="<?= esc( $staff->id_no ) ?>" class="form-control form-control-sm" autocomplete="off" id="edit-identity_no" name="identity_no" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="identity_no">Initials:</label>
                <input type="text" value="<?= esc( $staff->initials ) ?>" class="form-control form-control-sm" autocomplete="off" id="initials" name="initials" required>
            </div>
        </div>

        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
            <div class="divider">BASIC INPUT</div>
            <div class="form-group">
                <label class="form-label" for="phone">Phone: <span class="tx-danger">*</span></label>
                <input type="text" value="<?= esc( $staff->phone ) ?>" class="form-control form-control-sm" autocomplete="off" id="edit-phone" name="phone" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="email">Email:</label>
                <input type="text" value="<?= esc( $staff->email ) ?>" class="form-control form-control-sm" autocomplete="off" id="edit-email" name="email">
            </div>
            <div class="form-group">
                <label class="form-label" for="photo">Staff Profile Image:</label>
                <input type="file" class="dropify" data-height="110" id="edit-photo" name="photo">
            </div>
        </div>
    </div>
    <div class="row row-sm">
        <div class="form-group">
            <label class="form-label" for="ht_phone">SELECT ROLES THAT APPLY TO STAFF: <span class="tx-danger">*</span></label>
            <div class="row row-sm">
                <div class="col-lg-12 d-flex">
                    <label class="ckbox"><input <?= $staff->roles &&  in_array('school_teacher', $staff->roles) ? 'checked':''  ?> name="roles[]" value="school_teacher" type="checkbox"><span>Teacher</span></label> &nbsp; &nbsp; &nbsp;
                    <label class="ckbox"><input <?= $staff->roles &&  in_array('school_bursar', $staff->roles) ? 'checked':''  ?> name="roles[]" value="school_bursar" type="checkbox"><span>Bursar</span></label>&nbsp; &nbsp; &nbsp;
                    <label class="ckbox"><input <?= $staff->roles &&  in_array('school_none_teaching', $staff->roles) ? 'checked':''  ?> name="roles[]" value="school_none_teaching" type="checkbox"><span>Non Teaching</span></label>&nbsp; &nbsp; &nbsp;
                    <label class="ckbox"><input <?= $staff->roles &&  in_array('school_board_member', $staff->roles) ? 'checked':''  ?> name="roles[]" value="school_board_member" type="checkbox"><span>Board Member</span></label>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="modal-footer">
    <button class="btn ripple btn-primary" id="btn-save-edit-staff" type="button">Save Staff</button>
</div>