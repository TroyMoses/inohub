<?php

namespace App\Models\user_models\users;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;
use Config\Database;

class M_ManageUsers extends Model
{

    protected $db; // Database connection instance

    public function __construct(ConnectionInterface $db = null)
    {
        parent::__construct();

        if (!$db) {
            $dbName = 'inoc_system_main';

            // Load the helper
            helper('h_database');

            // Connect to a dynamic database
            $db = h_connect_database($dbName);
        }
        $this->db = $db;
    }

    public function listUsers()
    {
        // Get the school database name from the session
        $dbName = h_session('db_name');
        $users = $this->db->table('sch_user_accounts as user_accounts')
            ->select('user_accounts.*, sch_other_table.name, sch_access_groups.group_name')
            ->where('user_accounts.deleted', 0)
            ->where('user_accounts.branch_id', h_session('branch_id'))
            ->where('user_accounts.school_id', h_session('school_id'))
            ->join("$dbName.sch_people as sch_other_table", 'user_accounts.school_people_id = sch_other_table.id', 'left')
            ->join("$dbName.sch_user_groups as sch_user_groups", 'sch_user_groups.user_id = sch_other_table.id', 'left')
            ->join("$dbName.sch_access_groups as sch_access_groups", 'sch_user_groups.access_group_id = sch_access_groups.id', 'left')
            ->get()
            ->getResult();

        return $users ? $users : [];
    }

    public function addUser($data)
    {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';

        // Begin transaction
        $this->db->transBegin();

        try {

            $this->db->table('sch_user_accounts')->insert($data);
            $userID = $this->db->insertID();

            // Commit transaction
            $this->db->transCommit();

            $response['success'] = true;
            $response['StatusCode'] = '00';
            $response['ID'] = $userID;
        } catch (\Exception $e) {
            // Rollback transaction on error
            $this->db->transRollback();
            $response['message'] = $e->getMessage();
        }

        return (object) $response;
    }

    function addUserRole($data, $userAccountsId = 0)
    {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';

        if ($userAccountsId > 0) {
            $user = $this->db->table('sch_user_accounts')
                ->select('*')
                ->where('id', $userAccountsId)
                ->get()
                ->getRow();
            if ($user) {
                $data['user_id'] = $user->school_people_id;
            }
        }

        $dbName = h_session('db_name');
        $this->db->setDatabase($dbName);

        // Begin transaction
        $this->db->transBegin();
        try {

            $this->db->table('sch_user_groups')->insert($data);
            $userID = $this->db->insertID();

            // Commit transaction
            $this->db->transCommit();

            $response['success'] = true;
            $response['StatusCode'] = '00';
            $response['ID'] = $userID;
        } catch (\Exception $e) {
            // Rollback transaction on error
            $this->db->transRollback();
            $response['message'] = $e->getMessage();
        }

        $this->db->setDatabase('inoc_system_main');
        return (object) $response;
    }

    public function updateUserAccount($updateData, $ID)
    {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';

        try {
            // Start a transaction
            $this->db->transStart();

            // Perform the update
            $this->db->table('sch_user_accounts')
                ->where('id', $ID)
                ->update($updateData);

            // Complete the transaction
            $this->db->transComplete();

            // Check transaction status
            if ($this->db->transStatus()) {
                $response['success'] = true;
                $response['StatusCode'] = '00';
            }
        } catch (\Exception $e) {
            // Handle any exceptions and log the error
            $response['message'] = $e->getMessage();
        }

        return (object) $response;
    }

    public function listUserGroups()
    {
        $dbName = h_session('db_name');
        $this->db->setDatabase($dbName);
        $userGroups = $this->db->table('sch_access_groups')
            ->select('*')
            ->where('deleted', 0)
            ->where('branch_id', h_session('branch_id'))
            ->get()
            ->getResult();

        $this->db->setDatabase('inoc_system_main');
        return $userGroups ? $userGroups : [];
    }

