<form id="import-term-students-form" action="<?= base_url('/Sys/ExServices/DataImporter/importTermStudents'); ?>">
    <div class="divider"> FROM </div>

    <div class="row row-sm">
        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
            <div class="form-group">
                <label class="form-label" for="identity_type">Academic Year: <span class="tx-danger">*</span></label>
                <select name="from_year" class="form-control form-select form-control-sm" id="from-term-yr"
                    data-bs-placeholder="Select Status" required>
                    <option value="">---- Select ----- </option>
                    <?php foreach ($academic_years as $key => $academic_year) : ?>
                    <option id="from-term-yr-<?= esc($academic_year->id); ?>"
                        data-terms="<?= esc(json_encode($academic_year->terms)); ?>"
                        value="<?= esc($academic_year->id); ?>"><?= esc($academic_year->name); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
            <div class="form-group">
                <label class="form-label" for="identity_type">Term: <span class="tx-danger">*</span></label>
                <select name="from_term" class="form-control form-select form-control-sm" id="from-yr-terms"
                    data-bs-placeholder="Select Status" required>
                    <option value="">---- Select ----- </option>
                </select>
            </div>
        </div>
    </div>

    <div class="divider">TO </div>
    <div class="row row-sm">
        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
            <div class="form-group">
                <label class="form-label" for="identity_type">Academic Year: <span class="tx-danger">*</span></label>
                <select name="to_year" class="form-control form-select form-control-sm" id="to-term-yr"
                    data-bs-placeholder="Select Status" required>
                    <option value="">---- Select ----- </option>
                    <?php foreach ($academic_years as $key => $academic_year) : ?>
                    <option id="to-term-yr-<?= esc($academic_year->id); ?>"
                        data-terms="<?= esc(json_encode($academic_year->terms)); ?>"
                        value="<?= esc($academic_year->id); ?>"><?= esc($academic_year->name); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
            <div class="form-group">
                <label class="form-label" for="identity_type">Term: <span class="tx-danger">*</span></label>
                <select name="to_term" class="form-control form-select form-control-sm" id="to-yr-terms"
                    data-bs-placeholder="Select Status" required>
                    <option value="">---- Select ----- </option>
                </select>
            </div>
        </div>
    </div>

    <div class="col-lg-2 col-xl-2 col-md-2 col-sm-2 my-auto">
        <button type="button" id="import-term-students-btn"
            class="btn btn-sm btn-primary btn-sm mt-3">Import</button>
    </div>
</form>