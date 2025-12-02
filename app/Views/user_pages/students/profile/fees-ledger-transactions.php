<div class="table-responsive  export-table mt-4">
    <table id="fees-payments-ledger-datatable"
        class="table table-bordered text-nowrap key-buttons border-bottom"> 
        <thead>
            <tr>
                <th class="border-bottom-0">#</th>
                <th class="border-bottom-0">Ref No</th>
                <th class="border-bottom-0">Heading</th>
                <th class="border-bottom-0">Amount</th>
                <th class="border-bottom-0">Payment Method</th>
                <th class="border-bottom-0">Record Date</th>
                <th class="border-bottom-0">Session Date</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($transactions)) : ?>
                <?php foreach ($transactions as $key => $transaction) : ?>
                    <tr>
                        <td><?= $key + 1; ?></td>
                        <td><?= esc($transaction->reference_number); ?></td>
                        <td><?= esc($transaction->heading); ?></td>
                        <td><?= esc(number_format($transaction->amount)); ?></td>
                        <td><?= esc($transaction->payment_method); ?></td>
                        <td><?= esc( date('Y-m-d', strtotime($transaction->record_date)) ); ?></td> 
                        <td><?= esc( date('Y-m-d', strtotime($transaction->date_added))); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>