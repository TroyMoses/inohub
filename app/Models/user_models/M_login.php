<?php

namespace App\Models\user_models;

use CodeIgniter\Model;

class M_login extends Model
{
    
    protected $table = 'user_accounts'; 

	public function __construct()
	{
		parent::__construct();
	}

    protected function main_login_table($username, $password)
	{

        // Fetch user record with the given username and password
        $user = $this->db->table('sch_user_accounts AS users')
                ->select('school.*, school_db.*, users.*') // Select all columns from both tables
                ->where('users.user_name', $username)
                ->where('users.password', md5($password)) // Using md5 for simplicity; consider bcrypt or a more secure hashing method
                ->where('users.deleted', 0)
                ->where('school.deleted', 0)
                ->where('school_db.deleted', 0)
                ->join('sch_schools_registered AS school', 'school.id = users.school_id')
                ->join('sch_databases AS school_db', 'school_db.id = school.school_db_id')
                ->get()
                ->getRowArray();

        return $user ? $user : false;
	}

    public function user_login($username, $password)
	{
        $response = [];
		$response['success'] = false;
    
		//main login
		$sth = $this->main_login_table($username,$password);

        if ( $sth ) {
            $response = $sth;
            $response['success'] = true;
            $response['access_rights_ids'] = [];
            $response['access_rights_keys'] = [];

            // get branch details
            $sourceDb = $sth['db_name'];
            $this->db->setDatabase($sourceDb);

            $branch = $this->db->table('sch_branches')
                ->select('*')
                ->where('id', $sth['branch_id'])
                ->get()
                ->getRowArray();
            
            if ($branch) {

                $response['branch_id'] = $branch['id'];
                $response['branch_name'] = $branch['branch_name'];
                $response['branch_desc'] = $branch['branch_descr'];
                $response['branch_address'] = $branch['physical_address'];
                $response['branch_city'] = $branch['city'];
                $response['branch_country'] = $branch['country'];
                $response['branch_status'] = $branch['status'];
            }

            // people 
            $people = $this->db->table('sch_people')
                ->select('*')
                ->where('id', $sth['school_people_id'])
                ->get()
                ->getRowArray();
            
            if ($people) {
                $response['people_id'] = $people['id'];
                $response['people_name'] = $people['name'];
                $response['people_first_name'] = $people['first_name'];
                $response['people_last_name'] = $people['last_name'];
                $response['people_number'] = $people['people_number'];
                $response['person_type'] = $people['person_type'];
                $response['image_url'] = $people['image_url'];
                $response['gender'] = $people['gender'];
                $response['phone'] = $people['phone'];
                $response['email'] = $people['email'];
            }

            // list of all branchs
            $branches = $this->db->table('sch_branches')
                ->select('id, branch_name, physical_address, city, status, country')
                ->orderBy('id', 'ASC')
                ->get()
                ->getResultArray();
            
            $branches = $branches ? $branches : [];
            $response['branches'] = $branches;

            // access rights
            $role = $this->db->table('sch_user_groups')
                ->select('sch_user_groups.access_group_id, sch_access_groups.group_name, sch_access_groups.system_components')
                ->where('sch_user_groups.user_id', $sth['school_people_id'])
                ->where('sch_user_groups.status', '0')
                ->join('sch_access_groups AS sch_access_groups', 'sch_access_groups.id = sch_user_groups.access_group_id')
                ->get()
                ->getRow();
            
            $accessRights = [];
            if ($role) {
                $accessRights = json_decode($role->system_components);
            }

            $response['access_rights_ids'] = $accessRights;

            $this->db->setDatabase('inoc_system_main');


            if (!empty($response['access_rights_ids'])) {

                // revoke menus that were revoked from school
                $schaccess_rights_ids = [];
                if ($response['assigned_components']) {
                    foreach ($response['access_rights_ids'] as $key => $value) {
                        if (in_array($value, json_decode($response['assigned_components']) )) {
                            $schaccess_rights_ids[] = $value;
                        }
                    }
                }
                
                if (!empty($schaccess_rights_ids)) {
    
                    $rights = $this->db->table('sch_system_components')
                        ->select('sch_system_components.*')
                        ->whereIn('sch_system_components.id', $schaccess_rights_ids )
                        ->get()
                        ->getResult();
    
                    if ($rights) {
                        $componentKeys = array_map(function($component) {
                            return $component->sys_key; 
                        }, $rights);
        
                        $response['access_rights_keys'] = $componentKeys;
                    }
                }
            }
    
            // assign school admin all access
            if ($response['id'] == $response['admin_user_acc_id'] && $response['assigned_components'] ) {
                $rights = $this->db->table('sch_system_components')
                    ->select('sch_system_components.*')
                    ->whereIn('sch_system_components.id', json_decode($response['assigned_components']) )
                    ->get()
                    ->getResult();
    
                if ($rights) {
                    $componentKeys = array_map(function($component) {
                        return $component->sys_key; 
                    }, $rights);
    
                    $response['access_rights_keys'] = $componentKeys;
                }
            }
    
            // if root add
            if ($sth['user_name'] == 'bdikan256') {
                $componentKeys = $response['access_rights_keys'];
                $componentKeys[] = 'ROOT_ADMINISTRATOR';
                $response['access_rights_keys'] = $componentKeys;
            }

        }

        return (object) $response;
	}

