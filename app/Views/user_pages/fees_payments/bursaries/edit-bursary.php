<div class="modal fade school-large-modal" id="edit-bursary-modal" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Update Bursary</h6>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="update-bursary-form" method="post" action="<?= base_url('/Sys/FeesPayment/submitBursaryForm'); ?>">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" id="bursary-id">
                    <div class="row row-sm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Organization Type</label>
                                <select name="org_type" id="org_type" class="form-control form-select form-control-sm" required>
                                    <option value="">-- Select --</option>
                                    <option value="Organization">Organization</option>
                                    <option value="Individual">Individual</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" id="bursary-name" name="name" class="form-control form-control-sm" required>
                            </div>
                            <div class="form-group">
                                <label>Primary Contact</label>
                                <input type="text" id="bursary-primary-contact" name="primary_contact" class="form-control form-control-sm">
                            </div>
                            <div class="form-group">
                                <label>Telephone</label>
                                <input type="text" id="bursary-telephone" name="telephone" class="form-control form-control-sm">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" id="bursary-email" name="email" class="form-control form-control-sm">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" id="bursary-status" class="form-control form-select form-control-sm">
                                    <option value="">-- Select --</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <textarea name="address" id="bursary-address" class="form-control form-control-sm" rows="2"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Contact Person Name</label>
                                <input type="text" id="bursary-pcp-name" name="primary_contact_person_name" class="form-control form-control-sm">
                            </div>
                            <div class="form-group">
                                <label>Contact Person Email</label>
                                <input type="email" id="bursary-pcp-email" name="primary_contact_person_email" class="form-control form-control-sm">
                            </div>
                            <div class="form-group">
                                <label>Contact Person Phone</label>
                                <input type="text" id="bursary-pcp-telephone" name="primary_contact_person_telephone" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary btn-sm" id="btn-update-bursary" type="button">Update</button>
                <button class="btn ripple btn-secondary btn-sm" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>