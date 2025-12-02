<div class="modal fade" id="edit-academic-exam-modal" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Edit Exam</h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="edit-academic-exam-form" method="post" action="<?= base_url('/Sys/AcademicSettings/updateExaminationForm'); ?>">
                    <input type="hidden" name="exam_id" value="<?= esc($exam->id); ?>">
                    <div class="row row-sm">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Exam Label: <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="name" required value="<?= esc($exam->name); ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Exam Short Name: <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="short_name" required value="<?= esc($exam->short_name); ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Description: <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="description" required value="<?= esc($exam->description); ?>">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-update-academic-exam" type="button">Update</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>