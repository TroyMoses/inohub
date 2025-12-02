<div class="row row-sm">
    <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6" >
        <div class="divider"> SMS PURCHASE </div>

        <form id="new-sms-purchase-form" method="post" action="<?= base_url('/Sys/MessageCenter/submitPurchaseSMS'); ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label class="form-label" for="student_stream">Payment Method:<span
                class="tx-danger">*</span></label>
                <select name="payment-method" class="form-control form-control-sm form-select"
                    id="sms-payment-method" data-bs-placeholder="Select Payment Method" required>
                    <option value=""> ---- Select ---- </option>
                    <option value="cash"> Cash </option>
                    <option value="bank"> Bank </option>
                </select>
            </div>

            <div class="form-group" id="payment-method-sms-pay-div">
                <label class="form-label" for="payment_method_account">Select Account <span
                        class="tx-danger">*</span></label>
                <select name="payment-method-account" class="form-control form-select form-control-sm"
                    id="payment_method_pay_sms_account" data-bs-placeholder="Select Account">
                    <option value="">---- Select ----- </option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="sms-purchase-amount">Amount (sh): <span class="tx-danger">*</span></label>
                <input type="number" min="5000" class="form-control form-control-sm" autocomplete="off" name="amount" required autofocus="true">
            </div>

            <button id="sms-save-purchase-btn" class="btn ripple btn-primary" style="width: 100%;" type="button"> Purchase </button>
        </form>

    </div>
    <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6">
        <div>
            <div class="divider">SMS BALANCE DETAILS</div>
            <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">TOTAL SMS BALANCE:</span><span class="span-label-value"><?= esc( number_format($sms_balance->sms_bal) ) ?></span></p>
            <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">COST PER SMS:</span><span class="span-label-value"><?= esc( h_session('sms_cost') ) ?></span></p>
        </div>

        <div>
            <div class="divider">SMS SENT DETAILS</div>
            <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">TOTAL SMS SENT:</span><span class="span-label-value"><?= esc( number_format($sms_balance->sms_sent) ) ?></span></p>
        </div>

    </div>
</div>
