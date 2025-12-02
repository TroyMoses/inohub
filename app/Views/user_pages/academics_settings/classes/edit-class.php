<div class="modal fade" id="edit-school-class-modal" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Edit Class Info</h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-class-form" method="post" action="<?= base_url('/Sys/AcademicSettings/updateSchoolClass'); ?>">
                    <input type="hidden" name="class_id" value="<?= esc($class->id); ?>">
                    <div class="row row-sm">
                        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Class Name: <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control" name="name" required value="<?= esc($class->name); ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Short Name: <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control" name="short_name" required value="<?= esc($class->short_name); ?>">
                            </div>

                            <?php
                                // Fallback if class_section doesn't exist
                                $classSection = property_exists($class, 'class_section') ? $class->class_section : '';
                            ?>
                            <div class="form-group">
                                <label class="form-label">Section:</label>
                                <select class="form-control form-select" name="class_section">
                                    <option value="">---- Select ----</option>
                                    <option value="Nursury" <?= $classSection === 'Nursury' ? 'selected' : '' ?>>Nursury</option>
                                    <option value="Primary" <?= $classSection === 'Primary' ? 'selected' : '' ?>>Primary</option>
                                    <option value="Secondary" <?= $classSection === 'Secondary' ? 'selected' : '' ?>>Secondary</option>
                                </select>
                                <small class="text-muted">Optional - not stored in database currently</small>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-update-school-class" type="button">Update</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>
