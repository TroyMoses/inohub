<?php

namespace App\Models\user_models\staff;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;
use Config\Database;

class M_ManageStaff extends Model
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

    public function saveNewStaff($data, $roles = [])
    {
       $response = [];
       $response['success'] = false;
       $response['StatusCode'] = '57';

       // Begin transaction
       $this->db->transBegin();

       try {

            $this->db->table('sch_people')->insert($data);
            $staffID = $this->db->insertID();

            // Commit transaction
            $this->db->transCommit();

            $response['success'] = true;
            $response['StatusCode'] = '00';
            $response['ID'] = $staffID;

            // roles
            $this->addUpdateStaffRoles($roles, $staffID);
        } catch (\Exception $e) {
            // Rollback transaction on error
            $this->db->transRollback();
            $response['message'] = $e->getMessage();
        }

       return (object) $response;
    }


    public function updateStaff($updateData, $ID)
    {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';

        try {
            // Start a transaction
            $this->db->transStart();
        
            // Perform the update
            $this->db->table('sch_people')
                ->where('id', $ID)
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
                $logger->info('Successfully updated');

                $response['success'] = true;
                $response['StatusCode'] = '00';
            }
        } catch (\Exception $e) {
            // Handle any exceptions and log the error
            $logger = \Config\Services::logger();
            $logger->error('Exception occurred: ' . $e->getMessage());
            
            $response['message'] = $e->getMessage();
        }

        return (object) $response;
    }

    public function listStaff($status = 'active')
    {
        if ($status == 'all') {
            $staff = $this->db->table('sch_people as people')
                    ->select('people.*, dep.name as dep_name')
                    ->where('people.deleted', 0)
                    ->where('people.person_type', 'Staff')
                    ->where('people.branch_id', h_session('branch_id'))
                    ->where('people.school_id', h_session('school_id'))
                    ->join("sch_departments as dep", 'dep.id = people.department_id', 'left')
                    ->get()
                    ->getResult();
        }
        else{
            $staff = $this->db->table('sch_people as people')
                    ->select('people.*, dep.name as dep_name')
                    ->where('people.deleted', 0)
                    ->where('people.status', $status)
                    ->where('people.person_type', 'Staff')
                    ->where('people.branch_id', h_session('branch_id'))
                    ->where('people.school_id', h_session('school_id'))
                    ->join("sch_departments as dep", 'dep.id = people.department_id', 'left')
                    ->get()
                    ->getResult();
        }
        
        return $staff ? $staff : [];
    }


    public function listDepartments()
    {
        $departments = $this->db->table('sch_departments AS depart')
                ->select('depart.*, people.name AS person_name, people.first_name, people.last_name, people.people_number')
                ->where('depart.deleted', 0)
                ->where('depart.status', 0)
                ->where('depart.branch_id', h_session('branch_id'))
                ->where('depart.school_id', h_session('school_id'))
                ->join('sch_people AS people', 'people.id = depart.head_people_id', 'left')
                ->get()
                ->getResult();
     
        return $departments ? $departments : [];
    }

    public function saveNewDepartment($data)
    {
       $response = [];
       $response['success'] = false;
       $response['StatusCode'] = '57';

       // Begin transaction
       $this->db->transBegin();

       try {

            $this->db->table('sch_departments')->insert($data);
            $id = $this->db->insertID();

            // Commit transaction
            $this->db->transCommit();

            $response['success'] = true;
            $response['StatusCode'] = '00';
            $response['ID'] = $id;

        } catch (\Exception $e) {
            // Rollback transaction on error
            $this->db->transRollback();
            $response['message'] = $e->getMessage();
        }

       return (object) $response;
    }

    public function getDepartment($id)
    {
        return $this->db->table('sch_departments')
            ->where('id', $id)
            ->where('deleted', 0)
            ->get()
            ->getRow();
    }

    public function updateDepartment($data, $id)
    {
        $response = ['success' => false, 'StatusCode' => '57'];

        try {
            $this->db->transStart();

            $this->db->table('sch_departments')
                ->where('id', $id)
                ->update($data);

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                $response['message'] = 'Failed to update';
            } else {
                $response['success'] = true;
                $response['StatusCode'] = '00';
            }
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }

        return (object) $response;
    }

    public function listSchoolTeachers()
    {
        $staff = $this->db->table('sch_teacher as teacher')
                ->select('people.*')
                ->where('people.deleted', 0)
                ->where('teacher.deleted', 0)
                ->where('people.person_type', 'Staff')
                ->where('people.branch_id', h_session('branch_id'))
                ->where('people.school_id', h_session('school_id'))
                ->join('sch_people AS people', 'people.id = teacher.people_id')
                ->get()
                ->getResult(); 

        return $staff ? $staff : [];
    }

    function getStaff($ID) {
        $roleKeys = [];
        $staff = $this->db->table('sch_people as people')
                ->select('people.*, dep.name as dep_name, dep.id as dep_id')
                ->where('people.id', $ID)
                ->join("sch_departments as dep", 'dep.id = people.department_id', 'left')
                ->get()
                ->getRow();

        if ($staff) {
            $staffRoles = $this->db->table('sch_people_roles as people')
                ->select('role.role_key')
                ->where('people.people_id', $staff->id)
                ->where('people.status', '0')
                ->join("sch_roles as role", 'role.id = people.role_id', 'left')
                ->get()
                ->getResult();
            
            $roleKeys = array_map(function($role) {
                    return $role->role_key;
                }, $staffRoles);
        }

        $staff->roles = $roleKeys;
        return $staff;
    }

    function addUpdateStaffRoles($roles, $staffID) {
        // save roles
        $roles = $this->db->table('sch_roles')
                    ->select('*')
                    ->where('deleted', 0)
                    ->whereIn('role_key', $roles)
                    ->get()
                    ->getResult();
        
        $roleIds = array_map(function($role) {
                        return $role->id;
                    }, $roles);

        $existingStaffRoles = $this->db->table('sch_people_roles')
                    ->select('role_id, id')
                    ->where('people_id', $staffID)
                    ->get()
                    ->getResult();
                    
        // update existing
        if ($existingStaffRoles) {
            foreach ($existingStaffRoles as $key => $existingStaffRole) {
                if (!in_array($existingStaffRole->role_id, $roleIds)) {
                    $updateData = ['status' => '1'];
                    $this->db->table('sch_people_roles')
                        ->where('id', $existingStaffRole->id)
                        ->update($updateData);
                }
            }
        }

        if (!empty($roles)) {
            foreach ($roles as $role) {

                $peopleRoles = $this->db->table('sch_people_roles')
                    ->select('id')
                    ->where('role_id', $role->id)
                    ->where('people_id', $staffID)
                    ->get()
                    ->getRow();
                
                if ($peopleRoles) {
                    $updateData = ['status' => '0'];
                    $this->db->table('sch_people_roles')
                        ->where('id', $peopleRoles->id)
                        ->update($updateData);
                }
                else{
                    $roleData = ['people_id' => $staffID, 'role_id' => $role->id, 'added_by' => h_session('current_user_id') ];
                    $this->db->table('sch_people_roles')->insert($roleData);

                    // save teacher
                    if ($role->role_key == 'school_teacher') {
                        $teacherData = ['people_id' => $staffID, 'added_by_id' => h_session('current_user_id') ];
                        $this->db->table('sch_teacher')->insert($teacherData);
                    }
                }
            }
        }
    }


    function generateStaffNumber() {
        $prefix = h_session('staff_no_prefix');  // Get the prefix
        $prefix = $prefix . '24';
        // Get the last student number
        $lastStudentQuery = $this->db->table('sch_people')
                               ->select('people_number')
                               ->where('person_type', 'Staff')
                               ->orderBy('people_number', 'DESC')
                               ->limit(1)
                               ->get()
                               ->getRow();
    
        if (!$lastStudentQuery) {
            $lastStudentNumber = 0;
        } else {
            $studentNumber = $lastStudentQuery->people_number;
            if (strpos($studentNumber, $prefix) === 0) {
                $numericPart = substr($studentNumber, strlen($prefix));
            } else {
                $numericPart = $studentNumber;
            }

            // Convert the numeric part to an integer
            $lastStudentNumber = (int) $numericPart;
        }
    
        $newStudentNumber = $prefix . str_pad($lastStudentNumber + 1, 3, '0', STR_PAD_LEFT);
    
        return $newStudentNumber;
    }

    public function listStaffByTerm($termId, $classId = 0)
    {
        $staffs = $this->db->table('sch_people as people')
                ->select('people.*, dep.name as dep_name')
                ->where('people.deleted', 0)
                ->where('people.person_type', 'Staff')
                ->where('people.branch_id', h_session('branch_id'))
                ->where('people.school_id', h_session('school_id'))
                ->join("sch_departments as dep", 'dep.id = people.department_id', 'left')
                ->join("sch_teacher as teac", 'teac.people_id = people.id')
                ->get()
                ->getResult();

        foreach ($staffs as $key => $staff) {
            if ($classId == 0) {
                $class_subjects = $this->db->table('sch_term_subjects as term_sub')
                    ->select('sub.name as subject_name, class.short_name, class.name as class_name')
                    ->where('term_sub.teacher_id', $staff->id)
                    ->where('term_sub.status', 'active')
                    ->where('term_sub.deleted', '0')
                    ->where('term_class.academic_term_id', $termId)
                    ->join("sch_subjects as sub", 'sub.id = term_sub.subject_id')
                    ->join("sch_academic_term_class_streams as term_class", 'term_class.id = term_sub.term_class_streams_id')
                    ->join("sch_classes as class", 'class.id = term_class.class_id')
                    ->get()
                    ->getResult();
            } else{
                $class_subjects = $this->db->table('sch_term_subjects as term_sub')
                    ->select('sub.name as subject_name, class.short_name, class.name as class_name')
                    ->where('term_sub.teacher_id', $staff->id)
                    ->where('term_sub.status', 'active')
                    ->where('term_sub.deleted', '0')
                    ->where('term_class.academic_term_id', $termId)
                    ->where('term_class.class_id', $classId)
                    ->join("sch_subjects as sub", 'sub.id = term_sub.subject_id')
                    ->join("sch_academic_term_class_streams as term_class", 'term_class.id = term_sub.term_class_streams_id')
                    ->join("sch_classes as class", 'class.id = term_class.class_id')
                    ->get()
                    ->getResult();
            }
            
            $classes = [];

            // Process the result into the desired structure $classId
            foreach ($class_subjects as $row) {
                $classKey = $row->class_name; // Use class name as the key
                if (!isset($classes[$classKey])) {
                    $classes[$classKey] = [
                        'short_name' => $row->short_name,
                        'subjects' => []
                    ];
                }
                $classes[$classKey]['subjects'][] = $row->subject_name;
            }
            
            // Final structured list
            $result = array_values($classes);

            $staff->classes = !empty($result) ? $result : [];

            // Remove the staff if classes are empty
            if (empty($staff->classes) && $classId != 0) {
                unset($staffs[$key]);
            }

        }

        // Re-index the array to avoid gaps in keys
        $staffs = array_values($staffs);
        return $staffs;
    }
}
