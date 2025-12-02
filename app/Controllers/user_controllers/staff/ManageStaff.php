<?php

namespace App\Controllers\user_controllers\staff;

use App\Controllers\BaseController;
use App\Models\user_models\staff\M_ManageStaff;
use App\Models\user_models\users\M_ManageUsers;

use App\Models\user_models\M_AuditModel;

class ManageStaff extends BaseController 
{
    protected $modal;
    protected $auditModel;

	public function __construct()
	{

        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        // initiate school db connection
        $this->modal = new M_ManageStaff();
        $this->auditModel = new M_AuditModel();
    }

    public function index()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        if (h_is_ajax_request() && h_post('type') == 'add_new_user' ) {
            
            // Handle AJAX request
            $staffList = $this->modal->listStaff('all');
            
            $userModal = new M_ManageUsers();
            $usersList = $userModal->listUsers();

            // Create a list of staff IDs to remove
            $userIdsToRemove = array_column($usersList, 'school_people_id');

            // Filter the stafflist
            $filteredStaffList = array_filter($staffList, function ($staff) use ($userIdsToRemove) {
                return !in_array($staff->id, $userIdsToRemove);
            });

            // Reset array keys
            $filteredStaffList = array_values($filteredStaffList);

            return $this->response->setJSON(['staff' => $filteredStaffList, 'status' => true ]);
        }

