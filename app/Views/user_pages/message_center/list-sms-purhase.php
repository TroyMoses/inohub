<div class="table-responsive export-table">
    <table id="school-global-ajax-datatable" class="table table-bordered text-nowrap key-buttons border-bottom">
        <thead>
            <tr>
                <th class="border-bottom-0">#</th>
                <th class="border-bottom-0">Amount</th>
                <th class="border-bottom-0">SMS Cost</th>
                <th class="border-bottom-0">Total SMS</th>
                <th class="border-bottom-0">Status</th>
                <th class="border-bottom-0">Payment Method</th>
                <th class="border-bottom-0">Session Date</th>
                <th class="border-bottom-0 call-action">Action</th>
            </tr>
        </thead>
        <tbody>

            <?php if (!empty($sms_purchases)) : ?>
            <?php foreach ($sms_purchases as $key => $purchase) : ?>
            <tr>
                <td><?= $key + 1; ?></td>
                <td><?= esc(number_format($purchase->amount)); ?></td>
                <td><?= esc(number_format($purchase->sms_cost)); ?></td>
                <td><?= esc(number_format(round($purchase->amount/$purchase->sms_cost))); ?></td>
                <td><?= esc($purchase->status); ?> </td>
                <td><?= esc($purchase->payment_method); ?></td>
                <td><?= esc($purchase->date_added); ?></td>
                <td class="call-action">
                    <button type="button" class="btn btn-primary btn-sm">View</button>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>

        </tbody>
    </table>
</div>