    public function registerUserGroup($data)
    {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';

        try {

            $dbName = h_session('db_name');
            $this->db->setDatabase($dbName);

            // Start a transaction
            $this->db->transStart();

            $this->db->table('sch_access_groups')->insert($data);
            $userGroupID = $this->db->insertID();

            // Commit transaction
            $this->db->transCommit();

            $response['success'] = true;
            $response['StatusCode'] = '00';
            $response['ID'] = $userGroupID;

            $this->db->setDatabase('inoc_system_main');
        } catch (\Exception $e) {
            // Handle any exceptions and log the error
            $response['message'] = $e->getMessage();
        }

        return (object) $response;
    }

    public function updateUserGroup($groupId, $updateData)
    {
        $response = ['success' => false, 'StatusCode' => '57'];

        try {
            $dbName = h_session('db_name');
            $this->db->setDatabase($dbName);

            $this->db->table('sch_access_groups')
                ->where('id', $groupId)
                ->update($updateData);

            $response['success'] = true;
            $response['StatusCode'] = '00';

            $this->db->setDatabase('inoc_system_main'); // revert DB
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }

        return (object) $response;
    }


    public function getAllComponentTree($parentId = null)
    {
        // Retrieve components with the given parent_id (or NULL for root elements)
        $components = $this->db->table('sch_system_components')
            ->select('*')
            ->where('parent_id', $parentId)
            ->get()
            ->getResult();

        $tree = [];
        foreach ($components as $component) {
            // Recursively fetch children for the current component
            $children = $this->getAllComponentTree($component->id);
            if (!empty($children)) {
                $component->children = $children;
            }
            $tree[] = $component;
        }

        return $tree;
    }

    public function getComponentTree($parentId = null)
    {
        // Retrieve components with the given parent_id (or NULL for root elements)
        $components = $this->db->table('sch_system_components')
            ->select('*')
            ->where('parent_id', $parentId)
            ->get()
            ->getResult();

        $tree = [];
        $assigned_components = [];

        $school = $this->db->table('sch_schools_registered')
            ->select('*')
            ->where('id', h_session('school_id'))
            ->get()
            ->getRow();

        if ($school && $school->assigned_components) {
            $assigned_components = json_decode($school->assigned_components);
        }

        foreach ($components as $component) {

            // school components only
            if (in_array($component->id, $assigned_components)) {

                // Recursively fetch children for the current component
                $children = $this->getComponentTree($component->id);
                if (!empty($children)) {
                    $component->children = $children;
                }
                $tree[] = $component;
            }
        }

        return $tree;
    }

    function getComponentTreeIds($Ids, $listChild = true)
    {

        // Initialize an array to hold all component IDs
        $allComponentIds = [];

        foreach ($Ids as $key => $parentId) {
            if ($listChild) {
                $components = $this->db->table('sch_system_components')
                    ->select('*')
                    ->where('parent_id', $parentId)
                    ->get()
                    ->getResult();
                if ($components) {

                    // Create an array of component IDs
                    $componentIds = array_map(function ($component) {
                        return $component->id; // Assuming 'id' is the name of the ID field in the database
                    }, $components);

                    // Merge the current component IDs into the allComponentIds array
                    $allComponentIds = array_merge($allComponentIds, $componentIds);

                    // Recursively fetch child components for the current component IDs
                    $allComponentIds = array_merge($allComponentIds, $this->getComponentTreeIds($componentIds, $listChild));
                }
            } else {
                // Fetch the component where the id matches the childId
                $component = $this->db->table('sch_system_components')
                    ->select('*')
                    ->where('id', $parentId)
                    ->get()
                    ->getRow();  // We expect a single row (the parent component)

                if ($component && $component->parent_id) {
                    // Add the parent ID to the list
                    $parentId = $component->parent_id;
                    $allComponentIds[] = $parentId;

                    // Recursively fetch parents of this parent (if any)
                    $allComponentIds = array_merge($allComponentIds, $this->getComponentTreeIds([$parentId], $listChild));
                }
            }
        }

        return array_unique($allComponentIds);
    }

