<?php

namespace App\Models\user_models\schools;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;
use Config\Database;

class M_ManageSchools extends Model
{
    protected $table = 'schools_registered';
    protected $primaryKey = 'id';
    protected $db; // Database connection instance

    public function __construct(ConnectionInterface $db = null)
    {
        if (!$db) {
            // Load the helper
            helper('h_database');

            // Connect to a dynamic database
            $dbName = "inoc_system_main";
            $db = h_connect_database($dbName);
        }
        $this->db = $db;
    }

    protected function createDatabase($dbName)
    {
        $logger = \Config\Services::logger();

        $response = [
            'success' => false,
            'message' => '',
        ];

        try {
            // Create new database
            $createDbQuery = "CREATE DATABASE IF NOT EXISTS `$dbName`";
            if ($this->db->query($createDbQuery)) {
                $logger->debug("Database $dbName created successfully.");
            } else {
                throw new \Exception("Error creating database $dbName.");
            }

            // Get the list of tables from the source database
            $sourceDb = 'inoc_inocrate_sch';
            $this->db->setDatabase($sourceDb);
            $tables = $this->db->listTables();

            if (empty($tables)) {
                throw new \Exception("No tables found in the source database $sourceDb.");
            }

            // Copy each table structure to the new database
            foreach ($tables as $table) {
                $createTableQuery = $this->db->query("SHOW CREATE TABLE `$table`")->getRowArray()['Create Table'];
                $createTableQuery = preg_replace('/AUTO_INCREMENT=\d+/', '', $createTableQuery);
                $this->db->setDatabase($dbName);

                if (!$this->db->query($createTableQuery)) {
                    throw new \Exception("Error creating table $table in $dbName.");
                }

                // Copy data from the source database to the new database for each table
                if ($table === 'sch_roles' || $table === 'sch_sms_types' || $table === 'sch_grade_ranges') {
                    // Copy data from sch_roles in the source database
                    $this->db->setDatabase($sourceDb);
                    $data = $this->db->table($table)->get()->getResultArray();

                    // Set the target database to the new database
                    $this->db->setDatabase($dbName);

                    // Insert data into sch_roles/sch_sms_types in the new database
                    if (!empty($data)) {
                        $this->db->table($table)->insertBatch($data);
                    }
                }

                $this->db->setDatabase($sourceDb);
            }

            // main_db
            $mainDb = 'inoc_system_main';
            $this->db->setDatabase($mainDb);
            $response['success'] = true;
            $response['message'] = "Database creation completed.";
            $logger->debug("Database creation completed.");
        } catch (\Exception $e) {
            $logger->error($e->getMessage());
            $response['message'] = $e->getMessage();
        }

        return (object) $response;
    }

    public function registerNewSchool($data)
    {
        $response = [
            'success' => false,
            'message' => '',
            'StatusCode' => ''
        ];

        // Post new school data
        $dbName = "rmxbzbmy_inoc_" . $data['school_db_name'];
        $schoolData = $data['school_data'];

        // Create the database
        $schoolDb = $this->createDatabase($dbName);

        if ($schoolDb->success) {
            // Begin transaction
            $this->db->transBegin();

            try {
                // Save database details
                $dbDetails = [
                    'db_name' => $dbName,
                    'db_type' => 'single',
                    'other_info' => '0',
                ];
                $this->db->table('sch_databases')->insert($dbDetails);
                $schoolDBID = $this->db->insertID();

                // // Save school data
                $schoolData['school_db_id'] = $schoolDBID;
                $this->db->table('sch_schools_registered')->insert($schoolData);
                $schoolID = $this->db->insertID();

                // Commit transaction
                $this->db->transCommit();

                // save school admin
                $schoolSysAdmin = $data['school_sys_admin'];
                $schoolSysAdmin['db_name'] = $dbName;
                $schoolSysAdmin['school_id'] = $schoolID;
                $this->registerSchoolAdmin($schoolSysAdmin);

                $response['success'] = true;
                $response['StatusCode'] = '00';
                $response['ID'] = $schoolID;
                $response['message'] = "School registered successfully with ID: $schoolID";
            } catch (\Exception $e) {
                // Rollback transaction on error
                $this->db->transRollback();
                $response['message'] = $e->getMessage();
                $response['StatusCode'] = '57';
            }
        } else {
            $response['StatusCode'] = '50';
            $response['message'] = "Error creating database for school.";
        }

        return (object) $response;
    }

