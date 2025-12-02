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
                <div class="main-content-label mb-0 mg-t-8 school-navigation-header">
                    <?php echo h_session('current_page') ? h_session('current_page') :'' ?></div>
                <div class="ms-auto"><a class="d-block tx-20" data-placement="top" data-bs-toggle="tooltip"
                        title="<?php echo h_session('current_page') ? h_session('current_page') :'' ?>"
                        href="javascript:void(0);"><i class="si si-plus text-muted"></i></a></div>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card custom-card overflow-hidden">
            <div class="card-body">
                <form id="filter-fees-ledger-form" method="post"
                    action="<?= base_url('Sys/FeesPayment/feesLedger'); ?>" enctype="multipart/form-data">
                    <div class="row row-sm">
                        
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="identity_type">Academic Year:</label>
                                <select name="academic_year" class="form-control form-select form-control-sm"
                                    id="fees-academic-year-ledger" data-bs-placeholder="Select Status">
                                    <option value="">---- Select ----- </option>
                                    <?php foreach ($academic_years as $key => $academic_year) : ?>
                                        <option id="fees-academic-year-ledger-<?= esc($academic_year->id); ?>" data-terms="<?= esc(json_encode($academic_year->terms)); ?>" value="<?= esc($academic_year->id); ?>"><?= esc($academic_year->name); ?></option>
                                        <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-xl-2 col-md-2 col-sm-2">
                            <div class="form-group">
                                <label class="form-label" for="identity_type">Term:</label>
                                <select name="term_id" class="form-control form-select form-control-sm"
                                    id="fees-academic-year-term-ledger" data-bs-placeholder="Select Status">
                                    <option value="">---- Select ----- </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-2 col-xl-2 col-md-2 col-sm-2">
                            <div class="form-group">
                                <label class="form-label" for="income_start_date">Start Date <span
                                        class="tx-danger">*</span></label>
                                <input value="<?= date('Y-m-d'); ?>" type="date" class="form-control form-control-sm"
                                    id="fess_start_date" name="start_date" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="col-lg-2 col-xl-2 col-md-2 col-sm-2">
                            <div class="form-group">
                                <label class="form-label" for="income_end_date">End Date <span
                                        class="tx-danger">*</span></label>
                                <input value="<?= date('Y-m-d'); ?>" type="date" class="form-control form-control-sm"
                                    id="fess_end_date" name="end_date" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="col-lg-2 col-xl-2 col-md-2 col-sm-2">
                            <div class="form-group">
                                <label class="form-label" for="register_std_fees_payment_mtd">Payment Method</label>
                                <select name="payment_method" class="form-control form-select form-control-sm"
                                    data-bs-placeholder="">
                                    <option value="0"> All </option>
                                    <option value="cash">Cash</option>
                                    <option value="bank">Bank</option>
                                    <option value="sacco">Sacco</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-1 col-xl-1 col-md-1 col-sm-1 pt-3">
                            <button class="btn ripple btn-primary mt-4 btn-sm" id="btn-fetch-fees-transactions"
                                type="button">Fetch</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card custom-card overflow-hidden">
            <div class="card-body">

                <div id="fees-ledger-view-container">

                    <div class="table-responsive export-table">
                        <table id="pending-schools-datatable"
                            class="table table-bordered text-nowrap key-buttons border-bottom">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">Name</th>
                                    <th class="border-bottom-0">Student No</th>
                                    <th class="border-bottom-0">Class/Stream</th>
                                    <th class="border-bottom-0">Amount Paid</th>
                                    <th class="border-bottom-0">Payment Method</th>
                                    <th class="border-bottom-0">Record Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($fees)) : ?>
                                    <?php foreach ($fees as $key => $fee) : ?>
                                        <tr>
                                            <td><?= $key + 1; ?></td> 
                                            <td><?= esc($fee->name); ?></td>
                                            <td><?= esc($fee->people_number); ?></td>
                                            <td> <?= $fee->current_class ? esc($fee->current_class->class_name) : ''; ?> </td>
                                            <td><?= esc(number_format($fee->amount)); ?></td>
                                            <td><?= esc($fee->payment_method); ?></td>
                                            <td><?= esc(h_format_date_display($fee->record_date)); ?></td>
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
</div>
<!-- End Row -->

<?= $this->endSection('content'); ?>