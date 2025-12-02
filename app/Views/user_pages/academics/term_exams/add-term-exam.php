<div class="form-group">
    <label class="form-label" for="country">Exam:<span class="tx-danger">*</span></label>
    <select name="country" class="form-control form-select form-control-sm" id="class-term-examination" data-bs-placeholder="Select Country" required>
        <option value="">--- select ---</option>
        <?php if (!empty($exams)) : ?>
            <?php foreach ($exams as $key => $exam) : ?>
                <option value="<?= esc($exam->id); ?>"><?= esc($exam->name); ?></option>
            <?php endforeach; ?>
        <?php endif; ?>
    </select>
</div>

<input type="hidden" value="<?= esc($termId); ?>" id="term-class-examination-id" >

<table class="table table-bordered text-nowrap key-buttons border-bottom" id="class-term-exams-form-table">
    <thead>
        <tr>
            <th class="border-bottom-0">Class</th>
            <th class="border-bottom-0">Marked out of</th>
            <th class="border-bottom-0">Final mark Contribution</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($classes)) : ?>
            <?php foreach ($classes as $key => $_class) : ?>
                <tr>
                    <td><?= esc($_class->name); ?> <?= $_class->short_name ? '('. esc($_class->short_name). ')':''; ?></td>
                    <td><input type="number" data-classid="<?= esc($_class->id); ?>" class="form-control form-control-sm" name="exam-marked-out-of" autocomplete="off" max="100" value="0" required></td> 
                    <td><input type="number" data-classid="<?= esc($_class->id); ?>" class="form-control form-control-sm" name="exam-final-mark-contribution" autocomplete="off" max="100" value="0" required></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>