<div class="modal fade" id="edit-academic-year-modal" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Edit Academic Year</h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-academic-year-form" method="post" action="<?= base_url('/Sys/AcademicSettings/submitUpdateAcademicYearForm'); ?>">
                    <input type="hidden" name="academic_year_id" id="edit_academic_year_id">
                    <div class="row row-sm">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Academic Year Label: <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" name="academic_year_label" id="edit_academic_year_label" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Start Date: <span class="tx-danger">*</span></label>
                                <input type="date" class="form-control form-control-sm" name="start_date" id="edit_start_date" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">End Date: <span class="tx-danger">*</span></label>
                                <input type="date" class="form-control form-control-sm" name="end_date" id="edit_end_date" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-update-academic-year" type="button">Update</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>
