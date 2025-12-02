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
                <div class="main-content-label mb-0 mg-t-8 school-navigation-header">
                    <?php echo h_session('current_page') ? h_session('current_page') :'' ?></div>
                <div class="ms-auto"><a class="d-block tx-20" data-placement="top" data-bs-toggle="tooltip"
                        title="<?php echo h_session('current_page') ? h_session('current_page') :'' ?>"
                        href="javascript:void(0);"><i class="si si-plus text-muted"></i></a></div>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->

<div class="row row-sm">
    <div class="col-lg-3">
        <div class="card custom-card overflow-hidden">
            <div class="card-body p-1">
                <div class="mg-b-20">
                    <div class="main-content-left main-content-left-mail">
                        <a class="btn btn-primary btn-compose" href="" id="btnCompose">OTHER SETTINGS PORTAL:</a>
                        <div class="main-mail-menu">
                            <nav class="nav main-nav-column mg-b-20">
                                <a class="nav-link thumb active" data-bs-toggle="tab" href="#tabSchoolRequirements"><i
                                        class="fa fa-home"></i> School Requirements </a>
                                <a class="nav-link thumb" data-bs-toggle="tab" href="#tabStudentRequirements"><i
                                        class="fa fa-edit"></i>
                                    Student Requirements</a>
                                <a class="nav-link thumb" data-bs-toggle="tab" href="#tabTermSchoolRequirements"><i
                                        class="fa fa-cog"></i> Term School Requirements</a>
                                <a class="nav-link thumb" data-bs-toggle="tab" href="#tabTermStudentRequirements"><i
                                        class="fa fa-cog"></i> Term Student Requirements</a>
                                <a class="nav-link thumb" data-bs-toggle="tab" href="#tabStudentAccomodation"><i
                                        class="fa fa-cog"></i> Student Accomodation</a>
                            </nav>
                        </div>
                        <!-- main-mail-menu -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-9">
        <div class="tab-content">

            <div class="tab-pane active show" id="tabSchoolRequirements">

                <div class="row row-sm">
                    <div class="col-lg-12">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body">
                                <a href="javascript:void(0);" data-bs-target="#add-new-school-requirements-modal"
                                    data-bs-toggle="modal" class="btn btn-primary btn-sm mb-2">Add School
                                    Requirement</a>
                                <div class="table-responsive  export-table">
                                    <table id="pending-schools-datatable"
                                        class="table table-bordered text-nowrap key-buttons border-bottom">
                                        <thead>
                                            <tr>
                                                <th class="border-bottom-0">#</th>
                                                <th class="border-bottom-0">Name</th>
                                                <th class="border-bottom-0">Description</th>
                                                <th class="border-bottom-0">Status</th>
                                                <th class="border-bottom-0">Session Date</th>
                                                <th class="border-bottom-0 call-action">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($school_requirements)) : ?>
                                            <?php foreach ($school_requirements as $key => $school_requirement) : ?>
                                            <tr>
                                                <td><?= $key + 1; ?></td>
                                                <td><?= esc($school_requirement->name); ?></td>
                                                <td><?= esc($school_requirement->description); ?></td>
                                                <td><?= $school_requirement->status == '0'? 'Active':'Inactive'; ?></td>
                                                <td><?= esc(h_format_date_display($school_requirement->date_added)); ?>
                                                </td>
                                                <td class="call-action"><button
                                                        data-id="<?= esc($school_requirement->id); ?>" type="button"
                                                        class="btn btn-primary btn-sm">Edit</button> <button
                                                        data-id="<?= esc($school_requirement->id); ?>" type="button"
                                                        class="btn btn-danger btn-sm">Delete</button></td>
                                            </tr>
                                            <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="tab-pane" id="tabStudentRequirements">


                <div class="row row-sm">
                    <div class="col-lg-12">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body">
                                <a href="javascript:void(0);" data-bs-target="#add-new-stud-requirements-modal"
                                    data-bs-toggle="modal" class="btn btn-primary btn-sm mb-2">Add Student
                                    Requirements</a>
                                <div class="table-responsive  export-table">
                                    <table id="pending-schools-datatable2"
                                        class="table table-bordered text-nowrap key-buttons border-bottom">
                                        <thead>
                                            <tr>
                                                <th class="border-bottom-0">#</th>
                                                <th class="border-bottom-0">Name</th>
                                                <th class="border-bottom-0">Description</th>
                                                <th class="border-bottom-0">Status</th>
                                                <th class="border-bottom-0">Session Date</th>
                                                <th class="border-bottom-0 call-action">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($student_requirements)) : ?>
                                            <?php foreach ($student_requirements as $key => $student_requirement) : ?>
                                            <tr>
                                                <td><?= $key + 1; ?></td>
                                                <td><?= esc($student_requirement->name); ?></td>
                                                <td><?= esc($student_requirement->description); ?></td>
                                                <td><?= $student_requirement->status == '0'? 'Active':'Inactive'; ?>
                                                </td>
                                                <td><?= esc(h_format_date_display($student_requirement->date_added)); ?>
                                                </td>
                                                <td class="call-action"><button
                                                        data-id="<?= esc($student_requirement->id); ?>" type="button"
                                                        class="btn btn-primary btn-sm">Edit</button> <button
                                                        data-id="<?= esc($student_requirement->id); ?>" type="button"
                                                        class="btn btn-danger btn-sm">Delete</button></td>
                                            </tr>
                                            <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="tab-pane" id="tabTermSchoolRequirements">

                <div class="row row-sm">
                    <div class="col-lg-12">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body">
                                <form method="post" action="" enctype="multipart/form-data">
                                    <div class="row row-sm">
                                        <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label" for="identity_type">Academic Year:<span
                                                        class="tx-danger">*</span></label>
                                                <select name="term_school_req_academic_years"
                                                    class="form-control form-select form-control-sm"
                                                    id="term_school_req_academic_years"
                                                    data-bs-placeholder="Select Year" required>
                                                    <option value="">---- Select ----- </option>
                                                    <?php foreach ($academic_years as $key => $academic_year) : ?>
                                                    <option
                                                        id="term_school_req_academic_years_<?= esc($academic_year->id); ?>"
                                                        data-terms="<?= esc(json_encode($academic_year->terms)); ?>"
                                                        value="<?= esc($academic_year->id); ?>">
                                                        <?= esc($academic_year->name); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label" for="identity_type">Academic Term:<span
                                                        class="tx-danger">*</span></label>
                                                <select name="term_school_req_academic_year_terms"
                                                    class="form-control form-select form-control-sm"
                                                    id="term_school_req_academic_year_terms"
                                                    data-bs-placeholder="Select Status" required>
                                                    <option value="">---- Select ----- </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div id="tabTerm-School-Requirements-container"></div>
                    </div>
                </div>

            </div>

            <div class="tab-pane" id="tabTermStudentRequirements">


                <div class="row row-sm">
                    <div class="col-lg-12">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body">
                                <form method="post" action="" enctype="multipart/form-data">
                                    <div class="row row-sm">
                                        <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label" for="identity_type">Academic Year:<span
                                                        class="tx-danger">*</span></label>
                                                <select name="term_student_req_academic_years"
                                                    class="form-control form-select form-control-sm"
                                                    id="term_student_req_academic_years"
                                                    data-bs-placeholder="Select Year" required>
                                                    <option value="">---- Select ----- </option>
                                                    <?php foreach ($academic_years as $key => $academic_year) : ?>
                                                    <option
                                                        id="term_student_req_academic_years_<?= esc($academic_year->id); ?>"
                                                        data-terms="<?= esc(json_encode($academic_year->terms)); ?>"
                                                        value="<?= esc($academic_year->id); ?>">
                                                        <?= esc($academic_year->name); ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label" for="identity_type">Academic Term:<span
                                                        class="tx-danger">*</span></label>
                                                <select name="term_student_req_academic_year_terms"
                                                    class="form-control form-select form-control-sm"
                                                    id="term_student_req_academic_year_terms"
                                                    data-bs-placeholder="Select Status" required>
                                                    <option value="">---- Select ----- </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Row -->


            </div>

            <div class="tab-pane" id="tabStudentAccomodation">


                <div class="row row-sm">
                    <div class="col-lg-12">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-body">
                                <a href="javascript:void(0);" data-bs-target="#add-new-school-dormitry"
                                    data-bs-toggle="modal" class="btn btn-primary btn-sm mb-2">Add New Dormitory</a>
                                <div class="table-responsive  export-table">
                                    <table id="pending-schools-datatable3"
                                        class="table table-bordered text-nowrap key-buttons border-bottom">
                                        <thead>
                                            <tr>
                                                <th class="border-bottom-0">#</th>
                                                <th class="border-bottom-0">Name</th>
                                                <th class="border-bottom-0">No of Beds</th>
                                                <th class="border-bottom-0">Session Date</th>
                                                <th class="border-bottom-0 call-action">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($accomodations)) : ?>
                                            <?php foreach ($accomodations as $key => $accomodation) : ?>
                                            <tr>
                                                <td><?= $key + 1; ?></td>
                                                <td><?= esc($accomodation->name); ?></td>
                                                <td><?= esc($accomodation->number_of_beds); ?></td>
                                                <td><?= esc(h_format_date_display($accomodation->date_added)); ?></td>
                                                <td class="call-action"><button data-id="<?= esc($accomodation->id); ?>"
                                                        type="button" class="btn btn-primary btn-sm">Edit</button>
                                                    <button data-id="<?= esc($accomodation->id); ?>" type="button"
                                                        class="btn btn-danger btn-sm">Delete</button></td>
                                            </tr>
                                            <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>

        </div>
    </div>
