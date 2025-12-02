<form id="edit-user-registration-form" method="post" action="<?= base_url('Sys/Users/submitEditUserForm'); ?>">
<input type="hidden" class="form-control form-control-sm" autocomplete="off" name="user_id" value="<?= esc($user->id); ?>">
<input type="hidden" class="form-control form-control-sm" autocomplete="off" name="people_id" value="<?= esc($user->people_id); ?>">

    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="form-group">
                <label class="form-label" for="user_username">Login Username: <span class="tx-danger">*</span></label>
                <input type="text" value="<?= esc($user->user_name); ?>" disabled class="form-control form-control-sm" autocomplete="off" id="edit_user_username" name="username" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="user_rights_group">Select User Group :<span class="tx-danger">*</span></label>
                <select name="user_group" class="form-control form-select form-control-sm" id="edit_user_rights_group" data-bs-placeholder="Select Region" required>
                    <option value="">--- select ---</option>
                    <?php if (!empty($userGroups)) : ?>
                        <?php foreach ($userGroups as $key => $userGroup) : ?>
                            <option <?= $user->access_group_id == $userGroup->id ? 'selected':''; ?> value="<?= esc($userGroup->id); ?>"><?= esc($userGroup->group_name); ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?> 
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" for="branch_region">User Account Status:<span class="tx-danger">*</span></label>
                <select name="account_status" class="form-control form-select form-control-sm" id="edit_branch_region" data-bs-placeholder="Select Region" required>
                    <option <?= $user->status == 'active'? 'selected':''; ?> value="active">Active</option>
                    <option <?= $user->status == 'inactive'? 'selected':''; ?> value="inactive">Inactive</option>
                    <option <?= $user->status == 'suspended'? 'selected':''; ?> value="suspended">Suspended</option>
                    <option <?= $user->status == 'pending'? 'selected':''; ?> value="pending">Pending</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" for="branch_region">2FA:<span class="tx-danger">*</span></label>
                <select name="is_two_factor" class="form-control form-select form-control-sm" id="edit_branch_region" data-bs-placeholder="Select Region" required>
                    <option <?= $user->is_2fa == 'Yes'? 'selected':''; ?> value="Yes">Yes</option>
                    <option <?= $user->is_2fa == 'No'? 'selected':''; ?> value="No">No</option>
                </select>
            </div>
            <div class="divider">CHANGE PASSWORD</div>
            <div class="form-group">
                <label class="form-label" for="user_password">Login Password:</label>
                <input type="password" class="form-control form-control-sm" autocomplete="off" id="edit_user_password" name="password">
            </div>
            <div class="form-group">
                <label class="form-label" for="user_confirm_password">Confirm Login Password:</label>
                <input type="password" class="form-control form-control-sm" autocomplete="off" id="edit_user_confirm_password" name="confirm_password">
            </div>
        </div>
    </div>
</form>