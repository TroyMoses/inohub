<div class="modal fade school-large-modal" id="school-search-student" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Search Student by Name | Student Number</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <label>Search Term - Full Name | Student No</label>
                    <input type="text" class="form-control form-control-sm"  autocomplete="off" placeholder="Searching....." id="search-student-detail-input" autofocus="true">
                    <div class="table-responsive export-table mt-2" id="search-student-results">
                        <p class="mt-2">Enter Atleast (4) characters</p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade school-large-modal" id="view-searched-student" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Student Details</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="search-student-detail-input-id">

                <!-- row -->
                <div class="row row-sm">
                    <!-- Col -->
                    <div class="col-lg-3 col-xl-3 col-md-3 col-sm-3">
                        <div class="mg-b-20">
                            <div class="main-content-left main-content-left-mail">
                                <a class="btn btn-primary btn-compose" href="#!" id="btnCompose">Student Profile</a>
                                <div class="main-mail-menu">
                                    <nav class="nav main-nav-column mg-b-20">
                                        <a class="nav-link thumb active" data-bs-toggle="tab" id="btn-tabStudentProf" href="#tabStudentProf"><i
                                                class="fa fa-home"></i> Profile </a>
                                        <a class="nav-link thumb" data-bs-toggle="tab" id="btn-tabStudentEdit" href=""><i class="fa fa-edit"></i>
                                            Edit Profile</a>
                                        <a class="nav-link thumb" data-bs-toggle="tab" id="btn-tabStudentPocketMoney" href="#tabStudentPocketMoney"><i
                                            class="fa fa-cog"></i> Pocket Money Ledger</a>
                                        <a class="nav-link thumb" data-bs-toggle="tab" id="btn-tabStudentFees" href=""><i
                                            class="fa fa-cog"></i> Fees Ledger</a>
                                        <a class="nav-link thumb" data-bs-toggle="tab" href="#tabStudentAdmission"><i
                                                class="fa fa-cog"></i> Admission</a>
                                        <a class="nav-link thumb" data-bs-toggle="tab" href="#tabStudentReportCard"><i
                                                class="fa fa-cog"></i> Report Card</a>
                                        
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

                            <div class="tab-pane active show" id="tabStudentProf">
                                
                            </div>

                            <div  class="tab-pane" id="tabStudentEdit">
                                
                            </div>
                            <div  class="tab-pane" id="tabStudentAdmission">
                                <div class="divider">GENERAL PROFILE DATA </div>
                            </div>
                            <div  class="tab-pane" id="tabStudentReportCard">
                                <div class="divider">GENERAL PROFILE DATA </div>
                            </div>
                            <div  class="tab-pane" id="tabStudentFees">
                                
                            </div>
                            <div  class="tab-pane" id="tabStudentPocketMoney">
                                <div class="divider"> POCKET MONEY LEDGER </div>
                            </div>

                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

