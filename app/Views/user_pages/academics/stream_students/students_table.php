<?php helper('h_date'); ?>
<input type="hidden" id="view-class-stream-table-id"  class="form-control" value="<?= esc($stream_id); ?>">
<div class="table-responsive export-table">
    <table id="view-students-table" class="table table-bordered text-nowrap key-buttons border-bottom">
        <thead>
            <tr>
                <th class="border-bottom-0">#</th>
                <th class="border-bottom-0">Name</th>
                <th class="border-bottom-0">Student No</th>
                <th class="border-bottom-0">Admission No</th>
                <th class="border-bottom-0">Gender</th>
                <th class="border-bottom-0">DOB</th>
                <th class="border-bottom-0 call-action">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($students)) : ?>
            <?php foreach ($students as $key => $student) : ?>
            <tr>
                <td><?= $key + 1; ?></td>
                <td><?= esc($student->name); ?></td>
                <td><?= esc($student->people_number); ?></td>
                <td><?= esc($student->admission_no); ?></td>
                <td><?= esc($student->gender); ?></td>
                <td><?= $student->dob ? esc(h_format_date_display($student->dob)):''; ?></td>
                <td class="call-action"><button type="button" class="btn btn-primary btn-sm">--- view
                        ---</button></td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>