<div class="modal fade school-large-modal" id="edit-department-modal" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Edit Department</h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="edit-department-form" method="post" action="<?= base_url('Sys/Staff/submitEditDepartmentForm'); ?>" enctype="multipart/form-data">
                    <input type="hidden" name="department_id" value="<?= esc($department->id) ?>">

                    <div class="row row-sm">
                        <div class="col-lg-4">
                            <div class="divider">Basic Info</div>
                            <div class="form-group">
                                <label class="form-label">Department Name <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="name" value="<?= esc($department->name) ?>" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Department Head:</label>
                                <select name="department_head" class="form-control form-select form-control-sm">
                                    <option value="">---- Select -----</option>
                                    <?php foreach ($staff as $person): ?>
                                        <option <?= $department->head_people_id == $person->id ? 'selected' : '' ?> value="<?= esc($person->id) ?>">
                                            <?= esc($person->name) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="divider">More Info</div>
                            <div class="form-group">
                                <label class="form-label">Short Name:</label>
                                <input type="text" class="form-control form-control-sm" name="short_name" value="<?= esc($department->short_name) ?>">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Department Status:<span class="tx-danger">*</span></label>
                                <select name="department_status" class="form-control form-select form-control-sm" required>
                                    <option value="">---- Select -----</option>
                                    <option value="0" <?= $department->status == 0 ? 'selected' : '' ?>>Active</option>
                                    <option value="1" <?= $department->status == 1 ? 'selected' : '' ?>>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="divider">Parent Department</div>
                            <div class="form-group">
                                <label class="form-label">Parent Department:</label>
                                <select name="parent_department" class="form-control form-select form-control-sm">
                                    <option value="">---- Select -----</option>
                                    <?php foreach ($departments as $dept): ?>
                                        <?php if ($dept->id != $department->id): // prevent selecting self ?>
                                            <option <?= $department->parent_department_id == $dept->id ? 'selected' : '' ?> value="<?= esc($dept->id) ?>">
                                                <?= esc($dept->name) ?>
                                            </option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-save-edit-department" type="button">Update Department</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>
