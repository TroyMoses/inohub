<div class="divider">GENERAL PROFILE DATA </div>


<form id="update-school-settings-form" method="post"
    action="<?= base_url('Sys/Schools/submitGeneralSchoolSettingsForm'); ?>"
    enctype="multipart/form-data">
    <div class="row row-sm">
        <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
            <div class="form-group">
                <label class="form-label" for="school_name">SMS Cost <span
                        class="tx-danger">*</span></label>
                <input type="number" class="form-control form-control-sm" id="school_sms_cost" value="<?= esc( $school->sms_cost ) ?>" name="sms_cost" autocomplete="off" required>
            </div>
        </div>
    </div>
    
    <input type="hidden" value="<?= esc( $schoolId ) ?>" class="form-control form-control-sm" id="general-school-settings-id" name="school_id" autocomplete="off">
    <button class="btn ripple btn-primary" id="btn-save-school-sms-btn" type="button">Save</button>
</form>