    function registerUserGroupComponents($data)
    {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';
        $updateData = ['system_components' => json_encode($data['grants'])];
        $groupId = $data['group'];

        try {

            $dbName = h_session('db_name');
            $this->db->setDatabase($dbName);

            // Start a transaction
            $this->db->transStart();

            // Perform the update
            $this->db->table('sch_access_groups')
                ->where('id', $groupId)
                ->update($updateData);

            // Complete the transaction
            $this->db->transComplete();

            // Check transaction status
            if ($this->db->transStatus()) {
                $response['success'] = true;
                $response['StatusCode'] = '00';
            }
        } catch (\Exception $e) {
            // Handle any exceptions and log the error
            $response['message'] = $e->getMessage();
        }

        $this->db->setDatabase('inoc_system_main');
        return (object) $response;
    }

    function getUserGroupById($ID)
    {
        $dbName = h_session('db_name');
        $this->db->setDatabase($dbName);

        $userGroup = $this->db->table('sch_access_groups')
            ->select('*')
            ->where('id', $ID)
            ->get()
            ->getRow();

        $this->db->setDatabase('inoc_system_main');
        return $userGroup;
    }

    function getUserDetails($ID)
    {

        $dbName = h_session('db_name');
        $user = $this->db->table('sch_user_accounts as user_accounts')
            ->select('user_accounts.*, sch_other_table.name, sch_access_groups.group_name, sch_user_groups.access_group_id, sch_other_table.id as people_id')
            ->where('user_accounts.id', $ID)
            ->join("$dbName.sch_people as sch_other_table", 'user_accounts.school_people_id = sch_other_table.id', 'left')
            ->join("$dbName.sch_user_groups as sch_user_groups", 'sch_user_groups.user_id = sch_other_table.id', 'left')
            ->join("$dbName.sch_access_groups as sch_access_groups", 'sch_user_groups.access_group_id = sch_access_groups.id', 'left')
            ->get()
            ->getRow();

        return $user;
    }

    function updateUser($data)
    {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';

        try {
            $userId = $data['user_id'];
            $peopleId = $data['people_id'];

            $updateData = ['status' => $data['account_status'], 'is_2fa' => $data['is_two_factor']];
            if ($data['password']) {
                $updateData['password'] = md5($data['password']);
            }

            // Start a transaction
            $this->db->transStart();

            // Perform the update
            $this->db->table('sch_user_accounts')
                ->where('id', $userId)
                ->update($updateData);

            // Complete the transaction
            $this->db->transComplete();

            // Check transaction status
            if ($this->db->transStatus()) {
                $response['success'] = true;
                $response['StatusCode'] = '00';

                $dbName = h_session('db_name');
                $this->db->setDatabase($dbName);

                $peopleUpdateAcc = ['access_group_id' => $data['user_group']];

                $userAccess = $this->db->table('sch_user_groups')
                    ->select('*')
                    ->where('user_id', $peopleId)
                    ->get()
                    ->getRow();

                if ($userAccess) {
                    $this->db->table('sch_user_groups')
                        ->where('user_id', $peopleId)
                        ->update($peopleUpdateAcc);
                } else {
                    $peopleUpdateAcc['user_id'] = $peopleId;
                    $peopleUpdateAcc['branch_id'] = h_session('branch_id');
                    $peopleUpdateAcc['section_id'] = 0;
                    $peopleUpdateAcc['added_by'] = h_session('current_user_id');
                    $this->db->table('sch_user_groups')->insert($peopleUpdateAcc);
                }
            }
        } catch (\Exception $e) {
            // Handle any exceptions and log the error
            $response['message'] = $e->getMessage();
        }

        $this->db->setDatabase('inoc_system_main');
        return (object) $response;
    }
}
