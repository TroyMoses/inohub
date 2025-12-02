<div class="modal fade school-large-modal" id="register-new-school" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Register new school</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="new-school-registration-form" method="post" action="<?= base_url('Sys/Schools/submitNewSchoolForm'); ?>" enctype="multipart/form-data">
                    <div class="row row-sm">
                        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
                            <div>
                                <div class="divider">BASIC INPUT</div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="school_name">School Name <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" value="" id="school_name" name="school_name" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="school_short_name">Short Name:</label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="school_short_name" name="school_short_name">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="school_database">Database Name(max 15 characters):<span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" maxlength="15" autocomplete="off" id="school_database" name="school_database" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="registration_number">Registration Number:<span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="registration_number" name="registration_number" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="school_code">School Code:<span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="school_code" name="school_code" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="school_owner">School Owned:<span class="tx-danger">*</span></label>
                                <select name="school_owner" class="form-control form-select form-control-sm" id="school_owner" data-bs-placeholder="Select Owner" required>
                                    <option value="Private">Private</option>
                                    <option value="Government_Aided">Government Aided</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="school_sections">School Sections:<span class="tx-danger">*</span></label>
                                <select name="school_sections" multiple class="form-control form-select select2 form-control-sm" id="school_sections" data-bs-placeholder="Select Sections" required>
                                    <option value="Nursury">Nursury</option>
                                    <option value="Primary">Primary</option>
                                    <option value="Secondary">Secondary</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="school_type">School Type:<span class="tx-danger">*</span></label>
                                <select name="school_type" class="form-control form-select form-control-sm" id="school_type" data-bs-placeholder="Select Type" required>
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
                                <input type="email" class="form-control form-control-sm" autocomplete="off" id="contact_email" name="contact_email">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="date_established">Date Established:<span class="tx-danger">*</span></label>
                                <input type="date" class="form-control form-control-sm" autocomplete="off" id="date_established" name="date_established" max="<?= date('Y-m-d'); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="school_color_code">School Color Hex Code: EG: #000000:<span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="school_color_code" name="school_color_code" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="school_po_box">Box Address:</label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="school_po_box" name="school_po_box">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="school_gender">Gender:<span class="tx-danger">*</span></label>
                                <select name="school_gender" class="form-control form-select form-control-sm" id="school_gender" data-bs-placeholder="Select Gender" required>
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
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="district" name="district" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="school_address">Physical Address:<span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="school_address" name="address" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="school_country">Country:<span class="tx-danger">*</span></label>
                                <select name="country" class="form-control form-select form-control-sm" id="school_country" data-bs-placeholder="Select Country" required>
                                    <option value="Uganda">Uganda</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="school_region">Region:<span class="tx-danger">*</span></label>
                                <select name="region" class="form-control form-select form-control-sm" id="school_region" data-bs-placeholder="Select Region" required>
                                    <option value="Central">Central</option>
                                    <option value="Western">Western</option>
                                    <option value="Eastern">Eastern</option>
                                    <option value="Northern">Northern</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="contact_phone">Contact Telephone:<span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="contact_phone" name="contact_phone" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="student_no_prefix">Student No Prefix:</label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="student_no_prefix" name="student_no_prefix">
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="admission_no_prefix">Admission No Prefix:</label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="admission_no_prefix" name="admission_no_prefix">
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="staff_no_prefix">Staff No Prefix:</label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="staff_no_prefix" name="staff_no_prefix">
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
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="ht_name" name="ht_name" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="ht_phone">Head Teacher Phone: <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="ht_phone" name="ht_phone" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="ht_email">Head Teacher Email:</label>
                                <input type="email" class="form-control form-control-sm" autocomplete="off" id="ht_email" name="ht_email">
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
                                <label class="form-label" for="sys_admin_name">System Admin Name: <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="sys_admin_name" name="sys_admin_name" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="sys_admin_phone">System Admin Phone: <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="sys_admin_phone" name="sys_admin_phone" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="sys_admin_username">System Admin Username: <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="sys_admin_username" name="sys_admin_username" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="sys_admin_email">System Admin Email:</label>
                                <input type="email" class="form-control form-control-sm" autocomplete="off" id="sys_admin_email" name="sys_admin_email">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-save-new-school" type="button">Save Client Details</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>