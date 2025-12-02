<?php 
    $accessRightsKeys = h_session('access_rights_keys') ? h_session('access_rights_keys') : [];
?>
<div class="modal fade school-large-modal" id="view-school-profile" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">School Profile</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <input type="hidden" class="form-control form-control-sm" autocomplete="off"
                    id="viewed-active-school-id" name="">

                <!-- row -->
                <div class="row row-sm">
                    <!-- Col -->
                    <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                        <div class="mg-b-20">
                            <div class="main-content-left main-content-left-mail">
                                <a class="btn btn-primary btn-compose" href="" id="btnCompose">School Profile</a>
                                <div class="main-mail-menu">
                                    <nav class="nav main-nav-column mg-b-20">
                                        <a class="nav-link thumb active" data-bs-toggle="tab" href="#tabSchoolProf"><i
                                                class="fa fa-home"></i> Profile </a>
                                        <a class="nav-link thumb" data-bs-toggle="tab" id="btn-tabSchoolEdit" href=""><i
                                                class="fa fa-edit"></i>
                                            Edit Profile</a>

                                        <?php if(in_array('ROOT_ADMINISTRATOR', $accessRightsKeys ) ): ?>
                                        <a class="nav-link thumb" data-bs-toggle="tab" id="btn-tabSchoolFeatures"
                                            href=""><i class="fa fa-cog"></i> Features </a>
                                        <?php endif ?>

                                        <a class="nav-link thumb" data-bs-toggle="tab"  id="btn-tabSchoolSettings" href=""><i
                                                class="fa fa-cog"></i> General Settings</a>
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
                            <div class="tab-pane active show" id="tabSchoolProf">

                            </div>

                            <div class="tab-pane" id="tabSchoolEdit">

                            </div>
                            <div class="tab-pane" id="tabSchoolSettings">
                            
                            </div>
                            <div class="tab-pane" id="tabSchoolFeatures">

                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>