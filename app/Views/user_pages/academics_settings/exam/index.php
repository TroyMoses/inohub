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
                                <th class="border-bottom-0">Exam</th>
                                <th class="border-bottom-0">Short Name</th>
                                <th class="border-bottom-0">Description</th>
                                <th class="border-bottom-0">Status</th>
                                <th class="border-bottom-0">Session Date</th>
                                <th class="border-bottom-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($exams)) : ?>
                                <?php foreach ($exams as $key => $exam) : ?>
                                    <tr>
                                        <td><?= $key + 1; ?></td>
                                        <td><?= esc($exam->name); ?></td>
                                        <td><?= esc($exam->short_name); ?></td>
                                        <td><?= esc($exam->description); ?></td>
                                        <td><?= esc($exam->status == '0' ? 'Active' : 'Inactive'); ?></td>
                                        <td><?= esc($exam->date_added); ?></td>
                                        <td class="call-action">
                                            <button type="button" class="btn btn-primary btn-sm btn-edit-academic-exam" data-id="<?= esc($exam->id); ?>">Edit</button>

                                            <button type="button"
                                                class="btn btn-danger btn-sm btn-delete-exam"
                                                data-id="<?= esc($exam->id); ?>"
                                                data-label="<?= esc($exam->name); ?>">
                                                Delete
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

<div id="edit-exam-modal-container"></div>

<?= $this->endSection('content'); ?>