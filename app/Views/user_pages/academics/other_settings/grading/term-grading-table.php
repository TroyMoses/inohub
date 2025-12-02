<button class="btn ripple btn-primary btn-sm mb-2" id="btn-add-new-term-grading" type="button">Add New</button>
<div class="table-responsive  export-table">
    <table id="term-grading-datatable"
        class="table table-bordered text-nowrap key-buttons border-bottom"> 
        <thead>
            <tr>
                <th class="border-bottom-0">#</th>
                <th class="border-bottom-0">Grading</th>
                <th class="border-bottom-0">Classes</th>
                <th class="border-bottom-0">Session Date</th>
                <th class="border-bottom-0 call-action">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($grades)) : ?>
                <?php foreach ($grades as $key => $grade) : ?>
                    <tr>
                        <td><?= $key + 1; ?></td>
                        <td><?= esc($grade['name']); ?></td>
                        <td>
                            <?php foreach ($grade['classes'] as $key => $class_grade) : ?>
                                <span class="badge bg-primary me-1"><?= esc($class_grade['class_name']); ?><?= $class_grade['short_name'] ? ' ('. esc($class_grade['short_name']) . ')' :''; ?> </span>
                            <?php endforeach; ?>
                        </td>
                        <td><?= esc($grade['date_added']); ?></td>
                        <td class="call-action"><button data-id="<?= $grade['grading_key']; ?>" type="button" class="btn btn-primary btn-sm">Edit</button> <button data-id="<?= $grade['grading_key']; ?>" type="button" class="btn btn-danger btn-sm">Delete</button></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>


<div class="modal fade" id="add-new-term-grading-modal" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add New</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="add-term-classes-grading-form" method="post" action="">
                    
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-save-new-term-grading" type="button">Save</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>
