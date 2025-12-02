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
                                <th class="border-bottom-0">Grade Title</th>
                                <th class="border-bottom-0">Classes</th>
                                <th class="border-bottom-0">Grade</th>
                                <th class="border-bottom-0 call-action no-print">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($grades)) : ?>
                                <?php foreach ($grades as $key => $grade) : ?>
                                    <tr>
                                        <td><?= $key + 1; ?></td>
                                        <td><?= esc($grade->title); ?></td>
                                        <td>
                                            <div class="text-wrap">
                                                <?php if (!empty($grade->classes)): ?>
                                                    <?php foreach ($grade->classes as $key => $class) : ?>
                                                        <span class="badge badge-pill bg-info me-1 my-2"><?= esc($class->short_name); ?></span>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <table id="class-grades-datatable"
                                                class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="border-bottom-0">Grade</th>
                                                        <th class="border-bottom-0">Agg</th>
                                                        <th class="border-bottom-0">Min</th>
                                                        <th class="border-bottom-0">Max</th>
                                                        <th class="border-bottom-0">Remarks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($grade->grades)): ?>
                                                        <?php foreach ($grade->grades as $key => $grading) : ?>
                                                            <tr>
                                                                <td><?= esc($grading->grade); ?></td>
                                                                <td><?= esc($grading->aggregate); ?></td>
                                                                <td><?= esc($grading->min); ?></td>
                                                                <td><?= esc($grading->max); ?></td>
                                                                <td><?= esc($grading->remarks); ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm btn-edit-class-grade"
                                                data-id="<?= esc($grade->id); ?>">
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

<div id="edit-grade-modal-container"></div>

<?= $this->endSection('content'); ?>