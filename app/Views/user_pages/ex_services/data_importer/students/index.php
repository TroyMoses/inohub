    <div class="">
        <div class="panel panel-primary tabs-style-3 p-2" style="border: 0px solid #e3e3e3 !important">
            <div class="tab-menu-heading">
                <div class="tabs-menu ">
                    <!-- Tabs -->
                    <ul class="nav panel-tabs">
                        <li class=""><a href="#tabupload11" class="active btn-sm" data-bs-toggle="tab"> Latest Uploads
                            </a></li>
                        <li><a href="#tabdownload12" class="btn-sm" data-bs-toggle="tab"> Download Students Template </a>
                        </li>
                        <li><a href="#tabuploaded13" class="btn-sm" data-bs-toggle="tab">Upload Students</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body tabs-menu-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tabupload11">
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
                                        <th class="border-bottom-0">Status</th>
                                        <th class="border-bottom-0 call-action">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($results)) : ?>
                                    <?php foreach ($results as $key => $result) : ?>
                                    <tr>
                                        <td><?= $key + 1; ?></td>
                                        <td><?= esc($result->name); ?></td>
                                        <td><?= esc(number_format($result->total_records)); ?></td>
                                        <td><?= esc(number_format($result->total_records)); ?></td>
                                        <td><?= esc(number_format($result->total_failed)); ?></td>
                                        <td><?= esc($result->status); ?></td>
                                        <td class="call-action">
                                            <div class="btn-group">
                                                <div class="dropdown">
                                                    <button aria-expanded="false" aria-haspopup="true"
                                                        class="btn ripple btn-info btn-sm" data-bs-toggle="dropdown"
                                                        type="button">--- action --- <i
                                                            class="fas fa-caret-down ms-1"></i></button>
                                                    <div class="dropdown-menu tx-13">
                                                        <?php if($result->total_records > 0 && $result->status == 'pending'): ?>
                                                            <a class="dropdown-item" data-id="<?= esc($result->id); ?>" id="migrate-to-main-db" href="#!">Migrate To Database</a>
                                                        <?php endif; ?>
                                                        <a class="dropdown-item active"
                                                            href="javascript:void(0);">View Records </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="tabdownload12">
                        <a href="javascript:void(0);" class="btn btn-sm btn-outline-info btn-md mb-2">View Import Students
                            Codes</a>
                        <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary btn-md mb-2 download-student-template-btn">Download Students
                            Template</a>
                    </div>
                    <div class="tab-pane" id="tabuploaded13">
                        <form id="upload-school-students-form" method="post"
                            action="<?= base_url('/Sys/ExServices/DataImporter/submitStudentsUpload'); ?>"
                            enctype="multipart/form-data">
                            <div class="row row-sm">
                                <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label" for="branch_name">Select File: <span
                                                class="tx-danger">*</span></label>
                                        <input type="file" accept=".csv" class="form-control form-control-sm" id="students-upload"
                                            name="file" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="dob">Upload Date:<span
                                                class="tx-danger">*</span></label>
                                        <input type="date" value="<?= date('Y-m-d'); ?>" class="form-control form-control-sm"
                                            autocomplete="off" id="upload-date" name="date" required>
                                    </div>

                                    <input type="hidden" value="file" name="transType" id="transType" >

                                    <button class="btn btn-sm ripple btn-outline-primary" id="btn-upload-students"
                                        type="button">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

