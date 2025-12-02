<div class="modal fade school-large-modal" id="register-new-staff" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Register new staff</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="new-staff-registration-form" method="post" action="<?= base_url('Sys/Staff/submitNewStaffForm'); ?>" enctype="multipart/form-data">
                    <div class="row row-sm">
                        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
                            <div>
                                <div class="divider">BASIC INPUT</div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="staff_name">Full Name <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" id="staff_name" name="staff_name" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="staff_no">Staff No:</label>
                                <input type="text" class="form-control form-control-sm" id="staff_no" name="staff_no" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="dob">Date of Birth:<span class="tx-danger">*</span></label>
                                <input type="date" class="form-control form-control-sm" autocomplete="off" id="dob" name="dob" max="<?= date('Y-m-d'); ?>" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="gender">Gender:<span class="tx-danger">*</span></label>
                                <select name="gender" class="form-control form-select form-control-sm" id="gender" data-bs-placeholder="Select Gender" required>
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="select-department">Department:<span class="tx-danger">*</span></label>
                                <select name="department" class="form-control form-select form-control-sm" id="staff-department-select" data-bs-placeholder="Select department" required>
                                    <option value="">---- select ----</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
                            <div class="divider">BASIC INPUT</div>
                            <div class="form-group">
                                <label class="form-label" for="address">Physical Address:<span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="address" name="address" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="country">Country:<span class="tx-danger">*</span></label>
                                <select name="country" class="form-control form-select form-control-sm" id="country" data-bs-placeholder="Select Country" required>
                                    <option value="Uganda">Uganda</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="identity_type">Identity Type:<span class="tx-danger">*</span></label>
                                <select name="identity_type" class="form-control form-select form-control-sm" id="identity_type" data-bs-placeholder="Select Identity Type" required>
                                    <option value="">---- Select ----- </option>
                                    <option value="passport">PassPort Number</option>
                                    <option value="nin">National Identification No(NIN)</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="identity_no">Identity Number:<span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="identity_no" name="identity_no" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="identity_no">Initials:<span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="initials" name="initials" required>
                            </div>
                        </div>

                        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
                            <div class="divider">BASIC INPUT</div>
                            <div class="form-group">
                                <label class="form-label" for="phone">Phone: <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="phone" name="phone" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="email">Email:</label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="email" name="email">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="photo">Staff Profile Image:</label>
                                <input type="file" class="dropify" data-height="110" id="photo" name="photo">
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="form-group">
                            <label class="form-label" for="ht_phone">SELECT ROLES THAT APPLY TO STAFF: <span class="tx-danger">*</span></label>
                            <div class="row row-sm">
                                <div class="col-lg-12 d-flex">
                                    <label class="ckbox"><input name="roles[]" value="school_teacher" type="checkbox"><span>Teacher</span></label> &nbsp; &nbsp; &nbsp;
                                    <label class="ckbox"><input name="roles[]" value="school_bursar" type="checkbox"><span>Bursar</span></label>&nbsp; &nbsp; &nbsp;
                                    <label class="ckbox"><input name="roles[]" value="school_none_teaching" type="checkbox"><span>Non Teaching</span></label>&nbsp; &nbsp; &nbsp;
                                    <label class="ckbox"><input name="roles[]" value="school_board_member" type="checkbox"><span>Board Member</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-save-new-staff" type="button">Save Staff Details</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>