<?= $this->extend('layouts/switcher-main'); ?>

<?= $this->section('styles'); ?>

<?= $this->endSection('styles'); ?>

<?= $this->section('content'); ?>

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

        <div class="card custom-card" id="pill">
            <div class="card-body">
                <div class="text-wrap">
                    <div class="">
                        <div class="p-2 br-5 ">
                            <ul class="nav nav-pills nav-pills-circle" id="tabs_2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link border active show py-2 px-3 m-2" id="tab1" data-bs-toggle="tab"
                                        href="#tabs_1_assets" role="tab" aria-selected="false">
                                        <span class="nav-link-icon d-block"><i class="fe fe-home"></i> Assets</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link border py-2 px-3  m-2" id="tab2" data-bs-toggle="tab"
                                        href="#tabs_2_liabilities" role="tab" aria-selected="false">
                                        <span class="nav-link-icon d-block"><i class="fe fe-unlock"></i> Liabilities
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link py-2 px-3  border m-2" id="tab3" data-bs-toggle="tab"
                                        href="#tabs_3_capital" role="tab" aria-selected="true">
                                        <span class="nav-link-icon d-block"><i class="fe fe-play"></i> Capital</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link border py-2 px-3  m-2" id="tab4" data-bs-toggle="tab"
                                        href="#tabs_4_incomes" role="tab" aria-selected="false">
                                        <span class="nav-link-icon d-block"><i class="fe fe-layers"></i> Income</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link border py-2 px-3  m-2" id="tab5" data-bs-toggle="tab"
                                        href="#tabs_5_expenses" role="tab" aria-selected="false">
                                        <span class="nav-link-icon d-block"><i class="fe fe-image"></i> Expenses </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="card-body tab-content">
                    <div class="tab-pane active show" id="tabs_1_assets">
                        <?php if (!empty($coa->assets)) : ?>
                            <?php echo h_buildTreeHtml($coa->assets, 'tree-assets'); ?>
                        <?php endif; ?>
                    </div>
                    <div class="tab-pane" id="tabs_2_liabilities">
                        <?php if (!empty($coa->liabilities)) : ?>
                            <?php echo h_buildTreeHtml($coa->liabilities, 'tree-liabilities'); ?>
                        <?php endif; ?>
                    </div>
                    <div class="tab-pane" id="tabs_3_capital">
                        <?php if (!empty($coa->capital)) : ?>
                            <?php echo h_buildTreeHtml($coa->capital, 'tree-capital'); ?>
                        <?php endif; ?>
                    </div>
                    <div class="tab-pane" id="tabs_4_incomes">
                        <?php if (!empty($coa->income)) : ?>
                            <?php echo h_buildTreeHtml($coa->income, 'tree-incomes'); ?>
                        <?php endif; ?>
                    </div>
                    <div class="tab-pane" id="tabs_5_expenses">
                        <?php if (!empty($coa->expenses)) : ?>
                            <?php echo h_buildTreeHtml($coa->expenses, 'tree-expenses'); ?>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
<!-- End Row -->

<?= $this->endSection('content'); ?>

<?= $this->section('scripts'); ?>

<!-- Internal Treeview js -->
<script src="<?php echo base_url('assets/plugins/treeview/treeview.js'); ?>"></script>

<?= $this->endSection('scripts'); ?>