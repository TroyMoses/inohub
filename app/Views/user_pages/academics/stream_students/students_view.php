<?php helper('h_date'); ?>
<div class="row">
    <div class="col-lg-4 col-xl-3">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">Streams</div>
            </div>
            <div class="main-content-left main-content-left-mail card-body pt-0">
                <div class="main-settings-menu">
                    <nav class="nav main-nav-column">
                        <?php if (!empty($streams)) : ?>
                        <?php foreach ($streams as $key => $_stream) : ?>
                        <a id="view-class-stream-students-<?= esc($_stream->id); ?>" class="nav-link <?php echo $stream ? $stream->id == $_stream->id ? 'active':'' :''?> thumb mb-2 view-class-stream-students" data-id="<?= esc($_stream->id); ?>"
                            href="javascript:view_class_stream_students(<?= esc($_stream->id); ?>);"><i class="fe fe-grid"></i> Stream - <?= esc($_stream->name); ?>
                        </a>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-xl-9">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">Class Stream Students</div>
                <a href="javascript:void(0);" class="btn btn-primary btn-sm mb-2" id="add-students-to-stream">Add
                    Students</a>
                <a href="javascript:void(0);" class="btn btn-secondary btn-sm mb-2">Import Students</a>
                <div id="view-class-stream-students-view-td">
                    <?= view('user_pages/academics/stream_students/students_table') ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade school-large-modal" id="add-new-student-stream" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add Students To Stream</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <table id="view-standents-table" class="table table-bordered text-nowrap key-buttons border-bottom">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">#</th>
                            <th class="border-bottom-0">Name</th>
                            <th class="border-bottom-0">Admission No</th>
                            <th class="border-bottom-0">Student No</th>
                            <th class="border-bottom-0">Admission Date</th>
                            <th class="border-bottom-0">Gender</th>
                            <th class="border-bottom-0">DOB</th>
                            <th class="border-bottom-0 call-action">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>