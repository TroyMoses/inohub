<?php

namespace App\Controllers\user_controllers\users;

use App\Controllers\BaseController;
use App\Models\user_models\M_login;
use App\Models\user_models\academics_settings\M_ManageAcademicYears;

class Login extends BaseController 
{
    
	public function __construct()
	{

    }

    public function index()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        if (h_session('school_id')) {
            return redirect()->route('dashboard');
        }

        return view('user_pages/users/login');
    }


    public function processLogin()
    {
        $username = h_post('username');
        $password = h_post('password');
    
        if (!isset($username) || !isset($password)) {
            return $this->index();
        }

        $M_login = new M_login();
        $response = $M_login->user_login($username,$password);
        
        if ($response->success) {
            $userData = [
                'current_user_id' => $response->id,
                'user_branch_id'    => $response->branch_id,
                'school_id' => $response->school_id,
                'user_name' => $response->user_name,
                'email' => $response->email,
                'logged_in' => true,
                'login_time' => time() * 1000,
                'school_name' => $response->school_name,
                'short_name' => $response->short_name,
                'school_logo' => $response->school_logo,
                'color_hex_code' => $response->color_hex_code,
                'physical_address' => $response->physical_address,
                'city' => $response->city,
                'region' => $response->region,
                'country' => $response->country,
                'date_established' => $response->date_established,
                'phone' => $response->phone,
                'school_db_id' => $response->school_db_id,
                'db_name'      => $response->db_name,
                'current_page' => 'Dashboard',

                'people_id'      => $response->people_id,
                'people_name'      => $response->people_name,
                'people_first_name' => $response->people_first_name,
                'people_last_name' => $response->people_last_name,
                'people_number'    => $response->people_number,
                'person_type'      => $response->person_type,
                'image_url'        => $response->image_url,

                'branch_id'    => $response->branch_id,
                'branch_name'    => $response->branch_name,
                'branch_desc'    => $response->branch_desc,
                'branch_address'    => $response->branch_address,
                'branch_city'    => $response->branch_city,
                'branch_country'    => $response->branch_country,
                'branch_status'    => $response->branch_status,
                'branches'         => $response->branches,
                'access_rights_keys' => $response->access_rights_keys,
                'access_rights_ids'  => $response->access_rights_ids,
                'student_no_prefix' => $response->student_no_prefix,
                'staff_no_prefix' => $response->staff_no_prefix,
                'admission_no_prefix' => $response->admission_no_prefix,
                'sms_cost' => $response->sms_cost
            ];

            h_set_session($userData);
            return redirect()->route('dashboard');
        }
        else{
            // Invalid login, set flash message
            $this->session->setFlashdata('username',$username);
            $this->session->setFlashdata('login_error',"&nbsp;&nbsp;Invalid Login!");

			return $this->index();
        }

    }

    function getCurrentYearDetails()  {
        if ( h_session('currentYearId') != '') {
            return ['currentYearId' => h_session('currentYearId'), 'currentYearName' => h_session('currentYearName') ];
        }
        else {
            $M_currentYear = new M_ManageAcademicYears();

            $currentYear = $M_currentYear->getCurrentYear();
    
            h_set_session('currentYearName', $currentYear ? $currentYear->name :'');
            h_set_session('currentYearId', $currentYear ? $currentYear->id : 0);

            return ['currentYearId' => $currentYear ? $currentYear->id: 0, 'currentYearName' => $currentYear ? $currentYear->name :''];
        }
    }

    public function client_dashboard()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $M_login = new M_login();

        $currentYear = $this->getCurrentYearDetails();
        $currentTermId = h_session('currentTermId') ? h_session('currentTermId'): 0;

        $data['dashboard'] = $M_login->dashboard_statistics($currentYear['currentYearId'], $currentTermId);

        $data['currentYear'] = $currentYear;

        h_set_session('current_page','Dashboard');
        return view('user_pages/dashboard/index', $data);
    }

    public function processLogout()
    {

        h_kill_login_session();

        $msg = '';

        //kill/unset sessions data
		$userData = [
            'school_id' => NULL,
            'username' => NULL,
            'email' => NULL,
            'logged_in' => false
        ];

        h_set_session($userData);

        $session = \Config\Services::session();
        $session->destroy();

        if (h_is_ajax_request()) {
            // Handle AJAX request
            return $this->response->setJSON(['message' => 'Session expired - you have been logged out', "url" => base_url('/serviceAuth/login'), 'status' => 'logged_out']);
        }

		$msg = !$msg ? "Logged out Successfully" : $msg;
		$this->session->setFlashdata('success', $msg);

        return view('user_pages/users/login');
    }
    // $logger = \Config\Services::logger();
    // $logger->debug('sess');

    public function processSwitchBranch()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }
        
        $branchID = h_post('id');
        if ($branchID) {
            $branchID =h_encrypt_decrypt($branchID, 'decrypt');
            $userData = [];
            $branches = h_session('branches') ? h_session('branches'): [];
            foreach ($branches as $key => $branch) {
                if (intval($branch['id']) == intval($branchID)) {
                    $userData['branch_id']    = $branch['id'];
                    $userData['branch_name']    = $branch['branch_name'];
                    $userData['branch_desc']    = $branch['branch_name'];
                    $userData['branch_address']    = $branch['physical_address'];
                    $userData['branch_city']    = $branch['city'];
                    $userData['branch_country']  = $branch['country'];
                    $userData['branch_status'] =  $branch['status'];

                    h_set_session($userData);
                    break;
                }
            }
        }

        return $this->response->setJSON(['message' => 'Switched Branch', "url" => base_url('/dashboard'), 'status' => 'switched']);
    }

    function forgot() {
        return view('user_pages/users/forgot');
    }
}
