<div class="modal fade" id="add-new-academic-year" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add Academic Year</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="new-academic-year-reg-form" method="post" action="<?= base_url('/Sys/AcademicSettings/submitAcademicYearForm'); ?>">
                    <div class="row row-sm">
                        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="academic_year_label">Academic Year Label: <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="academic_year_label" name="academic_year_label" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="start_date">Start Date: <span class="tx-danger">*</span></label>
                                <input type="date" class="form-control form-control-sm" autocomplete="off" id="start_date" name="start_date" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="end_date">End Date: <span class="tx-danger">*</span></label>
                                <input type="date" class="form-control form-control-sm" autocomplete="off" id="end_date" name="end_date" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-save-new-academic-year" type="button">Save Academic Year</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>