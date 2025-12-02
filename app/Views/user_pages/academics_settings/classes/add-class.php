<div class="modal fade" id="add-new-school-class" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add Class</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="new-class-reg-form" method="post" action="<?= base_url('/Sys/AcademicSettings/submitSchoolClassForm'); ?>">
                    <div class="row row-sm">
                        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="class_name">Class Name: <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="class_name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="short_name">Class Short Name: <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="short_name" name="short_name" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="class_section">Class Section:<span class="tx-danger">*</span></label>
                                <select name="class_section" class="form-control form-select select2 form-control-sm" id="class_section" data-bs-placeholder="Select Section" required>
                                    <option value="">---- Select ----</option>
                                    <option value="Nursury">Nursury</option>
                                    <option value="Primary">Primary</option>
                                    <option value="Secondary">Secondary</option>
                                </select>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-save-new-school-class" type="button">Save Class</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>