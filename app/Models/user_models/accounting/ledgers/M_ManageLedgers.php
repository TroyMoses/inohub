<?php

namespace App\Models\user_models\accounting\ledgers;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;
use Config\Database;

class M_ManageLedgers extends Model
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

   
    public function listRegisteredCOA()
    {
        $coa = $this->db->table('sch_coa')
            ->select('*')
            ->where('parent', 0)
            ->where('deleted', 0)
            ->get()
            ->getResult();

        $coas = $coa ? $coa : [];

        // create charts if not existing
        if (empty($coas)) {
            $this->populate_school_coa();
        }

        $chart_lines = ['assets', 'liabilities', 'capital', 'income', 'expenses'];
        $all_chart_line_charts = [];

        foreach ($chart_lines as $chart_line) {
            $all_coas = [];

            $coas = $this->db->table('sch_coa')
                ->select('*')
                ->where('parent', 0)
                ->where('deleted', 0)
                ->where('chart_line', $chart_line)
                ->get()
                ->getResult();
                
            if ($coas) {
                foreach ($coas as $root) {
                    $all_coas[] = [
                        'id' => $root->id,
                        'name' => $root->name, 
                        'code' => $root->code,
                        'chart_line' => $root->chart_line,
                        'children' => $this->getChildren($root->id) // Get child nodes
                    ];
                }
            }
            
            $all_chart_line_charts[$chart_line] = $all_coas;
        }
        
        return (object) $all_chart_line_charts;
    }

    public function populate_school_coa()
    {
        //order is name/label, code, parent (if 0 it has no parent, if not 0 then replace with parent code)
       $data = [
        'assets' => [
            ['Current Assets', 'sys-11', 0],
            ['Receivables', 'sys-113', 'sys-11'],
            ['Receivable Sms Payments From Branches', 'sys-1131', 'sys-113'],
            ['School Fees Receivable', 'sys-1132', 'sys-113'],
            ['Inventory/Stock Receivable', 'sys-1133', 'sys-113'],
            ['Liquid Assets', 'sys-114', 'sys-11'],
            ['Cash, Mobile Money & Bank Accounts', 'sys-1141', 'sys-114'],
            ['Bank Accounts', 'sys-11411', 'sys-1141'],
            ['Cash Accounts', 'sys-11412', 'sys-1141'],
            ['Teller Accounts', 'sys-11413', 'sys-1141'],
            ['Mobile Money Accounts', 'sys-11414', 'sys-1141'],
            ['System E - Wallets', 'sys-11418', 'sys-1141'],
            ['Inventory', 'sys-115', 'sys-11'],
            ['Automated Inventory', 'sys-118', 'sys-11'],
            ['Non Current Assets', 'sys-12', 0],
            ['Fixed Assets', 'sys-121', 'sys-12'],
            ['Land', 'sys-1211', 'sys-121'],
            ['Other Assets', 'sys-122', 'sys-12'],
            ['Investments', 'sys-123', 'sys-12'],
        ],
        'liabilities' => [
            ['Current Liabilities', 'sys-21', 0],
            ['Accounts  Payable', 'sys-212', 'sys-21'],
            ['Payable Sms', 'sys-2121', 'sys-212'],
            ['Inventory/Stock Payable', 'sys-2123', 'sys-212'],
            ['Schoolfees & Deposits', 'sys-211', 'sys-21'],
            ['Withholding Tax Payable', 'sys-217', 'sys-21'],
            ['Withholding Tax Payable 6%', 'sys-2171', 'sys-217'],
            ['Withholding Tax Payable 15%', 'sys-2172', 'sys-217'],
            ['Non Current Liabilities', 'sys-22', 0],
        ],
        'capital' => [
            ['Member Share Capital', 'sys-31', 0],
            ['Member Shares', 'sys-311', 'sys-31'],
            ['Inter Branch Share Transfer Account', 'sys-312', 'sys-31'],
            ['Institutional Capital', 'sys-32', 0],
            ['Reserves', 'sys-321', 'sys-32'],
            ['Statutory Legal Reserves', 'sys-3211', 'sys-321'],
            ['Donations And Grant', 'sys-322', 'sys-32'],
            ['Retained Earnings/Capital Reserves', 'sys-323', 'sys-32'],
            ['Current Period Earnings', 'sys-33', 0]
        ],
        'income' => [
            ['Interest Income', 'sys-41', 0],
            ['Income On Liquid Investments', 'sys-412', 'sys-41'],
            ['Income On Financial Investments', 'sys-413', 'sys-41'],
            ['Other Interest Income', 'sys-414', 'sys-41'],
            ['Non Interest Income', 'sys-42', 0],
            ['Income From school fees payments & Deposits', 'sys-421', 'sys-42'],
            ['Income From Sms Charges', 'sys-422', 'sys-42'],
            ['Income From Sale On Fixed Assets', 'sys-424', 'sys-42'],
            ['Other Non-Interest Income', 'sys-425', 'sys-42'],
            ['Gain On Asset Disposal', 'sys-4251', 'sys-425'],
            ['Income From Sale Of Inventory', 'sys-4252', 'sys-425'],
            ['Income From Bad Debts Recovered', 'sys-426', 'sys-42'],
            ['Income From Account Management', 'sys-427', 'sys-42'],
            ['Non-Financial Investment Income', 'sys-428', 'sys-42'],
            ['Income Receivables', 'sys-429', 'sys-42'],
            ['Registered Receivables', 'sys-4291', 'sys-429'],
            ['School Fees Receivables', 'sys-4292', 'sys-429'],
        ],
        'expenses' => [
            ['Financial Costs', 'sys-51', 0],
            ['Finance Costs Bank Charges', 'sys-515', 'sys-51'],
            ['Bank Transfer Charges', 'sys-5151', 'sys-515'],
            ['Loss From Sale Of Inventory', 'sys-518', 'sys-51'],
            ['Non-Financial Costs', 'sys-52', 0],
            ['Costs Of Non-Financial Investments', 'sys-521', 'sys-52'],
            ['Operating Expenses', 'sys-53', 0],
            ['Personnal Expenses', 'sys-531', 'sys-53'],
            ['Governance Expenses', 'sys-532', 'sys-53'],
            ['Marketing & Sales Expenses', 'sys-533', 'sys-53'],
            ['Depreciation And Amortization', 'sys-534', 'sys-53'],
            ['Asset Depreciation', 'sys-5341', 'sys-534'],
            ['Amortization', 'sys-5342', 'sys-534'],
            ['Administrative Expenses', 'sys-535', 'sys-53'],
            ['Sms Purchase Costs', 'sys-536', 'sys-53'],
            ['Loss On Asset Disposal', 'sys-537', 'sys-53'],
            ['Provision Expenses For Risk Assets', 'sys-54', 0]
        ]];

        $assets = $data['assets'];
        $liabilities = $data['liabilities'];
        $capital = $data['capital'];
        $income = $data['income'];
        $expenses = $data['expenses'];

        // assests
        foreach ($assets as $asset) {
            $parent = 0;
            if ($asset[2] != 0) {
                $coa = $this->db->table('sch_coa')
                        ->select('id')
                        ->where('deleted', 0)
                        ->where('code', $asset[2])
                        ->get()
                        ->getRow();
                
                if ( $coa ) {
                    $parent = $coa->id;
                }
            }
            $save_obj = ['name' => $asset[0], 'code' => $asset[1], 'parent' => $parent, 'chart_line' => 'assets', 'added_by_id' => h_session('current_user_id') ];
            // Begin transaction
            $this->db->transBegin();
            try {
                $this->db->table('sch_coa')->insert($save_obj);
                // Commit transaction
                $this->db->transCommit();
                } catch (\Exception $e) {
                    // Rollback transaction on error
                $this->db->transRollback();
            }
        }

        // liabilities
        foreach ($liabilities as $asset) {
            $parent = 0;
            if ($asset[2] != 0) {
                $coa = $this->db->table('sch_coa')
                        ->select('id')
                        ->where('deleted', 0)
                        ->where('code', $asset[2])
                        ->get()
                        ->getRow();
                
                if ( $coa ) {
                    $parent = $coa->id;
                }
            }
            $save_obj = ['name' => $asset[0], 'code' => $asset[1], 'parent' => $parent, 'chart_line' => 'liabilities', 'added_by_id' => h_session('current_user_id') ];
            // Begin transaction
            $this->db->transBegin();
            try {
                $this->db->table('sch_coa')->insert($save_obj);
                // Commit transaction
                $this->db->transCommit();
                } catch (\Exception $e) {
                    // Rollback transaction on error
                $this->db->transRollback();
            }
        }

        // capital
        foreach ($capital as $asset) {
            $parent = 0;
            if ($asset[2] != 0) {
                $coa = $this->db->table('sch_coa')
                        ->select('id')
                        ->where('deleted', 0)
                        ->where('code', $asset[2])
                        ->get()
                        ->getRow();
                
                if ( $coa ) {
                    $parent = $coa->id;
                }
            }
            $save_obj = ['name' => $asset[0], 'code' => $asset[1], 'parent' => $parent, 'chart_line' => 'capital', 'added_by_id' => h_session('current_user_id') ];
            // Begin transaction
            $this->db->transBegin();
            try {
                $this->db->table('sch_coa')->insert($save_obj);
                // Commit transaction
                $this->db->transCommit();
                } catch (\Exception $e) {
                    // Rollback transaction on error
                $this->db->transRollback();
            }
        }


        // income
        foreach ($income as $asset) {
            $parent = 0;
            if ($asset[2] != 0) {
                $coa = $this->db->table('sch_coa')
                        ->select('id')
                        ->where('deleted', 0)
                        ->where('code', $asset[2])
                        ->get()
                        ->getRow();
                
                if ( $coa ) {
                    $parent = $coa->id;
                }
            }
            $save_obj = ['name' => $asset[0], 'code' => $asset[1], 'parent' => $parent, 'chart_line' => 'income', 'added_by_id' => h_session('current_user_id') ];
            // Begin transaction
            $this->db->transBegin();
            try {
                $this->db->table('sch_coa')->insert($save_obj);
                // Commit transaction
                $this->db->transCommit();
                } catch (\Exception $e) {
                    // Rollback transaction on error
                $this->db->transRollback();
            }
        }


        // expenses
        foreach ($expenses as $asset) {
            $parent = 0;
            if ($asset[2] != 0) {
                $coa = $this->db->table('sch_coa')
                        ->select('id')
                        ->where('deleted', 0)
                        ->where('code', $asset[2])
                        ->get()
                        ->getRow();
                
                if ( $coa ) {
                    $parent = $coa->id;
                }
            }
            $save_obj = ['name' => $asset[0], 'code' => $asset[1], 'parent' => $parent, 'chart_line' => 'expenses', 'added_by_id' => h_session('current_user_id') ];
            // Begin transaction
            $this->db->transBegin();
            try {
                $this->db->table('sch_coa')->insert($save_obj);
                // Commit transaction
                $this->db->transCommit();
                } catch (\Exception $e) {
                    // Rollback transaction on error
                $this->db->transRollback();
            }
        }

        return true;
    }
    

    function getChildren($parentId) {
        $children = $this->db->table('sch_coa')
            ->select('*')
            ->where('parent', $parentId)
            ->where('deleted', 0)
            ->get()
            ->getResult();
        
        $tree = [];
        foreach ($children as $child) {
            $tree[] = [
                'id' => $child->id,
                'name' => $child->name,
                'code' => $child->code,
                'chart_line' => $child->chart_line,
                'children' => $this->getChildren($child->id) // Recursive call
            ];
        }
    
        return $tree;
    }

    public function listLedgerIncomes()
    {
        // $bankAccs = $this->db->table('sch_bank_accounts')
        //             ->select('*')
        //             ->where('deleted', 0)
        //             ->get()
        //             ->getResult();

        return [];
    }

    public function schoolChartOfAccounts($chart_line)
    {
        $response = [];
        $response['success'] = true;
        $response['StatusCode'] = '00';

        $chart_line = $chart_line ? explode(',', $chart_line) : [];

        if (empty($chart_line)) {
                // Query to find records without children
                $accounts =  $this->db->table('sch_coa')
                    ->select('*')
                    ->whereNotIn('id', function($query) {
                        $query->select('parent')
                            ->from('sch_coa');
                    })
                    ->get()
                    ->getResult();
        }
        else{
            $accounts =  $this->db->table('sch_coa')
                    ->select('*')
                    ->whereIn('chart_line', $chart_line)
                    ->whereNotIn('id', function($query) {
                        $query->select('parent')
                            ->from('sch_coa');
                    })
                    ->get()
                    ->getResult();
        }

        $response['data'] = $accounts;
        return  (object) $response;
    }


    public function schoolPaymentAccounts($payment_method)
    {
        $response = [];
        $response['success'] = true;
        $response['StatusCode'] = '00';
        $accounts = [];

        if ($payment_method == 'cash') {
            $accounts = $this->db->table('sch_cash_accounts as csh')
                ->select('csh.id as id, csh.account_name as name, coa.code as code, csh.currency as currency, csh.chart_id as chart_id')
                ->join('sch_coa AS coa', 'csh.chart_id = coa.id')
                ->where('csh.deleted', 0)
                ->where('csh.user_id', h_session('current_user_id'))
                ->get()
                ->getResult();
        }

        if ($payment_method == 'bank') {
            $accounts = $this->db->table('sch_bank_accounts AS bnk')
                ->select('bnk.id as id, bnk.bank_name as name, coa.code as code, bnk.currency as currency, bnk.chart_id as chart_id')
                ->join('sch_coa AS coa', 'bnk.chart_id = coa.id')
                ->where('bnk.deleted', 0)
                ->get()
                ->getResult();
        }

        $response['data'] = $accounts;
        return  (object) $response;
    }

    public function submitLedgerTransaction($data)
    {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';

        try {
                // Start a transaction
                $this->db->transStart();
                $journal_entry = ['heading' => $data['heading'], 'payment_method' => $data['payment_method'],
                'reference_number' => $data['reference_number'], 'record_date' => $data['record_date'], 'added_by_id' => $data['added_by'],
                'branch_id' => $data['branch_id'], 'voucher_number' => $data['voucher_number'] ];
                $this->db->table('sch_journal_entries')->insert($journal_entry);
                
                $journalID = $this->db->insertID();

                // Complete the transaction
                $this->db->transComplete();
            
                // Check transaction status
                if ($this->db->transStatus() === true) {
                    // Log success message
                    $logger = \Config\Services::logger();
                    $logger->info('Successfully Saved');

                    $response['success'] = true;
                    $response['StatusCode'] = '00';

                    if ($journalID) {
                        $journal_entries1 = ['journal_entry_id' => $journalID, 'chart_account_id' => $data['credit_chart_id'], 'amount' => $data['amount'], 'cr_dr' => 'cr' ];
                        $this->db->table('sch_journal_entry_lines')->insert($journal_entries1);

                        $journal_entries2 = ['journal_entry_id' => $journalID, 'chart_account_id' => $data['debit_chart_id'], 'amount' => $data['amount'], 'cr_dr' => 'dr' ];
                        $this->db->table('sch_journal_entry_lines')->insert($journal_entries2);
                    }
                }
            } catch (\Exception $e) {
                // Handle any exceptions and log the error
                $logger = \Config\Services::logger();
                $logger->error('Exception occurred: ' . $e->getMessage());
                
                $response['message'] = $e->getMessage();
            }

        return (object) $response;
    }

    public function schoolListChartLineTransactions($chart_line, $start_date, $end_date)
    {
        $response = [];
        $response['success'] = true;
        $response['StatusCode'] = '00';
        $account_transactions = [];

        $chart_of_accounts = $this->schoolChartOfAccounts($chart_line);

        // Get all chart_ids in an array
        $chart_ids = array_map(function($value) {
            return $value->id;
        }, $chart_of_accounts->data);

        if ($chart_line == 'expenses') {
            $account_transactions = $this->db->table('sch_journal_entry_lines AS sys')
                ->select('sys.*, coa.name, coa.code, jou.*')
                ->join('sch_coa AS coa', 'sys.chart_account_id = coa.id')
                ->join('sch_journal_entries AS jou', 'sys.journal_entry_id = jou.id')
                ->where('sys.cr_dr', 'dr')
                ->where('jou.transaction_status', 'normal')
                ->whereIn('sys.chart_account_id', $chart_ids)
                // ->where('jou.record_date >=', $start_date)
                // ->where('jou.record_date <=', $end_date)
                ->get()
                ->getResult();

            $grouped = [];
            foreach ($account_transactions as $transaction) {
                $chartId = $transaction->chart_account_id;
            
                if (!isset($grouped[$chartId])) {
                    $grouped[$chartId] = [
                        'account'       => [
                            'id'   => $chartId,
                            'name' => $transaction->name,
                            'code' => $transaction->code
                        ],
                        'transactions'  => [],
                        'total_debit'  => 0,
                        'record_count'  => 0
                    ];
                }
            
                $grouped[$chartId]['transactions'][] = $transaction;
                $grouped[$chartId]['total_debit'] += $transaction->amount;
                $grouped[$chartId]['record_count']++;
            }

            $response = $grouped;
            
        }else {
            $account_transactions = $this->db->table('sch_journal_entry_lines AS sys')
                ->select('sys.*, coa.name, coa.code, jou.*')
                ->join('sch_coa AS coa', 'sys.chart_account_id = coa.id')
                ->join('sch_journal_entries AS jou', 'sys.journal_entry_id = jou.id')
                ->where('sys.cr_dr', 'cr')
                ->where('jou.transaction_status', 'normal')
                ->whereIn('sys.chart_account_id', $chart_ids)
                // ->where('jou.record_date >=', $start_date)
                // ->where('jou.record_date <=', $end_date)
                ->get()
                ->getResult();

            $grouped = [];
            foreach ($account_transactions as $transaction) {
                $chartId = $transaction->chart_account_id;
            
                if (!isset($grouped[$chartId])) {
                    $grouped[$chartId] = [
                        'account'       => [
                            'id'   => $chartId,
                            'name' => $transaction->name,
                            'code' => $transaction->code
                        ],
                        'transactions'  => [],
                        'total_credit'  => 0,
                        'record_count'  => 0
                    ];
                }
            
                $grouped[$chartId]['transactions'][] = $transaction;
                $grouped[$chartId]['total_credit'] += $transaction->amount;
                $grouped[$chartId]['record_count']++;
            }

            $response = $grouped;
        }
        
        return $response;
    }

    public function schoolListAccountTransactions($start_date, $end_date)
    {
        $response = [];
        $response['success'] = true;
        $response['StatusCode'] = '00';
        $account_transactions = [];

        $chart_line = 'assets,expenses,income,liabilities,capital';
        $chart_of_accounts = $this->schoolChartOfAccounts($chart_line);

        // Get all chart_ids in an array
        $chart_ids = array_map(function($value) {
            return $value->id;
        }, $chart_of_accounts->data);

        $account_transactions = $this->db->table('sch_journal_entry_lines AS sys')
                ->select('sys.*, coa.name, coa.code, jou.*')
                ->join('sch_coa AS coa', 'sys.chart_account_id = coa.id')
                ->join('sch_journal_entries AS jou', 'sys.journal_entry_id = jou.id')
                ->where('jou.transaction_status', 'normal')
                ->whereIn('sys.chart_account_id', $chart_ids)
                // ->where('jou.record_date >=', $start_date)
                // ->where('jou.record_date <=', $end_date)
                ->get()
                ->getResult();

            $grouped = [];
            foreach ($account_transactions as $transaction) {
                $chartId = $transaction->chart_account_id;
            
                if (!isset($grouped[$chartId])) {
                    $grouped[$chartId] = [
                        'account'       => [
                            'id'   => $chartId,
                            'name' => $transaction->name,
                            'code' => $transaction->code
                        ],
                        'transactions'  => [],
                        'total_credit'  => 0,
                        'total_debit'  => 0,
                        'record_count'  => 0
                    ];
                }
            
                $grouped[$chartId]['transactions'][] = $transaction;
                $grouped[$chartId]['total_credit'] += $transaction->cr_dr == 'cr'? $transaction->amount:0;
                $grouped[$chartId]['total_debit'] += $transaction->cr_dr == 'dr' ? $transaction->amount: 0;
                $grouped[$chartId]['record_count']++;
            }
        
        return  $grouped;
    }
}