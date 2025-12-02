
<div class="modal fade" id="treasury-safe-account-add" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add New Safe Account</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="new-safe-acc-registration-form" method="post"
                    action="<?= base_url('/Sys/Treasury/submitSafeAccount'); ?>" enctype="multipart/form-data">
                    <div class="row row-sm">
                        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">

                            <div class="form-group">
                                <label class="form-label" for="department_name">Safe Name <span
                                        class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" id="safe_name" name="name"
                                    autocomplete="off" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="bank_currency">Currency:<span class="tx-danger">*</span></label>
                                <select name="currency" class="form-control form-select form-control-sm" id="safe_currency" data-bs-placeholder="Select Currency" required>
                                    <option value="">---- Select ----- </option>
                                    <option value="UGX" selected>UGX</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="registration_date">Registration Date <span
                                        class="tx-danger">*</span></label>
                                <input type="date" max="<?= date('Y-m-d'); ?>" value="<?= date('Y-m-d'); ?>" class="form-control form-control-sm" id="registration_date" name="registration_date"
                                    autocomplete="off" required>
                            </div>
                           
                        </div>

                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-save-new-safe-acc" type="button">Save Safe
                    Details</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>
