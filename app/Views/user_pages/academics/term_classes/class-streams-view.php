<div class="row">
    <div class="col-lg-4 col-xl-3">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">Classes</div>
            </div>
            <div class="main-content-left main-content-left-mail card-body pt-0">
                <div class="main-settings-menu">
                    <div class="mb-3 mx-4 text-center">
                        <a href="javascript:void(0);" class="btn btn-primary d-grid btn-sm"
                            id="add-new-term-classes-btn">Add Class/Streams</a>
                    </div>
                    <nav class="nav main-nav-column">
                        <?php if (!empty($classes)) : ?>
                        <?php foreach ($classes as $key => $_class) : ?>
                        <a id="view-class-streams-tb-<?= esc($_class->id); ?>" class="nav-link thumb <?php echo $class ? $class->id == $_class->id ? 'active':'' :''?> mb-2 view-class-streams-tb"
                            href="javascript:view_class_streams(<?= esc($_class->id); ?>);"><i class="fe fe-home"></i> <?= esc($_class->name); ?>
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
                <div class="card-title">Class Streams</div>
                <div id="view-class-streams-page-view-td">
                    <?= view('user_pages/academics/term_classes/class-stream-table') ?>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add-new-term-classes-modal" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add Classes To Term</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="new-term-classes-registration-form" method="post"
                    action="<?= base_url('/Sys/Academics/submitTermClassesForm'); ?>" enctype="multipart/form-data">
                    <input type="hidden" autocomplete="off" id="input-term_class_id" name="term">
                    <div class="row row-sm">
                        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="branch_name">Class: <span
                                        class="tx-danger">*</span></label>
                                <select name="class" class="form-control form-select form-control-sm"
                                    id="new-term-class-select" data-bs-placeholder="Select class" required>
                                    <option value="">--- select ---</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="branch_name">Class Streams: <span
                                        class="tx-danger">*</span></label>
                                <select name="stream" class="form-control form-select form-control-sm"
                                    id="new-term-class-stream-select" data-bs-placeholder="Select Stream" required>
                                    <option value="">--- select ---</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-save-new-term-class" type="button">Save Details</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>