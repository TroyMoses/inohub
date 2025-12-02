<button class="btn ripple btn-primary btn-sm" id="btn-add-new-school-requirements" type="button">Add New</button>
<div class="table-responsive  export-table">
    <table id="schools-requirements-datatable"
        class="table table-bordered text-nowrap key-buttons border-bottom"> 
        <thead>
            <tr>
                <th class="border-bottom-0">#</th>
                <th class="border-bottom-0">Class</th>
                <th class="border-bottom-0">Requirements</th>
                <th class="border-bottom-0">Session Date</th>
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
                        <td class="call-action"><button data-id="<?= h_encrypt_decrypt($student->id); ?>" type="button" class="btn btn-primary btn-sm view-student-details">--- view ---</button></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>