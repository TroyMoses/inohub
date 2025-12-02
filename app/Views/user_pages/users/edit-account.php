<div class="modal fade" id="user-edit-user-account" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Edit User Account</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="edit-user-account-form" method="post" action="<?= base_url('Sys/Users/submitEditUserAccountForm'); ?>">
                    <div class="row row-sm">
                        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="edit_user_username">Login Username: <span class="tx-danger">*</span></label>
                                <input type="text" disabled class="form-control form-control-sm" autocomplete="off" id="edit_user_username" value="<?php echo h_session('user_name') ? h_session('user_name') :'' ?>" name="username" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="edit_user_password">New Login Password: <span class="tx-danger">*</span></label>
                                <input type="password" class="form-control form-control-sm" autocomplete="off" id="edit_user_password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="edit_user_confirm_password">Confirm New Login Password: <span class="tx-danger">*</span></label>
                                <input type="password" class="form-control form-control-sm" autocomplete="off" id="edit_user_confirm_password" name="confirm_password" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-save-edit-user-account" type="button">Save Changes</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>