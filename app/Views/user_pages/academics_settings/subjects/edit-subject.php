<div class="modal fade" id="edit-subject-modal" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Edit Subject</h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-subject-form" method="post" action="<?= base_url('/Sys/AcademicSettings/updateSubjectForm'); ?>">
                    <input type="hidden" name="subject_id" value="<?= esc($subject->id); ?>">

                    <div class="row row-sm">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Subject Name: <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control" name="name" value="<?= esc($subject->name); ?>" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Subject Short Name: <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control" name="short_name" value="<?= esc($subject->short_name); ?>" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Subject Code: <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control" name="subject_code" value="<?= esc($subject->code); ?>" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Subject Type: <span class="tx-danger">*</span></label>
                                <select name="subject_type" class="form-control form-select" required>
                                    <option value="">---- Select ----</option>
                                    <option value="Theory" <?= $subject->subject_type == 'Theory' ? 'selected' : '' ?>>Theory</option>
                                    <option value="Practical" <?= $subject->subject_type == 'Practical' ? 'selected' : '' ?>>Practical</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Related Subject:</label>
                                <select name="related_subject" class="form-control form-select select2">
                                    <option value="">---- Select ----</option>
                                    <?php foreach ($subjects as $item): ?>
                                        <?php if ($item->id != $subject->id): ?>
                                            <option value="<?= $item->id ?>" <?= ($subject->related_subject ?? null) == $item->id ? 'selected' : '' ?>>
                                                <?= esc($item->name); ?>
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
                <button class="btn ripple btn-primary" id="btn-update-subject" type="button">Update Subject</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>