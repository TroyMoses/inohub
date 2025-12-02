<?php

namespace App\Models\user_models\reports;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;
use Config\Database;

class M_FinancialReports extends Model
{
    protected $table = 'sch_people';
    protected $primaryKey = 'id';
    protected $db; // Database connection instance

    public function __construct(ConnectionInterface $db = null)
    {
        if (!$db) {
            $dbName = h_session('db_name');
            if ($dbName) {
                // Load the helper
                helper('h_database');

                // Connect to a dynamic database
                $db = h_connect_database($dbName);
            }
            else{
                $db = Database::connect();
            }
        }
        $this->db = $db;
    }

    // function get_reports_transaction() {
    //     $line_charts = [
    //         ['line_chart' => 'assets', "name" => "ASSETS"],
    //         ['line_chart' => 'liabilities', "name" => "LIABILITIES"],
    //         ['line_chart' => 'capital', "name" => "CAPITAL"],
    //         ['line_chart' => 'income', "name" => "INCOME"],
    //         ['line_chart' => 'expenses', "name" => "COSTS & EXPENSES"]
    //     ];
    
    //     // Use a reference to modify the original array
    //     foreach ($line_charts as &$line_chart) {
    //         $transactions = [];
    //         $accounts = $this->db->table('sch_coa')
    //             ->select('*')
    //             ->where('parent', '0')
    //             ->where('chart_line', $line_chart['line_chart'])
    //             ->orderBy('id', 'ASC')
    //             ->get()
    //             ->getResult();
    
    //         foreach ($accounts as $account) {
    //             $account->children = $this->get_child_transactions($account, $line_chart['line_chart']); // Collect children or transactions
    //             $account->line_chart = $line_chart;
    //             $transactions[] = $account;
    //         }
    
    //         // Assign transactions to the current line chart
    //         $line_chart['transactions'] = $transactions;
    //     }
    //     unset($line_chart); // Break the reference to avoid accidental changes
    
    //     return $line_charts; // Return the complete hierarchy
    // }    
    
    // function get_child_transactions($account, $line_chart) {
    //     $child_accounts = $this->db->table('sch_coa')
    //         ->select('*')
    //         ->where('parent', $account->id)
    //         ->orderBy('id', 'ASC')
    //         ->get()
    //         ->getResult();
    
    //     if (empty($child_accounts)) {
    //         $account->children = [];
    //         $account->line_chart = $line_chart;
    //         $account->transactions = $this->get_chart_transactions($account, $line_chart); // Get transaction balance
    //         return [];
    //     }
    
    //     $children = [];
    //     foreach ($child_accounts as $child_account) {
    //         $child_account->children = $this->get_child_transactions($child_account, $line_chart);
    //         $child_account->transactions = $this->get_chart_transactions($child_account, $line_chart); // Balance for child
    //         $child_account->line_chart = $line_chart;
    //         $children[] = $child_account;
    //     }
    
    //     $account->transactions = 0; // Parent accounts only aggregate child transactions
    //     return $children;
    // }


    function get_reports_transaction($startDate, $endDate) {
        $line_charts = [
            ['line_chart' => 'assets', "name" => "ASSETS"],
            ['line_chart' => 'liabilities', "name" => "LIABILITIES"],
            ['line_chart' => 'capital', "name" => "CAPITAL"],
            ['line_chart' => 'income', "name" => "INCOME"],
            ['line_chart' => 'expenses', "name" => "COSTS & EXPENSES"]
        ];
    
        // Use a reference to modify the original array
        foreach ($line_charts as &$line_chart) {
            $transactions = [];
            $accounts = $this->db->table('sch_coa')
                ->select('*')
                ->where('parent', '0')
                ->where('chart_line', $line_chart['line_chart'])
                ->orderBy('id', 'ASC')
                ->get()
                ->getResult();
    
            foreach ($accounts as $account) {
                // Get children or transactions recursively
                $account->children = $this->get_filtered_child_transactions($account, $line_chart['line_chart'], $startDate, $endDate);
                $account->line_chart = $line_chart;
                // Only add the parent account if it has transactions or children with transactions
                if ($account->transactions !== 0 || !empty($account->children)) {
                    $transactions[] = $account;
                }
            }
    
            // Assign transactions to the current line chart
            $line_chart['transactions'] = $transactions;
        }
        unset($line_chart); // Break the reference to avoid accidental changes
    
        return $line_charts; // Return the complete hierarchy
    }
    
