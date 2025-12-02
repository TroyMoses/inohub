<?= $this->extend('layouts/switcher-main'); ?>

<?= $this->section('styles'); ?>
<?= $this->endSection('styles'); ?>

<?= $this->section('content'); ?>

<!-- Row -->
<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card mg-b-20">
            <div class="card-body d-flex p-1">
                <div class="main-content-label mb-0 mg-t-8 school-navigation-header">
                    <?= h_session('current_page') ?? '' ?>
                </div>
                <div class="ms-auto">
                    <a class="d-block tx-20" data-placement="top" data-bs-toggle="tooltip"
                        title="Add New Bursary" href="javascript:void(0);" id="add-new-bursary-href">
                        <i class="si si-plus text-muted"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- List -->
<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card custom-card overflow-hidden">
            <div class="card-body">
                <div class="table-responsive export-table">
                    <table id="pending-schools-datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">Org Type</th>
                                <th class="border-bottom-0">Name</th>
                                <th class="border-bottom-0">Status</th>
                                <th class="border-bottom-0">Primary Contact</th>
                                <th class="border-bottom-0">Email</th>
                                <th class="border-bottom-0">Contact Person</th>
                                <th class="border-bottom-0">Contact Phone</th>
                                <th class="border-bottom-0">Date Added</th>
                                <th class="border-bottom-0 call-action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bursaries ?? [] as $key => $bursary): ?>
                                <tr>
                                    <td><?= $key + 1; ?></td>
                                    <td><?= esc($bursary->org_type); ?></td>
                                    <td><?= esc($bursary->name); ?></td>
                                    <td><?= esc($bursary->status); ?></td>
                                    <td><?= esc($bursary->primary_contact); ?></td>
                                    <td><?= esc($bursary->email); ?></td>
                                    <td><?= esc($bursary->primary_contact_person_name); ?></td>
                                    <td><?= esc($bursary->primary_contact_person_telephone); ?></td>
                                    <td><?= esc($bursary->created_at); ?></td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm edit-bursary-btn"
                                            data-id="<?= $bursary->id ?>"
                                            data-name="<?= esc($bursary->name) ?>"
                                            data-org_type="<?= esc($bursary->org_type) ?>"
                                            data-status="<?= esc($bursary->status) ?>"
                                            data-primary_contact="<?= esc($bursary->primary_contact) ?>"
                                            data-telephone="<?= esc($bursary->telephone) ?>"
                                            data-email="<?= esc($bursary->email) ?>"
                                            data-address="<?= esc($bursary->address) ?>"
                                            data-pcp_name="<?= esc($bursary->primary_contact_person_name) ?>"
                                            data-pcp_email="<?= esc($bursary->primary_contact_person_email) ?>"
                                            data-pcp_telephone="<?= esc($bursary->primary_contact_person_telephone) ?>">
                                            Edit
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-danger btn-sm delete-bursary-btn"
                                            data-id="<?= esc($bursary->id); ?>"
                                            data-name="<?= esc($bursary->name); ?>">
                                            Delete
                                        </button>

                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Add and Edit Modals -->
<?= $this->include('user_pages/fees_payments/bursaries/add-bursary'); ?>
<?= $this->include('user_pages/fees_payments/bursaries/edit-bursary'); ?>

<?= $this->endSection('content'); ?>