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
                <form id="" method="post"
                    action="" enctype="multipart/form-data">
                    <div class="row row-sm">

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
                <div class="table-responsive export-table" id="list-income-transactions-table">
                    <table id="pending-schools-datatable"
                        class="table table-bordered text-nowrap key-buttons border-bottom">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">Chart Account</th>
                                <th class="border-bottom-0">DR</th>
                                <th class="border-bottom-0">CR</th>
                                <th class="border-bottom-0">BALANCE</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- End Row --> 

<?= $this->endSection('content'); ?>