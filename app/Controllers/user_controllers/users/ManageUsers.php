<?php

namespace App\Controllers\user_controllers\users;

use App\Controllers\BaseController;
use App\Models\user_models\users\M_ManageUsers;

class ManageUsers extends BaseController
{

    protected $modal;

    public function __construct()
    {

        // initiate school db connection
        $this->modal = new M_ManageUsers();
    }


    public function index()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }


        $users = $this->modal->listUsers();

        if (h_is_ajax_request()) {
            return $this->response->setJSON(['users' => $users, 'success' => true]);
        }

        $data['users'] = $users;
        h_set_session('current_page', 'List Users');
        return view('user_pages/users/list-users', $data);
    }

    public function submitNewUserForm()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $staff = h_post('staff');
        $userGroup = h_post('user_group');
        $username = h_post('username');
        $password = h_post('password');
        $status = h_post('account_status');
        $isTwoFactor = h_post('is_two_factor');

        $data = [
            'school_people_id' => $staff,
            'user_name' => $username,
            'password' => md5($password),
            'school_id' => h_session('school_id'),
            'branch_id' => h_session('branch_id'),
            'status' => $status,
            'is_2fa' => $isTwoFactor
        ];
        $response = $this->modal->addUser($data);

        if ($response->success) {

            $role = ['access_group_id' => $userGroup, 'user_id' => 0, 'added_by' => h_session('current_user_id'), 'branch_id' => h_session('branch_id'), 'section_id' => 0];
            $this->modal->addUserRole($role, $response->ID);

            $results['success'] = true;
            $results['message'] = 'User Registered Successfully';
        }

        return $this->response->setJSON($results);
    }

    public function submitEditUserAccountForm()
    {
        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        if (!is_logged_in()) {
            $results = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($results);
        }

        $password = h_post('password');
        $data = ['password' => md5($password)];
        $response = $this->modal->updateUserAccount($data, h_session('current_user_id'));
        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'User Account Updated Successfully';
        }

        return $this->response->setJSON($results);
    }

    public function listUserGroups()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $userGroups = $this->modal->listUserGroups();
        h_set_session('current_page', 'List Users Group');

        if (h_is_ajax_request()) {
            return $this->response->setJSON(['userGroups' => $userGroups, 'status' => true]);
        }
        $data['userGroups'] = $userGroups;
        return view('user_pages/users/list-user-groups', $data);
    }

    public function submitNewUserGroupForm()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $groupName = h_post('user-group-name');
        $groupDesc = h_post('user-group-description');

        $data = ["group_name" => $groupName, "group_descr" => $groupDesc, "added_by_id" => h_session('current_user_id'), "branch_id" => h_session('branch_id'), 'system_components' => json_encode([])];
        $response = $this->modal->registerUserGroup($data);
        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'User Account Updated Successfully';
        }

        return $this->response->setJSON($results);
    }

    public function updateUserGroup()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = ['success' => false, 'message' => 'Error Occurred'];

        $groupId = h_post('user_group_id');
        $groupName = h_post('user_group_name');
        $groupDesc = h_post('user_group_description');

        if ($groupId && $groupName && $groupDesc) {
            $updateData = [
                'group_name' => $groupName,
                'group_descr' => $groupDesc,
            ];

            $response = $this->modal->updateUserGroup($groupId, $updateData);

            if ($response->success) {
                $results['success'] = true;
                $results['message'] = 'User group updated successfully.';
            } else {
                $results['message'] = $response->message ?? 'Failed to update user group.';
            }
        } else {
            $results['message'] = 'Missing required fields.';
        }

        return $this->response->setJSON($results);
    }


    public function listUserGroupComponents()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }
        $group = h_get('group');

        $results = $this->modal->getComponentTree();
        $data['componentTree'] = $results;

        $data['group'] = $this->modal->getUserGroupById($group);

        $response = ['success' => true, "html" => view('user_pages/users/list-user-group-comps', $data)];
        return $this->response->setJSON($response);
    }

    public function submitUserGroupComponents()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $grants = h_post('grant');
        $group =  h_post('group');

        $data = ["grants" => $grants, 'group' => $group];
        $response = $this->modal->registerUserGroupComponents($data);
        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Access Updated Successfully';
        }

        return $this->response->setJSON($results);
    }

    function editUserAccountView()
    {
        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        if (!is_logged_in()) {
            $results = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($results);
        }

        $userId =  h_post('user_id');
        $data['user'] = $this->modal->getUserDetails($userId);

        $userGroups = $this->modal->listUserGroups();
        $data['userGroups'] = $userGroups;

        $response = ['success' => true, "html" => view('user_pages/users/edit-user', $data)];
        return $this->response->setJSON($response);
    }

    function submitEditUserForm()
    {
        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        if (!is_logged_in()) {
            $results = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($results);
        }

        $userGroup = h_post('user_group');
        $password = h_post('password');
        $status = h_post('account_status');
        $userId = h_post('user_id');
        $peopleId = h_post('people_id');
        $isTwoFactor = h_post('is_two_factor');

        $data = ['user_group' => $userGroup, 'password' => $password, 'account_status' => $status, 'user_id' => $userId, 'people_id' => $peopleId, 'is_two_factor' => $isTwoFactor];
        $response = $this->modal->updateUser($data);
        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'User Updated Successfully';
        }

        return $this->response->setJSON($results);
    }
}
