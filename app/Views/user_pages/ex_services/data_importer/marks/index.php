    <div class="">
        <div class="panel panel-primary tabs-style-3 p-2" style="border: 0px solid #e3e3e3 !important">
            <div class="tab-menu-heading">
                <div class="tabs-menu ">
                    <!-- Tabs -->
                    <ul class="nav panel-tabs">
                        <li class=""><a href="#tabuploadMarks" class="active btn-sm" data-bs-toggle="tab"> Latest Uploads
                            </a></li>
                        <li><a href="#tabdownloadMrkTemp" class="btn-sm" data-bs-toggle="tab"> Download Marks Template </a>
                        </li>
                        <li><a href="#tabuploadedMrk" class="btn-sm" data-bs-toggle="tab">Upload Marks</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body tabs-menu-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tabuploadMarks">
                        <div class="table-responsive  export-table">
                            <table id="pending-schools-datatable"
                                class="table table-bordered text-nowrap key-buttons border-bottom">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0">#</th>
                                        <th class="border-bottom-0">Name</th>
                                        <th class="border-bottom-0">Total</th>
                                        <th class="border-bottom-0">Total Succeded</th>
                                        <th class="border-bottom-0">Total Failed</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($marks)) : ?>
                                    <?php foreach ($marks as $key => $mark) : ?>
                                    <tr>
                                        <td><?= $key + 1; ?></td>
                                        <td><?= esc($mark->name); ?></td>
                                        <td><?= esc(number_format($mark->total_records)); ?></td>
                                        <td><?= esc(number_format($mark->successCount)); ?></td>
                                        <td><?= esc(number_format($mark->failedCount)); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="tabdownloadMrkTemp">
                        <form id="download-marks-template-form" action="<?= base_url('/Sys/ExServices/DataImporter/downloadMarksTemplate'); ?>">
                            <div class="row row-sm">
                                <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label" for="identity_type">Academic Year: <span class="tx-danger">*</span></label>
                                        <select name="year" class="form-control form-select form-control-sm"
                                            id="download-template-yr" data-bs-placeholder="Select Status" required>
                                            <option value="">---- Select ----- </option>
                                            <?php foreach ($academic_years as $key => $academic_year) : ?>
                                                <option id="download-template-yr-<?= esc($academic_year->id); ?>" data-terms="<?= esc(json_encode($academic_year->terms)); ?>" value="<?= esc($academic_year->id); ?>"><?= esc($academic_year->name); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                                    <div class="form-group">
                                        <label class="form-label" for="identity_type">Term: <span class="tx-danger">*</span></label>
                                        <select name="term" class="form-control form-select form-control-sm"
                                            id="download-template-yr-terms" data-bs-placeholder="Select Status" required>
                                            <option value="">---- Select ----- </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                                    <div class="form-group">
                                        <label class="form-label" for="identity_type">Class:<span class="tx-danger">*</span></label>
                                        <select name="class" class="form-control form-select form-control-sm"
                                            id="download-template-yr-term-class" data-bs-placeholder="Select Year" required>
                                            <option value="">---- Select ----- </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2 col-xl-2 col-md-2 col-sm-2 my-auto">
                                    <button type="button" id="download-marks-template-btn" class="btn btn-sm btn-primary btn-sm mt-3">Download</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="tabuploadedMrk">
                        <form id="upload-students-marks-form" method="post" action="<?= base_url('/Sys/ExServices/DataImporter/submitStudentMarksUpload'); ?>" enctype="multipart/form-data">
                            <div class="row row-sm">
                                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label" for="branch_name">Select File: <span
                                                class="tx-danger">*</span></label>
                                        <input type="file" accept=".xslx" class="form-control form-control-sm" id="student-marks-upload"
                                            name="file" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="identity_type">Academic Year: <span class="tx-danger">*</span></label>
                                        <select name="year" class="form-control form-select form-control-sm"
                                            id="student-marks-upload-yr" data-bs-placeholder="Select Status" required>
                                            <option value="">---- Select ----- </option>
                                            <?php foreach ($academic_years as $key => $academic_year) : ?>
                                                <option id="student-marks-upload-yr-<?= esc($academic_year->id); ?>" data-terms="<?= esc(json_encode($academic_year->terms)); ?>" value="<?= esc($academic_year->id); ?>"><?= esc($academic_year->name); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label" for="identity_type">Term: <span class="tx-danger">*</span></label>
                                        <select name="term" class="form-control form-select form-control-sm"
                                            id="student-marks-upload-yr-terms" data-bs-placeholder="Select Status" required>
                                            <option value="">---- Select ----- </option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label" for="identity_type">Exam: <span class="tx-danger">*</span></label>
                                        <select name="exam" class="form-control form-select form-control-sm"
                                            id="student-marks-upload-yr-term-exam" data-bs-placeholder="Select Status" required>
                                            <option value="">---- Select ----- </option>
                                        </select>
                                    </div>

                                    <button class="btn btn-sm ripple btn-outline-primary" id="btn-upload-student-marks"
                                        type="button">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>