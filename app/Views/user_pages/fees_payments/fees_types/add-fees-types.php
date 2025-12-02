<div class="modal fade school-large-modal" id="add-new-fees-type-modal" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Add Fees Type</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="new-fees-type-registration-form" method="post" action="<?= base_url('/Sys/FeesPayment/submitFeesTypesForm'); ?>">
                    <div class="row row-sm">
                        <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="user_username">Name: <span class="tx-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" autocomplete="off" name="name" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="user_username">Description: <span class="tx-danger">*</span></label>
                                <textarea class="form-control" placeholder="" name="description" rows="2" required></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="register_std_fees_payment_mtd">Select fee category</label>
                                <select name="type_key" class="form-control form-select form-control-sm" data-bs-placeholder="">
                                    <option value="">---- Select ----- </option>
                                    <option value="school_fees">School Fees</option>
                                    <option value="admission_fee">Admission Fee </option>
                                    <option value="boarding_fee">Boarding Fee</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="register_std_fees_payment_mtd">Select Chart <span class="tx-danger">*</span></label>
                                <select id="fees-type-chart-id" name="chart_id" class="form-control form-select form-control-sm" data-bs-placeholder="" required>
                                    <option value="">---- Select ----- </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-save-new-fees-type" type="button">Save</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>