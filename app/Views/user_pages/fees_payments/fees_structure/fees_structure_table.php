<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card custom-card overflow-hidden">
            <div class="card-body">

                <div class="row row-sm">
                    <div class="col-lg-12">
                        <a href="javascript:void(0);" style="float:right; margin-left:4px" class="btn btn-primary btn-sm mb-2" id="add-fees-structure-to-term">Add New Fee</a> &nbsp; &nbsp;
                        <a href="javascript:void(0);" style="float:right" class="btn btn-secondary btn-sm mb-2 mr-2 ml-2" id="">Import From Previous Term</a>
                    </div>
                </div>
                <div class="table-responsive  export-table">
                    <table id="fees-structure-datatable-view"
                        class="table table-bordered text-nowrap key-buttons border-bottom"> 
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">Name</th>
                                <th class="border-bottom-0">Classes</th>
                                <th class="border-bottom-0">Status</th>
                                <th class="border-bottom-0 call-action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($fees_structures)) : ?>
                                <?php foreach ($fees_structures as $key => $fees_structure) : ?>
                                    <tr>
                                        <td><?= $key + 1; ?></td>
                                        <td><?= esc($fees_structure['fees_type_name']); ?></td>
                                        <td>
                                            <?php foreach ($fees_structure['classes'] as $key => $class_fees_structure) : ?>
                                                <span class="badge bg-primary me-1"><?= $class_fees_structure['short_name'] ? esc($class_fees_structure['short_name']) :esc($class_fees_structure['class_name']); ?> - <?= esc(number_format($class_fees_structure['amount'])); ?></span>
                                            <?php endforeach; ?>
                                        </td>
                                        <td>
                                            <label class="">
                                                <input type="checkbox" checked name="custom-switch-checkbox3" class="custom-switch-input">
                                                <span class="custom-switch-indicator custom-radius"></span>
                                            </label>
                                        </td>
                                        <td class="call-action"><button type="button" class="btn btn-primary btn-sm edit-fees-structures-btn" data-heading="<?= esc($fees_structure['fees_type_name']); ?>" data-classes="<?= esc(json_encode($fees_structure['classes'])); ?>" data-fees_type_id="<?= esc($fees_structure['fees_type_id']); ?>">Edit</button> <button type="button" class="btn btn-danger btn-sm delete-fees-structures-btn" data-heading="<?= esc($fees_structure['fees_type_name']); ?>" data-fees_type_id="<?= esc($fees_structure['fees_type_id']); ?>">Delete</button></td>
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
<!-- End Row -->

<div class="modal fade" id="register-new-fees-structure" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Register new Fee Structure</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" id="fees-structure-registration-form-page-div">
                
            </div>
            <div class="modal-footer">
                <input type="hidden" class="form-control form-control-sm" id="selected-fee-structure-academic-year-term-id" name="name" autocomplete="off" required>
                <button class="btn ripple btn-primary" id="btn-save-new-fee-structure" type="button">Save Details</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="register-edit-fees-structure" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Update Fee Structure</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" id="fees-structure-table-container">
                
            </div>
            <div class="modal-footer">
                <input type="hidden" class="form-control form-control-sm" id="update-fee-structure-academic-year-term-id" name="name" autocomplete="off" required>
                <input type="hidden" class="form-control form-control-sm" id="update-selected-fee-structure-id" name="name" autocomplete="off" required>
                <button class="btn ripple btn-primary" id="btn-save-update-fee-structure" type="button">Save Details</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>