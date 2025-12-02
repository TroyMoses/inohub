<?php

namespace App\Controllers\user_controllers\message_center;

use App\Controllers\BaseController;
use App\Models\user_models\message_center\M_ManageMessageCenter;
use App\Models\user_models\academics_settings\M_ManageAcademicYears;

class ManageMessageCenter extends BaseController 
{
    protected $modal;

	public function __construct()
	{

        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        // initiate school db connection 
        $this->modal = new M_ManageMessageCenter();
        $this->modal1 = new M_ManageAcademicYears();
    }

    public function smsTypes()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }
        
        h_set_session('current_page','SMS Types');
        $data['smstypes'] = $this->modal->listSMSTypes();
        return view('user_pages/message_center/sms-types', $data);
    }

    public function sentMessages()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }
        
        h_set_session('current_page','Out Box');
        $data['mesages'] = $this->modal->listSentSMS();
        return view('user_pages/message_center/out-box', $data);
    }

    function submitUpdateSMSTypes() {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }
        
        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $id = h_post('id');
        $status = h_post('status');

        $data = ['status' => $status];
        $response = $this->modal->saveUpdateSMSTypesData($data, $id);
        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Updated Successfully';
        }

        return $this->response->setJSON($results);
    }

    function submitSendSMS() {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }
        
        $results = [];
        $results['success'] = false;
        $results['message'] = 'Failed To send SMS';

        $message = h_post('message');
        $recepients = h_post('recepients');
        $form = h_post('form');
        if ($form == '1') {
            $recepients = explode(',', $recepients);
            $data = ['message' => $message, 'recepients' => $recepients];
            $response = $this->modal->sendSMSData($data);
            if ($response->success) {
                $results['success'] = true;
                $results['message'] = 'SMS Sent Successfully';
            }
        }

        if ($form == '3') {
            $file = h_file_post('file');
            $message = h_post('message');
            if ($file) {
                // Check if the file is valid and has a CSV extension
                if ($file && $file->isValid() && $file->getClientExtension() === 'csv') {
                    $filePath = WRITEPATH . 'uploads/' . $file->getName();  // Save to writable/uploads
                    $file->move(WRITEPATH . 'uploads/');  // Move the file to the uploads folder

                    // Open and read the CSV file
                    $csvData = array();
                    $ID = 0;
                    $totalRows = 0;
                    if (($handle = fopen($filePath, 'r')) !== false) {

                        $header = fgetcsv($handle);  // Read the first row as header
                        // Count total rows in the file
                        while (($row = fgetcsv($handle)) !== false) {
                            $totalRows++;
                        }
                        // Close and reopen the file to start processing from the beginning
                        fclose($handle);
                        $handle = fopen($filePath, 'r');
                        fgetcsv($handle);

                        $recepients = [];
                        while (($row = fgetcsv($handle)) !== false) {
                            $phone = $row[0];

                            // Check if the phone number starts with '0', if not, prepend '0'
                            if (strpos($phone, '0') !== 0) {
                                $phone = '0' . $phone;
                            }

                            // Ensure the phone number is exactly 10 digits
                            if (strlen($phone) === 10) {
                                $recepients[] = $phone;
                            }
                        }
                        
                        $data = ['message' => $message, 'recepients' => $recepients];
                        $response = $this->modal->sendSMSData($data);

                        fclose($handle);
                    }
                }

                $response = ['success' => true, 'message' => 'Messages sent Successfully'];
                return $this->response->setJSON($response);
            }
            else{
                $response = ['success' => false, "url" => '', 'message' => 'No_file_attached'];
                return $this->response->setJSON($response);
            }
        }

        return $this->response->setJSON($results);
    }

    function composeNewMessageForm() {
        $response = [];
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        $results = $this->modal1->listRegisteredAcademicYears();
        $data['academic_years'] = $results;
        
        $classes = $this->modal1->listRegisteredSchoolClasses();
        $data['classes'] = $classes;

        $response = $this->modal->listSMSBalance();

        $data['sms_balance'] = $response;

        $response = ['success' => true, "html" => view('user_pages/message_center/compose-form', $data) ];

        return $this->response->setJSON($response);
    }

    function submitPurchaseSMS() {
        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        $paymentMethod = h_post('payment-method');
        $account = h_post('payment-method-account');
        $amount = h_post('amount');
        $sms_cost = h_session('sms_cost');

        $data = ['payment_method' => $paymentMethod, 'account_id' => $account, "amount" => $amount, "added_by_id" => h_session('current_user_id'), "sms_cost" => $sms_cost ];
        $response = $this->modal->purchaseSMSData($data);
        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Request Submitted Successfully';
        }

        return $this->response->setJSON($results);
    }

    function listSMSPurchase() {
        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        $type = h_post('type');
        $data = [];
        if ($type == "form") {
            $response = $this->modal->listSMSBalance();
            $data['sms_balance'] = $response;
            $page = 'user_pages/message_center/purchase-form';
        }
        else {
            $page = 'user_pages/message_center/list-sms-purhase';
            $response = $this->modal->listSMSPurchases();
            $data['sms_purchases'] = $response;
        }

        $response = ['success' => true, "html" => view($page, $data) ];
        return $this->response->setJSON($response);
    }

    function listSMSRequests() {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }
        
        h_set_session('current_page','SMS Requests');
        $data['smsrequests'] = $this->modal->listSMSPurchasesRequests();;
        return view('user_pages/message_center/sms-requests', $data);
    }

    function approveSMSPurchaseRequest() {
        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        $id = h_post('id');
        $response = $this->modal->approvePurchaseSMSData($id);
        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Request Approved Successfully';
        }

        return $this->response->setJSON($results);
    }
}