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
                                <th class="border-bottom-0">Message</th>
                                <th class="border-bottom-0">Recipients</th>
                                <th class="border-bottom-0">Date Sent</th>
                                <th class="border-bottom-0">Status</th>
                                <th class="border-bottom-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($mesages)) : ?>
                                <?php foreach ($mesages as $key => $mesage) : ?>
                                    <tr>
                                        <td><?= $key + 1; ?></td>
                                        <td><?= strlen($mesage->message) > 40 ? substr(esc($mesage->message), 0, 40) . '...' : esc($mesage->message); ?></td>
                                        <td>
                                            <?php 
                                                $recipients = json_decode($mesage->recipients); 
                                                $maxToShow = 5; 
                                                foreach ($recipients as $key => $recipient) : 
                                                    if ($key < $maxToShow) : ?>
                                                        <span class="badge bg-primary me-1"><?= esc($recipient); ?></span>
                                                    <?php elseif ($key === $maxToShow) : ?>
                                                        <span class="badge bg-secondary me-1">...</span>
                                                        <?php break; ?>
                                                    <?php endif; 
                                                endforeach; 
                                            ?>
                                        </td>
                                        <td><?= esc($mesage->date_added); ?></td>
                                        <td>Sent</td>
                                        <td class="call-action">
                                            <button type="button" class="btn btn-primary btn-sm">View</button>
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

<?= $this->endSection('content'); ?>