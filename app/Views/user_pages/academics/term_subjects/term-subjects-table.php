<input type="hidden" autocomplete="off" id="tb-term_class_subject_class_id" value="<?= esc($class_id); ?>">
<div class="table-responsive  export-table">
    <table id="view-term-class-subjects-table" class="table table-bordered text-nowrap key-buttons border-bottom">
        <thead>
            <tr>
                <th class="border-bottom-0">#</th>
                <th class="border-bottom-0">Subject Name</th>
                <th class="border-bottom-0">Code</th>
                <th class="border-bottom-0">Short Name</th>
                <th class="border-bottom-0">Teacher Name</th>
                <th class="border-bottom-0">Type</th>
                <th class="border-bottom-0 call-action">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($subjects)) : ?>
                <?php foreach ($subjects as $key => $subject) : ?>
                    <tr>
                        <td><?= $key + 1; ?></td>
                        <td><?= esc($subject->name); ?></td>
                        <td><?= esc($subject->code); ?></td>
                        <td><?= esc($subject->short_name); ?></td>
                        <td><?= esc($subject->teacher_name); ?></td>
                        <td><?= esc($subject->subject_type); ?></td>
                        <td class="call-action"><button type="button" data-subjectid="<?= esc($subject->subject_id); ?>" class="btn btn-primary btn-sm remove-class-stream-subject">Remove</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>