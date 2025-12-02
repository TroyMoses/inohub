<div class="modal fade" id="add-new-academic-class-stream" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add Stream</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="new-academic-class-stream-reg-form" method="post" action="<?= base_url('/Sys/AcademicSettings/submitClassStreamForm'); ?>">
                    <div class="row row-sm">
                        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="stream_label">Stream Label: <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="stream_label" name="name" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="stream_class">Class: <span class="tx-danger">*</span></label>
                                <select name="class" class="form-control form-control-sm form-select" id="stream_class" data-bs-placeholder="Select Stream">
                                    <option value="">---- select ----</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-save-new-academic-class-stream" type="button">Save Stream</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>