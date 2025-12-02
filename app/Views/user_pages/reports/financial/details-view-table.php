<?php 
    helper('h_date'); 
?>

<div class="table-responsive  export-table">
    <table id="school-global-ajax-datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
        <thead>
            <tr>
                <th class="border-bottom-0">#</th>
                <th class="border-bottom-0">Heading</th>
                <th class="border-bottom-0">DR</th>
                <th class="border-bottom-0">CR</th>
                <th class="border-bottom-0">Reference No</th>
                <th class="border-bottom-0">Record Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($transactions)): ?>
            <?php foreach ($transactions as $key => $transaction) : ?>
            <tr>
                <td><?= $key + 1; ?></td>
                <td><?= esc($transaction->heading); ?></td>
                <td><?= $transaction->cr_dr == 'dr' ? number_format($transaction->amount):0 ?></td>
                <td><?= $transaction->cr_dr == 'cr' ? number_format($transaction->amount):0 ?></td>
                <td><?= esc($transaction->reference_number); ?></td>
                <td><?= $transaction->record_date ? esc(h_format_date_display($transaction->record_date)):''; ?></td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>