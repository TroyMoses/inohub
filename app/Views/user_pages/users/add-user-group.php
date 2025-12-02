
<div class="modal fade" id="user-add-new-user-group" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add User Group</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="add-user-group-form" method="post" action="<?= base_url('Sys/Users/submitNewUserGroupForm'); ?>">
                    <div class="row row-sm">
                        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="user-group-name">Group Name: <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" id="user-group-name"  name="user-group-name" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="user-group-description">Group Description: <span class="tx-danger">*</span></label>
                                <textarea class="form-control" name="user-group-description" id="user-group-description" placeholder="Write some description" rows="2" required></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-save-user-group" type="button">Save Changes</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>