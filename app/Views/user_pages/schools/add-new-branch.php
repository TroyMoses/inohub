<div class="modal fade school-large-modal" id="register-new-branch" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Register new branch</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="new-branch-registration-form" method="post" action="<?= base_url('Sys/Schools/submitNewBranchForm'); ?>" enctype="multipart/form-data">
                    <div class="row row-sm">
                        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
                            <div>
                                <div class="divider">BASIC INPUT</div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="branch_name">Branch Name: <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control" id="branch_name" name="branch_name" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="dob">Branch No:<span class="tx-danger">*</span></label>
                                <input type="text" class="form-control" autocomplete="off" id="branch_no" name="branch_no" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="branch_prefix">Branch Prefix:</label>
                                <input type="text" class="form-control" autocomplete="off" id="branch_prefix" name="branch_prefix">
                            </div>
                        </div>

                        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
                            <div class="divider">BASIC INPUT</div>
                            <div class="form-group">
                                <label class="form-label" for="phone">Contact Telephone: <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control" autocomplete="off" id="phone" name="phone" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="branch_email">Contact Email:</label>
                                <input type="text" class="form-control" autocomplete="off" id="branch_email" name="email">
                            </div>
                        </div>

                        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
                            <div class="divider">LOCATION INPUT</div>
                            <div class="form-group">
                                <label class="form-label" for="branch_address">Physical Address:<span class="tx-danger">*</span></label>
                                <input type="text" class="form-control" autocomplete="off" id="branch_address" name="address" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="branch_district">City/District:<span class="tx-danger">*</span></label>
                                <input type="text" class="form-control" autocomplete="off" id="branch_district" name="district" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="branch_region">Region:<span class="tx-danger">*</span></label>
                                <select name="region" class="form-control form-select" id="branch_region" data-bs-placeholder="Select Region" required>
                                    <option value="Central">Central</option>
                                    <option value="Western">Western</option>
                                    <option value="Eastern">Eastern</option>
                                    <option value="Northern">Northern</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="branch_country">Country:<span class="tx-danger">*</span></label>
                                <select name="country" class="form-control form-select" id="branch_country" data-bs-placeholder="Select Country" required>
                                    <option value="Uganda">Uganda</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-save-new-branch" type="button">Save Branch Details</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>