    function dashboard_statistics($academicYear = 0, $currentTermId = 0) {
        $response = [];

        $dbName = h_session('db_name');
        $this->db->setDatabase($dbName);

        // students
        $studentCount = $this->db->table('sch_people as people')
                        ->select('COUNT(DISTINCT stream.student_id) AS student_count')
                        ->where('people.deleted', 0)
                        ->where('people.person_type', 'Student')
                        ->where('people.branch_id', h_session('branch_id'))
                        ->where('people.school_id', h_session('school_id'))
                        ->where('year.id', $academicYear)
                        ->join('sch_student AS student', 'people.id = student.people_id')
                        ->join('sch_stream_students AS stream', 'student.id = stream.student_id')
                        ->join('sch_academic_year_terms AS term', 'term.id = stream.term_id')
                        ->join('sch_academic_years AS year', 'year.id = term.academic_year_id');

        if ($currentTermId > 0) {
            $studentCount->where('stream.term_id', $currentTermId);
        }

        $results = $studentCount->get()->getRow();
        
        $studentCountValue = $results ? $results->student_count : 0;

        // staff
        $staffCount = $this->db->table('sch_people')
                    ->selectCount('id')
                    ->where('deleted', 0)
                    ->where('person_type', 'Staff')
                    ->where('branch_id', h_session('branch_id'))
                    ->where('school_id', h_session('school_id'))
                    ->get()
                    ->getRow();
        $staffCountValue = $staffCount ? $staffCount->id : 0;

        // male students
        $maleStudentsCount = $this->db->table('sch_people as people')
                        ->select('COUNT(DISTINCT stream.student_id) AS student_count')
                        ->where('people.gender', 'M')
                        ->where('people.deleted', 0)
                        ->where('people.person_type', 'Student')
                        ->where('people.branch_id', h_session('branch_id'))
                        ->where('people.school_id', h_session('school_id'))
                        ->where('year.id', $academicYear)
                        ->join('sch_student AS student', 'people.id = student.people_id')
                        ->join('sch_stream_students AS stream', 'student.id = stream.student_id')
                        ->join('sch_academic_year_terms AS term', 'term.id = stream.term_id')
                        ->join('sch_academic_years AS year', 'year.id = term.academic_year_id');

        if ($currentTermId > 0) {
            $maleStudentsCount->where('stream.term_id', $currentTermId);
        }
                
        $results = $maleStudentsCount->get()->getRow();
        $maleStudentsCountValue = $results ? $results->student_count  : 0;

        // female students
        $femaleStudentsCount = $this->db->table('sch_people as people')
                        ->select('COUNT(DISTINCT stream.student_id) AS student_count')
                        ->where('people.gender', 'F')
                        ->where('people.deleted', 0)
                        ->where('people.person_type', 'Student')
                        ->where('people.branch_id', h_session('branch_id'))
                        ->where('people.school_id', h_session('school_id'))
                        ->where('year.id', $academicYear)
                        ->join('sch_student AS student', 'people.id = student.people_id')
                        ->join('sch_stream_students AS stream', 'student.id = stream.student_id')
                        ->join('sch_academic_year_terms AS term', 'term.id = stream.term_id')
                        ->join('sch_academic_years AS year', 'year.id = term.academic_year_id');

        if ($currentTermId > 0) {
            $femaleStudentsCount->where('stream.term_id', $currentTermId);
        }

        $results = $femaleStudentsCount->get()->getRow();
        $femaleStudentsCountValue = $results ? $results->student_count : 0;

        $response['studentCount'] = $studentCountValue;
        $response['maleStudentCount'] = $maleStudentsCountValue;
        $response['femaleStudentCount'] = $femaleStudentsCountValue;

        $response['staffCount'] = $staffCountValue;
        $this->db->setDatabase('inoc_system_main');

        return (object) $response;
    }
}