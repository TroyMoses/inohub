<div class="row row-sm">
    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">

        <div class="form-group">
            <label class="form-label" for="identity_type">Grading Type:<span class="tx-danger">*</span></label>
            <select name="grading_type" class="form-control form-select form-control-sm" id="grading_type" data-bs-placeholder="Select Type" required>
                <option value="">---- Select ----- </option>
                <option value="grading">Grading/Divisions</option>
                <option value="positioning">Positioning</option>
            </select>
        </div>

        <input id="term-grading-term-id" value="<?= esc($termId); ?>" type="hidden">

        <div class="row row-sm">
            <div class="form-group">
                <label class="form-label" for="ht_phone">Classes: <span class="tx-danger">*</span></label>
                <div class="row row-sm">
                    <div class="col-lg-12 d-flex">
                        <?php if (!empty($classes)) : ?>
                            <?php foreach ($classes as $key => $_class) : ?>
                                <label class="ckbox"><input name="term-grading-classes-id" data-id="<?= esc($_class->id); ?>" type="checkbox"><span><?= esc($_class->name); ?> <?= $_class->short_name ? '('. esc($_class->short_name). ')':''; ?></span></label> &nbsp; &nbsp; &nbsp;
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>