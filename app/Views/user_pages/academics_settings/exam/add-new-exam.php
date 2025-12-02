<div class="modal fade" id="add-new-academic-exam-modal" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add Exam</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="new-academic-exam-reg-form" method="post" action="<?= base_url('/Sys/AcademicSettings/submitExaminationForm'); ?>">
                    <div class="row row-sm">
                        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="exam_name">Exam Label: <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="exam_name" name="name" required>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label" for="exam_short_name">Exam Short Name: <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="exam_short_name" name="short_name" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="exam_description">Description: <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="exam_description" name="description" required>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-save-new-academic-exam" type="button">Save</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>