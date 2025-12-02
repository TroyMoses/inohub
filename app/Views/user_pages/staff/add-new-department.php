<div class="modal fade school-large-modal" id="register-new-department" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Register new department</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="new-department-registration-form" method="post" action="<?= base_url('Sys/Staff/submitNewDepartmentForm'); ?>" enctype="multipart/form-data">
                    <div class="row row-sm">
                        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
                            <div>
                                <div class="divider">BASIC INPUT</div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="department_name">Department Name <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" id="department_name" name="name" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="department_head">Department Head:</label>
                                <select name="department_head" class="form-control form-select form-control-sm" id="select-department-head" data-bs-placeholder="Select Head" >
                                    <option value="">---- Select ----- </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
                            <div class="divider">BASIC INPUT</div>
                            <div class="form-group">
                                <label class="form-label" for="dob">Short Name:</label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="short_name" name="short_name">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="identity_type">Department Status:<span class="tx-danger">*</span></label>
                                <select name="department_status" class="form-control form-select form-control-sm" id="department_status" data-bs-placeholder="Select Status" required>
                                    <option value="">---- Select ----- </option>
                                    <option value="0" selected>Active</option>
                                    <option value="1">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
                            <div class="divider">BASIC INPUT</div>
                            <div class="form-group">
                                <label class="form-label" for="identity_type">Parent Department:</label>
                                <select name="parent_department" class="form-control form-select form-control-sm" id="select-parent-department" data-bs-placeholder="Select Parent Department">
                                    <option value="">---- Select ----- </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-save-new-department" type="button">Save Department Details</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>