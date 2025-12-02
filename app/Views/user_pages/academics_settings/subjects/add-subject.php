<div class="modal fade" id="add-new-academic-subject" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add Subject</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="new-subject-reg-form" method="post" action="<?= base_url('/Sys/AcademicSettings/submitNewSubjectForm'); ?>">
                    <div class="row row-sm">
                        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="subject_label">Subject Name: <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="subject_label" name="name" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="short_name">Subject Short Name: <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="short_name" name="short_name" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="subject_code">Subject Code: <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="subject_code" name="subject_code" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="subject_type">Subject Type: <span class="tx-danger">*</span></label>
                                <select name="subject_type" class="form-control form-control-sm form-select" id="subject_type" data-bs-placeholder="Select Subject Type">
                                    <option value="">---- select ----</option>
                                    <option value="Theory">Theory</option>
                                    <option value="Practical">Practical</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="class_section">Related Subject:</label>
                                <select name="related_subject" class="form-control form-select select2 form-control-sm" id="related_subject" data-bs-placeholder="Select Section">
                                    <option value="">---- Select ----</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-save-new-academic-subject" type="button">Save Subject</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>