<div class="modal fade school-large-modal" id="add-new-class-grading" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add Grade</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="reg-new-class-grading-form" method="post" action="<?= base_url('/Sys/AcademicSettings/submitClassesGrading'); ?>">
                    <div class="row row-sm">
                        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="grade_title">Grade Title: <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" placeholder="eg. O-Level Grading" id="grade_title" name="grade_title" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="grade_title">Select Classes: <span class="tx-danger">*</span></label>
                                <div class="row">
                                    <div class="col-lg-12 inline-grade-classes" id="inline-grade-classes">
                                        <!-- <label class="ckbox"><input name="class_ids[]" value="1" type="checkbox" required><span>Senior One (S.1)</span></label>&nbsp;&nbsp;
                                        <label class="ckbox"><input name="class_ids[]" value="2" type="checkbox" required><span>Senior Two (S.2)</span></label>&nbsp;&nbsp;
                                        <label class="ckbox"><input name="class_ids[]" value="3" type="checkbox" required><span>Senior Three (S.3)</span></label>
                                        <label class="ckbox"><input name="class_ids[]" value="4" type="checkbox" required><span>Senior Four (S.4)</span></label>
                                        <label class="ckbox"><input name="class_ids[]" value="5" type="checkbox" required><span>Senior Five (S.5)</span></label>
                                        <label class="ckbox"><input name="class_ids[]" value="6" type="checkbox" required><span>Senior Six (S.6)</span></label> -->
                                    </div>
                                    <span class="text-danger" id="inline-grade-classes-validation" style="display:none">Please select class</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="description">Description:</label>
                                <textarea class="form-control form-control-sm" name="description" id="description" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                            <button class="btn ripple btn-primary btn-sm float-end" id="btn-add-more-class-grade-fields" type="button">Add More</button>
                        </div>
                    </div>
                    <div id="multiply-class-grades">
                        <div class="row row-sm grade-group">
                            <div class="col-lg-2 col-xl-2 col-md-2 col-sm-2">
                                <div class="form-group">
                                    <label class="form-label" for="grade">Grade: <span class="tx-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" placeholder="eg. A+" autocomplete="off" id="grade" name="grade[]" required>
                                    <input type="hidden" class="form-control form-control-sm" id="grade_id" name="grade_id[]" required>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xl-2 col-md-2 col-sm-2">
                                <div class="form-group">
                                    <label class="form-label" for="grade_min">Agg: <span class="tx-danger">*</span></label>
                                    <input type="number" class="form-control form-control-sm" placeholder="eg. 4" autocomplete="off" id="grade_agg" name="grade_agg[]" required>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xl-2 col-md-2 col-sm-2">
                                <div class="form-group">
                                    <label class="form-label" for="grade_min">Min: <span class="tx-danger">*</span></label>
                                    <input type="number" class="form-control form-control-sm" placeholder="eg. 0" autocomplete="off" id="grade_min" name="grade_min[]" required>
                                </div>
                            </div>
                            <div class="col-lg-2 col-xl-2 col-md-2 col-sm-2">
                                <div class="form-group">
                                    <label class="form-label" for="grade_max">Max: <span class="tx-danger">*</span></label>
                                    <input type="number" class="form-control form-control-sm" placeholder="eg. 30" autocomplete="off" id="grade_max" name="grade_max[]" required>
                                </div>
                            </div>
                            <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                                <div class="form-group">
                                    <label class="form-label" for="grade_remark">Remarks: <span class="tx-danger">*</span></label>
                                    <textarea class="form-control form-control-sm" placeholder="eg. Keep Hard working" name="grade_remark[]" id="grade_remark" rows="1" required></textarea>
                                </div>
                            </div>
                            <div class="col-lg-1 col-xl-1 col-md-1 col-sm-1">
                                <div class="remove-new-grade-form-field">
                                    <span class="section_id_error text-danger rtl-float-right cursor-pointer"><i class="fa fa-times remove_row"></i></span>                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-save-new-class-grade" type="button">Save Grade</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>