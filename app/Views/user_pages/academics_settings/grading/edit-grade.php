<div class="modal fade school-large-modal" id="edit-class-grade-modal" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Edit Grade Info</h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-class-grade-form" method="post" action="<?= base_url('/Sys/AcademicSettings/updateClassGrade'); ?>">
                    <input type="hidden" name="grade_id" value="<?= esc($grade->id); ?>">

                    <div class="form-group">
                        <label class="form-label">Grade Title: <span class="tx-danger">*</span></label>
                        <input type="text" class="form-control" name="grade_title" value="<?= esc($grade->title); ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="grade_title">Select Classes: <span class="tx-danger">*</span></label>
                        <div class="row">
                            <div class="col-lg-12 inline-grade-classes" id="inline-grade-classes">
                                <?php if (!empty($classes)) : ?>
                                    <?php foreach ($classes as $class): ?>
                                        <label class="ckbox">
                                            <input type="checkbox" name="class_ids[]" value="<?= $class->id; ?>"
                                                <?= in_array($class->id, array_column($grade->classes, 'class_id')) ? 'checked' : ''; ?>>
                                            <span><?= esc($class->name); ?> (<?= esc($class->short_name); ?>)</span>
                                        </label>&nbsp;&nbsp;
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="description">Description:</label>
                        <textarea class="form-control form-control-sm" name="description" id="description" rows="2"><?= esc($grade->description); ?></textarea>
                    </div>



                    <hr>
                    <h6>Grading Details</h6>
                    <div id="edit-multiply-class-grades">
                        <?php if (!empty($grade->grades)) : ?>
                            <?php foreach ($grade->grades as $g) : ?>
                                <div class="row row-sm grade-group">
                                    <div class="col-lg-2 col-xl-2 col-md-2 col-sm-2">
                                        <div class="form-group">
                                            <label class="form-label" for="grade">Grade: <span class="tx-danger">*</span></label>
                                            <input type="text" class="form-control" name="grade[]" id="grade" value="<?= esc($g->grade); ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-xl-2 col-md-2 col-sm-2">
                                        <div class="form-group">
                                            <label class="form-label" for="grade_min">Agg: <span class="tx-danger">*</span></label>
                                            <input type="number" class="form-control" id="grade_agg" name="grade_agg[]" value="<?= esc($g->aggregate); ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-xl-2 col-md-2 col-sm-2">
                                        <div class="form-group">
                                            <label class="form-label" for="grade_min">Min: <span class="tx-danger">*</span></label>
                                            <input type="number" class="form-control" name="grade_min[]" id="grade_min" value="<?= esc($g->min); ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-xl-2 col-md-2 col-sm-2">
                                        <div class="form-group">
                                            <label class="form-label" for="grade_max">Max: <span class="tx-danger">*</span></label>
                                            <input type="number" class="form-control" name="grade_max[]" id="grade_max" value="<?= esc($g->max); ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                                        <div class="form-group">
                                            <label class="form-label" for="grade_remark">Remarks: <span class="tx-danger">*</span></label>
                                            <textarea class="form-control" name="grade_remark[]" id="grade_remark" required><?= esc($g->remarks); ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-1 col-xl-1 col-md-1 col-sm-1">
                                        <div class="remove-new-grade-form-field">
                                            <span class="section_id_error text-danger rtl-float-right cursor-pointer">
                                                <i class="fa fa-times remove_row"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-update-class-grade" type="button">Update</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>