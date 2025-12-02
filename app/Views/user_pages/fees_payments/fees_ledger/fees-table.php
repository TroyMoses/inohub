<?php helper('h_date'); ?>
<div class="table-responsive export-table">
    <table id="school-global-ajax-datatable"
        class="table table-bordered text-nowrap key-buttons border-bottom">
        <thead>
            <tr>
                <th class="border-bottom-0">#</th>
                <th class="border-bottom-0">Name</th>
                <th class="border-bottom-0">Student No</th>
                <th class="border-bottom-0">Class/Stream</th>
                <th class="border-bottom-0">Amount Paid</th>
                <th class="border-bottom-0">Payment Method</th>
                <th class="border-bottom-0">Record Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($fees)) : ?>
                <?php foreach ($fees as $key => $fee) : ?>
                    <tr>
                        <td><?= $key + 1; ?></td> 
                        <td><?= esc($fee->name); ?></td>
                        <td><?= esc($fee->people_number); ?></td>
                        <td> <?= $fee->current_class ? esc($fee->current_class->class_name) : ''; ?> </td>
                        <td><?= esc(number_format($fee->amount)); ?></td>
                        <td><?= esc($fee->payment_method); ?></td>
                        <td><?= esc(h_format_date_display($fee->record_date)); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>