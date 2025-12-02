<div class="modal fade" id="ledger-liabilities-reg-modal" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Register Liability</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <form id="new-liability-registration-form" method="post"
                    action="<?= base_url('/Sys/Accounting/Ledgers/submitLedgerLiabilityForm'); ?>" enctype="multipart/form-data">
                    <div class="row row-sm">
                        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">

                            <div class="form-group">
                                <label class="form-label" for="description">Liability Description<span
                                        class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" id="description" name="description"
                                    autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="account_name">Liability Amount <span
                                        class="tx-danger">*</span></label>
                                <input type="number" class="form-control form-control-sm" id="amount"
                                    name="amount" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="record_date">Record Date <span
                                        class="tx-danger">*</span></label>
                                <input type="date" max="<?= date('Y-m-d'); ?>" value="<?= date('Y-m-d'); ?>" class="form-control form-control-sm" id="record_date"
                                    name="record_date" autocomplete="off" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="register_liability_account">Select Liability Account:<span
                                        class="tx-danger">*</span></label>
                                <select name="account" class="form-control form-select form-control-sm"
                                    id="register_liability_account" data-bs-placeholder="Select Account" required>
                                    <option value="">---- Select ----- </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="registration_date">Select Payment Method <span
                                        class="tx-danger">*</span></label>
                                <select name="payment_method" class="form-control form-select form-control-sm"
                                    id="register_liability_payment_method" data-bs-placeholder="Select Currency" required>
                                    <option value="">---- Select ----- </option>
                                    <option value="cash"> Cash </option>
                                    <option value="bank"> Bank/Cheque </option>
                                </select>
                            </div>

                            <div class="form-group" style="display:none" id="payment-method-liability-acc-div">
                                <label class="form-label" for="payment_method_account">Select Account <span
                                        class="tx-danger">*</span></label>
                                <select name="payment_method_account" class="form-control form-select form-control-sm"
                                    id="payment_method_liability_account" data-bs-placeholder="Select Account" required>
                                    <option value="">---- Select ----- </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="account_name">Reference/Voucher Number </label>
                                <input type="text" class="form-control form-control-sm" id="reference_no"
                                    name="reference_no" autocomplete="off">
                            </div>

                        </div>

                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-save-new-liability" type="button">Save Liability
                    Details</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>