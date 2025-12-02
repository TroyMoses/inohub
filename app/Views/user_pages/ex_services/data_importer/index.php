<?= $this->extend('layouts/switcher-main'); ?>

<?= $this->section('styles'); ?>

<?= $this->endSection('styles'); ?>

<?= $this->section('content'); ?>

<?php helper('h_date'); ?>

<?php 
    $accessRightsKeys = h_session('access_rights_keys') ? h_session('access_rights_keys') : [];
?>
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
    <div class="col-lg-3">
        <div class="card custom-card overflow-hidden">
            <div class="card-body p-1">
                <div class="mg-b-20">
                    <div class="main-content-left main-content-left-mail">
                        <a class="btn btn-primary btn-compose" href="" id="btnCompose">DATA-IMPORTER PORTAL:</a>
                        <div class="main-mail-menu">
                            <nav class="nav main-nav-column mg-b-20">

                                <a class="nav-link thumb active" data-bs-toggle="tab" href="#tabImportMarks"><i
                                class="fa fa-cog"></i> Marks</a>

                                <a class="nav-link thumb" data-bs-toggle="tab" href="#tabImportStudents"><i
                                        class="fa fa-home"></i> Students </a>
                                
                                <?php if( in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
                                    <a class="nav-link thumb" data-bs-toggle="tab" href="#tabImportTeachers"><i
                                            class="fa fa-cog"></i>
                                        Teachers</a>
                                <?php endif ?>
                                
                                <?php if(in_array('EX_IMPORT_TERM_STUDENTS', $accessRightsKeys ) || in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
                                    <a class="nav-link thumb" data-bs-toggle="tab" href="#tabImportTermSettings"><i
                                            class="fa fa-cog"></i>
                                        Term Students</a>
                                <?php endif ?>
                            </nav>
                        </div>
                        <!-- main-mail-menu -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
    <div class="card custom-card overflow-hidden">
    <div class="card-body">
        <div class="tab-content">

            <div class="tab-pane active show" id="tabImportMarks">
                <div class="divider">GENERAL MARKS DATA </div>
                <?= view('user_pages/ex_services/data_importer/marks/index') ?>
            </div>

            <div class="tab-pane" id="tabImportStudents">
                <div class="row row-sm">
                    <div class="col-lg-12">
                        <div class="divider">GENERAL IMPORT STUDENTS </div>
                        <?= view('user_pages/ex_services/data_importer/students/index') ?>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="tabImportTeachers">

            </div>

            <div class="tab-pane" id="tabImportTermSettings">
                <?= view('user_pages/ex_services/data_importer/term/index') ?>
            </div>

        </div>
</div>
</div>

    </div>
</div>
<!-- End Row -->

<?= $this->endSection('content'); ?>