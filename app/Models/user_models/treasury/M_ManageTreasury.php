<?php

namespace App\Models\user_models\treasury;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;
use Config\Database;

class M_ManageTreasury extends Model
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


    public function listBankAccounts()
    {
        $bankAccs = $this->db->table('sch_bank_accounts')
                    ->select('*')
                    ->where('deleted', 0)
                    ->get()
                    ->getResult();

        foreach ($bankAccs as $key => $bankAcc) {
            $bankAcc->balance = $this->get_chart_balance($bankAcc->chart_id);
        }
        return $bankAccs ? $bankAccs : [];
    }

    public function listCashAccounts()
    {
        $accounts = $this->db->table('sch_cash_accounts')
                    ->select('*')
                    ->where('deleted', 0)
                    ->get()
                    ->getResult();

        foreach ($accounts as $key => $account) {
            $account->balance = $this->get_chart_balance($account->chart_id);
        }

        return $accounts ? $accounts : [];
    }

    public function listSafeAccounts()
    {
        $accounts = $this->db->table('sch_safe_accounts')
                    ->select('*')
                    ->where('deleted', 0)
                    ->get()
                    ->getResult();

        return $accounts ? $accounts : [];
    }

    public function listMMAccounts()
    {
        $accounts = $this->db->table('sch_mm_accounts')
                    ->select('*')
                    ->where('deleted', 0)
                    ->get()
                    ->getResult();

        return $accounts ? $accounts : [];
    }

    public function get_chart_of_account_by_code($account_code)
    {
        $account = $this->db->table('sch_coa')
                ->select('*')
                ->where('code', $account_code)
                ->orderBy('id', 'DESC')
                ->limit(1)
                ->get()
                ->getRowArray();
        return $account;
    }

    function get_chart_balance($chartId)  {
        $total_credits = 0;
        $total_debits = 0;
        $credits = $this->db->table('sch_journal_entry_lines AS sys')
                ->selectSum('sys.amount', 'total_credits')
                ->join('sch_coa AS coa', 'sys.chart_account_id = coa.id')
                ->join('sch_journal_entries AS jou', 'sys.journal_entry_id = jou.id')
                ->where('jou.transaction_status', 'normal')
                ->where('sys.chart_account_id', $chartId)
                ->where('sys.cr_dr', 'cr')
                // ->where('jou.record_date >=', $start_date)
                // ->where('jou.record_date <=', $end_date)
                ->get()
                ->getRow();
        if ($credits) {
            $total_credits = $credits->total_credits;
        }
        $debits = $this->db->table('sch_journal_entry_lines AS sys')
                ->selectSum('sys.amount', 'total_debits')
                ->join('sch_coa AS coa', 'sys.chart_account_id = coa.id')
                ->join('sch_journal_entries AS jou', 'sys.journal_entry_id = jou.id')
                ->where('jou.transaction_status', 'normal')
                ->where('sys.chart_account_id', $chartId)
                ->where('sys.cr_dr', 'dr')
                // ->where('jou.record_date >=', $start_date)
                // ->where('jou.record_date <=', $end_date)
                ->get()
                ->getRow();

        if ($debits) {
            $total_debits = $debits->total_debits;
        }

        $balance = $total_debits - $total_credits;
        return (object) ["bal_row" => round( $balance , 1), "bf" => 0, 'bal' => number_format(round($balance, 1))];
    }

    public function generate_chart_of_account_code($parent_id, $account_line)
    {
        $account_code = '';

        if ($parent_id > 0) {
            // Query for the last child based on parent_id
            $last_child = $this->db->table('sch_coa')
                ->select('*')
                ->where('parent', $parent_id)
                ->orderBy('id', 'DESC')
                ->limit(1)
                ->get()
                ->getRowArray();

            if ($last_child) {
                $temp_code = explode('-', $last_child['code']);
                if (count($temp_code) > 1) {
                    $account_code = (int) $temp_code[1] + 1;
                } else {
                    $account_code = (int) $temp_code[0] + 1;
                }
                $account_code = $this->change_code_octate($account_code);
            } else {
                // Query for the parent if no child found
                $parent = $this->db->table('sch_coa')
                    ->select('*')
                    ->where('id', $parent_id)
                    ->get()
                    ->getRowArray();
                
                if ($parent) {
                    $temp_code = explode('-', $parent['code']);
                    if (count($temp_code) > 1) {
                        $account_code = $temp_code[1] . '1';
                    } else {
                        $account_code = $temp_code[0] . '1';
                    }
                }
            }
        } else {
            // Query for the last child based on account_line and no parent_id
            $children = $this->db->table('sch_coa')
                ->select('*')
                ->where('chart_line', $account_line)
                ->where('parent', 0)
                ->orderBy('id', 'DESC')
                ->limit(1)
                ->get()
                ->getRowArray();

            if ($children) {
                $temp_code = explode('-', $children['code']);
                if (count($temp_code) > 1) {
                    $account_code = (int) $temp_code[1] + 1;
                } else {
                    $account_code = (int) $temp_code[0] + 1;
                }
                $account_code = $this->change_code_octate($account_code);
            } else {
                // If no children found, generate based on account_line
                $account_line_code = $this->get_account_line_code($account_line);
                $account_code = $account_line_code . '1';
            }
        }

        return $account_code;
    }

    private function change_code_octate($account_code)
    {
        //  logic to change code octate
        return str_pad($account_code, 4, '0', STR_PAD_LEFT);
    }

    private function get_account_line_code($account_line)
    {
        // logic to get account line code
        return substr($account_line, 0, 3);
    }

    public function save_chart_of_account_code($name, $account_line, $account_code, $parent, $allow_sub_account=0)
    {
        $code_id = 0;

        $data = [
            'name' => $name, 'code' => $account_code, 'parent' => $parent, 
            'chart_line' => $account_line, 'allow_sub_account' => $allow_sub_account,
            'added_by_id' => h_session('current_user_id')
        ];

        $this->db->table('sch_coa')->insert($data);
        $code_id = $this->db->insertID();

        return $code_id;
    }

    public function saveBankAccountData($data)
    {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';

        try {
                $parent = $this->get_chart_of_account_by_code('sys-11411');
                if ($parent) {
                    // Start a transaction
                    $this->db->transStart();

                    $account_code = $this->generate_chart_of_account_code($parent['id'], 'assets');
                    if ($account_code) {
                        $name = '001:UGX '. strtoupper($data['bank_name']);
                        $data['chart_id'] = $this->save_chart_of_account_code($name, 'assets', $account_code, $parent['id']);
                    }

                    $this->db->table('sch_bank_accounts')->insert($data);
                }
                // Complete the transaction
                $this->db->transComplete();
            
                // Check transaction status
                if ($this->db->transStatus() === false) {
                    // Log the error if transaction failed
                    $logger = \Config\Services::logger();
                    $logger->error('Failed to update');

                    $response['message'] = $e->getMessage();
                } 
                else {
                    // Log success message
                    $logger = \Config\Services::logger();
                    $logger->info('Successfully Saved');

                    $response['success'] = true;
                    $response['StatusCode'] = '00';
                }
            } catch (\Exception $e) {
                // Handle any exceptions and log the error
                $logger = \Config\Services::logger();
                $logger->error('Exception occurred: ' . $e->getMessage());
                
                $response['message'] = $e->getMessage();
            }

            return (object) $response;
    }

    public function generate_reference_no($line, $prefix = null)
    {
        // Get current date
        $now = new \DateTime();
        $year_month = $now->format('ym');

        // Get the base for the reference number
        if ($prefix === null) {
            $base = $this->get_account_line_keys($line) . '-' . $year_month . '-';
        } else {
            $base = $prefix . '-' . $year_month . '-';
        }

        $query = $this->db->table('sch_journal_entries')
            ->select('reference_number')
            ->like('reference_number', $base, 'after')  // Filter by reference_no starting with the base
            ->orderBy('id', 'DESC')
            ->limit(1)
            ->get();
        $last_reference = $query->getRow();

        // Set new reference number to 1 by default
        $new_ref = 1;
        if ($last_reference) {
            $last_ref_parts = explode('-', $last_reference->reference_number);  // Explode the reference number by '-'
            $new_ref = (int) $last_ref_parts[3] + 1;  // Increment the last part of the reference number
        }

        return $base . $this->pad_reference_number($new_ref);
    }

    public function pad_reference_number($number)
    {
        $number = (string) $number;

        // Calculate how many leading zeros are needed
        $leading_zeros = 5 - strlen($number);

        // If leading zeros are needed, prepend them to the number
        if ($leading_zeros > 0) {
            $number = str_repeat('0', $leading_zeros) . $number;
        }

        return $number;
    }


    public function get_account_line_keys($account_line)
    {
        $keys = [
            'assets' => 'Ast-Ref',
            'liabilities' => 'Lbt-Ref',
            'capital' => 'Cpt-Ref',
            'income' => 'Inc-Ref',
            'expenses' => 'Exp-Ref'
        ];

        return isset($keys[$account_line]) ? $keys[$account_line] : '';
    }

    
    public function saveCashAccountData($data)
    {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';

        try {
                $parent = $this->get_chart_of_account_by_code('sys-11412');
                if ($parent) {
                    // Start a transaction
                    $this->db->transStart();

                    $account_code = $this->generate_chart_of_account_code($parent['id'], 'assets');
                    if ($account_code) {
                        $name = '001:UGX '. strtoupper($data['account_name']);
                        $data['chart_id'] = $this->save_chart_of_account_code($name, 'assets', $account_code, $parent['id']);
                    }

                    $this->db->table('sch_cash_accounts')->insert($data);
                }
                // Complete the transaction
                $this->db->transComplete();
            
                // Check transaction status
                if ($this->db->transStatus() === false) {
                    // Log the error if transaction failed
                    $logger = \Config\Services::logger();
                    $logger->error('Failed to update');

                    $response['message'] = $e->getMessage();
                } 
                else {
                    // Log success message
                    $logger = \Config\Services::logger();
                    $logger->info('Successfully Saved');

                    $response['success'] = true;
                    $response['StatusCode'] = '00';
                }
            } catch (\Exception $e) {
                // Handle any exceptions and log the error
                $logger = \Config\Services::logger();
                $logger->error('Exception occurred: ' . $e->getMessage());
                
                $response['message'] = $e->getMessage();
            }

            return (object) $response;
    }
    
    public function saveSafeAccountData($data)
    {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';

        try {
                $parent = $this->get_chart_of_account_by_code('sys-11412');
                if ($parent) {
                    // Start a transaction
                    $this->db->transStart();

                    $account_code = $this->generate_chart_of_account_code($parent['id'], 'assets');
                    if ($account_code) {
                        $name = '001:UGX '. strtoupper($data['safe_name']);
                        $data['chart_id'] = $this->save_chart_of_account_code($name, 'assets', $account_code, $parent['id']);
                    }

                    $this->db->table('sch_safe_accounts')->insert($data);
                }
                // Complete the transaction
                $this->db->transComplete();
            
                // Check transaction status
                if ($this->db->transStatus() === false) {
                    // Log the error if transaction failed
                    $logger = \Config\Services::logger();
                    $logger->error('Failed to update');

                    $response['message'] = $e->getMessage();
                } 
                else {
                    // Log success message
                    $logger = \Config\Services::logger();
                    $logger->info('Successfully Saved');

                    $response['success'] = true;
                    $response['StatusCode'] = '00';
                }
            } catch (\Exception $e) {
                // Handle any exceptions and log the error
                $logger = \Config\Services::logger();
                $logger->error('Exception occurred: ' . $e->getMessage());
                
                $response['message'] = $e->getMessage();
            }

            return (object) $response;
    }

    public function saveMMAccountData($data)
    {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';

        try {
                $parent = $this->get_chart_of_account_by_code('sys-11414');
                if ($parent) {
                    // Start a transaction
                    $this->db->transStart();

                    $account_code = $this->generate_chart_of_account_code($parent['id'], 'assets');
                    if ($account_code) {
                        $name = '001:UGX '. strtoupper($data['mm_number']);
                        $data['chart_id'] = $this->save_chart_of_account_code($name, 'assets', $account_code, $parent['id']);
                    }

                    $this->db->table('sch_mm_accounts')->insert($data);
                }
                // Complete the transaction
                $this->db->transComplete();
            
                // Check transaction status
                if ($this->db->transStatus() === false) {
                    // Log the error if transaction failed
                    $logger = \Config\Services::logger();
                    $logger->error('Failed to update');

                    $response['message'] = $e->getMessage();
                } 
                else {
                    // Log success message
                    $logger = \Config\Services::logger();
                    $logger->info('Successfully Saved');

                    $response['success'] = true;
                    $response['StatusCode'] = '00';
                }
            } catch (\Exception $e) {
                // Handle any exceptions and log the error
                $logger = \Config\Services::logger();
                $logger->error('Exception occurred: ' . $e->getMessage());
                
                $response['message'] = $e->getMessage();
            }

            return (object) $response;
    }

    public function listAccountTypes()
    {
        $accounts = $this->db->table('sch_account_type')
                    ->select('*')
                    ->where('deleted', 0)
                    ->get()
                    ->getResult();

        return $accounts ? $accounts : [];
    }

    
    public function saveAccountTypeData($data)
    {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';

        try {
                // Start a transaction
                $this->db->transStart();

                $this->db->table('sch_account_type')->insert($data);

                // Complete the transaction
                $this->db->transComplete();
            
                // Check transaction status
                if ($this->db->transStatus() === false) {
                    // Log the error if transaction failed
                    $logger = \Config\Services::logger();
                    $logger->error('Failed to update');

                    $response['message'] = $e->getMessage();
                } 
                else {
                    // Log success message
                    $logger = \Config\Services::logger();
                    $logger->info('Successfully Saved');

                    $response['success'] = true;
                    $response['StatusCode'] = '00';
                }
            } catch (\Exception $e) {
                // Handle any exceptions and log the error
                $logger = \Config\Services::logger();
                $logger->error('Exception occurred: ' . $e->getMessage());
                
                $response['message'] = $e->getMessage();
            }

            return (object) $response;
    }

}