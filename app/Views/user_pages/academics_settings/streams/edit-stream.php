<div class="modal fade" id="edit-stream-modal" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Edit Stream Info</h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-stream-form" method="post" action="<?= base_url('/Sys/AcademicSettings/updateClassStreamForm'); ?>">
                    <input type="hidden" name="stream_id" value="<?= esc($stream->id); ?>">

                    <div class="row row-sm">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Stream Label: <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control" name="name" required value="<?= esc($stream->name); ?>">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Class: <span class="tx-danger">*</span></label>
                                <select class="form-control form-select" name="class" required>
                                    <option value="">---- Select ----</option>
                                    <?php foreach ($classes as $class): ?>
                                        <option value="<?= esc($class->id); ?>" <?= $stream->class_id == $class->id ? 'selected' : ''; ?>>
                                            <?= esc($class->name); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-update-stream" type="button">Update Stream</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>