<div class="form-group">
    <label class="form-label" for="grade_title">Template Title: <span class="tx-danger">*</span></label>
    <input type="text" value="<?= esc($title); ?>" class="form-control form-control-sm" autocomplete="off" placeholder="" id="update-report-card-template-name" name="name" required>
</div>
<input type="hidden" id="update-report-card-template-term-id" value="<?= esc($termId); ?>">
<div class="form-group">
    <label class="form-label" for="grade_title">Select Classes: <span class="tx-danger">*</span></label>
    <div class="row">
        <div class="col-lg-12 inline-grade-classes" id="update-inline-grade-classes">
            <?php if (!empty($classes)) : ?>
                <?php foreach ($classes as $key => $_class) : ?>
                    <label class="ckbox"><input <?= in_array($_class->id, $classesList)? 'checked':'' ?> name="update_report_class_ids" value="<?= esc($_class->id); ?>" type="checkbox" required><span><?= esc($_class->name); ?>
                    <?= $_class->short_name ? '('. esc($_class->short_name). ')':''; ?></span></label>&nbsp;&nbsp;
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <span class="text-danger" id="inline-grade-classes-validation" style="display:none">Please select class</span>
    </div>
</div>

<div class="form-group">
    <label class="form-label" for="register_std_fees_payment_mtd">Select Template</label>
    <select name="type_key" class="form-control form-select form-control-sm" data-bs-placeholder="">
        <option value="template_1">Template 1 </option>
        <!-- <option value="template_2">Template 2</option> -->
    </select>
</div>

<textarea id="update-report-card-template-editor" >
 &lt;p&gt;Initial Document Content&lt;/p&gt;
</textarea>
<!-- <div id="update-report-card-template-editor"></div> -->