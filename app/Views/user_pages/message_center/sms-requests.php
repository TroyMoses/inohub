<?= $this->extend('layouts/switcher-main'); ?>

<?= $this->section('styles'); ?>

<?= $this->endSection('styles'); ?>

<?= $this->section('content'); ?>

<?php helper('h_date'); ?>

<!-- Row -->
<div class="row row-sm">
    <!-- col -->
    <div class="col-lg-12">
        <div class="card mg-b-20">
            <div class="card-body d-flex p-1">
                <div class="main-content-label mb-0 mg-t-8 school-navigation-header"><?php echo h_session('current_page') ? h_session('current_page') :'' ?></div>
                <div class="ms-auto"><a class="d-block tx-20" data-placement="top" data-bs-toggle="tooltip"
                    title="<?php echo h_session('current_page') ? h_session('current_page') :'' ?>" href="javascript:void(0);"><i class="si si-plus text-muted"></i></a></div>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card custom-card overflow-hidden">
            <div class="card-body">
                <div class="table-responsive  export-table">
                    <table id="pending-schools-datatable"
                        class="table table-bordered text-nowrap key-buttons border-bottom"> 
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">School</th>
                                <th class="border-bottom-0">Amount</th>
                                <th class="border-bottom-0">SMS Cost</th>
                                <th class="border-bottom-0">Payment Method</th>
                                <th class="border-bottom-0">Status</th>
                                <th class="border-bottom-0">Added By</th>
                                <th class="border-bottom-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($smsrequests)) : ?>
                                <?php foreach ($smsrequests as $key => $smsrequest) : ?>
                                    <tr>
                                        <td><?= $key + 1; ?></td>
                                        <td><?= esc($smsrequest->school_name); ?></td>
                                        <td> <?= esc(number_format($smsrequest->amount)); ?> </td>
                                        <td><?= esc($smsrequest->sms_cost); ?></td>
                                        <td><?= esc($smsrequest->payment_method); ?></td>
                                        <td><?= esc($smsrequest->status); ?></td>
                                        <td><?= esc($smsrequest->user_name); ?></td>
                                        <td class="call-action">
                                            <?php if ($smsrequest->status == "pending") : ?>
                                                <button type="button" class="btn btn-primary btn-sm" data-id="<?= esc($smsrequest->id); ?>" id="approve-school-sms-req">Approve</button>
                                                <button type="button" class="btn btn-danger btn-sm" data-id="<?= esc($smsrequest->id); ?>" >Reject</button>
                                            <?php endif; ?>
                                            <?php if ($smsrequest->status == "approved" ) : ?>
                                                <button type="button" class="btn btn-primary btn-sm" data-id="<?= esc($smsrequest->id); ?>" >Print Receipt</button>
                                            <?php endif; ?>
                                            <?php if ($smsrequest->status == "rejected" ) : ?>
                                                <button type="button" class="btn btn-primary btn-sm" data-id="<?= esc($smsrequest->id); ?>" >View</button>
                                            <?php endif; ?>
                                        </td>
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

<?= $this->endSection('content'); ?>