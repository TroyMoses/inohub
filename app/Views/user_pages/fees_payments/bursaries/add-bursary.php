<div class="modal fade school-large-modal" id="add-new-bursary-modal" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add Bursary</h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="new-bursary-form" method="post" action="<?= base_url('/Sys/FeesPayment/submitBursaryForm'); ?>">
                    <input type="hidden" name="action" value="create">
                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Organization Type <span class="tx-danger">*</span></label>
                                <select name="org_type" class="form-control form-select form-control-sm" required>
                                    <option value="">-- Select --</option>
                                    <option value="Organization">Organization</option>
                                    <option value="Individual">Individual</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Name <span class="tx-danger">*</span></label>
                                <input type="text" name="name" class="form-control form-control-sm" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Primary Contact</label>
                                <input type="text" name="primary_contact" class="form-control form-control-sm">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Telephone</label>
                                <input type="text" name="telephone" class="form-control form-control-sm">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control form-control-sm">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control form-select form-control-sm">
                                    <option value="">-- Select --</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control form-control-sm" rows="2"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Contact Person Name</label>
                                <input type="text" name="primary_contact_person_name" class="form-control form-control-sm">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Contact Person Email</label>
                                <input type="email" name="primary_contact_person_email" class="form-control form-control-sm">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Contact Person Phone</label>
                                <input type="text" name="primary_contact_person_telephone" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary btn-sm" id="btn-save-new-bursary" type="button">Save Bursary</button>
                <button class="btn ripple btn-secondary btn-sm" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>