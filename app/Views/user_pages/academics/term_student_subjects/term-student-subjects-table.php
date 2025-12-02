<input type="hidden" value="<?= esc($streamId); ?>" id="term-student-subject-stream-id">
<div class="table-responsive  export-table">
    <table id="term-students-subject-datatable"
        class="table table-bordered text-nowrap key-buttons border-bottom"> 
        <thead>
            <tr>
                <th class="border-bottom-0">#</th>
                <th class="border-bottom-0">Student No</th>
                <th class="border-bottom-0">Student Name</th>
                <th class="border-bottom-0">Subjects</th>
                <th class="border-bottom-0 call-action">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($students)) : ?>
                <?php foreach ($students as $key => $student) : ?>
                    <tr>
                        <td><?= $key + 1; ?></td>
                        <td><?= esc($student->people_number); ?></td>
                        <td><?= esc($student->name); ?></td>
                        <td>
                            <?php foreach ($student->subjects as $key => $_student) : ?>
                                <span class="badge bg-primary me-1"><?= $_student->code ? esc($_student->code). ' - ' :'' ?><?= esc($_student->name) ?><?= $_student->short_name ? ' ('. esc($_student->short_name) . ')': '' ?></span>
                            <?php endforeach; ?>
                        </td>
                        <td class="call-action"><button type="button" data-id="<?= esc($student->student_id); ?>" class="btn btn-primary btn-sm term-student-subjects-btn">Edit</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="add-term-student-subjects-modal" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add Subjects</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" id="term-student-subjects-details-container">
                
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-save-term-student-subjects" type="button">Save</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>