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
                <form id="new-ledger-list-incomes" method="post"
                    action="<?= base_url('Sys/Staff/submitNewDepartmentForm'); ?>" enctype="multipart/form-data">
                    <div class="row row-sm">
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="identity_type">Select Chart Account:<span
                                        class="tx-danger">*</span></label>
                                <select name="income-list-charts" class="form-control form-select form-control-sm"
                                    id="income-list-charts" data-bs-placeholder="Select Year" required>
                                    <option value="">Select Account Chart </option>
                                    <?php if (!empty($income_charts)) : ?>
                                    <?php foreach ($income_charts as $key => $income_chart) : ?>
                                    <option value="<?= esc($income_chart->id); ?>"> <?= esc($income_chart->code); ?> -
                                        <?= esc($income_chart->name); ?> </option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="income_start_date">Start Date <span
                                        class="tx-danger">*</span></label>
                                <input value="<?= date('Y-m-d'); ?>" type="date" class="form-control form-control-sm"
                                    id="income_start_date" name="income_start_date" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="income_end_date">End Date <span
                                        class="tx-danger">*</span></label>
                                <input value="<?= date('Y-m-d'); ?>" type="date" class="form-control form-control-sm"
                                    id="income_end_date" name="income_end_date" autocomplete="off" required>
                            </div>
                        </div>

                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3 pt-3">
                            <button class="btn ripple btn-primary mt-4 btn-sm" id="btn-fetch-income-transactions"
                                type="button">Fetch Transactions</button>
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
                <div class="table-responsive  export-table" id="list-income-transactions-table">
                    <table id="pending-schools-datatable-1"
                        class="table table-bordered text-nowrap key-buttons border-bottom">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">Description</th>
                                <th class="border-bottom-0">Payment Method</th>
                                <th class="border-bottom-0">DR</th>
                                <th class="border-bottom-0">CR</th>
                                <th class="border-bottom-0">Ref No</th>
                                <th class="border-bottom-0">User</th>
                                <th class="border-bottom-0">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($transactions)) : ?>
                            <?php foreach ($transactions as $chartId => $group) : ?>
                            <tr style="background:#f5f5f5; font-weight:bold;">
                                <td></td>
                                <td>
                                    <?= esc($group['account']['code']); ?> - <?= esc($group['account']['name']); ?>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <?php foreach ($group['transactions'] as $index => $transaction) : ?>
                            <tr>
                                <td><?= $index + 1; ?></td>
                                <td><?= esc($transaction->heading); ?></td>
                                <td><?= esc(ucwords($transaction->payment_method)); ?></td>
                                <td><?= esc(number_format($transaction->amount)); ?></td>
                                <td><?= esc(0); ?></td>
                                <td><?= esc($transaction->reference_number); ?></td>
                                <td><?= esc($transaction->added_by_id); ?></td>
                                <td><?= esc(h_format_date_display($transaction->record_date)); ?></td>
                            </tr>

                            <!-- Totals Row -->
                            <?php if ($index + 1 === count($group['transactions'])) : ?>
                            <tr style="font-weight:bold; background-color: #eef;">
                                <td></td>
                                <td>---Totals (<?= $group['record_count']; ?>)---</td>
                                <td></td>
                                <td><?= number_format($group['total_debit']); ?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <?php endif; ?>
                            <?php endforeach; ?>

                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                        <?php
                            $grand_total = array_sum(array_column($transactions, 'total_debit'));
                        ?>
                        <?php if (!empty($transactions)) : ?>
                            <tfoot>
                                <tr style="font-weight:bold; background-color: #ddd;">
                                    <td></td>
                                    <td>Grand Total</td>
                                    <td></td>
                                    <td></td>
                                    <td><?= number_format($grand_total); ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->

<?= $this->endSection('content'); ?>