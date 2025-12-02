<div class="">
    <div class="panel panel-primary tabs-style-3">
        <div class="row row-sm">
            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                <div class="divider">SMS BALANCE DETAILS</div>
            </div>
        </div>

        <div class="row row-sm">
            <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
                <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">TOTAL SMS BALANCE:</span><span class="span-label-value"><?= esc( number_format($sms_balance->sms_bal) ) ?></span></p>
            </div>
            <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
                <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">COST PER SMS:</span><span class="span-label-value"><?= esc( h_session('sms_cost') ) ?></span></p>
            </div>
            <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
                <p class="text-muted ms-md-4 ms-0 mb-2"><span class="font-weight-semibold me-2">TOTAL SMS SENT:</span><span class="span-label-value"><?= esc( number_format($sms_balance->sms_sent) ) ?></span></p>
            </div>
        </div>
        <div class="row row-sm">
            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                <div class="divider">COMPOSE MESSAGE</div>
            </div>
        </div>

        <div class="tab-menu-heading">
            <div class="tabs-menu ">
                <!-- Tabs -->
                <ul class="nav panel-tabs">
                    <li class=""><a href="#tab11" class="active" data-bs-toggle="tab"> To Few Recipients
                        </a></li>
                    <li><a href="#tab12" data-bs-toggle="tab"> To Class </a>
                    </li>
                    <li><a href="#tab13" data-bs-toggle="tab">Bulk Upload</a></li>
                </ul>
            </div>
        </div>
        <div class="panel-body tabs-menu-body">
            <div class="tab-content">
                <div class="tab-pane active" id="tab11">

                    <form id="new-sms-bulk-upload-form-1" method="post" action="<?= base_url('/Sys/MessageCenter/submitSendSMS'); ?>" enctype="multipart/form-data">
                        <input type="hidden" value="1" name="form">
                        <div class="row row-sm">
                            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="branch_name">Message: <span class="tx-danger">*</span></label>
                                    <textarea id="send-sms-message" class="form-control form-control-sm" autocomplete="off"
                                        name="message" rows="2" placeholder="" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="dob">Recipients(eg, 078xx,077xx):<span class="tx-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm" autocomplete="off" id="send-sms-recepients" name="recepients" required>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="modal-footer">
                        <?php if ($sms_balance->sms_bal <= 0) : ?>
                            <div class="alert alert-outline-danger mg-b-0 alert-dismissible fade show m-0 p-2" role="alert">
                                You have Insufficient SMS, please load more.
                            </div>
                        <?php endif; ?>

                        <button class="btn ripple btn-primary" <?php echo $sms_balance->sms_bal <= 0 ? 'disabled':'' ?> id="btn-send-new-sms-1" type="button">Send</button>
                        <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
                    </div>
                    
                </div>
                <div class="tab-pane" id="tab12">
                    <form id="new-sms-bulk-upload-form-2" method="post" action="<?= base_url('/Sys/MessageCenter/submitSendSMS'); ?>" enctype="multipart/form-data">
                        <input type="hidden" value="2" name="form">
                        <div class="row row-sm">
                            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="branch_name">Message: <span class="tx-danger">*</span></label>
                                    <textarea id="message" class="form-control form-control-sm" autocomplete="off"
                                        name="message" rows="2" placeholder="" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="branch_region">Academic Year:<span class="tx-danger">*</span></label>
                                    <select name="year" class="form-control form-select form-control-sm" id="compose_message_academic_years" data-bs-placeholder="Select Region" required>
                                        <option value="">--- select --- </option>
                                        <?php foreach ($academic_years as $key => $academic_year) : ?>
                                            <option id="compose_message_academic_years_<?= esc($academic_year->id); ?>" data-terms="<?= esc(json_encode($academic_year->terms)); ?>" value="<?= esc($academic_year->id); ?>"><?= esc($academic_year->name); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="branch_region">Term:<span class="tx-danger">*</span></label>
                                    <select name="term_id" class="form-control form-select form-control-sm" id="compose_message_academic_years_term" data-bs-placeholder="Select Region" required>
                                        <option value="">--- select --- </option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label" for="ht_phone">Select Classes: <span class="tx-danger">*</span></label>
                                    <div class="row row-sm">
                                        <div class="col-lg-12 d-flex">
                                            <?php foreach ($classes as $key => $class) : ?>
                                                <label class="ckbox"><input name="class[]" value="<?= esc($class->id); ?>" type="checkbox"><span><?= esc($class->name); ?></span></label> &nbsp; &nbsp; &nbsp;
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <?php if ($sms_balance->sms_bal <= 0) : ?>
                            <div class="alert alert-outline-danger mg-b-0 alert-dismissible fade show m-0 p-2" role="alert">
                                You have Insufficient SMS, please load more.
                            </div>
                        <?php endif; ?>
                        <button class="btn ripple btn-primary" <?php echo $sms_balance->sms_bal <= 0 ? 'disabled':'' ?> id="btn-send-new-sms-2" type="button">Send</button>
                        <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
                    </div>
                </div>
                <div class="tab-pane" id="tab13">
                    <form id="new-sms-bulk-upload-form-3" method="post" action="<?= base_url('/Sys/MessageCenter/submitSendSMS'); ?>" enctype="multipart/form-data">
                        <input type="hidden" value="3" name="form">
                        <div class="row row-sm">
                            <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label" for="branch_name">Message: <span class="tx-danger">*</span></label>
                                    <textarea class="form-control form-control-sm" autocomplete="off"
                                        name="message" id="send-sms-message-3" rows="2" placeholder="" required></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label" for="dob">Bulk Upload:<span class="tx-danger">*</span></label>
                                    <input type="file" id="send-sms-file" class="form-control form-control-sm" autocomplete="off" id="file" name="file" required>
                                </div>

                                <a href="javascript:void(0);" class="btn btn-outline-primary btn-md mb-2 download-sms-bulk-template-btn">Download Template</a>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <?php if ($sms_balance->sms_bal <= 0) : ?>
                            <div class="alert alert-outline-danger mg-b-0 alert-dismissible fade show m-0 p-2" role="alert">
                                You have Insufficient SMS, please load more.
                            </div>
                        <?php endif; ?>
                        <button class="btn ripple btn-primary" <?php echo $sms_balance->sms_bal <= 0 ? 'disabled':'' ?> id="btn-send-new-sms-3" type="button">Send</button>
                        <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>