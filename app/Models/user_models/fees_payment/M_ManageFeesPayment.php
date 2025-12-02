<?php

namespace App\Models\user_models\fees_payment;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;
use Config\Database;
use App\Models\user_models\treasury\M_ManageTreasury;

class M_ManageFeesPayment extends Model
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
            } else {
                $db = Database::connect();
            }
        }
        $this->db = $db;
    }

    public function saveEpaymentData($data)
    {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';

        try {
            // Start a transaction
            $this->db->transStart();
            $this->db->table('sch_e_payments')->insert($data);
            // Complete the transaction
            $this->db->transComplete();

            // Check transaction status
            if ($this->db->transStatus() === false) {
                // Log the error if transaction failed
                $logger = \Config\Services::logger();
                $logger->error('Failed to update');

                $response['message'] = $e->getMessage();
            } else {
                // Log success message
                $logger = \Config\Services::logger();
                $logger->info('Successfully Saved');

                $response['success'] = true;
                $response['StatusCode'] = '00';
            }
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }

        return (object) $response;
    }

    public function listFeesTypes()
    {
        $feesTypes = $this->db->table('sch_fees_types as type')
            ->select('type.*, coa.name as chart_name, coa.code')
            ->where('type.deleted', 0)
            ->join('sch_coa AS coa', 'coa.id = type.chart_id', 'left')
            ->get()
            ->getResult();

        return $feesTypes ? $feesTypes : [];
    }

    function saveFeesTypes($data)
    {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';

        try {
            // Start a transaction
            $this->db->transStart();
            $this->db->table('sch_fees_types')->insert($data);
            // Complete the transaction
            $this->db->transComplete();

            // Check transaction status
            if ($this->db->transStatus() === false) {
                // Log the error if transaction failed
                $logger = \Config\Services::logger();
                $logger->error('Failed to update');

                $response['message'] = $e->getMessage();
            } else {
                // Log success message
                $logger = \Config\Services::logger();
                $logger->info('Successfully Saved');

                $response['success'] = true;
                $response['StatusCode'] = '00';
            }
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }

        return (object) $response;
    }

    function saveFeesStructure($data)
    {
        $response = [];
        $response['success'] = true;
        $response['StatusCode'] = '00';

        $fees_type_id = $data['fees_type_id'];
        $term_id = $data['term_id'];
        $fees = $data['fees'];
        foreach ($fees as $key => $fee) {
            $classId = $fee['classId'];
            $amount = $fee['amount'];
            $feesStructure = $this->db->table('sch_fees_structure')
                ->select('*')
                ->where('class_id', $classId)
                ->where('fees_type_id', $fees_type_id)
                ->where('term_id', $term_id)
                ->where('deleted', '0')
                ->get()
                ->getResult();
            if (empty($feesStructure)) {
                $saveData = ['amount' => $amount, 'fees_type_id' => $fees_type_id, 'class_id' => $classId, 'term_id' => $term_id, 'added_by_id' => h_session('current_user_id')];

                try {
                    // Start a transaction
                    $this->db->transStart();
                    $this->db->table('sch_fees_structure')->insert($saveData);
                    // Complete the transaction
                    $this->db->transComplete();

                    // Check transaction status
                    if ($this->db->transStatus() === false) {
                        // Log the error if transaction failed
                        $logger = \Config\Services::logger();
                        $logger->error('Failed to update');

                        $response['message'] = $e->getMessage();
                    }
                } catch (\Exception $e) {
                    $response['message'] = $e->getMessage();
                }
            }
        }

        return (object) $response;
    }

    function listFeesStructures($termId, $classId = 0, $student = '')
    {
        if ($classId > 0) {
            $feesStructure = $this->db->table('sch_fees_structure fees_structure')
                ->select('fees_structure.term_id,fees_structure.id, fees_structure.amount, fees_structure.status, fees_type.name as fees_type_name, class.name as class_name, class.short_name as class_short_name,fees_structure.class_id, fees_structure.fees_type_id, fees_type.type_key')
                ->where('fees_structure.term_id', $termId)
                ->where('fees_structure.class_id', $classId)
                ->where('fees_structure.deleted', '0')
                ->join('sch_fees_types AS fees_type', 'fees_type.id = fees_structure.fees_type_id')
                ->join('sch_classes AS class', 'class.id = fees_structure.class_id')
                ->get()
                ->getResult();
        } else {
            $feesStructure = $this->db->table('sch_fees_structure fees_structure')
                ->select('fees_structure.term_id, fees_structure.id, fees_structure.amount, fees_structure.status, fees_type.name as fees_type_name, class.name as class_name, class.short_name as class_short_name,fees_structure.class_id, fees_structure.fees_type_id, fees_type.type_key')
                ->where('fees_structure.term_id', $termId)
                ->where('fees_structure.deleted', '0')
                ->join('sch_fees_types AS fees_type', 'fees_type.id = fees_structure.fees_type_id')
                ->join('sch_classes AS class', 'class.id = fees_structure.class_id')
                ->get()
                ->getResult();
        }

        $formattedResult = [];
        // Process the result
        foreach ($feesStructure as $fee) {
            $total_payments = 0;
            // if student 
            if ($student && $student->admission) {
                if ($fee->type_key == 'admission_fee') {
                    $studentClass = $this->db->table('sch_stream_students')
                        ->select('*')
                        ->where('term_id', $termId)
                        ->where('student_id', $student->admission->id)
                        ->where('status', 'active')
                        ->where('deleted', '0')
                        ->get()
                        ->getRow();

                    if ($studentClass && $studentClass->is_new_student == '1') {
                        continue;
                    }
                }

                if ($fee->type_key == 'boarding_fee') {
                    $studentClass = $this->db->table('sch_people_accomodation')
                        ->select('*')
                        ->where('term_id', $termId)
                        ->where('people_id', $student->id)
                        ->get()
                        ->getRow();

                    if (!$studentClass) {
                        continue;
                    }
                }
                $payments = $this->db->table('sch_fees_types_payments pay')
                    ->selectSum('pay.amount', 'total_amount')
                    ->where('payment.term_id', $termId)
                    ->where('payment.people_id', $student->id)
                    ->where('payment.transaction_status', 'normal')
                    ->where('pay.fees_structure_id', $fee->id)
                    ->join("sch_fees_payment as payment", 'payment.id = pay.fees_payment_id')
                    ->get()
                    ->getRow();

                $total_payments = $payments->total_amount ?? 0;
            }

            $balance = $fee->amount - $total_payments;
            $balance = $balance > 0 ? $balance : 0;
            $feesTypeIndex = array_search($fee->fees_type_name, array_column($formattedResult, 'fees_type_name'));
            if ($feesTypeIndex === false) {
                // If not, create a new entry for this fees_type_name
                $formattedResult[] = [
                    'id' => $fee->id,
                    'fees_type_id' => $fee->fees_type_id,
                    'fees_type_name' => $fee->fees_type_name,
                    'status' => $fee->status,
                    'term_id' => $fee->term_id,
                    'classes' => [
                        [
                            'id' => $fee->class_id,
                            'class_name' => $fee->class_name,
                            'short_name' => $fee->class_short_name,
                            'amount' => $fee->amount,
                            'balance' => $balance
                        ]
                    ]
                ];
            } else {
                // If it exists, add the class and amount under the existing fees_type_name
                $formattedResult[$feesTypeIndex]['classes'][] = [
                    'id' => $fee->class_id,
                    'class_name' => $fee->class_name,
                    'short_name' => $fee->class_short_name,
                    'amount' => $fee->amount,
                    'balance' => $balance
                ];
            }
        }

        return $formattedResult;
    }

    function deleteFeesStructure($ID, $term_id)
    {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';

        try {
            $updateData = ['deleted' => '1'];
            // Start a transaction
            $this->db->transStart();

            $this->db->table('sch_fees_structure')
                ->where('fees_type_id', $ID)
                ->where('term_id', $term_id)
                ->update($updateData);

            // Complete the transaction
            $this->db->transComplete();

            // Check transaction status
            if ($this->db->transStatus() === false) {
                // Log the error if transaction failed
                $response['message'] = $e->getMessage();
            } else {
                $response['success'] = true;
                $response['StatusCode'] = '00';
            }
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }

        return (object) $response;
    }

    function updateFeesStructure($data)
    {
        $response = [];
        $response['success'] = true;
        $response['StatusCode'] = '00';

        try {
            $feesTypeId = $data['fees_type_id'];
            $fees = $data['fees'];
            $termId = $data['term_id'];

            foreach ($fees as $key => $fee) {
                $classId = $fee['classId'];
                $amount = $fee['amount'];

                $feesStructure = $this->db->table('sch_fees_structure')
                    ->select('*')
                    ->where('class_id', $classId)
                    ->where('fees_type_id', $feesTypeId)
                    ->where('term_id', $termId)
                    ->get()
                    ->getResult();

                if ($feesStructure) {
                    $updateData = ['amount' => $amount];
                    // Start a transaction
                    $this->db->transStart();

                    $this->db->table('sch_fees_structure')
                        ->where('fees_type_id', $feesTypeId)
                        ->where('term_id', $termId)
                        ->where('class_id', $classId)
                        ->update($updateData);

                    // Complete the transaction
                    $this->db->transComplete();
                } else {
                    if (intval($amount) > 0) {
                        $saveData = ['amount' => $amount, 'fees_type_id' => $feesTypeId, 'class_id' => $classId, 'term_id' => $termId, 'added_by_id' => h_session('current_user_id')];
                        $this->db->transStart();
                        $this->db->table('sch_fees_structure')->insert($saveData);
                        // Complete the transaction
                        $this->db->transComplete();
                    }
                }
            }
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }

        return (object) $response;
    }

    function studentFeesPaymentsLedger($peopleID, $termId)
    {
        $fees = $this->db->table('sch_fees_payment fees')
                    ->select('system.*, fees.source, fees.id as fee_id')
                    ->where('fees.transaction_status', 'normal')
                    ->where('fees.people_id', $peopleID)
                    ->where('fees.term_id', $termId)
                    ->where('fees.deleted', '0')
                    ->join('sch_journal_entries AS system', 'system.id = fees.journal_entry_id')
                    ->orderBy('system.record_date', 'DESC')
                    ->get()
                    ->getResult();
                    
        foreach ($fees as $key => $fee) {
            $studentFee = $this->db->table('sch_journal_entry_lines')
                ->select('*')
                ->where('journal_entry_id', $fee->id)
                ->get()
                ->getRow();

            $fee->amount = $studentFee ? $studentFee->amount : 0;
        }
        return $fees?  $fees : [];
    }

    function saveFeesPayment($data)
    {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';

        $treasury = new M_ManageTreasury();
        $credit = $treasury->get_chart_of_account_by_code('sys-421');
        $debit_chart_id = 0;
        if ($data['payment_method'] == 'cash') {
            $cash_account = $this->db->table('sch_cash_accounts')
                ->select('*')
                ->where('id', $data['payment_method_account'])
                ->get()
                ->getRow();
            if ($cash_account) {
                $debit_chart_id = $cash_account->chart_id;
            }
        }

        if ($data['payment_method'] == 'bank') {
            $bank_account = $this->db->table('sch_bank_accounts')
                ->select('*')
                ->where('id', $data['payment_method_account'])
                ->get()
                ->getRow();
            if ($bank_account) {
                $debit_chart_id = $bank_account->chart_id;
            }
        }

        try {
            // Start a transaction
            $this->db->transStart();
            $reference_number = $treasury->generate_reference_no('income');
            $journal_entry = [
                'heading' => $data['description'],
                'payment_method' => $data['payment_method'],
                'reference_number' => $reference_number,
                'record_date' => $data['record_date'],
                'added_by_id' =>  h_session('current_user_id'),
                'branch_id' => h_session('branch_id'),
                'voucher_number' => ''
            ];

            $credit_chart_id = $credit['id'];

            $this->db->table('sch_journal_entries')->insert($journal_entry);
            $journalID = $this->db->insertID();

            // Complete the transaction
            $this->db->transComplete();

            // Check transaction status
            if ($this->db->transStatus() === false) {
                $response['message'] = $e->getMessage();
            } else {
                $response['success'] = true;
                $response['StatusCode'] = '00';

                $journal_entries1 = ['journal_entry_id' => $journalID, 'chart_account_id' => $credit_chart_id, 'amount' => $data['amount'], 'cr_dr' => 'cr'];
                $this->db->table('sch_journal_entry_lines')->insert($journal_entries1);

                $journal_entries2 = ['journal_entry_id' => $journalID, 'chart_account_id' => $debit_chart_id, 'amount' => $data['amount'], 'cr_dr' => 'dr'];
                $this->db->table('sch_journal_entry_lines')->insert($journal_entries2);

                $fees_payments_data = ['journal_entry_id' => $journalID, 'people_id' => $data['people_id'], 'term_id' => $data['term_id'], 'added_by_id' => h_session('current_user_id')];
                $this->db->table('sch_fees_payment')->insert($fees_payments_data);
                $paymentID = $this->db->insertID();

                if ($paymentID) {
                    foreach (json_decode($data['payments']) as $key => $payment) {
                        $fees_types_data = ['amount' => $payment->amount, 'fees_payment_id' => $paymentID, 'fees_structure_id' => $payment->id];
                        $this->db->table('sch_fees_types_payments')->insert($fees_types_data);
                    }
                }

                if ($data['send_sms'] == '0') {
                    // send sms
                    $people = $this->db->table('sch_people')
                        ->select('*')
                        ->where('id', $data['people_id'])
                        ->get()
                        ->getRow();
                    if ($people) {
                        $balance = $data['balance'] ? $data['balance'] : 0;
                        $school = h_session('short_name') ? h_session('short_name') : h_session('school_name');
                        $message = "Dear Parent, \n" . $school . " confirms receipt of your payment for " . $people->name . "'s fees (" . number_format($data['amount']) . "), your childs balance is " . $balance . " \nWe thank you for your timely payment.";
                        $parent = $this->db->table('sch_people_relation as relation')
                            ->select('people.*')
                            ->where('relation.person_1', $data['people_id'])
                            ->join('sch_people AS people', 'people.id = relation.person_2')
                            ->get()
                            ->getRow();
                        if ($parent && $parent->phone) {
                            h_make_send_sms_request($message, $parent->phone);
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }

        return (object) $response;
    }

    function updateFeesType($updateData, $id)
    {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';

        try {
            // Start a transaction
            $this->db->transStart();

            $this->db->table('sch_fees_types')
                ->where('id', $id)
                ->update($updateData);

            // Complete the transaction
            $this->db->transComplete();

            // Check transaction status
            if ($this->db->transStatus() === false) {
                // Log the error if transaction failed
                $response['message'] = $e->getMessage();
            } else {
                $response['success'] = true;
                $response['StatusCode'] = '00';
            }
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }

        return (object) $response;
    }

    public function listBursaries()
    {
        return $this->db->table('sch_bursaries')
            ->where('deleted', 0)
            ->orderBy('id', 'DESC')
            ->get()
            ->getResult();
    }

    public function saveBursary($data)
    {
        $this->db->transStart();
        $this->db->table('sch_bursaries')->insert($data);
        $this->db->transComplete();

        return (object)[
            'success' => $this->db->transStatus(),
            'message' => $this->db->transStatus() ? 'Bursary Saved Successfully' : 'Error Occurred'
        ];
    }

    public function updateBursary($data, $id)
    {

        $this->db->transStart();
        $this->db->table('sch_bursaries')->where('id', $id)->update($data);
        $this->db->transComplete();

        return (object)[
            'success' => $this->db->transStatus(),
            'message' => $this->db->transStatus() ? 'Bursary Updated Successfully' : 'Update Failed'
        ];
    }

    function validateStudentByCode($data)
    {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';

        $token = $data['token'];
        $student_number = $data['student_number'];
        $this->db->setDatabase('inoc_system_main');

        $validate_token = $this->db->table('sch_schools_registered as sch')
            ->select('sch.*, db.db_name')
            ->where('sch.status', 'approved')
            ->where('sch.deleted', 0)
            ->where('sch.token', $token)
            ->where('sch.expires_at >', date('Y-m-d H:i:s'))
            ->join('sch_databases AS db', 'db.id = sch.school_db_id')
            ->get()
            ->getRow();

        if (!$validate_token) {
            $response['StatusCode'] = '58';
            $response['Message'] = 'Unauthorised';

            return (object) $response;
        }

        $tokenData = h_validate_jwt($token);
        if ($tokenData == 'expired' || $tokenData == 'error') {
            $response['StatusCode'] = '58';
            $response['Message'] = 'Unauthorised';
            return (object) $response;
        }

        if ($tokenData['id'] != $validate_token->id) {
            $response['StatusCode'] = '58';
            $response['Message'] = 'Unauthorised';
            return (object) $response;
        }

        $this->db->setDatabase($validate_token->db_name);

        $student = $this->db->table('sch_student as stud')
            ->select('peop.*')
            ->where('peop.status', 'active')
            ->where('peop.deleted', 0)
            ->where('stud.student_payment_code', $student_number)
            ->join('sch_people AS peop', 'peop.id = stud.people_id')
            ->get()
            ->getRow();

        if (!$student) {
            $response['StatusCode'] = '59';
            $response['Message'] = 'Not Student Found';

            return (object) $response;
        }

        $response['StatusCode'] = '00';
        $response['success'] = true;

        $response['accountNumber'] = $student_number;
        $response['accountName'] = $student->name;
        $response['accountProvider'] = $validate_token->school_name;
        $response['outstandingBalance'] = 0;
        $response['accountType'] = 'school_fees';

        $this->db->setDatabase('inoc_system_main');
        return (object) $response;
    }

    function payStudentFeesByCode($data)
    {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';

        $token = $data['token'];
        $student_number = $data['accountNumber'];
        $this->db->setDatabase('inoc_system_main');

        $validate_token = $this->db->table('sch_schools_registered as sch')
            ->select('sch.*, db.db_name')
            ->where('sch.status', 'approved')
            ->where('sch.deleted', 0)
            ->where('sch.token', $token)
            ->where('sch.expires_at >', date('Y-m-d H:i:s'))
            ->join('sch_databases AS db', 'db.id = sch.school_db_id')
            ->get()
            ->getRow();

        if (!$validate_token) {
            $response['StatusCode'] = '58';
            $response['Message'] = 'Unauthorised';

            return (object) $response;
        }

        $tokenData = h_validate_jwt($token);
        if ($tokenData == 'expired' || $tokenData == 'error') {
            $response['StatusCode'] = '58';
            $response['Message'] = 'Unauthorised';
            return (object) $response;
        }

        if ($tokenData['id'] != $validate_token->id) {
            $response['StatusCode'] = '58';
            $response['Message'] = 'Unauthorised';
            return (object) $response;
        }

        $this->db->setDatabase($validate_token->db_name);
        $dbData = ['db_name' => $validate_token->db_name];
        h_set_session($dbData);

        $student = $this->db->table('sch_student as stud')
            ->select('peop.*, stud.id as student_id')
            ->where('peop.status', 'active')
            ->where('peop.deleted', 0)
            ->where('stud.student_payment_code', $student_number)
            ->join('sch_people AS peop', 'peop.id = stud.people_id')
            ->get()
            ->getRow();

        if (!$student) {
            $response['StatusCode'] = '59';
            $response['Message'] = 'Not Student Found';

            return (object) $response;
        }

        $bank_account = $this->db->table('sch_bank_accounts')
            ->select('*')
            ->where('bank_type', 'sacco')
            ->get()
            ->getRow();
        if (!$bank_account) {
            $response['StatusCode'] = '60';
            $response['Message'] = 'Not Bank account Found';

            return (object) $response;
        }

        try {
            // Start a transaction
            helper('h_database');
            $db = h_connect_database($validate_token->db_name);
            $this->db->transStart();
            $treasury = new M_ManageTreasury($db);
            $credit = $treasury->get_chart_of_account_by_code('sys-421');
            $reference_number = $treasury->generate_reference_no('income');

            $journal_entry = [
                'heading' => $data['narration'],
                'payment_method' => 'bank',
                'reference_number' => $reference_number,
                'record_date' => $data['record_date'],
                'added_by_id' => 0,
                'branch_id' => 0,
                'voucher_number' => ''
            ];

            $credit_chart_id = $credit['id'];
            $debit_chart_id = $bank_account->chart_id;

            $this->db->table('sch_journal_entries')->insert($journal_entry);

            $journalID = $this->db->insertID();

            // Complete the transaction
            $this->db->transComplete();

            // Check transaction status
            if ($this->db->transStatus() === true) {

                $response['success'] = true;
                $response['StatusCode'] = '00';
                $response['transactionId'] = $reference_number;

                if ($journalID) {
                    $journal_entries1 = ['journal_entry_id' => $journalID, 'chart_account_id' => $credit_chart_id, 'amount' => $data['amount'], 'cr_dr' => 'cr'];
                    $this->db->table('sch_journal_entry_lines')->insert($journal_entries1);

                    $journal_entries2 = ['journal_entry_id' => $journalID, 'chart_account_id' => $debit_chart_id, 'amount' => $data['amount'], 'cr_dr' => 'dr'];
                    $this->db->table('sch_journal_entry_lines')->insert($journal_entries2);

                    $fees_payments_data = ['journal_entry_id' => $journalID, 'people_id' => $student->id, 'source' => $data['source']];
                    $this->db->table('sch_fees_payment')->insert($fees_payments_data);
                    $paymentID = $this->db->insertID();

                    $school = $validate_token->school_name;
                    $message = "Dear Parent, \n" . $school . " confirms receipt of your payment for " . $student->name . "'s fees (" . number_format($data['amount']) . "). \nWe thank you for your timely payment.";
                    $parent = $this->db->table('sch_people_relation as relation')
                        ->select('people.*')
                        ->where('relation.person_1', $student->id)
                        ->join('sch_people AS people', 'people.id = relation.person_2')
                        ->get()
                        ->getRow();

                    if ($parent && $parent->phone) {
                        // h_make_send_sms_request( $message, $parent->phone);
                    }
                }
            }
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }

        return (object) $response;
    }


    function getFeesPaymentLedger($startDate, $endDate, $termId, $paymentMethod) {
        $fees = $this->db->table('sch_fees_payment fees')
                ->select('system.*, fees.source, fees.id as fee_id, people.*, system.id as transaction_id, student.id as student_id')
                ->where('fees.transaction_status', 'normal')
                ->where('fees.deleted', '0')
                ->join('sch_journal_entries AS system', 'system.id = fees.journal_entry_id')
                ->join('sch_people AS people', 'people.id = fees.people_id')
                ->join('sch_student AS student', 'people.id = student.people_id')
                ->orderBy('system.record_date', 'DESC');

        if ($termId != 0) {
            $fees->where('fees.term_id', $termId);
        }

        if ($paymentMethod != 0) {
            $fees->where('system.payment_method', $paymentMethod);
        }

        // Add record_date filter by date
        if (!empty($startDate) && !empty($endDate)) {
            $fees->where("DATE(system.record_date) >=", $startDate);
            $fees->where("DATE(system.record_date) <=", $endDate);
        }

        $results = $fees->get()->getResult();

        foreach ($results as $key => $result) {
            $entry = $this->db->table('sch_journal_entry_lines')
                ->select('*')
                ->where('journal_entry_id', $result->transaction_id)
                ->get()
                ->getRow();
            
            if ($entry) {
                $result->amount = $entry->amount;
            }
            else {
                $result->amount = 0;
            }

            $class = $this->db->table('sch_stream_students strem_student')
                    ->select('strem_student.*, stream.name as stream_name, class.name as class_name, class.short_name as class_short_name')
                    ->where('strem_student.student_id', $result->student_id)
                    ->join('sch_streams AS stream', 'stream.id = strem_student.class_stream_id')
                    ->join('sch_classes AS class', 'class.id = stream.class_id')
                    ->orderBy('strem_student.id', 'DESC')
                    ->get()
                    ->getRow();
            
            $result->current_class = $class;
        }

        return $results;
    }

}
