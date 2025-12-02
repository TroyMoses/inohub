<div class="row">
    <div class="col-lg-4 col-xl-3">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">Classes</div>
            </div>
            <div class="main-content-left main-content-left-mail card-body pt-0">
                <div class="main-settings-menu">
                    <nav class="nav main-nav-column">
                    <?php if (!empty($classes)) : ?>
                        <?php foreach ($classes as $key => $_class) : ?>
                        <a id="view-term-class-subjects-tb-<?= esc($_class->id); ?>" class="nav-link thumb <?php echo $class ? $class->id == $_class->id ? 'active':'' :''?> mb-2 view-term-class-subjects-tb"
                            href="javascript:view_term_class_subjects(<?= esc($_class->id); ?>);;"><i class="fe fe-home"></i> <?= esc($_class->name); ?>
                            <?= $_class->short_name ? '('. esc($_class->short_name). ')':''; ?> </a>
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
                <div class="card-title">Class Subjects</div>
                <a href="javascript:void(0);" class="btn btn-primary btn-sm mb-2" id="add-new-term-class-subject-btn">Add Subject</a>

                <div id="view-term-class-subjects-page-td">
                    <?= view('user_pages/academics/term_subjects/term-subjects-table') ?>
                </div>

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="add-new-term-class-subject-modal" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add Subject To Class</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="new-term-class-subject-registration-form" method="post"
                    action="<?= base_url('/Sys/Academics/submitTermClassSubjectForm'); ?>" enctype="multipart/form-data">
                    <input type="hidden" autocomplete="off" id="input-term_class_subject_term_id" name="term">
                    <input type="hidden" autocomplete="off" id="input-term_class_subject_class_id" name="class">
                    <div class="row row-sm">
                        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="branch_name">Subject: <span
                                        class="tx-danger">*</span></label>
                                <select name="subject" class="form-control form-select form-control-sm"
                                    id="new-term-class-subject" data-bs-placeholder="Select class" required>
                                    <option value="">--- select ---</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="branch_name">Teacher: <span
                                        class="tx-danger">*</span></label>
                                <select name="teacher" class="form-control form-select form-control-sm"
                                    id="new-term-class-subject-teacher" data-bs-placeholder="Select Teacher" required>
                                    <option value="">--- select ---</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="branch_name">Subject Type: <span
                                        class="tx-danger">*</span></label>
                                <select name="subject_type" class="form-control form-select form-control-sm"
                                    id="subject-type" data-bs-placeholder="Select type" required>
                                    <option value="Mandatory">Mandatory</option>
                                    <option value="Elective">Elective</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-save-new-term-class-subject" type="button">Save Details</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>