<div class="modal fade" id="add-new-academic-year-term" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add Term</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="new-academic-year-term-reg-form" method="post" action="<?= base_url('/Sys/AcademicSettings/submitAcademicYearTermForm'); ?>">
                    <div class="row row-sm">
                        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="term_label">Term Label: <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="term_label" name="term_label" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="term_academic_year_label">Academic Year: <span class="tx-danger">*</span></label>
                                <select name="term_academic_year" class="form-control form-control-sm form-select" id="term_academic_year_label" data-bs-placeholder="Select Academic Year">
                                    <option value="">---- select ----</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="start_date">Start Date: <span class="tx-danger">*</span></label>
                                <input type="date" class="form-control form-control-sm" autocomplete="off" id="start_date" name="start_date" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="end_date">End Date: <span class="tx-danger">*</span></label>
                                <input type="date" class="form-control form-control-sm" autocomplete="off" id="end_date" name="end_date" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="order_number">Order Number: <span class="tx-danger">*</span></label>
                                <input type="number" class="form-control form-control-sm" autocomplete="off" id="order_number" name="order_number" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-save-new-academic-year-term" type="button">Save Term</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>