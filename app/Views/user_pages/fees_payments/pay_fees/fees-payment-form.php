<?php helper('h_date'); ?>
<input type="hidden" id="search-student-detail-fees-id" value="<?= h_encrypt_decrypt(esc($student->id)); ?>">
                
<div class="row row-sm">
    <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
        <div>
            <div class="divider">BASIC PROFILE </div>
            <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">FULL NAME:</span><span class="span-label-value"><?= esc( $student->name  ) ?></span></p>
            <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">FIRST NAME:</span><span class="span-label-value"><?= esc( $student->first_name ) ?></span></p>
            <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">LAST NAME:</span><span class="span-label-value"><?= esc( $student->last_name ) ?></span></p>
            <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">STUDENT NO:</span><span class="span-label-value"><?= esc( $student->people_number ) ?></span></p>
            <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">REGISTRATION NO:</span><span class="span-label-value"></span></p>
        </div>
    
    </div>

    <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
        <div>
            <div class="divider">BASIC PROFILE</div>
            <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">GENDER:</span><span class="span-label-value"><?= esc(  $student->gender ) ?></span></p>
            <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">DOB:</span><span class="span-label-value"><?= $student->dob? esc( h_format_date_display($student->dob) ): '' ?></span></p>
            <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">DORMITRY:</span><span class="span-label-value"> </span><?= $student->accomodation ? esc( $student->accomodation->name ):''?> </span></p>
            <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">BED NUMBER:</span><span class="span-label-value"> </span><?= $student->accomodation ? esc( $student->accomodation->bed_number ):''?> </span></p>
        </div>
    </div>

    <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
        <div>
            <div class="divider">CLASS DETAILS</div>
            <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">ACADEMIC YEAR:</span><span class="span-label-value"><?= $student->current_class?  esc( $student->current_class->year_name ):'' ?></span></p>
            <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">TERM:</span><span class="span-label-value"><?= $student->current_class ? esc( $student->current_class->term_name ):'' ?></span></p>
            <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">CLASS:</span><span class="span-label-value"> <?= $student->current_class ? ($student->current_class->class_name . ($student->current_class->class_short_name ? '('. $student->current_class->class_short_name . ')' :'' ) ) : ($student->admission ? $student->admission->class_name . ( $student->admission->class_short_name ? '('. $student->admission->class_short_name . ')' :'' ): '') ?> </span></span></p>
            <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">STREAM:</span><span class="span-label-value"> <?= $student->current_class ? ($student->current_class->stream_name ) : ($student->admission ? $student->admission->stream_name: '') ?> </span></span></p>
        </div>
    </div>
    
</div>

