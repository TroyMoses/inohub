<div class="divider">EDIT PROFILE </div>

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card custom-card overflow-hidden">
            <div class="card-body">
                <div class="alert alert-outline-info" role="alert">
                    <strong>Please Note:</strong> You MUST fill all Form Sections appropriately before you submit your
                    Application Form!
                </div>

                <form id="update-students-basic-form" method="post"
                    action="<?= base_url('Sys/Students/submitUpdateStudentForm'); ?>">

                    <div class="divider">BASIC INFORMATION</div>

                    <input type="hidden" value="<?= esc( $student->id ) ?>"
                                    id="edit_student_id" name="student_id">
                    
                    <input type="hidden" value="<?= $student->admission ? esc( $student->admission->id ): '' ?>"
                        id="edit_admission_student_id" name="admission_id">
                    
                    <div class="row row-sm">
                        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
                            <div class="form-group">
                                <label class="form-label" for="student_number">Student No:<span
                                        class="tx-danger">*</span></label>
                                <input type="text" value="<?= esc( $student->people_number ) ?>"
                                    class="form-control form-control-sm" autocomplete="off"
                                    id="edit_student_number" name="student_number" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="student_first_name">First Name: <span
                                        class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm"
                                    autocomplete="off" value="<?= esc( $student->first_name ) ?>"
                                    id="edit_student_first_name" name="first_name" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="student_dob">Date of Birth:</label>
                                <input type="date" class="form-control form-control-sm"
                                    autocomplete="off" id="edit_student_dob"
                                    value="<?= esc( $student->dob ) ?>" name="dob"
                                    max="<?= date('Y-m-d'); ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="student_class">Class:</label>
                                <select name="class" class="form-control form-control-sm form-select"
                                    id="edit_student_class" data-bs-placeholder="Select Class">
                                    <option value="">---- Select ----</option>
                                    <?php foreach ($classes as $key => $class) : ?>
                                    <option
                                        <?= $student->admission && $student->admission->admission_class_id == $class->id ? 'selected' : '' ?>
                                        id="_edit_student_class_<?= esc($class->id) ?>"
                                        value="<?= esc($class->id); ?>"
                                        data-streams="<?= esc( json_encode($class->streams) ) ?>">
                                        <?= esc($class->name); ?>(<?= esc($class->short_name); ?>)
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="student_stream">Section/Stream:</label>
                                <select name="stream" class="form-control form-control-sm form-select"
                                    id="edit_student_stream" data-bs-placeholder="Select Stream">
                                    <option value=""> ---- Select ---- </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
                            <div class="form-group">
                                <label class="form-label" for="student_admission_number">Admission
                                    No: <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm"
                                    autocomplete="off" id="edit_student_admission_number"
                                    name="admission_number"
                                    value="<?= $student->admission ? $student->admission->admission_no: '' ?>"
                                    required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="student_last_name">Last Name: <span
                                        class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm"
                                    autocomplete="off" value="<?= esc( $student->last_name ) ?>"
                                    id="edit_student_last_name" name="last_name" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="student_photo">Upload Student
                                    Photo:</label>
                                <input type="file" class="dropify" data-height="110"
                                    id="edit_student_photo" name="photo">
                            </div>
                        </div>
                        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
                            <div class="form-group">
                                <label class="form-label" for="student_admission_date">Admission Date:
                                    <span class="tx-danger">*</span></label>
                                <input type="date" class="form-control form-control-sm"
                                    autocomplete="off" id="edit_student_admission_date"
                                    name="admission_date"
                                    value="<?= $student->admission ? $student->admission->admission_date: '' ?>"
                                    max="<?= date('Y-m-d'); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="student_gender">Gender:<span
                                        class="tx-danger">*</span></label>
                                <select name="gender" class="form-control form-control-sm form-select"
                                    id="edit_student_gender" data-bs-placeholder="Select Gender"
                                    required>
                                    <option value="">---- select ----</option>
                                    <option <?= esc( $student->gender ) == 'M' ? 'selected':'' ?>
                                        value="M">Male</option>
                                    <option <?= esc( $student->gender ) == 'F' ? 'selected':'' ?>
                                        value="F">Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="student_house">House:</label>
                                <select name="house" class="form-control form-control-sm form-select"
                                    id="edit_student_house" data-bs-placeholder="Select House">
                                    <option value="">---- select ----</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="student_blood_group">Blood Group:</label>
                                <select name="blood_group"
                                    class="form-control form-control-sm form-select"
                                    id="edit_student_blood_group"
                                    data-bs-placeholder="Select Blood Group">
                                    <option value="">---- select ----</option>
                                    <option <?= $student->blood_group == 'O+' ? 'selected':'' ?>
                                        value="O+">O+</option>
                                    <option <?= $student->blood_group == 'A+' ? 'selected':'' ?>
                                        value="A+">A+</option>
                                    <option <?= $student->blood_group == 'B+' ? 'selected':'' ?>
                                        value="B+">B+</option>
                                    <option <?= $student->blood_group == 'AB+' ? 'selected':'' ?>
                                        value="AB+">AB+</option>
                                    <option <?= $student->blood_group == 'O-' ? 'selected':'' ?>
                                        value="O-">O-</option>
                                    <option <?= $student->blood_group == 'A-' ? 'selected':'' ?>
                                        value="A-">A-</option>
                                    <option <?= $student->blood_group == 'B-' ? 'selected':'' ?>
                                        value="B-">B-</option>
                                    <option <?= $student->blood_group == 'AB-' ? 'selected':'' ?>
                                        value="AB-">AB-</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="student_religion">Religion:</label>
                                <select name="religion" class="form-control form-control-sm form-select"
                                    id="edit_student_religion" data-bs-placeholder="Select Region">
                                    <option value="">---- select ----</option>
                                    <option
                                        <?= $student->religion == 'Roman Catholic' ? 'selected':'' ?>
                                        value="Roman Catholic">Roman Catholic</option>
                                    <option <?= $student->religion == 'Anglican' ? 'selected':'' ?>
                                        value="Anglican">Anglican</option>
                                    <option <?= $student->religion == 'Muslim' ? 'selected':'' ?>
                                        value="Muslim">Muslim</option>
                                    <option <?= $student->religion == 'Pentecostal' ? 'selected':'' ?>
                                        value="Pentecostal">Pentecostal</option>
                                    <option
                                        <?= $student->religion == 'Seventh-day Adventist' ? 'selected':'' ?>
                                        value="Seventh-day Adventist">Seventh-day Adventist</option>
                                    <option <?= $student->religion == 'Other' ? 'selected':'' ?>
                                        value="Other">Other</option>
                                </select>
                            </div>
                            
                        </div>
                    </div>

                    <div class="divider">PARENT/GUARDIAN INFORMATION</div>

                    <input value="<?= $student->father ? $student->father->id: '' ?>" type="hidden" class="form-control form-control-sm" name="father_id"
                        id="edit-form-student-parents-father">

                    <input value="<?= $student->mother ? $student->mother->id: '' ?>" type="hidden" class="form-control form-control-sm" name="mother_id"
                        id="edit-form-student-parents-mother">

                    <input value="<?= $student->guardian ? $student->guardian->id: '' ?>" type="hidden" class="form-control form-control-sm" name="gardian_id"
                        id="edit-form-student-parents-gardian">

                    <div class="row row-sm">
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="father_name">Father Name:</label>
                                <input value="<?= $student->father ? $student->father->name: '' ?>" type="text" class="form-control form-control-sm"
                                    autocomplete="off"  id="edit_father_name" name="father_name">
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="father_phone">Father Phone:</label>
                                <input maxlength = "10" value="<?= $student->father ? $student->father->phone: '' ?>" type="text" class="form-control form-control-sm"
                                    autocomplete="off" id="edit_father_phone" name="father_phone">
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="father_occupation">Occupation:</label>
                                <input value="<?= $student->father ? $student->father->occupation: '' ?>" type="text" class="form-control form-control-sm"
                                    autocomplete="off" id="edit_father_occupation"
                                    name="father_occupation">
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="father_photo">Upload Photo:</label>
                                <input type="file" data-height="110" id="edit_father_photo"
                                    name="father_photo">
                            </div>
                        </div>
                    </div>

                    <div class="row row-sm">
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="mother_name">Mother Name:</label>
                                <input value="<?= $student->mother ? $student->mother->name: '' ?>" type="text" class="form-control form-control-sm"
                                    autocomplete="off" id="edit_mother_name" name="mother_name">
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="mother_phone">Mother Phone:</label>
                                <input maxlength = "10" value="<?= $student->mother ? $student->mother->phone: '' ?>" type="text" class="form-control form-control-sm"
                                    autocomplete="off" id="edit_mother_phone" name="mother_phone">
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="mother_occupation">Occupation:</label>
                                <input value="<?= $student->mother ? $student->mother->occupation: '' ?>" type="text" class="form-control form-control-sm"
                                    autocomplete="off" id="edit_mother_occupation"
                                    name="mother_occupation">
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="mother_photo">Upload Photo:</label>
                                <input type="file" data-height="110" id="edit_mother_photo"
                                    name="mother_photo">
                            </div>
                        </div>
                    </div>

                    <div class="divider">If Guardian</div>

                    <div class="row row-sm">
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="guardian_name">Guardian Name :</label>
                                <input value="<?= $student->guardian ? $student->guardian->name: '' ?>" type="text" class="form-control form-control-sm"
                                    autocomplete="off" id="edit_guardian_name" name="guardian_name">
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="guardian_phone">Guardian Phone:</label>
                                <input maxlength = "10" value="<?= $student->guardian ? $student->guardian->phone: '' ?>" type="text" class="form-control form-control-sm"
                                    autocomplete="off" id="edit_guardian_phone" name="guardian_phone">
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="guardian_gender">Guardian Gender:</label>
                                <select name="guardian_gender"
                                    class="form-control form-control-sm form-select"
                                    id="edit_guardian_gender" data-bs-placeholder="Select Gender">
                                    <option value="">---- select ----</option>
                                    <option <?= $student->guardian && $student->guardian->gender == 'M' ? 'selected': '' ?> value="M">Male</option>
                                    <option <?= $student->guardian && $student->guardian->gender == 'F' ? 'selected': '' ?> value="F">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="guardian_photo">Upload Photo:</label>
                                <input type="file" data-height="110" id="edit_guardian_photo"
                                    name="guardian_photo">
                            </div>
                        </div>
                    </div>

                    <div class="row row-sm">
                        <div class="col-lg-4 col-xl-4 col-md-3 col-sm-4">
                            <div class="form-group">
                                <label class="form-label" for="guardian_occupation">Guardian
                                    Occupation:</label>
                                <input value="<?= $student->guardian ? $student->guardian->occupation: '' ?>" type="text" class="form-control form-control-sm"
                                    autocomplete="off" id="edit_guardian_occupation"
                                    name="guardian_occupation">
                            </div>
                        </div>
                        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
                            <div class="form-group">
                                <label class="form-label" for="guardian_address">Guardian
                                    Address:</label>
                                <textarea id="edit_guardian_address" value="<?= $student->guardian ? $student->guardian->physical_address: '' ?>" class="form-control"
                                    autocomplete="off" name="guardian_address" rows="1"
                                    placeholder=""></textarea>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4 div-right-content-alignment">
                            <button class="btn ripple btn-primary mt-4"
                                id="btn-save-update-student-basic-details" type="button">Update Student
                                Details</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
<!-- End Row -->