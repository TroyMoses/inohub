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
                <div class="main-content-label mb-0 mg-t-8 school-navigation-header">Register New Student</div>
                <div class="ms-auto"><a class="d-block tx-20" data-placement="top" data-bs-toggle="tooltip"
                        title="Register New Student" href="javascript:void(0);"><i
                            class="si si-plus text-muted"></i></a></div>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card custom-card overflow-hidden">
            <div class="card-body">

                <div class="alert alert-outline-info" role="alert">
                    <strong>Please Note:</strong> You MUST fill all Form Sections appropriately before you submit your
                    Application Form!
                </div>

                <form id="new-student-basic-form" method="post"
                    action="<?= base_url('Sys/Students/submitStudentForm'); ?>">

                    <div class="divider">BASIC INFORMATION</div>

                    <div class="row row-sm">
                        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
                            <div class="form-group">
                                <label class="form-label" for="student_number">Student No:</label>
                                <input type="text" class="form-control form-control-sm"
                                    autocomplete="off" id="student_number" name="student_number">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="student_first_name">First Name: <span
                                        class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm"
                                    autocomplete="off" id="student_first_name" name="first_name"
                                    required autofocus="true">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="student_dob">Date of Birth: <span
                                        class="tx-danger">*</span></label>
                                <input type="date" class="form-control form-control-sm"
                                    autocomplete="off" id="student_dob" name="dob"
                                    max="<?= date('Y-m-d'); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="identity_type">Academic Year:<span
                                        class="tx-danger">*</span></label>
                                <select id="student-admission-academic-year" name="academic_year_id" class="form-control form-select form-control-sm" data-bs-placeholder="Select Year" required>
                                    <option value=""> ---- Select ---- </option>
                                    <?php foreach ($academic_years as $key => $academic_year) : ?>
                                        <option id="students_admission_academic_years_<?= esc($academic_year->id); ?>" data-terms="<?= esc(json_encode($academic_year->terms)); ?>" value="<?= esc($academic_year->id); ?>"><?= esc($academic_year->name); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="student_stream">Term:<span
                                class="tx-danger">*</span></label>
                                <select name="term_id" class="form-control form-control-sm form-select"
                                    id="student-admission-terms" data-bs-placeholder="Select Stream" required>
                                    <option value=""> ---- Select ---- </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="student_class">Class:<span
                                class="tx-danger">*</span></label>
                                <select name="class" class="form-control form-control-sm form-select"
                                    id="student_class" data-bs-placeholder="Select Class" required>
                                    <option value="">---- Select ----</option>
                                    <?php foreach ($classes as $key => $class) : ?>
                                    <option id="_student_class_<?= esc($class->id) ?>"
                                        value="<?= esc($class->id); ?>"
                                        data-streams="<?= esc( json_encode($class->streams) ) ?>">
                                        <?= esc($class->name); ?>(<?= esc($class->short_name); ?>)
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="student_stream">Section/Stream:<span
                                class="tx-danger">*</span></label>
                                <select name="stream" class="form-control form-control-sm form-select"
                                    id="student_stream" data-bs-placeholder="Select Stream" required>
                                    <option value=""> ---- Select ---- </option>
                                </select>
                            </div>

                        </div>
                        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
                            <div class="form-group">
                                <label class="form-label" for="student_admission_number">Admission No:</label>
                                <input type="text" class="form-control form-control-sm"
                                    autocomplete="off" id="student_admission_number"
                                    name="admission_number">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="student_last_name">Last Name: <span
                                        class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm"
                                    autocomplete="off" id="student_last_name" name="last_name" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="student_photo">Upload Student
                                    Photo:</label>
                                <input type="file" class="dropify" data-height="110" id="student_photo"
                                    name="photo">
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="student_accounts">Student Accounts:<span class="tx-danger">*</span></label>
                                <select name="accounts[]"
                                    class="form-control form-select select2 form-control-sm"
                                    id="student_accounts" data-bs-placeholder="Select Accounts" required multiple>
                                    <?php foreach ($account_types as $key => $account_type) : ?>
                                        <option value="<?= esc($account_type->id); ?>"><?= esc($account_type->name); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                        </div>
                        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
                            <div class="form-group">
                                <label class="form-label" for="student_admission_date">Admission Date:
                                    <span class="tx-danger">*</span></label>
                                <input type="date" class="form-control form-control-sm"
                                    autocomplete="off" id="student_admission_date" name="admission_date"
                                    value="<?= date('Y-m-d'); ?>" max="<?= date('Y-m-d'); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="student_gender">Gender:<span
                                        class="tx-danger">*</span></label>
                                <select name="gender" class="form-control form-control-sm form-select"
                                    id="student_gender" data-bs-placeholder="Select Gender" required>
                                    <option value="">---- select ----</option>
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="student_house">House:</label>
                                <select name="house" class="form-control form-control-sm form-select"
                                    id="student_house" data-bs-placeholder="Select House">
                                    <option value="">---- select ----</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="student_blood_group">Blood Group:</label>
                                <select name="blood_group"
                                    class="form-control form-control-sm form-select"
                                    id="student_blood_group" data-bs-placeholder="Select Blood Group">
                                    <option value="">---- select ----</option>
                                    <option value="O+">O+</option>
                                    <option value="A+">A+</option>
                                    <option value="B+">B+</option>
                                    <option value="AB+">AB+</option>
                                    <option value="O-">O-</option>
                                    <option value="A-">A-</option>
                                    <option value="B-">B-</option>
                                    <option value="AB-">AB-</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="student_religion">Religion:</label>
                                <select name="religion" class="form-control form-control-sm form-select"
                                    id="student_religion" data-bs-placeholder="Select Region">
                                    <option value="">---- select ----</option>
                                    <option value="Roman Catholic">Roman Catholic</option>
                                    <option value="Anglican">Anglican</option>
                                    <option value="Muslim">Muslim</option>
                                    <option value="Pentecostal">Pentecostal</option>
                                    <option value="Seventh-day Adventist">Seventh-day Adventist</option>
                                    <option value="Other">Other</option>
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

                    <div class="divider">PARENT/GUARDIAN INFORMATION</div>

                    <div class="row row-sm">
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="father_name">Father Name:</label>
                                <input type="text" class="form-control form-control-sm"
                                    autocomplete="off" id="father_name" name="father_name">
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="father_phone">Father Phone:</label>
                                <input maxlength = "10" type="text" class="form-control form-control-sm"
                                    autocomplete="off" id="father_phone" name="father_phone">
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="father_occupation">Occupation:</label>
                                <input type="text" class="form-control form-control-sm"
                                    autocomplete="off" id="father_occupation" name="father_occupation">
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="father_photo">Upload Photo:</label>
                                <input type="file" data-height="110" id="father_photo"
                                    name="father_photo">
                            </div>
                        </div>
                    </div>

                    <div class="row row-sm">
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="mother_name">Mother Name:</label>
                                <input type="text" class="form-control form-control-sm"
                                    autocomplete="off" id="mother_name" name="mother_name">
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="mother_phone">Mother Phone:</label>
                                <input maxlength = "10" type="text" class="form-control form-control-sm"
                                    autocomplete="off" id="mother_phone" name="mother_phone">
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="mother_occupation">Occupation:</label>
                                <input type="text" class="form-control form-control-sm"
                                    autocomplete="off" id="mother_occupation" name="mother_occupation">
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="mother_photo">Upload Photo:</label>
                                <input type="file" data-height="110" id="mother_photo"
                                    name="mother_photo">
                            </div>
                        </div>
                    </div>

                    <div class="divider">If Guardian</div>

                    <div class="row row-sm">
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="guardian_name">Guardian Name :</label>
                                <input type="text" class="form-control form-control-sm"
                                    autocomplete="off" id="guardian_name" name="guardian_name">
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="guardian_phone">Guardian Phone:</label>
                                <input maxlength = "10" type="text" class="form-control form-control-sm"
                                    autocomplete="off" id="guardian_phone" name="guardian_phone">
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="guardian_gender">Guardian Gender:</label>
                                <select name="guardian_gender"
                                    class="form-control form-control-sm form-select"
                                    id="guardian_gender" data-bs-placeholder="Select Gender">
                                    <option value="">---- select ----</option>
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="guardian_photo">Upload Photo:</label>
                                <input type="file" data-height="110" id="guardian_photo"
                                    name="guardian_photo">
                            </div>
                        </div>
                    </div>

                    <div class="row row-sm">
                        <div class="col-lg-4 col-xl-4 col-md-3 col-sm-4">
                            <div class="form-group">
                                <label class="form-label" for="guardian_occupation">Guardian
                                    Occupation:</label>
                                <input type="text" class="form-control form-control-sm"
                                    autocomplete="off" id="guardian_occupation"
                                    name="guardian_occupation">
                            </div>
                        </div>
                        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
                            <div class="form-group">
                                <label class="form-label" for="guardian_address">Guardian
                                    Address:</label>
                                <textarea id="guardian_address" class="form-control" autocomplete="off"
                                    name="guardian_address" rows="1" placeholder=""></textarea>
                            </div>
                        </div>

                        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4 div-right-content-alignment">
                            <button class="btn ripple btn-primary mt-4"
                                id="btn-save-new-student-basic-details" type="button">Save Student
                                Details</button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<!-- End Row -->

<?= $this->endSection('content'); ?>