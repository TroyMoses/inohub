<?php

namespace App\Controllers\user_controllers\schools;

use App\Controllers\BaseController;
use App\Models\user_models\schools\M_ManageSchools;
use App\Models\user_models\users\M_ManageUsers;

class SchoolSetup extends BaseController
{
    protected $modal;

    public function __construct()
    {

        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        // initiate school db connection
        $this->modal = new M_ManageSchools();
        $this->modal1 = new M_ManageUsers();
    }

    public function index()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        if (h_session('school_id')) {
            h_set_session('current_page', 'Dashboard');
            return redirect()->route('dashboard');
        }

        return view('user_pages/users/login');
    }

    public function activeApprovedSchools()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $data['schools'] = $this->modal->listRegisteredSchools('approved');
        h_set_session('current_page', 'Active Schools');
        return view('user_pages/schools/active-approved-schools', $data);
    }

    public function submitNewSchoolForm()
    {

        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = [];
        $schoolName = h_post('school_name');
        $htSigniture = h_file_post('ht_signiture');
        $shortName = h_post('school_short_name');
        $schoolCode = h_post('school_code');
        $regNumber = h_post('registration_number');
        $schoolDatabase = h_post('school_database');
        $district = h_post('district');
        $address = h_post('address');
        $country = h_post('country');
        $region = h_post('region');
        $contactPhone = h_post('contact_phone');
        $contactEmail = h_post('contact_email');
        $dateEstablished = h_post('date_established');
        $schoolLogo = h_file_post('school_logo');
        $schoolColorCode = h_post('school_color_code');
        $htName = h_post('ht_name');
        $htPhone = h_post('ht_phone');
        $htEmail = h_post('ht_email');
        $htSigniture = h_file_post('ht_signiture');

        $sysAdminName = h_post('sys_admin_name');
        $sysAdminPhone = h_post('sys_admin_phone');
        $sysAdminEmail = h_post('sys_admin_email');
        $sysAdminUsername = h_post('sys_admin_username');

        $schoolPoBox = h_post('school_po_box');

        $staffNoPrefix = h_post('staff_no_prefix');
        $studentNoPrefix = h_post('student_no_prefix');
        $admissionNoPrefix = h_post('admission_no_prefix');

        $dbString = str_replace(' ', '_', $schoolDatabase);
        $data = ['school_db_name' => $dbString];
        $schoolData = [
            'reg_no' => $regNumber,
            'school_code' => $schoolCode,
            'school_name' => $schoolName,
            'short_name' => $shortName,
            'country' => $country,
            'region' => $region,
            'city' => $district,
            'physical_address' => $address,
            'institution_type' => 'primary',
            'po_box' => $schoolPoBox,
            'date_established' => $dateEstablished,
            'news_letter' => '0',
            'terms_agree' => '0',
            'phone' => $contactPhone,
            'email' => $contactEmail,
            'school_logo' => '',
            'color_hex_code' => $schoolColorCode,
            'head_teacher_name' => $htName,
            'head_teacher_email' => $htEmail,
            'head_teacher_phone' => $htPhone,
            'status' => 'approved',
            'gender_type' => 'Both',
            'residence_type' => 'all',
            'website' => '0',
            'staff_no_prefix' => $staffNoPrefix,
            'student_no_prefix' => $studentNoPrefix,
            'admission_no_prefix' => $admissionNoPrefix,
            'assigned_components' => json_encode([1])
        ];

        $adminData = [
            'sys_admin_name' => $sysAdminName,
            'sys_admin_phone' => $sysAdminPhone,
            'sys_admin_email' => $sysAdminEmail,
            'sys_admin_username' => $sysAdminUsername,
        ];

        $data['school_data'] = $schoolData;
        $data['school_sys_admin'] = $adminData;
        $response = $this->modal->registerNewSchool($data);
        if ($response->success) {

            // upload Image
            if ($schoolLogo) {
                $url = h_upload_file_uploads($schoolLogo, $response->ID, 'logo');
                if ($url) {
                    $updateData = ['school_logo' => $url];
                    $this->modal->UpdateRegisteredSchool($updateData, $response->ID);
                }
            }

            $results['success'] = true;
            $results['message'] = 'School Registered Successfully';
        } else if ($response->StatusCode == '57') {
            $results['success'] = false;
            $results['message'] = 'Error Occured';
        } else if ($response->StatusCode == '50') {
            $results['success'] = false;
            $results['message'] = 'Error Creating Database';
        }

        return $this->response->setJSON($results);
    }

    public function schoolBranches()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $data['branches'] = $this->modal->listRegisteredBranches();
        h_set_session('current_page', 'List Branches');
        return view('user_pages/schools/list-branches', $data);
    }

    public function submitNewBranchForm()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $branchName = h_post('branch_name');
        $branchNo = h_post('branch_no');
        $address = h_post('address');
        $email = h_post('email');
        $phone = h_post('phone');
        $prefix = h_post('branch_prefix');
        $district = h_post('district');
        $region = h_post('region');
        $country = h_post('country');

        $data = [
            "branch_name" => $branchName,
            "branch_descr" =>  $branchName,
            "status" => '0',
            'physical_address' => $address,
            'city' => $district,
            'country' => $country,
            'region' => $region,
            'phone' => $phone,
            'email' => $email,
            'prefix' => $prefix,
            'branch_no' => $branchNo
        ];
        $response = $this->modal->registerNewBranch($data);

        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Branch Registered Successfully';
        }

        return $this->response->setJSON($results);
    }

    public function editBranchView()
    {
        if (!is_logged_in()) {
            $response = ['success' => false, 'url' => base_url('/serviceAuth/logout')];
            return $this->response->setJSON($response);
        }

        $branchId = h_post('id');
        if (!$branchId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid branch ID']);
        }

        $branches = $this->modal->listRegisteredBranches();
        $branch = null;

        // Find branch by ID
        foreach ($branches as $b) {
            if ($b->id == $branchId) {
                $branch = $b;
                break;
            }
        }

        if (!$branch) {
            return $this->response->setJSON(['success' => false, 'message' => 'Branch not found']);
        }

        $data['branch'] = $branch;
        $html = view('user_pages/schools/edit-branch', $data);
        return $this->response->setJSON(['success' => true, 'html' => $html]);
    }

    public function updateBranch()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = ['success' => false, 'message' => 'Error Occurred'];

        $branchId = h_post('branch_id');
        $data = [
            'branch_name' => h_post('branch_name'),
            'branch_no' => h_post('branch_no'),
            'prefix' => h_post('branch_prefix'),
            'phone' => h_post('phone'),
            'email' => h_post('email'),
            'physical_address' => h_post('address'),
            'city' => h_post('district'),
            'region' => h_post('region'),
            'country' => h_post('country'),
        ];

        $response = $this->modal->updateBranch($branchId, $data);

        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Branch updated successfully.';
        } else {
            $results['message'] = $response->message ?? 'Failed to update.';
        }

        return $this->response->setJSON($results);
    }

    public function getHeaderFooter()
    {
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];
        }

        $footer = view('user_pages/includes/footer');
        $header = view('user_pages/includes/header');
        $response = ['footer' => $footer, 'header' => $header, 'success' => true];
        return $this->response->setJSON($response);
    }

    function viewSchoolInfo()
    {
        $schoolId = h_post('school_id');
        $type = h_post('type');
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        $school = $this->modal->getRegisteredSchoolInfo($schoolId);
        $data = [];
        $page = "user_pages/schools/school-basic-info";
        if ($type == 'edit-basic') {
            $page = "user_pages/schools/school-details-edit";
        }

        if ($type == 'features') {
            $page = "user_pages/schools/list-school-comps";

            $results = $this->modal1->getAllComponentTree();
            $data['componentTree'] = $results;
            $data['system_components'] = $school && $school->assigned_components ? json_decode($school->assigned_components) : [];
        }

        if ($type == 'general-settings') {
            $page = "user_pages/schools/school-general-settings";
        }

        $data['school'] = $school;
        $data['schoolId'] = $schoolId;
        $response = ['success' => true, "html" => view($page, $data)];
        return $this->response->setJSON($response);
    }

    function submitSchoolComponents()
    {
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        $grant = h_post('grant');
        $schoolId = h_post('school_id');

        $data = ['grant' => $grant, 'school_id' => $schoolId];
        $response = $this->modal->registerSchoolComponents($data);

        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Access Updated Successfully';
        }

        return $this->response->setJSON($results);
    }

    function submitGeneralSchoolSettings()
    {
        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        $sms_cost = h_post('sms_cost');
        $school_id = h_post('school_id');
        if ($sms_cost && $school_id) {
            $updateData = ['sms_cost' => $sms_cost];
            $this->modal->UpdateRegisteredSchool($updateData, $school_id);
        }

        $results['success'] = true;
        $results['message'] = 'Settings Updated Successfully';

        return $this->response->setJSON($results);
    }
}
