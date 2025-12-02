<div class="modal fade school-large-modal" id="school-pay-fees-search-student" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Search Student by Name | Student Number</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <label>Search Term - Full Name | Student No</label>
                    <input type="text" class="form-control form-control-sm"  autocomplete="off" placeholder="Searching....." id="search-student-detail-pay-fees" autofocus>
                    <div class="table-responsive export-table mt-2" id="search-student-pay-fees-results">
                        <p class="mt-2">Enter Atleast (4) characters</p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade school-large-modal" id="view-searched-student-fee-pay" data-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">School Fees Payment For </h6>

                <select id="fees-payment-current-year" style="width: 22%; margin-left:10px" class="form-control form-select form-control-sm"
                     data-bs-placeholder="Select Payment Method" required>
                </select>

                <select id="fees-payment-current-year-term" style="width: 22%;" class="form-control form-select form-control-sm"
                    data-bs-placeholder="Select Payment Method" required>
                </select>
                
                <button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" id="school-fees-payment-form-modal-div">
                

            </div>

            <div class="modal-footer">
                <button class="btn ripple btn-primary" id="btn-save-student-fees-payment" type="button">Save Payment</button>
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>

        </div>
    </div>
</div>

