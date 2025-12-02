<div class="divider"> FEES LEDGER </div>

<div class="row">
    <div class="col-lg-4 col-xl-4">
        <select id="stud-fees-payment-current-year" style="" class="form-control form-select form-control-sm"
            data-bs-placeholder="Select Payment Method" required>
            <?php foreach ($academic_years as $key => $academic_year) : ?>
                <option <?= $academic_year->is_current_year == '0'? 'selected':''; ?> id="student_fees_academic_years_<?= esc($academic_year->id); ?>" data-terms="<?= esc(json_encode($academic_year->terms)); ?>" value="<?= esc($academic_year->id); ?>"><?= esc($academic_year->name); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-lg-4 col-xl-4">
        <select id="stud-fees-payment-current-year-term" style="" class="form-control form-select form-control-sm"
            data-bs-placeholder="Select Payment Method" required>
        </select>
    </div>
    <div class="col-lg-4 col-xl-4">
        <button id="btn-fetch-fees-ledger-payment-trns" class="btn ripple btn-primary btn-sm mt-1" type="button">Fetch Transactions</button>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-xl-12">
        <div id="fees-ledger-fees-transactions-container">

        </div>
    </div>
</div>