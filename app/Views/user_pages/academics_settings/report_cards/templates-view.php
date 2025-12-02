<!-- End Row -->
<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card custom-card overflow-hidden">
            <div class="card-body">
                <div class="row row-sm">
                    <div class="col-lg-12">
                        <a href="javascript:void(0);" style="float:right; margin-left:4px" class="btn btn-primary btn-sm mb-2" id="btn-add-new-report-card-template">Add New</a> &nbsp; &nbsp;
                        <a href="javascript:void(0);" style="float:right" class="btn btn-secondary btn-sm mb-2 mr-2 ml-2" id="">Import From Previous Term</a>
                    </div>
                </div>

                <div class="table-responsive  export-table">
                    <table id="report-card-template-view-datatable"
                        class="table table-bordered text-nowrap key-buttons border-bottom"> 
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">Name</th>
                                <th class="border-bottom-0">Classes</th>
                                <th class="border-bottom-0">File Name</th>
                                <th class="border-bottom-0">Status</th>
                                <th class="border-bottom-0">Session Date</th>
                                <th class="border-bottom-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($templates)) : ?>
                                <?php foreach ($templates as $key => $template) : ?>
                                    <tr>
                                        <td><?= $key + 1; ?></td>
                                        <td><?= esc($template['name']); ?></td>
                                        <td>
                                            <?php foreach ($template['classes'] as $key => $class_temp) : ?>
                                                <span class="badge bg-primary me-1"> <?= esc($class_temp['class_name']); ?> <?= $class_temp['short_name'] ? '('. esc($class_temp['short_name']). ')':''; ?>  </span>
                                            <?php endforeach; ?>
                                        </td>
                                        <td><?= esc($template['file_name']); ?></td>
                                        <td><?= esc($template['status'] == '0'? 'Active':'Inactive'); ?></td>
                                        <td><?= esc($template['date_added']); ?></td>
                                        <td class="call-action"><button type="button" data-id="<?= esc($template['id']); ?>" data-file="<?= esc($template['file_name']); ?>" class="btn btn-primary btn-sm btn-edit-report-card">Edit</button> <button type="button" class="btn btn-danger btn-sm">Delete</button></td>
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
<!-- End Row -->

<div class="modal fade school-large-modal" id="add-new-report-card-template-modal" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">New Report Card Template</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="reg-new-report-card-template-form">
                    <div class="form-group">
                        <label class="form-label" for="grade_title">Template Title: <span class="tx-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" autocomplete="off" placeholder="" id="report-card-template-name" name="name" required>
                    </div>
                    <input type="hidden" id="report-card-template-term-id" value="<?= esc($termId); ?>">
                    <div class="form-group">
                        <label class="form-label" for="grade_title">Select Classes: <span class="tx-danger">*</span></label>
                        <div class="row">
                            <div class="col-lg-12 inline-grade-classes" id="inline-grade-classes">
                                <?php if (!empty($classes)) : ?>
                                    <?php foreach ($classes as $key => $_class) : ?>
                                        <label class="ckbox"><input name="report_class_ids" value="<?= esc($_class->id); ?>" type="checkbox" required><span><?= esc($_class->name); ?>
                                        <?= $_class->short_name ? '('. esc($_class->short_name). ')':''; ?></span></label>&nbsp;&nbsp;
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                
                            </div>
                            <span class="text-danger" id="inline-grade-classes-validation" style="display:none">Please select class</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="report-card-template">Select Template</label>
                        <select id="report-card-templates" name="type_key" class="form-control form-select form-control-sm" data-bs-placeholder="">
                            <option value="template_1">Template 1 </option>
                            <option value="template_2">Template 2</option>
                        </select>
                    </div>

                    <textarea id="report-card-template-editor"></textarea>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn ripple btn-success" id="btn-preview-report-card-temp-btn" type="button">Preview Report Card</button>
                <button class="btn ripple btn-primary" id="btn-save-new-report-card-temp-btn" type="button">Save</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade school-large-modal" id="update-report-card-template-modal" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Update Report Card Template</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="update-report-card-template-form">
                    
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn ripple btn-success" id="btn-update-report-card-temp-btn" type="button">Preview Report Card</button>
                <button class="btn ripple btn-primary" id="btn-save-update-report-card-temp-btn" type="button">Save</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>

        </div>
    </div>
</div>