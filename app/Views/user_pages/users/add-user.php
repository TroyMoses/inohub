<div class="modal fade school-large-modal" id="add-new-branch-user" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add A User</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="new-user-registration-form" method="post" action="<?= base_url('Sys/Users/submitNewUserForm'); ?>">
                    <div class="row row-sm">
                        <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="select-school-staff">Select School Staff :<span class="tx-danger">*</span></label>
                                <select name="staff" class="form-control form-select form-control-sm" id="select-school-staff" data-bs-placeholder="Select Staff" required>
                                    <option value="">---- Select ----- </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="user_rights_group">Select User Group :<span class="tx-danger">*</span></label>
                                <select name="user_group" class="form-control form-select form-control-sm" id="user_rights_group" data-bs-placeholder="Select Region" required>
                                    <option value="">--- select ---</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="branch_region">User Account Status:<span class="tx-danger">*</span></label>
                                <select name="account_status" class="form-control form-select form-control-sm" id="branch_region" data-bs-placeholder="Select Region" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="suspended">Suspended</option>
                                    <option value="pending">Pending</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="branch_region">2FA:<span class="tx-danger">*</span></label>
                                <select name="is_two_factor" class="form-control form-select form-control-sm" id="edit_branch_region" data-bs-placeholder="Select Region" required>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="user_username">Login Username: <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="user_username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="user_password">Login Password:</label>
                                <input type="password" class="form-control form-control-sm" autocomplete="off" id="user_password" name="password">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="user_confirm_password">Confirm Login Password:</label>
                                <input type="password" class="form-control form-control-sm" autocomplete="off" id="user_confirm_password" name="confirm_password">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-save-new-user" type="button">Save User</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>