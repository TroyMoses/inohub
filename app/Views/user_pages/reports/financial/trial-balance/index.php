<?= $this->extend('layouts/switcher-main'); ?>

<?= $this->section('styles'); ?>

<?= $this->endSection('styles'); ?>

<?= $this->section('content'); ?>

<?php 
helper('h_date'); 
$line_charts = $transactions; // Get the hierarchical data
?>

<!-- Row -->
<div class="row row-sm">
    <!-- col -->
    <div class="col-lg-12">
        <div class="card mg-b-20">
            <div class="card-body d-flex p-1">
                <div class="main-content-label mb-0 mg-t-8 school-navigation-header">
                    <?= h_session('current_page') ? h_session('current_page') : '' ?>
                </div>
                <div class="ms-auto">
                    <a class="d-block tx-20" data-placement="top" data-bs-toggle="tooltip"
                        title="<?= h_session('current_page') ? h_session('current_page') : '' ?>"
                        href="javascript:void(0);">
                        <i class="si si-plus text-muted"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card custom-card overflow-hidden">
            <div class="card-body">
                <form id="filter-financial-tb-form" method="post" action="<?= base_url('Sys/Reports/FinancialStatements/generalTrialBalance'); ?>" enctype="multipart/form-data">
                    <div class="row row-sm">
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="income_start_date">Start Date <span
                                        class="tx-danger">*</span></label>
                                <input value="<?= date('Y-m-d'); ?>" type="date" class="form-control form-control-sm"
                                    id="view-transactio-start-date" name="start_date" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                            <div class="form-group">
                                <label class="form-label" for="income_end_date">End Date <span
                                        class="tx-danger">*</span></label>
                                <input value="<?= date('Y-m-d'); ?>" type="date" class="form-control form-control-sm"
                                    id="view-transactio-end-date" name="end_date" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3 pt-3">
                            <button class="btn ripple btn-primary mt-4 btn-sm" id="btn-fetch-tb-transactions"
                                type="button">Fetch Transactions</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->
<div id="financial-trial-balance-container">
    <?= view('user_pages/reports/financial/trial-balance/trial-balance-view') ?>
</div>
<!-- End Row -->

<?= $this->endSection('content'); ?>