    function get_filtered_child_transactions($account, $line_chart, $startDate, $endDate) {
        // Fetch the child accounts of the current account
        $child_accounts = $this->db->table('sch_coa')
            ->select('*')
            ->where('parent', $account->id)
            ->orderBy('id', 'ASC')
            ->get()
            ->getResult();
    
        if (empty($child_accounts)) {
            // If there are no children, get transactions for this account
            $account->transactions = $this->get_chart_transactions($account, $line_chart, $startDate, $endDate); // Get transaction balance for this account
            $account->child_transactions = 0; // No child transactions for a leaf node
            return [];
        }
    
        $children = [];
        $total_child_transactions = 0;
    
        foreach ($child_accounts as $child_account) {
            // Recursively get children and transactions for each child
            $child_account->children = $this->get_filtered_child_transactions($child_account, $line_chart, $startDate, $endDate);
            $child_account->transactions = $this->get_chart_transactions($child_account, $line_chart, $startDate, $endDate); // Balance for child
            $child_account->line_chart = $line_chart;
    
            // Add transactions from the child account to the total of child transactions
            $total_child_transactions += $child_account->transactions;
    
            // Only add child if it has transactions or children with transactions
            if ($child_account->transactions !== 0 || !empty($child_account->children)) {
                $children[] = $child_account;
            }
        }
    
        // Set the total of child transactions for the parent account
        $account->child_transactions = $total_child_transactions;
    
        // If this account has its own transactions, we don't change the `transactions` key
        $account->transactions = $this->get_chart_transactions($account, $line_chart, $startDate, $endDate);
    
        return $children;
    }

    
    function get_chart_transactions($account, $line_chart, $startDate, $endDate) {
        // Sum of credits
        $credit_transactions = $this->db->table('sch_journal_entry_lines AS l')
            ->selectSum('l.amount', 'total_credits')
            ->join('sch_journal_entries AS e', 'l.journal_entry_id = e.id')
            ->where('l.chart_account_id', $account->id)
            ->where('e.transaction_status', 'normal')
            ->where("DATE(e.record_date) >=", $startDate)
            ->where("DATE(e.record_date) <=", $endDate)
            ->where('l.cr_dr', 'cr') // Filter for credits
            ->get()
            ->getRow();
    
        // Sum of debits
        $debit_transactions = $this->db->table('sch_journal_entry_lines AS l')
            ->selectSum('l.amount', 'total_debits')
            ->join('sch_journal_entries AS e', 'l.journal_entry_id = e.id')
            ->where('l.chart_account_id', $account->id)
            ->where('e.transaction_status', 'normal')
            ->where("DATE(e.record_date) >=", $startDate)
            ->where("DATE(e.record_date) <=", $endDate)
            ->where('l.cr_dr', 'dr') // Filter for debits
            ->get()
            ->getRow();
    
        // Initialize totals
        $total_credits = $credit_transactions ? $credit_transactions->total_credits : 0;
        $total_debits = $debit_transactions ? $debit_transactions->total_debits : 0;
    
        // Return balance (credits - debits)
        return in_array($line_chart, ['income', 'capital', 'liabilities'])? $total_credits - $total_debits: $total_debits - $total_credits;
    }

    function get_transaction_details($id, $startDate, $endDate) {
        $transactions = $this->db->table('sch_journal_entry_lines AS l')
            ->select('e.heading, e.record_date, e.reference_number, e.payment_method, l.amount, l.cr_dr')
            ->join('sch_journal_entries AS e', 'l.journal_entry_id = e.id')
            ->where('l.chart_account_id', $id)
            ->where('e.transaction_status', 'normal')
            ->where("DATE(e.record_date) >=", $startDate)
            ->where("DATE(e.record_date) <=", $endDate)
            ->orderBy('e.id', 'ASC')
            ->get()
            ->getResult();

        return $transactions ? $transactions: [];
    }
    
}