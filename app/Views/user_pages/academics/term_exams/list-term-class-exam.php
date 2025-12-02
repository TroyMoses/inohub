<div class="row">
    <div class="col-lg-12 col-xl-12">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">Term Class Exams</div>
                <a href="javascript:void(0);" class="btn btn-primary btn-sm mb-2" id="add-exam-to-term-class">Add
                    Exam</a>
                <div id="view-class-term-exam-view-td">
                    <div class="table-responsive  export-table">
                        <table id="view-term-class-exam-table" class="table table-bordered text-nowrap key-buttons border-bottom">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">Exam</th>
                                    <th class="border-bottom-0">Short Name</th>
                                    <th class="border-bottom-0">Classes</th>
                                    <th class="border-bottom-0 call-action">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($exams)) : ?>
                                <?php foreach ($exams as $key => $exam) : ?>
                                <tr>
                                    <td><?= $key + 1; ?></td>
                                    <td><?= esc($exam['name']); ?></td>
                                    <td><?= esc($exam['short_name']); ?></td>
                                    <td>
                                        <?php foreach ($exam['classes'] as $key => $class_exam) : ?>
                                            <span class="badge bg-primary me-1"> <?= $class_exam['short_name'] ? esc($class_exam['short_name']) :esc($class_exam['class_name']); ?> - <?= esc($class_exam['total_mark']); ?> | <?= esc($class_exam['final_mark_contribution']); ?> </span>
                                        <?php endforeach; ?>
                                    </td>
                                    <td class="call-action"><button type="button" class="btn btn-primary btn-sm">Edit</button> <button type="button" class="btn btn-danger btn-sm">Delete</button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade school-large-modal" id="add-class-term-exam-modal" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Term Exams</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="class-term-exams-form">
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-save-class-term-exams-btn" type="button">Save</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>

        </div>
    </div>
</div>