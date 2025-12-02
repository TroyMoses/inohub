<div class="modal fade" id="modal-edit-user-group" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Edit User Group</h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="edit-user-group-form" method="post" action="<?= base_url('Sys/Users/updateUserGroup'); ?>">
                    <input type="hidden" name="user_group_id" id="edit_user_group_id" value="">

                    <div class="row row-sm">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="edit_user_group_name" class="form-label">Group Name <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" id="edit_user_group_name" name="user_group_name" required>
                            </div>

                            <div class="form-group">
                                <label for="edit_user_group_description" class="form-label">Group Description <span class="tx-danger">*</span></label>
                                <textarea class="form-control" id="edit_user_group_description" name="user_group_description" rows="2" required></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn ripple btn-primary" id="btn-save-edit-user-group">Update Group</button>
                <button type="button" class="btn ripple btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
