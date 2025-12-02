
<div class="modal fade" id="add-new-term-class-subject-modal" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add Subject To Class</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="new-term-class-subject-registration-form" method="post"
                    action="<?= base_url('/Sys/Academics/submitTermClassSubjectForm'); ?>" enctype="multipart/form-data">
                    <input type="hidden" autocomplete="off" id="input-term_class_subject_id" name="term">
                    <div class="row row-sm">
                        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="branch_name">Subject: <span
                                        class="tx-danger">*</span></label>
                                <select name="class" class="form-control form-select form-control-sm"
                                    id="new-term-class-select" data-bs-placeholder="Select class" required>
                                    <option value="">--- select ---</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="branch_name">Teacher: <span
                                        class="tx-danger">*</span></label>
                                <select name="stream" class="form-control form-select form-control-sm"
                                    id="new-term-class-stream-select" data-bs-placeholder="Select Stream" required>
                                    <option value="">--- select ---</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-save-new-term-class-subject" type="button">Save Details</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>