</div>
<!-- End Row -->


<div class="modal fade" id="add-new-school-dormitry" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add New Dormitory</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="new-dormitry-registration-form" method="post"
                    action="<?= base_url('/Sys/Settings/submitNewDormitryForm'); ?>">
                    <div class="row row-sm">
                        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">

                            <div class="form-group">
                                <label class="form-label" for="user_username">Name: <span
                                        class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" name="name"
                                    required>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="user_username">No of Beds: <span
                                        class="tx-danger">*</span></label>
                                <input type="number" class="form-control form-control-sm" autocomplete="off"
                                    name="no_of_beds" required>
                            </div>

                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-save-new-dormitry" type="button">Save</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="add-new-school-requirements-modal" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add New Requirement</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="new-sch-req-registration-form" method="post"
                    action="<?= base_url('/Sys/Settings/submitSchRequirementsForm'); ?>">
                    <input type="hidden" name="req_type" value="school">
                    <div class="row row-sm">
                        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">

                            <div class="form-group">
                                <label class="form-label" for="user_username">Name: <span
                                        class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" name="name"
                                    required>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="user_username">Description: <span
                                        class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off"
                                    name="description" required>
                            </div>

                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-save-new-sch-requirement" type="button">Save</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="add-new-stud-requirements-modal" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add New Requirement</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="new-stud-req-registration-form" method="post"
                    action="<?= base_url('/Sys/Settings/submitSchRequirementsForm'); ?>">
                    <div class="row row-sm">
                        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                            <input type="hidden" name="req_type" value="student">
                            <div class="form-group">
                                <label class="form-label" for="user_username">Name: <span
                                        class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" name="name"
                                    required>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="user_username">Description: <span
                                        class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off"
                                    name="description" required>
                            </div>

                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-save-new-stud-requirement" type="button">Save</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>