    public function  registerSchoolAdmin($data)
    {
        $response = [];

        $schoolDBName = $data['db_name'];
        $this->db->setDatabase($schoolDBName);
        $userAccountId = 0;

        try {
            // Begin transaction
            $this->db->transBegin();

            // register branch
            $branchData = ["branch_name" => 'Head Office', "branch_descr" => "Head Office", "status" => '0'];
            $this->db->table('sch_branches')->insert($branchData);
            $branchID = $this->db->insertID();

            // rgister people
            $saveData = [
                "name" => $data['sys_admin_name'],
                "gender" => "O",
                "phone" => $data['sys_admin_phone'],
                "email" =>  $data['sys_admin_email'],
                "nationality" => "Ugandan",
                "school_id" => $data['school_id'],
                "branch_id" => $branchID,
                'person_type' => 'Administrator'
            ];

            $this->db->table('sch_people')->insert($saveData);
            $peopleID = $this->db->insertID();

            // Commit transaction
            $this->db->transCommit();

            $this->db->setDatabase('inoc_system_main');

            // Begin transaction
            $this->db->transBegin();

            $userDetails = [
                'school_people_id' => $peopleID,
                'user_name' => $data['sys_admin_username'],
                'password' => md5('password123'),
                'email'    => $data['sys_admin_email'],
                'school_id' => $data['school_id'],
                'branch_id' => $branchID,
                'added_by'  => h_session('current_user_id'),
                'last_updated_by' => h_session('current_user_id')
            ];

            $this->db->table('sch_user_accounts')->insert($userDetails);
            $userAccountId = $this->db->insertID();

            // Commit transaction
            $this->db->transCommit();

            $response['success'] = true;
            $response['StatusCode'] = '00';
        } catch (\Exception $e) {
            // Rollback transaction on error
            $this->db->transRollback();
            $response['message'] = $e->getMessage();
            $response['StatusCode'] = '57';
        }

        $this->db->setDatabase('inoc_system_main');

        // update admin
        $updateInfo = ['admin_user_acc_id' => $userAccountId];
        $this->db->table('sch_schools_registered')
            ->where('id', $data['school_id'])
            ->update($updateInfo);

        return $response;
    }

    public function listRegisteredSchools($status)
    {
        $schools = $this->db->table('sch_schools_registered')
            ->select('*')
            ->where('status', $status)
            ->where('deleted', 0)
            ->get()
            ->getResult();

        return $schools ? $schools : [];
    }

    public function UpdateRegisteredSchool($updateData, $ID)
    {
        try {
            // Start a transaction
            $this->db->transStart();

            // Perform the update
            $this->db->table('sch_schools_registered')
                ->where('id', $ID)
                ->update($updateData);

            // Complete the transaction
            $this->db->transComplete();

            // Check transaction status
            if ($this->db->transStatus() === false) {
                // Log the error if transaction failed
                $logger = \Config\Services::logger();
                $logger->error('Failed to update sch_schools_registered');
            } else {
                // Log success message
                $logger = \Config\Services::logger();
                $logger->info('Successfully updated sch_schools_registered');
            }
        } catch (\Exception $e) {
            // Handle any exceptions and log the error
            $logger = \Config\Services::logger();
            $logger->error('Exception occurred: ' . $e->getMessage());
        }
    }

    public function registerNewBranch($data)
    {
        $response = [];

        $dbName = h_session('db_name');
        $this->db->setDatabase($dbName);

        // Begin transaction
        $this->db->transBegin();
        try {

            $this->db->table('sch_branches')->insert($data);
            $branchID = $this->db->insertID();

            // Commit transaction
            $this->db->transCommit();

            $response['success'] = true;
            $response['StatusCode'] = '00';
            $response['ID'] = $branchID;
            $response['message'] = "branch registered successfully";
        } catch (\Exception $e) {
            // Rollback transaction on error
            $this->db->transRollback();
            $response['message'] = $e->getMessage();
            $response['StatusCode'] = '57';
        }

        $this->db->setDatabase('inoc_system_main');
        return (object) $response;
    }

    public function updateBranch($branchId, $data)
    {
        $response = ['success' => false];

        $dbName = h_session('db_name');
        $this->db->setDatabase($dbName);

        try {
            $this->db->table('sch_branches')
                ->where('id', $branchId)
                ->update($data);

            $response['success'] = true;
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }

        $this->db->setDatabase('inoc_system_main');
        return (object) $response;
    }


    public function listRegisteredBranches()
    {
        $dbName = h_session('db_name');
        $this->db->setDatabase($dbName);
        $branches = $this->db->table('sch_branches')
            ->select('*')
            ->where('status', 0)
            ->where('deleted', 0)
            ->get()
            ->getResult();

        $this->db->setDatabase('inoc_system_main');
        return $branches ? $branches : [];
    }

    function getRegisteredSchoolInfo($ID)
    {
        $school = $this->db->table('sch_schools_registered as registered_sch')
            ->select('registered_sch.*')
            ->where('registered_sch.id', $ID)
            ->get()
            ->getRow();

        return $school;
    }

    function registerSchoolComponents($data)
    {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';

        // Begin transaction
        $this->db->transBegin();

        try {

            $updateData = ['assigned_components' => json_encode($data['grant'])];
            $this->db->table('sch_schools_registered')
                ->where('id', $data['school_id'])
                ->update($updateData);

            // Commit transaction
            $this->db->transCommit();

            $response['success'] = true;
            $response['StatusCode'] = '00';
        } catch (\Exception $e) {
            // Rollback transaction on error
            $this->db->transRollback();
            $response['message'] = $e->getMessage();
            $response['StatusCode'] = '57';
        }

        return (object) $response;
    }
}
