<?php

namespace App\Models\user_models\message_center;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;
use Config\Database;

class M_ManageMessageCenter extends Model
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

    public function listSMSTypes()
    {
        $smsTypes = $this->db->table('sch_sms_types')
                ->select('*')
                ->get()
                ->getResult();

        return $smsTypes ? $smsTypes : [];
    }

    public function listSentSMS()
    {
        $sentSMS = $this->db->table('sch_sent_messages')
                ->select('*')
                ->orderBy('id', 'DESC')
                ->get()
                ->getResult();

        return $sentSMS ? $sentSMS : [];
    }

    function saveUpdateSMSTypesData($updateData, $id) {
       $response = [];
       $response['success'] = false;
       $response['StatusCode'] = '57';

       try {
            // Start a transaction
            $this->db->transStart();
            
            $this->db->table('sch_sms_types')
                ->where('id', $id)
                ->update($updateData);

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
            $response['message'] = $e->getMessage();
        }

       return (object) $response;
    }

    function sendSMSData($data) {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';

        $recepients = $data['recepients'];
        $message = $data['message'];
        $success = [];
        if (!empty($recepients) && $message) {
            foreach ($recepients as $key => $recepient) {
                $send = h_make_send_sms_request($message, $recepient);
                if ($send) {
                    $success[] = $recepient;
                }
            }
        }

        if (!empty($success)) {
            $sms_cost = h_session('sms_cost') ? h_session('sms_cost'): 0;
            $total_amount = count($success) * $sms_cost;
            $saveData = ['message' => $message, 'recipients' => json_encode($success), 'added_by_id' => h_session('current_user_id'), 'total_sms' => count($success), 'total_amount' => $total_amount, 'sms_cost' => $sms_cost ];

            try {
                // Start a transaction
                $this->db->transStart();
                $this->db->table('sch_sent_messages')->insert($saveData);
                 // Complete the transaction
                $this->db->transComplete();
            
                // Check transaction status
                if ($this->db->transStatus() === false) {
                    // Log the error if transaction failed
                    $logger = \Config\Services::logger();
                    $logger->error('Failed to update');
    
                    $response['message'] = $e->getMessage();
                }else {
                    if (count($success) > 0) {
                        $response['success'] = true;
                        $response['StatusCode'] = '00';
                    }
                }
    
            } catch (\Exception $e) {
                $response['message'] = $e->getMessage();
            }
        }

        return (object) $response;
    }

    function purchaseSMSData($saveData) {
       $response = [];
       $response['success'] = false;
       $response['StatusCode'] = '57';

       try {
            // Start a transaction
            $this->db->transStart();

            $saveSchoolData = $saveData;
            $this->db->setDatabase('inoc_system_main');

            $saveSchoolData['school_id'] = h_session('school_id');

            $this->db->table('sch_sms_purchase_requests')->insert($saveSchoolData);
            $requestID = $this->db->insertID();
            // Complete the transaction
            $this->db->transComplete();

            $dbName = h_session('db_name');
            $this->db->setDatabase($dbName);
            
            $this->db->transStart();
            $saveData['request_id'] = $requestID;
            $this->db->table('sch_sms_purchase_requests')->insert($saveData);
            $this->db->transComplete();
            
        
            // Check transaction status
            if ( $this->db->transStatus() ) {
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

    function listSMSPurchases() {
        $SMSPurchases = $this->db->table('sch_sms_purchase_requests')
                ->select('*')
                ->orderBy('id', 'DESC')
                ->get()
                ->getResult();

        return $SMSPurchases ? $SMSPurchases : [];
    }

    function listSMSPurchasesRequests() {
        $this->db->setDatabase('inoc_system_main');

        $SMSPurchaseRequests = $this->db->table('sch_sms_purchase_requests as req')
                ->select('req.*, sch.school_name, sch.school_code, acc.user_name')
                ->orderBy('req.id', 'ASC')
                ->join('sch_schools_registered AS sch', 'sch.id = req.school_id')
                ->join('sch_user_accounts AS acc', 'acc.id = req.added_by_id')
                ->get()
                ->getResult();

        $dbName = h_session('db_name'); 
        $this->db->setDatabase($dbName);
        return $SMSPurchaseRequests ? $SMSPurchaseRequests : [];
    }

    function approvePurchaseSMSData($id) {
        $response = [];
        $response['success'] = true;
        $response['StatusCode'] = '00';

        $this->db->setDatabase('inoc_system_main');
        $updateData = ["status" => "approved"];

        $this->db->table('sch_sms_purchase_requests')
                ->where('id', $id)
                ->update($updateData);

        $db = $this->db->table('sch_sms_purchase_requests as req')
                ->select('db.db_name')
                ->join('sch_schools_registered AS sch', 'sch.id = req.school_id')
                ->join('sch_databases AS db', 'db.id = sch.school_db_id')
                ->where('db.status', '0')
                ->where('db.deleted', '0')
                ->where('req.id', $id)
                ->get()
                ->getRow();

        if ($db) {

            $this->db->setDatabase($db->db_name);
            $this->db->table('sch_sms_purchase_requests')
                ->where('request_id', $id)
                ->update($updateData);
        }

        $dbName = h_session('db_name'); 
        $this->db->setDatabase($dbName);

        return (object) $response;
    }

    function listSMSBalance() {
        $total_amount = 0;
        $total_sent = 0;
        $total_sms_sent = 0;
        $SMSPurchases = $this->db->table('sch_sms_purchase_requests')
                ->selectSum('amount', 'total_amount')
                ->where('status', "approved")
                ->get()
                ->getRow();

        if ($SMSPurchases) {
            $total_amount = $SMSPurchases->total_amount;
        }

        $total = $this->db->table('sch_sent_messages')
                ->selectSum('total_amount', 'total_amount')
                ->where('status', "0")
                ->get()
                ->getRow();
        if ($total) {
            $total_sent = $total->total_amount;
        }

        $total_sms = $this->db->table('sch_sent_messages')
                ->selectSum('total_sms', 'total_sms')
                ->where('status', "0")
                ->get()
                ->getRow();
        if ($total_sms) {
            $total_sms_sent = $total_sms->total_sms;
        }

        $total_bal = $total_amount - $total_sent;
        $sms_cost = h_session('sms_cost');
        $sms_bal = $total_bal >= $sms_cost? round($total_bal/$sms_cost) :0;
        return (object)["balance" => $total_bal, "sms_bal" => $sms_bal, 'sms_sent' => $total_sms_sent];
    }
}
