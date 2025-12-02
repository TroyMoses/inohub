<input type="hidden" value="<?= esc($streamId); ?>" id="edit-term-student-subject-stream-id">
<input type="hidden" value="<?= esc($classId); ?>" id="edit-term-student-subject-class-id">
<input type="hidden" value="<?= esc($termId); ?>" id="edit-term-student-subject-term-id">
<input type="hidden" value="<?= esc($studentId); ?>" id="edit-term-student-subject-student-id">

<table class="table table-bordered text-nowrap key-buttons border-bottom" id="student-term-subjects-form-table">
    <thead>
        <tr>
            <th class="border-bottom-0">Name</th>
            <th class="border-bottom-0">Code</th>
            <th class="border-bottom-0">Short Name</th>
            <th class="border-bottom-0 call-action">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($subjects)) : ?>
            <?php foreach ($subjects as $key => $subject) : ?>
                <tr>
                    <td><?= esc($subject->name); ?> </td>
                    <td><?= esc($subject->code) ?></td>
                    <td><?= esc($subject->short_name); ?></td> 
                    <td> <label class="ckbox"><input data-id="<?= esc($subject->subject_id); ?>" name="term-student-subjects-input" value="" type="checkbox"><span></span></label> </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>