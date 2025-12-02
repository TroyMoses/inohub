<form id="edit-branch-form" method="post" action="<?= base_url('Sys/Schools/updateBranch'); ?>">
    <input type="hidden" name="branch_id" value="<?= esc($branch->id); ?>">

    <div class="row row-sm">
        <!-- Left Column -->
        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
            <div>
                <div class="divider">BASIC INPUT</div>
            </div>
            <div class="form-group">
                <label class="form-label" for="branch_name">Branch Name: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" id="branch_name" name="branch_name" autocomplete="off" required value="<?= esc($branch->branch_name); ?>">
            </div>
            <div class="form-group">
                <label class="form-label" for="branch_no">Branch No: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" autocomplete="off" id="branch_no" name="branch_no" required value="<?= esc($branch->branch_no); ?>">
            </div>
            <div class="form-group">
                <label class="form-label" for="branch_prefix">Branch Prefix:</label>
                <input type="text" class="form-control" autocomplete="off" id="branch_prefix" name="branch_prefix" value="<?= esc($branch->prefix); ?>">
            </div>
        </div>

        <!-- Middle Column -->
        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
            <div>
                <div class="divider">CONTACT INFO</div>
            </div>
            <div class="form-group">
                <label class="form-label" for="phone">Contact Telephone: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" autocomplete="off" id="phone" name="phone" required value="<?= esc($branch->phone); ?>">
            </div>
            <div class="form-group">
                <label class="form-label" for="branch_email">Contact Email:</label>
                <input type="email" class="form-control" autocomplete="off" id="branch_email" name="email" value="<?= esc($branch->email); ?>">
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
            <div>
                <div class="divider">LOCATION INPUT</div>
            </div>
            <div class="form-group">
                <label class="form-label" for="branch_address">Physical Address: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" autocomplete="off" id="branch_address" name="address" required value="<?= esc($branch->physical_address); ?>">
            </div>
            <div class="form-group">
                <label class="form-label" for="branch_district">City/District: <span class="tx-danger">*</span></label>
                <input type="text" class="form-control" autocomplete="off" id="branch_district" name="district" required value="<?= esc($branch->city); ?>">
            </div>
            <div class="form-group">
                <label class="form-label" for="branch_region">Region: <span class="tx-danger">*</span></label>
                <select name="region" class="form-control form-select" id="branch_region" required>
                    <option value="Central" <?= $branch->region == 'Central' ? 'selected' : ''; ?>>Central</option>
                    <option value="Western" <?= $branch->region == 'Western' ? 'selected' : ''; ?>>Western</option>
                    <option value="Eastern" <?= $branch->region == 'Eastern' ? 'selected' : ''; ?>>Eastern</option>
                    <option value="Northern" <?= $branch->region == 'Northern' ? 'selected' : ''; ?>>Northern</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" for="branch_country">Country: <span class="tx-danger">*</span></label>
                <select name="country" class="form-control form-select" id="branch_country" required>
                    <option value="Uganda" <?= $branch->country == 'Uganda' ? 'selected' : ''; ?>>Uganda</option>
                </select>
            </div>
        </div>
    </div>
</form>