<div class="divider">PAYMENT FORM</div>
<form id="new-student-fees-payment-form" method="post"
                    action="<?= base_url('/Sys/FeesPayment/submitFeesPaymentForm'); ?>">
    
    <input type="hidden" value="<?= $student->first_name ? esc( $student->first_name  ): esc( $student->name  ); ?>" class="form-control form-control-sm" id="first_name"
        name="first_name" autocomplete="off">
    <input type="hidden" class="form-control form-control-sm" id="last_name"
        name="last_name" value="<?= $student->last_name ? esc( $student->last_name ): esc( $student->name ); ?>" autocomplete="off">
    
    <input type="hidden" class="form-control form-control-sm"
        name="people_id" value="<?= esc( $student->id );?>" autocomplete="off">
    
    <input type="hidden" class="form-control form-control-sm" 
        name="fees-structure-payments" id="fees-structure-payments-list" autocomplete="off">
    
    <input type="hidden" class="form-control form-control-sm"
        name="term_id" value="<?= esc( $term_id );?>" autocomplete="off">
        
    <div class="row row-sm">
        <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6">
            <?php if (!empty($fees_structures)) : ?>
                <table class="table table-bordered text-nowrap key-buttons border-bottom" id="fees-payment-fees-structure-table">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">Name</th>
                            <th class="border-bottom-0">Amount</th>
                            <th class="border-bottom-0">Bal</th>
                            <th class="border-bottom-0">Pay</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($fees_structures)) : ?>
                            <?php 
                                $totalAmount = 0;
                                $totalBalance = 0;
                            ?>
                            <?php foreach ($fees_structures as $key => $fees_structure) : ?>
                                <?php 
                                    // Initialize the amount and balance for each row
                                    $amount = $fees_structure['classes'][0]['amount'];
                                    $balance = $fees_structure['classes'][0]['balance']; // Initially balance is the same as amount
                                    $totalAmount += $amount;
                                    $totalBalance += $balance;
                                ?>
                                <tr data-balance="<?= $balance; ?>">
                                    <td><?= esc($fees_structure['fees_type_name']); ?></td>
                                    <td class="fee-amount"><?= esc(number_format($fees_structure['classes'][0]['amount'])); ?></td>
                                    <td class="fee-balance"><?= esc(number_format($fees_structure['classes'][0]['balance'])); ?></td>
                                    <td ><input type="number" data-id="<?= $fees_structure['id'] ?>" class="form-control form-control-sm pay-sch-fees-payment-amount" name="fee-amount" autocomplete="off" value="0" required></td> 
                                </tr>
                            <?php endforeach; ?>
                            <tr id="totals-row">
                                <td><b>--- Total ---</b></td>
                                <td><b id="fees-payment-total-amount"><?= number_format($totalAmount); ?></b></td>
                                <td><b id="fees-payment-total-balance"><?= number_format($totalBalance); ?></b></td>
                                <td><b id="fees-payment-total-pay">0</b></td> 
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            <?php endif; ?>
            <?php if (empty($fees_structures)) : ?>
                <div class="alert alert-outline-danger" role="alert">
                    <strong>Note:</strong> No Fees Structure found, please contact your admin for support!
                </div>
            <?php endif; ?>
            <input type="hidden" class="form-control form-control-sm" id="total_fees_pay_amount" name="amount" value="0" autocomplete="off" required>
            <input type="hidden" class="form-control form-control-sm" id="total_fees_pay_amount_bal" name="amount_balance" value="0" autocomplete="off" required>

            <div class="form-group">
                <label class="form-label" for="description">Narration<span
                        class="tx-danger">*</span></label>
                <input value="Fees payment for <?= esc( $student->name  ); ?>" type="text" class="form-control form-control-sm" id="description" name="description"
                    autocomplete="off" required>
            </div>
        </div>
        <div class="col-lg-6 col-xl-6 col-md-6 col-sm-6">
            <div class="form-group">
                <label class="form-label" for="record_date">Record Date <span
                        class="tx-danger">*</span></label>
                <input type="date" max="<?= date('Y-m-d'); ?>" value="<?= date('Y-m-d'); ?>" class="form-control form-control-sm" id="record_date"
                    name="record_date" autocomplete="off" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="register_std_fees_payment_mtd">Select Payment Method <span
                        class="tx-danger">*</span></label>
                <select name="payment_method" class="form-control form-select form-control-sm"
                    id="register_std_fees_payment_mtd" data-bs-placeholder="Select Payment Method" required>
                    <option value="">---- Select ----- </option>
                    <!-- <option value="mm_collect"> MM Collection </option> -->
                    <option value="cash"> Cash </option>
                    <option value="bank"> Bank/Cheque </option>
                    <!-- <option value="offset"> Offset </option> -->
                </select>
            </div>

            <div id="fees-payment-phone-number-div" style="display:none">
                <div class="row row-sm">
                    <div class="col-lg-8 col-xl-8 col-md-8 col-sm-8">
                        <div class="form-group">
                            <label class="form-label mt-0" for="fees-payment-phone-number">Phone Number (e.g 07xxx)<span class="tx-danger">*</span></label>
                            <input type="tel" maxlength = "10" class="form-control form-control-sm" id="fees-payment-phone-number" name="phone_number"
                                autocomplete="off">
                        </div>  
                    </div>
                    <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
                        <button style="margin-top:28px" class="btn ripple btn-primary btn-sm" id="btn-collect-mm-fees-payment" type="button">Collect Now </button>
                    </div>
                </div>
            </div>
            
            <div class="form-group" id="payment-method-fees-pay-div">
                <label class="form-label" for="payment_method_account">Select Account <span
                        class="tx-danger">*</span></label>
                <select name="payment_method_account" class="form-control form-select form-control-sm"
                    id="payment_method_pay_fees_account" data-bs-placeholder="Select Account">
                    <option value="">---- Select ----- </option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label mt-0" for="reference_no">Reference/Voucher Number</label>
                <input type="text" class="form-control form-control-sm" id="mm_fees_payment_reference_no"
                    name="reference_no" autocomplete="off">
                
                    <input type="hidden" class="form-control form-control-sm" id="mm_fees_payment_reference_number"
                    name="reference_number">
            </div>

            <div class="form-group">
                <div class="row row-sm">
                    <div class="col-lg-12">
                        <input id="send-fees-payment-sms-field" name="send_sms" type="hidden">
                        <label class="ckbox"><input id="send-fees-payment-sms" checked type="checkbox"><span>Send SMS</span></label>
                        <p class="help-block"><small>If un-checked system won't attempt to send an sms </small></p>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</form>