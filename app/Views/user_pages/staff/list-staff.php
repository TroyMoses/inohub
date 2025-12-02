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
                                <th class="border-bottom-0">Staff Name</th>
                                <th class="border-bottom-0">Staff No</th>
                                <th class="border-bottom-0">Department</th>
                                <th class="border-bottom-0">Gender</th>
                                <th class="border-bottom-0">Phone</th>
                                <th class="border-bottom-0">Email</th>
                                <th class="border-bottom-0">DOB</th>
                                <th class="border-bottom-0 call-action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($staff_list)) : ?>
                                <?php foreach ($staff_list as $key => $listStaff) : ?>
                                <tr>
                                    <td><?= $key + 1; ?></td>
                                    <td><?= esc($listStaff->name); ?></td>
                                    <td><?= esc($listStaff->people_number); ?></td>
                                    <td><?= esc($listStaff->dep_name); ?></td>
                                    <td><?= esc($listStaff->gender == 'M'? 'Male': 'Female'); ?></td>
                                    <td><?= esc($listStaff->phone); ?></td>
                                    <td><?= esc($listStaff->email); ?></td>
                                    <td><?= esc(h_format_date_display($listStaff->dob)); ?></td>
                                    <td class="call-action"><button data-id="<?= esc($listStaff->id); ?>" type="button" class="btn btn-primary btn-sm view-staff-details-btn">--- view ---</button></td>
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

<div class="modal fade school-large-modal" id="view-searched-staff-modal" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Staff Details</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="search-staff-detail-input-id">

                <!-- row -->
                <div class="row row-sm">
                    <!-- Col -->
                    <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                        <div class="mg-b-20">
                            <div class="main-content-left main-content-left-mail">
                                <a class="btn btn-primary btn-compose" href="#!" id="btnCompose">Staff Profile</a>
                                <div class="main-mail-menu">
                                    <nav class="nav main-nav-column mg-b-20">
                                        <a class="nav-link thumb active" data-bs-toggle="tab" id="btn-tabStaffProf" href="#tabStaffProf"><i
                                                class="fa fa-home"></i> Profile </a>
                                        <a class="nav-link thumb" data-bs-toggle="tab" id="btn-tabStaffEdit" href=""><i class="fa fa-edit"></i>
                                            Edit Profile</a>
                                    </nav>
                                </div>
                                <!-- main-mail-menu -->
                            </div>
                        </div>
                    </div>
                    <!-- /Col -->

                    <!-- Col -->
                    <div class="col-lg-9 col-xl-9">

                        <div class="tab-content">
                            <div class="tab-pane active show" id="tabStaffProf">
                                
                            </div>

                            <div  class="tab-pane" id="tabStaffEdit">
                                
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>