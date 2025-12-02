<?php

namespace App\Controllers\user_controllers\fees_payment;

use App\Controllers\BaseController;
use App\Models\user_models\fees_payment\M_ManageFeesPayment;
use App\Models\user_models\students\M_ManageStudents;
use App\Helpers\user_helpers\e_payments\SchoolPesapalV30Helper;
use App\Models\user_models\academics_settings\M_ManageAcademicYears;
use App\Models\user_models\academics\M_ManageTerms;

class ManageFeesPayment extends BaseController
{
    protected $modal;
    protected $modal1;
    protected $modal2;
    protected $modal3;

    public function __construct()
    {

        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        // initiate school db connection
        $this->modal = new M_ManageFeesPayment();
        $this->modal1 = new M_ManageStudents();
        $this->modal2 = new M_ManageAcademicYears();
        $this->modal3 = new M_ManageTerms();
    }

    public function feesLedger()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        h_set_session('current_page','Fees Payments Ledger');
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d');

        $results = $this->modal2->listRegisteredAcademicYears();
        $data['academic_years'] = $results;

        $data['fees'] =  $this->modal->getFeesPaymentLedger($startDate, $endDate, 0, 0);
        return view('user_pages/fees_payments/fees_ledger/index', $data);
    }

    function feesLedgerView() {
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];
            return $this->response->setJSON($response);
        }

        $startDate = h_post('start_date');
        $endDate = h_post('end_date');
        $term_id = h_post('term_id');
        $payment_method = h_post('payment_method');

        $data['fees'] =  $this->modal->getFeesPaymentLedger($startDate, $endDate, $term_id, $payment_method);

        $page = 'user_pages/fees_payments/fees_ledger/fees-table';
        $response = ['success' => true, "html" => view($page, $data)];
        return $this->response->setJSON($response);
    }

    public function feesPaymentForm()
    {
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];
            return $this->response->setJSON($response);
        }

        $id = h_post('id');
        $term_id = h_post('term_id');
        $data = [];
        $data['fees_structures'] = [];
        $data['student'] = [];
        $studentID = 0;
        $student = [];
        $peopleID = h_encrypt_decrypt($id, 'decrypt');
        if ($peopleID) {
            $student = $this->modal1->studentDetails($peopleID);
            $data['student'] = $student;
            if ($student && $student->admission) {
                $studentID = $student->admission->id;
            }
        }

        $classDetails = $this->modal1->studentClassTermDetails($term_id, $studentID);
        if ($classDetails) {
            $data['fees_structures'] = $this->modal->listFeesStructures($term_id, $classDetails->class_id, $student);
        }
        $data['class_details'] = $classDetails;
        $data['term_id'] = $term_id;

        $page = 'user_pages/fees_payments/pay_fees/fees-payment-form';
        $response = ['success' => true, "html" => view($page, $data)];
        return $this->response->setJSON($response);
    }

    public function collectMMFeesPayment()
    {
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];
            return $this->response->setJSON($response);
        }

        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $phoneNumber = h_post('phone_number');
        $amount = h_post('amount');
        $description = h_post('description');
        $firstName = h_post('first_name');
        $lastName = h_post('last_name');
        $peopleId = h_post('people_id');

        $api = 'live';
        $consumer_key = "mDyGm1UF3SFudoAQ/QIDPd0ub3n6lGZG";
        $consumer_secret = "ZRuH3ONZG9UTpv7bDBmdE252KGg=";

        $callback_url = "http://localhost/sample_api3/redirect.php";

        // Pesapal helper class
        $pesapalV30Helper = new SchoolPesapalV30Helper($api);
        // Step 1 Authentication
        $access = $pesapalV30Helper->getAccessToken($consumer_key, $consumer_secret);
        if ($access->status && $access->status == '200') {
            $access_token = $access->token;

            $IPN_respose = $pesapalV30Helper->getNotificationId($access_token, $callback_url);

            // This notification_id uniquely identifies the endpoint Pesapal will send alerts to whenever a payment status changes for each transaction processed via API 3.0
            $IPN_id = $IPN_respose->ipn_id;

            $order = [];
            $ref                =  str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789', 5);
            $reference    =  substr(str_shuffle($ref), 0, 10);
            $order['id'] = $reference;
            $order['currency'] = 'UGX';
            $order['amount'] = number_format($amount, 2); //format amount to 2 decimal places
            $order['description'] = $description;
            $order['callback_url'] = $callback_url; //URL user to be redirected to after payment
            $order['notification_id'] = $IPN_id; // //unique transaction id, generated by merchant.
            $order['language'] = 'EN';
            $order['terms_and_conditions_id'] = '';
            $order['phone_number'] = preg_replace("/[^0-9]/", "", str_replace(' ', '', $phoneNumber));
            $order['email_address'] = ''; //Optional if we have phone
            $order['country_code'] = 'UG'; //ISO codes (2 digits)
            $order['first_name'] = $firstName;
            $order['middle_name'] = '';
            $order['last_name'] = $lastName;
            $order['line_1'] = 'SchoolHub';
            $order['line_2'] = '';
            $order['city'] = 'Kampala';
            $order['state'] = '';
            $order['postal_code'] = '';
            $order['zip_code'] = '';

            // post the order request to pesapal
            $data = $pesapalV30Helper->getMerchertOrderURL($order, $access_token);

            // Iframe source link
            $reference_no = $reference;
            if ($data->redirect_url) {
                $results['success'] = true;
                $results['message'] = 'Payment Initiated Successfully';
                $results['redirect_url'] = $data->redirect_url;
                $results['reference_number'] = $data->order_tracking_id;
                $reference_no = $data->order_tracking_id;

                // save transaction.
                $number = preg_replace("/[^0-9]/", "", str_replace(' ', '', $phoneNumber));
                $paymentData = [
                    'amount' => (float)$amount,
                    'phone_number' => $number,
                    'added_by_id' => h_session('current_user_id'),
                    'reference_no' =>  $reference_no,
                    'people_id' => $peopleId,
                    'narration' => $description,
                    'other_info' => "IPN_ID:{$IPN_id}, ID:{$reference}"
                ];
                $this->modal->saveEpaymentData($paymentData);
            }
        }
        return $this->response->setJSON($results);
    }

    public function feesTypes()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        h_set_session('current_page', 'Fees Types Ledger');
        $data['fees_types'] = $this->modal->listFeesTypes();
        return view('user_pages/fees_payments/fees_types/index', $data);
    }

    public function submitFeesTypesForm()
    {
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];
            return $this->response->setJSON($response);
        }

        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $name = h_post('name');
        $desc = h_post('description');
        $type_key = h_post('type_key');
        $chart_id = h_post('chart_id');

        $data = ['name' => $name, 'description' => $desc, 'added_by_id' => h_session('current_user_id'), 'type_key' => $type_key, 'chart_id' => $chart_id];
        $response = $this->modal->saveFeesTypes($data);
        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Saved Successfully';
        }

        return $this->response->setJSON($results);
    }

    public function listBursaries()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $data['bursaries'] = $this->modal->listBursaries();
        h_set_session('current_page', 'List Bursaries');

        return view('user_pages/fees_payments/bursaries/index', $data);
    }

    public function getAddBursaryForm()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        return view('user_pages/fees_payments/bursaries/add-bursary');
    }

    public function submitBursaryForm()
    {
        if (!is_logged_in()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $results = ['success' => false, 'message' => 'Error Occurred'];

        $action = h_post('action');
        $data = [
            'org_type' => h_post('org_type'),
            'name' => h_post('name'),
            'primary_contact' => h_post('primary_contact'),
            'telephone' => h_post('telephone'),
            'email' => h_post('email'),
            'status' => h_post('status'),
            'address' => h_post('address'),
            'primary_contact_person_name' => h_post('primary_contact_person_name'),
            'primary_contact_person_email' => h_post('primary_contact_person_email'),
            'primary_contact_person_telephone' => h_post('primary_contact_person_telephone'),
        ];

        if ($action === 'delete') {
            $id = h_post('id');
            if ($id) {
                $response = $this->modal->updateBursary(['deleted' => 1], $id);
                if ($response->success) {
                    $results['success'] = true;
                    $results['message'] = 'Bursary deleted successfully';
                }
            } else {
                $results['message'] = 'Missing Bursary ID';
            }

            return $this->response->setJSON($results);
        }

        if ($action === 'create') {
            $data['added_by_id'] = h_session('current_user_id');
            $response = $this->modal->saveBursary($data);
        } elseif ($action === 'update') {
            $id = h_post('id');
            $response = $this->modal->updateBursary($data, $id);
        }

        return $this->response->setJSON($response);
    }

    public function feesStructureIndex()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        if (h_is_ajax_request()) {
            $termId = h_get('id');
            // Handle AJAX request
            $data['fees_structures'] = $this->modal->listFeesStructures($termId);
            $page = 'user_pages/fees_payments/fees_structure/fees_structure_table';
            $response = ['success' => true, "html" => view($page, $data)];
            return $this->response->setJSON($response);
        }

        h_set_session('current_page', 'Fees Structure Ledger');
        $results = $this->modal2->listRegisteredAcademicYears();
        $data['academic_years'] = $results;
        return view('user_pages/fees_payments/fees_structure/index', $data);
    }

    function addFeesStructureForm()
    {
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];
            return $this->response->setJSON($response);
        }

        $termId = h_get('term_id');
        // Handle AJAX request
        $data['fees_types'] = $this->modal->listFeesTypes();
        $data['classes'] = $this->modal3->listTermClasses($termId);

        $page = 'user_pages/fees_payments/fees_structure/add-fees-structure';
        $response = ['success' => true, "html" => view($page, $data)];
        return $this->response->setJSON($response);
    }

    function submitFeesStructureForm()
    {
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];
            return $this->response->setJSON($response);
        }

        $feesTypeId = h_post('fees_type');
        $fees = h_post('fees');
        $termId = h_post('term_id');

        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        if (!empty($fees)) {
            $data = ['fees_type_id' => $feesTypeId, 'fees' => $fees, 'term_id' => $termId];
            $response = $this->modal->saveFeesStructure($data);
            if ($response->success) {
                $results['success'] = true;
                $results['message'] = 'Saved Successfully';
            }
        }

        return $this->response->setJSON($results);
    }

    function submitEditFeesStructureForm()
    {
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];
            return $this->response->setJSON($response);
        }

        $transType = h_post('trans_type');
        if ($transType == 'delete') {
            $id = h_post('id');
            $term_id = h_post('term_id');
            if ($term_id) {
                $response = $this->modal->deleteFeesStructure($id, $term_id);
                if ($response->success) {
                    $results['success'] = true;
                    $results['message'] = 'Deleted Successfully';
                }
            }
        }
        if ($transType == 'edit') {
            $feesTypeId = h_post('fees_type_id');
            $fees = h_post('fees');
            $termId = h_post('term_id');

            if ($feesTypeId && !empty($fees) && $termId) {
                $data = ['fees_type_id' => $feesTypeId, 'fees' => $fees, 'term_id' => $termId];
                $response = $this->modal->updateFeesStructure($data);
                if ($response->success) {
                    $results['success'] = true;
                    $results['message'] = 'Updated Successfully';
                }
            }
        }

        return $this->response->setJSON($results);
    }

    function submitFeesPaymentForm()
    {
        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];
            return $this->response->setJSON($response);
        }

        $peopleId = h_post('people_id');
        $payments = h_post('fees-structure-payments');
        $amount = h_post('amount');
        $description = h_post('description');
        $record_date = h_post('record_date');
        $payment_method = h_post('payment_method');
        $payment_method_account = h_post('payment_method_account');
        $reference_no = h_post('reference_no');
        $reference_number = h_post('reference_number');
        $send_sms = h_post('send_sms');
        $term_id = h_post('term_id');
        $balance = h_post('amount_balance');

        $data = [
            'people_id' => $peopleId,
            'payments' => $payments,
            'amount' => $amount,
            'description' => $description,
            'record_date' => $record_date,
            'payment_method' => $payment_method,
            'payment_method_account' => $payment_method_account,
            'reference_no' => $reference_no,
            'reference_number' => $reference_number,
            'send_sms' => $send_sms,
            'term_id' => $term_id,
            "balance" => $balance
        ];
        $response = $this->modal->saveFeesPayment($data);
        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Payment Recorded Successfully';
        }

        return $this->response->setJSON($results);
    }

    function submitFeesTypesEdit()
    {
        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];
            return $this->response->setJSON($response);
        }

        $action = h_post('action');
        if ($action == 'delete') {
            $id = h_post('id');
            $data = ["deleted" => '1'];
            $response = $this->modal->updateFeesType($data, $id);
            if ($response->success) {
                $results['success'] = true;
                $results['message'] = 'Deleted Successfully';
            }
        }
        if ($action == 'edit') {
            $id = h_post('id');
            $name = h_post('name');
            $description = h_post('description');
            $type_key = h_post('type_key');
            $chart_id = h_post('chart_id');

            $data = ["name" => $name, "description" => $description, 'type_key' => $type_key, 'chart_id' => $chart_id];
            $response = $this->modal->updateFeesType($data, $id);
            if ($response->success) {
                $results['success'] = true;
                $results['message'] = 'Updated Successfully';
            }
        }

        return $this->response->setJSON($results);
    }

    public function validateStudentByCode()
    {
        $errors = [];
        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $jsonData = $this->request->getJSON(true);

        $student_number = $jsonData['student_number'] ?? null;
        $apiKey = $this->request->getHeaderLine('Authorization');

        // Validate required fields
        if (!$student_number) {
            $errors['student_number'] = 'Student number is required.';
        }

        if (!$apiKey) {
            $errors['Authorization'] = 'Authorization header is required.';
        }

        // Check if errors exist
        if (!empty($errors)) {
            return $this->response
                ->setStatusCode(400) // Bad Request
                ->setJSON(['errors' => $errors]); // Return all validation errors
        }

        $tokenData = h_validate_jwt($apiKey);
        if ($tokenData == 'expired' || $tokenData == 'error') {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'Unauthorized']);
        }

        $treasury = new M_ManageFeesPayment();
        $data = ['student_number' => $student_number,  'token' => $apiKey];
        $response = $treasury->validateStudentByCode($data);
        if (!$response->success && $response->StatusCode == '58') {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'Unauthorized']);
        }

        if (!$response->success && $response->StatusCode == '57') {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Error Occurred']);
        }

        if (!$response->success && $response->StatusCode == '59') {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'No Student Found']);
        }

        $results = [
            'accountNumber' => $response->accountNumber,
            'accountName' => $response->accountName,
            'accountProvider' => $response->accountProvider,
            'outstandingBalance' => $response->outstandingBalance,
            'accountType' => $response->accountType
        ];

        return $this->response->setStatusCode(200)->setJSON($results);
    }

    public function payStudentFeesByCode()
    {
        $errors = [];
        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $jsonData = $this->request->getJSON(true); // Converts JSON to an associative array

        // Define validation rules
        $rules = [
            'accountNumber' => 'required|numeric',
            'accountName'   => 'required|string|min_length[3]|max_length[255]',
            'amount'        => 'required|numeric|greater_than[0]',
            'record_date'   => 'required|regex_match[/^\d{4}-\d{2}-\d{2}$/]',
            'narration'     => 'required|string|max_length[500]',
            'source'        => 'required|string|max_length[50]',
        ];

        // Load validation service
        $validation = \Config\Services::validation();
        $validation->setRules($rules);

        // Validate input data
        if (!$validation->run($jsonData)) {
            // Validation failed, return errors
            $errors = $validation->getErrors();

            return $this->response
                ->setStatusCode(400) // Bad Request
                ->setJSON(['errors' => $errors]);
        }

        $accountNumber = $jsonData['accountNumber'] ?? null;
        $accountName = $jsonData['accountName'] ?? null;
        $amount = $jsonData['amount'] ?? null;
        $record_date = $jsonData['record_date'] ?? null;
        $narration = $jsonData['narration'] ?? null;
        $source = $jsonData['source'] ?? null;

        $apiKey = $this->request->getHeaderLine('Authorization');


        // Validate required fields
        if (!$accountNumber) {
            $errors['accountNumber'] = 'Account number is required.';
        }

        if (!$source) {
            $errors['source'] = 'source is required.';
        }

        if ($source && !in_array($source, ['sacco'])) {
            $errors['source'] = 'Invalid source';
        }

        if (!$accountName) {
            $errors['accountName'] = 'Account name is required.';
        }

        if (!$amount) {
            $errors['amount'] = 'Amount is required.';
        }

        if (!$record_date) {
            $errors['record_date'] = 'Record date is required.';
        }

        if (!$narration) {
            $errors['narration'] = 'Narration is required.';
        }

        if (!$apiKey) {
            $errors['Authorization'] = 'Authorization header is required.';
        }

        // Check if errors exist
        if (!empty($errors)) {
            return $this->response
                ->setStatusCode(400) // Bad Request
                ->setJSON(['errors' => $errors]); // Return all validation errors
        }

        $tokenData = h_validate_jwt($apiKey);
        if ($tokenData == 'expired' || $tokenData == 'error') {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'Unauthorized']);
        }

        $treasury = new M_ManageFeesPayment();
        $data = [
            'accountNumber' => $accountNumber,
            'accountName' => $accountName,
            'amount' => $amount,
            'record_date' => $record_date,
            'narration' => $narration,
            'source' => $source,
            'token' => $apiKey
        ];
        $response = $treasury->payStudentFeesByCode($data);
        if (!$response->success && $response->StatusCode == '58') {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'Unauthorized']);
        }

        if (!$response->success && $response->StatusCode == '57') {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Error Occurred']);
        }

        if (!$response->success && $response->StatusCode == '59') {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'No Student Found']);
        }

        if (!$response->success && $response->StatusCode == '60') {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'No bank account Found']);
        }

        $results = [
            'transactionId' => $response->transactionId
        ];

        return $this->response->setStatusCode(200)->setJSON($results);
    }

    function generateToken()
    {
        $jsonData = $this->request->getJSON(true);
        $id = $jsonData['id'] ?? null;
        $tokenData = h_generate_jwt(['id' => $id, 'hashing' => 'pXji0auG7G']);
        // $apiKey = $this->request->getHeaderLine('Authorization');
        // $tokenData = h_validate_jwt($apiKey);

        return $this->response->setStatusCode(200)->setJSON($tokenData);
    }
}
