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
                                <th class="border-bottom-0">Stream</th>
                                <th class="border-bottom-0">Class</th>
                                <th class="border-bottom-0">Class Short Name</th>
                                <th class="border-bottom-0">Date Added</th>
                                <th class="border-bottom-0 call-action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($streams)) : ?>
                                <?php foreach ($streams as $key => $stream) : ?>
                                    <tr>
                                        <td><?= $key + 1; ?></td>
                                        <td><?= esc($stream->name); ?></td>
                                        <td><?= esc($stream->class_name); ?></td>
                                        <td><?= esc($stream->class_short_name); ?></td>
                                        <td><?= esc($stream->date_added); ?></td>
                                        <td class="call-action">
                                            <button type="button" class="btn btn-primary btn-sm btn-edit-stream" data-id="<?= esc($stream->id); ?>">Edit</button>
                                            <button type="button"
                                                class="btn btn-danger btn-sm btn-delete-stream"
                                                data-id="<?= esc($stream->id); ?>">
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

<div id="edit-class-modal-container"></div>

<div class="modal fade" id="delete-stream-confirmation-modal" tabindex="-1" aria-labelledby="deleteStreamLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Confirm Delete</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this stream?
                <input type="hidden" id="delete_stream_id">
            </div>
            <button type="button"
                class="btn btn-danger btn-sm btn-delete-stream"
                data-id="<?= esc($stream->id); ?>"
                data-label="<?= esc($stream->name); ?>">
                Delete
            </button>
        </div>
    </div>
</div>

<?= $this->endSection('content'); ?>