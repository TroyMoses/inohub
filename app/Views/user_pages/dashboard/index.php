<?= $this->extend('layouts/switcher-main'); ?>

<?= $this->section('styles'); ?>

<?= $this->endSection('styles'); ?>

<?= $this->section('content'); ?>

<div class="row row-sm mb-2">
    <!-- col -->
    <div class="col-lg-12">
        <div class="card mg-b-2">
            <div class="card-body p-2">

                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                        <h4 style="margin: 5px; font-size: 14px;"> ACADEMIC YEAR: <span
                                class="badge bg-primary"> <?= h_session('currentYearName') ?> </span> <span class="fa fa-forward"></span> TERM: <span
                                class="badge bg-primary">All Terms</span> </h4>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                        <button type="button" id="" style="float: inline-end;" class="btn btn-primary btn-sm">Filter
                            Dashboard</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- row -->
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <!-- <div class="container"> -->
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-3 col-xs-3">
                <div class="card sales-card circle-image1">
                    <div class="row">
                        <div class="col-8">
                            <div class="ps-4 pt-4 pe-3 pb-4">
                                <div class="">
                                    <h6 class="mb-2 tx-12 ">Total Staff</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <h4 class="tx-20 font-weight-semibold mb-2">
                                            <?= esc(number_format($dashboard->staffCount) ); ?> </h4>
                                    </div>
                                    <p class="mb-0 tx-12 text-muted">Last Term<i
                                            class="fa fa-caret-up mx-2 text-success"></i>
                                        <span class="text-success font-weight-semibold"> +1</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div
                                class="circle-icon bg-primary-transparent text-center align-self-center overflow-hidden">
                                <i class="fe fe-shopping-bag tx-16 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-xs-3">
                <div class="card sales-card circle-image2">
                    <div class="row">
                        <div class="col-8">
                            <div class="ps-4 pt-4 pe-3 pb-4">
                                <div class="">
                                    <h6 class="mb-2 tx-12">Total Students</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <h4 class="tx-20 font-weight-semibold mb-2">
                                            <?= esc(number_format($dashboard->studentCount)); ?> </h4>
                                    </div>
                                    <p class="mb-0 tx-12 text-muted">Last Term<i
                                            class="fa fa-caret-down mx-2 text-danger"></i>
                                        <span class="font-weight-semibold text-danger"> -1</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="circle-icon bg-info-transparent text-center align-self-center overflow-hidden">
                                <i class="fe fe-dollar-sign tx-16 text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-xs-3">
                <div class="card sales-card circle-image3">
                    <div class="row">
                        <div class="col-8">
                            <div class="ps-4 pt-4 pe-3 pb-4">
                                <div class="">
                                    <h6 class="mb-2 tx-12">Female Students</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <h4 class="tx-20 font-weight-semibold mb-2">
                                            <?= esc(number_format($dashboard->femaleStudentCount)); ?></h4>
                                    </div>
                                    <p class="mb-0 tx-12 text-muted">Last Term<i
                                            class="fa fa-caret-up mx-2 text-success"></i>
                                        <span class=" text-success font-weight-semibold"> +0</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div
                                class="circle-icon bg-secondary-transparent text-center align-self-center overflow-hidden">
                                <i class="fe fe-external-link tx-16 text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-xs-3">
                <div class="card sales-card circle-image4">
                    <div class="row">
                        <div class="col-8">
                            <div class="ps-4 pt-4 pe-3 pb-4">
                                <div class="">
                                    <h6 class="mb-2 tx-12">Male Students</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <h4 class="tx-22 font-weight-semibold mb-2">
                                            <?= esc(number_format($dashboard->maleStudentCount)); ?></h4>
                                    </div>
                                    <p class="mb-0 tx-12  text-muted">Last Term<i
                                            class="fa fa-caret-down mx-2 text-danger"></i>
                                        <span class="text-danger font-weight-semibold"> -1</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div
                                class="circle-icon bg-warning-transparent text-center align-self-center overflow-hidden">
                                <i class="fe fe-credit-card tx-16 text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- </div> -->
</div>
<!-- row closed -->

<!-- row -->
<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-8">
        <div class="card custom-card overflow-hidden">
            <div class="card-header border-bottom-0">
                <div>
                    <h3 class="card-title mb-2 ">No Of Students Per Class</h3> <span
                        class="d-block tx-12 mb-0 text-muted"></span>
                </div>
            </div>
            <div class="card-body">
                <!-- <div id="statistics3"></div> -->
                <div class="ht-200 ht-sm-300" id="flotBar2"></div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-4">
        <div class="card custom-card overflow-hidden">
            <div class="card-header border-bottom-0">
                <div>
                    <h3 class="card-title mb-2 ">Student Gender Classification</h3> <span
                        class="d-block tx-12 mb-0 text-muted"></span>
                </div>
            </div>
            <div class="card-body">
                <div id="Viewers"></div>
            </div>
        </div>
    </div>
