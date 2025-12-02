<?php 
helper('h_date'); 
$line_charts = $transactions; // Get the hierarchical data
?>
<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card custom-card overflow-hidden">
            <div class="card-body">
                <div class="table-responsive export-table" id="list-income-transactions-table">
                    <table id="pending-schools-datatable-1"
                        class="table table-bordered text-nowrap key-buttons border-bottom">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">Chart Account</th>
                                <th class="border-bottom-0">DR</th>
                                <th class="border-bottom-0">CR</th>
                                <th class="border-bottom-0">BALANCE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $row_number = 1;
                            $grand_total_dr = 0;
                            $grand_total_cr = 0;
                            foreach ($line_charts as $line_chart): ?>
                            <tr style="background: #7e8da3; color: white;">
                                <td class="font-weight-bold text-left"><?= $line_chart['name']; ?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <?php foreach ($line_chart['transactions'] as $account): ?>
                            <?php render_account_row($account, $row_number, 0, $grand_total_dr, $grand_total_cr); ?>
                            <?php endforeach; ?>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="border-bottom-0"><strong>Grand Total</strong></th>
                                <th class="border-bottom-0"></th>
                                <th class="border-bottom-0 text-danger">
                                    <strong><?= number_format($grand_total_dr, 0); ?></strong></th>
                                <th class="border-bottom-0 text-danger">
                                    <strong><?= number_format($grand_total_cr, 0); ?></strong></th>
                                <th class="border-bottom-0">
                                    <strong><?= number_format($grand_total_dr - $grand_total_cr, 0); ?></strong></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="view-tb-trnsaction-details-modal" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Transaction Details</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" id="view-transaction-details-container">
                
            </div>
            <div class="modal-footer">
                <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>

<?php
function render_account_row($account, &$row_number, $level = 0, &$grand_total_dr = 0, &$grand_total_cr = 0) {
    $indent = str_repeat('&nbsp;&nbsp;', $level * 2); // Indent children
    $cr = in_array($account->line_chart, ['income', 'capital', 'liabilities'])? $account->transactions:0;
    $dr = !in_array($account->line_chart, ['income', 'capital', 'liabilities'])? $account->transactions:0;

    // Add to grand totals
    $grand_total_dr += $dr;
    $grand_total_cr += $cr;

    echo '<tr>';
    echo '<td>' . $row_number++ . '</td>';
    echo '<td>' . $indent. htmlspecialchars($account->name). '</td>';
    echo '<td>' . ($level == 0 ? '': amount_display($dr, $account) ) . '</td>';
    echo '<td>' . ($level == 0 ? '': amount_display($cr, $account) ) . '</td>';
    echo '<td>' . ($level == 0 ? '': ( $dr > 0 ? number_format($dr): number_format($cr) )  ) . '</td>';
    echo '</tr>';

    // Recursively render child accounts
    if (!empty($account->children)) {
        foreach ($account->children as $child_account) {
            render_account_row($child_account, $row_number, $level + 1, $grand_total_dr, $grand_total_cr);
        }
    }
}

function amount_display($amount, $account) {
    // file_put_contents('debug.log', print_r($account, true), FILE_APPEND );
    if ($amount > 0) {
        return '<a href="#!" onclick="showTransactionDetails(' . $account->id . ')" data-id="'. $account->id .'" style="color: #f34343 !important;">'. number_format($amount) .'</a>';
    }

    return 0;
}
?>