
<div class="row">
    <div class="col-md-12">
        <div class="mt-4 mb-4">
            <div class="custom-school-header-card">
                <div class="custom-school-header">
                    <div class="custom-school-logo">
                        <a href="<?php echo base_url('dashboard'); ?>" class="header-logo">
                            <img src="<?php echo h_session('school_logo') ? base_url(h_session('school_logo')) :base_url('assets/img/brand/logo.png'); ?>"
                                class="mobile-logo logo-1" alt="logo">
                        </a>
                        <span><?php echo h_session('school_name') ? h_session('school_name') :'' ?></span>
                    </div>
                    <div class="custom-school-info">
                        <div class="custom-school-info-section">
                            <span
                                class="custom-school-title"><?php echo h_session('current_page') ? h_session('current_page') :'Dashboard' ?></span>
                        </div>
                        <div class="custom-school-info-section">
                            <span class="custom-school-label">School:</span>
                            <span
                                class="custom-school-value custom-school-value-txt"><?php echo h_session('school_name') ? h_session('school_name') :'' ?></span>
                            <span class="custom-school-label">Address:</span>
                            <span
                                class="custom-school-value"><?php echo h_session('physical_address') ? h_session('physical_address') :'' ?></span>
                        </div>
                        <div class="custom-school-info-section">
                            <span class="custom-school-label">Branch:</span>
                            <span
                                class="custom-school-value custom-school-value-txt"><?php echo h_session('branch_name') ? h_session('branch_name') :'' ?></span>
                            <span class="custom-school-label">Address:</span>
                            <span
                                class="custom-school-value"><?php echo h_session('branch_address') ? h_session('branch_address') :'' ?></span>
                        </div>
                        <div class="custom-school-info-section">
                            <input type="hidden" id="custom-school-login-current-time"
                                value="<?php echo h_session('login_time') ? h_session('login_time') :'' ?>" />
                            <span class="custom-school-label">LOGIN TIME:</span>
                            <span class="custom-school-value" id="custom-school-login-time">0h 0m 0s</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if (h_session('user_branch_id') != h_session('branch_id')):?>
<div class="row mb-2">
    <div class="col-md-12">
        <div class="header-column" id="swich_branch_indicator">
            <h4 style="margin: 0px; font-size: 14px;">YOU HAVE SWITCHED TO BRANCH <span class="fa fa-forward"></span>
            <?= esc(h_session('branch_name')); ?></h4>
        </div>
    </div>
</div>
<?php endif; ?>