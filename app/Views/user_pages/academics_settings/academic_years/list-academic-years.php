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
                <div class="main-content-label mb-0 mg-t-8 school-navigation-header"><?php echo h_session('current_page') ? h_session('current_page') : '' ?></div>
                <div class="ms-auto"><a class="d-block tx-20" data-placement="top" data-bs-toggle="tooltip"
                        title="<?php echo h_session('current_page') ? h_session('current_page') : '' ?>" href="javascript:void(0);"><i class="si si-plus text-muted"></i></a></div>
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
                                <th class="border-bottom-0">Academic Year</th>
                                <th class="border-bottom-0">Start Date</th>
                                <th class="border-bottom-0">End Date</th>
                                <th class="border-bottom-0">Date Added</th>
                                <th class="border-bottom-0 call-action no-print">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($academic_years)) : ?>
                                <?php foreach ($academic_years as $key => $academic_year) : ?>
                                    <tr>
                                        <td><?= $key + 1; ?></td>
                                        <td><?= esc($academic_year->name); ?></td>
                                        <td><?= esc($academic_year->start_date); ?></td>
                                        <td><?= esc($academic_year->end_date); ?></td>
                                        <td><?= esc($academic_year->date_added); ?></td>
                                        <td class="call-action no-print"><button type="button"
                                                class="btn btn-sm btn-primary btn-edit-academic-year"
                                                data-id="<?= esc($academic_year->id); ?>"
                                                data-name="<?= esc($academic_year->name); ?>"
                                                data-start-date="<?= esc($academic_year->start_date); ?>"
                                                data-end-date="<?= esc($academic_year->end_date); ?>">
                                                Edit
                                            </button>

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

<?= $this->include('user_pages/academics_settings/academic_years/edit-academic-year'); ?>

<?= $this->endSection('content'); ?>