</div>


<!-- row -->
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <!-- <div class="container"> -->
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-3 col-xs-3">
                <div class="card sales-card circle-image1">
                    <div class="row">
                        <div class="col-8">
                            <div class="ps-4 pt-4 pe-3 pb-4">
                                <div class="">
                                    <h6 class="mb-2 tx-12 ">Expected Amount</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <h4 class="tx-20 font-weight-semibold mb-2">UGX 0</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div
                                class="circle-icon bg-primary-transparent text-center align-self-center overflow-hidden">
                                <i class="fe fe-shopping-bag tx-16 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-xs-3">
                <div class="card sales-card circle-image2">
                    <div class="row">
                        <div class="col-8">
                            <div class="ps-4 pt-4 pe-3 pb-4">
                                <div class="">
                                    <h6 class="mb-2 tx-12">Collected Amount</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <h4 class="tx-20 font-weight-semibold mb-2"> UGX 0</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="circle-icon bg-info-transparent text-center align-self-center overflow-hidden">
                                <i class="fe fe-dollar-sign tx-16 text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-xs-3">
                <div class="card sales-card circle-image3">
                    <div class="row">
                        <div class="col-8">
                            <div class="ps-4 pt-4 pe-3 pb-4">
                                <div class="">
                                    <h6 class="mb-2 tx-12">Total Bursuries</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <h4 class="tx-20 font-weight-semibold mb-2">UGX 0</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div
                                class="circle-icon bg-secondary-transparent text-center align-self-center overflow-hidden">
                                <i class="fe fe-external-link tx-16 text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-xs-3">
                <div class="card sales-card circle-image4">
                    <div class="row">
                        <div class="col-8">
                            <div class="ps-4 pt-4 pe-3 pb-4">
                                <div class="">
                                    <h6 class="mb-2 tx-12">Fees Exemptions</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <h4 class="tx-22 font-weight-semibold mb-2">UGX 0</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div
                                class="circle-icon bg-warning-transparent text-center align-self-center overflow-hidden">
                                <i class="fe fe-credit-card tx-16 text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- </div> -->
</div>
<!-- row closed -->

<?= $this->endSection('content'); ?>

<?= $this->section('scripts'); ?>

<!-- Internal Chart.Bundle js-->
<script src="<?php echo base_url('assets/plugins/chart.js/Chart.bundle.min.js'); ?>"></script>

<!-- INTERNAL Apexchart js -->
<script src="<?php echo base_url('assets/js/apexcharts.js'); ?>"></script>

<!--Internal Sparkline js -->
<script src="<?php echo base_url('assets/plugins/jquery-sparkline/jquery.sparkline.min.js'); ?>"></script>

<!-- Internal Flot js -->
<script src="<?php echo base_url('assets/plugins/jquery.flot/jquery.flot.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/jquery.flot/jquery.flot.pie.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/jquery.flot/jquery.flot.resize.js'); ?>"></script>

<!-- Rating js-->
<script src="<?php echo base_url('assets/plugins/rating/jquery.rating-stars.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/rating/jquery.barrating.js'); ?>"></script>

<!--Internal  Perfect-scrollbar js -->
<script src="<?php echo base_url('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/perfect-scrollbar/p-scroll.js'); ?>"></script>

<!-- right-sidebar js -->
<script src="<?php echo base_url('assets/plugins/sidebar/sidebar.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/sidebar/sidebar-custom.js'); ?>"></script>

<!--Internal  index js -->
<!-- <script src="<?php echo base_url('assets/js/index2.js'); ?>"></script> -->

<!-- Internal Data tables -->
<script src="<?php echo base_url('assets/plugins/datatable/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatable/js/dataTables.bootstrap5.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatable/dataTables.responsive.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatable/responsive.bootstrap5.min.js'); ?>"></script>

<!-- Internal Chart flot js -->
<script src="<?php echo base_url('assets/js/chart.flot.js'); ?>"></script>

<!-- Internal Chart.Bundle js-->
<script src="<?php echo base_url('assets/plugins/chart.js/Chart.bundle.min.js'); ?>"></script>

<!-- INTERNAL Apexchart js -->
<script src="<?php echo base_url('assets/js/apexcharts.js'); ?>"></script>

<!--Internal  index js -->
<script src="<?php echo base_url('assets/js/index.js'); ?>"></script>

<?= $this->endSection('scripts'); ?>