        h_set_session('current_page','List Staff');
        $data['staff_list'] = $this->modal->listStaff();
        return view('user_pages/staff/list-staff', $data);
    }

    public function submitNewStaffForm()
    {

        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }
        
        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $staffName = h_post('staff_name');
        $dob = h_post('dob');
        $gender = h_post('gender');
        $address = h_post('address');
        $country = h_post('country');
        $identityType = h_post('identity_type');
        $identityNo = h_post('identity_no');
        $phone = h_post('phone');
        $email = h_post('email');
        $photo = h_file_post('photo');
        $roles = h_post('roles');
        $staffNo = h_post('staff_no')? h_post('staff_no'): $this->modal->generateStaffNumber();
        $department = h_post('department');
        $initials = h_post('initials');

        $data = ["name" => $staffName, "gender" => $gender, "phone" => $phone, 
                "email" => $email, "nationality" => $country, "id_type" => $identityType, "id_no" => $identityNo,
                "school_id" => h_session('school_id'), "dob" => $dob, "physical_address" => $address, "country" => $country,
                "people_number" => $staffNo, 'branch_id' => h_session('branch_id'), 'person_type' => 'Staff', 
                'department_id' => $department, 'initials' => $initials ];
        
        $response = $this->modal->saveNewStaff($data, $roles);
        if ($response->success) {
            if ($photo) {
                $url = h_upload_file_uploads($photo, $response->ID, 'profile');
                if ($url) {

                    // updated staff image
                    $updateData = ["image_url" => $url];
                    $this->modal->updateStaff($updateData, $response->ID);
                }
            }

            // Log the action in the audit trail
            $user_id = h_session('current_user_id');
            $data['roles'] = $roles;
            $this->auditModel->logAudit($user_id, 'create', 'staff', $response->ID, $data);

            $results['success'] = true;
            $results['message'] = 'Staff Registered Successfully';
        }

        return $this->response->setJSON($results);
    }

    public function submitNewDepartmentForm()
    {
        $results = [];

        if (h_is_get_post_request('GET')) {
            $staffList = $this->modal->listStaff('all');
            $listDepartments = $this->modal->listDepartments();
            return $this->response->setJSON(['staff' => $staffList, 'departments' => $listDepartments, 'status' => true ]);
        }

        $name = h_post('name');
        $departmentHead = h_post('department_head');
        $shortName = h_post('short_name');
        $departmentStatus = h_post('department_status');
        $parentDepartment = h_post('parent_department');

        $data = ['name' => $name, 'short_name' => $shortName, 'status' => $departmentStatus, 'parent_department_id' => $parentDepartment, 
                'school_id' => h_session('school_id'), 'branch_id' => h_session('branch_id'), 'head_people_id' => $departmentHead ];

        $response = $this->modal->saveNewDepartment($data);
        if ($response->success) {

            // Log the action in the audit trail
            $user_id = h_session('current_user_id');
            $this->auditModel->logAudit($user_id, 'create', 'department', $response->ID, $data);

            $results['success'] = true;
            $results['message'] = 'Department Registered Successfully';
        }
        return $this->response->setJSON($results);
    }

    public function listDepartments()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }


        $departments = $this->modal->listDepartments();
        if (h_is_ajax_request()) {
            // Handle AJAX request
            return $this->response->setJSON(['success' => true, 'departments' => $departments] );
        }

        $data['departments'] = $departments;
        h_set_session('current_page','List Departments');
        return view('user_pages/staff/list-departments', $data);
    }

    public function editDepartmentView()
    {
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }
        
        $deptId = h_post('department_id');
        $department = $this->modal->getDepartment($deptId);
        $staffList = $this->modal->listStaff('all');
        $departments = $this->modal->listDepartments();

        $data = [
            'department' => $department,
            'staff' => $staffList,
            'departments' => $departments
        ];

        $response = ['success' => true, 'html' => view('user_pages/staff/edit-department', $data)];
        return $this->response->setJSON($response);
    }

    public function submitEditDepartmentForm()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = ['success' => false, 'message' => 'Error Occurred'];

        $id = h_post('department_id');
        $data = [
            'name' => h_post('name'),
            'short_name' => h_post('short_name'),
            'status' => h_post('department_status'),
            'parent_department_id' => h_post('parent_department'),
            'head_people_id' => h_post('department_head'),
            'school_id' => h_session('school_id'),
            'branch_id' => h_session('branch_id')
        ];

        $response = $this->modal->updateDepartment($data, $id);

        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Department updated successfully';
        }

        return $this->response->setJSON($results);
    }

    function editStaffView() {
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        $type = h_post('type');
        $staffId = h_post('staff_id');
        $data['departments'] = [];
        
        $page = "user_pages/staff/view-staff";
        if ($type == 'edit') {
            $listDepartments = $this->modal->listDepartments();
            $data['departments'] = $listDepartments;
            $page = "user_pages/staff/edit-staff";
        }

        $data['staff'] = $this->modal->getStaff($staffId);
        $response = ['success' => true, "html" => view($page, $data) ];
        return $this->response->setJSON($response);
    }

    function submitEditStaffForm() {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }
        
        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $staffName = h_post('staff_name');
        $dob = h_post('dob');
        $gender = h_post('gender');
        $address = h_post('address');
        $country = h_post('country');
        $identityType = h_post('identity_type');
        $identityNo = h_post('identity_no');
        $phone = h_post('phone');
        $email = h_post('email');
        // $photo = h_file_post('photo');
        $roles = h_post('roles');
        $staffNo = h_post('staff_no');
        $department = h_post('department');
        $staffId = h_post('staff_id');
        $initials = h_post('initials');

        $data = ["name" => $staffName, "gender" => $gender, "phone" => $phone, 
                "email" => $email, "nationality" => $country, "id_type" => $identityType, "id_no" => $identityNo,
                "dob" => $dob, "physical_address" => $address, "country" => $country,
                "people_number" => $staffNo,'department_id' => $department, 'initials' => $initials ];
        $response = $this->modal->updateStaff($data, $staffId);
        if ($response->success) {
            $this->modal->addUpdateStaffRoles($roles, $staffId);

            // Log the action in the audit trail
            $user_id = h_session('current_user_id');
            $this->auditModel->logAudit($user_id, 'update', 'staff', $staffId, $data);

            $results['success'] = true;
            $results['message'] = 'Staff Update Successfully';
        }

        return $this->response->setJSON($results);
    }
}