<?php

namespace App\Models\user_models\students;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;
use Config\Database;

class M_ManageStudents extends Model
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

    public function saveStudentData($data)
    {
       $response = [];
       $response['success'] = false;
       $response['StatusCode'] = '57';

       try {
            // save people
            $people = $data['basic'];
            $peopleID = 0;
            if (!empty($people)) {

                $this->db->table('sch_people')->insert($people);
                $peopleID = $this->db->insertID();

                $response['success'] = true;
                $response['StatusCode'] = '00';
                $response['ID'] = $peopleID;
            }


            // other student field
            $others = $data['others'];
            $class_details = $data['class'];
            $studentID = 0;
            if ($others) {
                $otherFields = ['people_id' => $peopleID, 'house_id' => $others['house'], 'house_status' => '0', 'student_no' => $others['student_no'],
                                'admission_no' => $others['admission_no'], 'admission_date' => $others['admission_date'], 'admission_class_id' => $class_details['class_id'], 
                               'admission_class_stream_id' => $class_details['stream_id'] ];
                $this->db->table('sch_student')->insert($otherFields);
                $studentID = $this->db->insertID();

                $response['success'] = true;
                $response['StatusCode'] = '00';
            }

            // class stream details
            if ($class_details['stream_id']) {
                $class_stream_details = ['class_stream_id' => $class_details['stream_id'], 'student_id' => $studentID, 'added_by_id' => h_session('current_user_id'),'term_id' => $class_details['term_id'], 'is_new_student' => $class_details['is_new_student']  ];
                $this->db->table('sch_stream_students')->insert($class_stream_details);

                // add student to mandantory subjects
                $this->addStudentClassTermSubjects($class_details['stream_id'], $class_details['term_id'], $studentID);
            }

            $parents = $data['parents'];
            if (!empty($parents)) {
                $ID = $data['ID'];
                $father = $parents['father'];
                $mother = $parents['mother'];
                $guardian = $parents['guardian'];

                // save father
                if ($father['name'] && $father['gender'] ) {
                    $basicData = ['person_type' => $father['person_type'], 'name' => $father['name'], 'gender' => $father['gender'], 
                        'school_id' => h_session('school_id'), 'branch_id' => h_session('branch_id'), 'phone' => $father['phone'], 
                        'occupation' => $father['occupation'], 'physical_address' => $father['physical_address'] ];
                    
                    $this->db->table('sch_people')->insert($basicData);
                    $fatherID = $this->db->insertID();

                    $relationData = ['person_1' => $ID, 'person_2' => $fatherID, 'relationship' => 'father'];
                    $this->db->table('sch_people_relation')->insert($relationData);
                }

                // save mother
                if ($mother['name'] && $mother['gender'] ) {
                    $basicData = ['person_type' => $mother['person_type'], 'name' => $mother['name'], 'gender' => $mother['gender'], 
                        'school_id' => h_session('school_id'), 'branch_id' => h_session('branch_id'), 'phone' => $mother['phone'], 
                        'occupation' => $mother['occupation'], 'physical_address' => $mother['physical_address'] ];
                    
                    $this->db->table('sch_people')->insert($basicData);
                    $motherID = $this->db->insertID();

                    $relationData = ['person_1' => $ID, 'person_2' => $motherID, 'relationship' => 'mother'];
                    $this->db->table('sch_people_relation')->insert($relationData);
                }

                // save guardian
                if ($guardian['name'] && $guardian['gender'] ) {
                    $basicData = ['person_type' => $guardian['person_type'], 'name' => $guardian['name'], 'gender' => $guardian['gender'], 
                        'school_id' => h_session('school_id'), 'branch_id' => h_session('branch_id'), 'phone' => $guardian['phone'], 
                        'occupation' => $guardian['occupation'], 'physical_address' => $guardian['physical_address'] ];
                    
                    $this->db->table('sch_people')->insert($basicData);
                    $guardianID = $this->db->insertID();

                    $relationData = ['person_1' => $ID, 'person_2' => $guardianID, 'relationship' => $guardian['relationship'] ];
                    $this->db->table('sch_people_relation')->insert($relationData);
                }

                $response['success'] = true;
                $response['StatusCode'] = '00';
            }

            $response['success'] = true;
            $response['StatusCode'] = '00';

        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }

       return (object) $response;
    }

    function addStudentClassTermSubjects($streamId, $termId, $studentId) {

        $termClasses = $this->db->table('sch_academic_term_class_streams')
            ->select('id')
            ->where('stream_id', $streamId)
            ->where('academic_term_id', $termId)
            ->where('deleted', 0)
            ->where('is_active', 0)
            ->get()
            ->getResult();
        
        $termClassIds = array_map(function($termClass) {
                return $termClass->id;
            }, $termClasses);
        
        $termClassSubjects = $this->db->table('sch_term_subjects')
            ->select('*')
            ->whereIn('term_class_streams_id', $termClassIds)
            ->where('subject_type', 'Mandatory')
            ->get()
            ->getResult();

        foreach ($termClassSubjects as $key => $termClassSubject) {

            $exists = $this->db->table('sch_stream_student_term_subjects')
                ->select('*')
                ->where('student_id', $studentId)
                ->where('subject_id', $termClassSubject->subject_id)
                ->where('term_id', $termId)
                ->where('stream_id', $streamId)
                ->get()
                ->getResult();

            if ( empty($exists) ) {
                $subjectData = [
                    "student_id" => $studentId, "subject_id" => $termClassSubject->subject_id, "term_id" => $termId, "stream_id" => $streamId, "added_by_id" => h_session('current_user_id')
                ];
                $this->db->table('sch_stream_student_term_subjects')->insert($subjectData);
            }
        }
    }

    public function updateStudent($updateData, $ID)
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

    public function listStudents($termId, $classId = 0)
    {
        $students = [];

        if ($classId == 0) {
            $students = $this->db->table('sch_people as people')
                    ->select('people.*, student.id as student_id, student.admission_no, student.student_no, class.name as class_name, class.short_name as class_short_name, class_stream.name as stream_name')
                    ->where('people.deleted', 0)
                    ->where('people.person_type', 'Student')
                    ->where('people.branch_id', h_session('branch_id'))
                    ->where('people.school_id', h_session('school_id'))
                    ->where('stream.term_id', $termId )
                    ->where('stream.deleted', 0 )
                    ->where('stream.status', 'active' )
                    ->join('sch_student AS student', 'student.people_id = people.id')
                    ->join("sch_stream_students as stream", 'student.id = stream.student_id')
                    ->join("sch_streams as class_stream", 'class_stream.id = stream.class_stream_id')
                    ->join("sch_classes as class", 'class.id = class_stream.class_id')
                    ->get()
                    ->getResult();
        } else {
            $students = $this->db->table('sch_people as people')
                    ->select('people.*, student.id as student_id, student.admission_no, student.student_no, class.name as class_name, class.short_name as class_short_name, class_stream.name as stream_name')
                    ->where('people.deleted', 0)
                    ->where('people.person_type', 'Student')
                    ->where('people.branch_id', h_session('branch_id'))
                    ->where('people.school_id', h_session('school_id'))
                    ->where('stream.term_id', $termId )
                    ->where('class_stream.class_id', $classId )
                    ->where('stream.deleted', 0 )
                    ->where('stream.status', 'active' )
                    ->join('sch_student AS student', 'student.people_id = people.id')
                    ->join("sch_stream_students as stream", 'student.id = stream.student_id')
                    ->join("sch_streams as class_stream", 'class_stream.id = stream.class_stream_id')
                    ->join("sch_classes as class", 'class.id = class_stream.class_id')
                    ->get()
                    ->getResult();
        }
        
        return $students ? $students : [];
    }

    function getBoardingStudentReportData($termId, $classId = 0) {
        $students = []; 

        if ($classId == 0) {
            $students = $this->db->table('sch_people as people')
                    ->select('people.*, student.id as student_id, student.admission_no, student.student_no, class.name as class_name, class.short_name as class_short_name, class_stream.name as stream_name, acc.bed_number, accom.name as dormitry_name')
                    ->where('people.deleted', 0)
                    ->where('people.person_type', 'Student')
                    ->where('people.branch_id', h_session('branch_id'))
                    ->where('people.school_id', h_session('school_id'))
                    ->where('stream.term_id', $termId )
                    ->where('stream.deleted', 0 )
                    ->where('stream.status', 'active' )
                    ->where('acc.term_id', $termId )
                    ->join('sch_student AS student', 'student.people_id = people.id')
                    ->join("sch_stream_students as stream", 'student.id = stream.student_id')
                    ->join("sch_streams as class_stream", 'class_stream.id = stream.class_stream_id')
                    ->join("sch_classes as class", 'class.id = class_stream.class_id')
                    ->join('sch_people_accomodation AS acc', 'acc.people_id = people.id')
                    ->join('sch_accomodation AS accom', 'acc.accomodation_id = accom.id')
                    ->get()
                    ->getResult();
        } else {
            $students = $this->db->table('sch_people as people')
                    ->select('people.*, student.id as student_id, student.admission_no, student.student_no, class.name as class_name, class.short_name as class_short_name, class_stream.name as stream_name, acc.bed_number, accom.name as dormitry_name')
                    ->where('people.deleted', 0)
                    ->where('people.person_type', 'Student')
                    ->where('people.branch_id', h_session('branch_id'))
                    ->where('people.school_id', h_session('school_id'))
                    ->where('stream.term_id', $termId )
                    ->where('class_stream.class_id', $classId )
                    ->where('stream.deleted', 0 )
                    ->where('stream.status', 'active' )
                    ->where('acc.term_id', $termId )
                    ->join('sch_student AS student', 'student.people_id = people.id')
                    ->join("sch_stream_students as stream", 'student.id = stream.student_id')
                    ->join("sch_streams as class_stream", 'class_stream.id = stream.class_stream_id')
                    ->join("sch_classes as class", 'class.id = class_stream.class_id')
                    ->join('sch_people_accomodation AS acc', 'acc.people_id = people.id')
                    ->join('sch_accomodation AS accom', 'acc.accomodation_id = accom.id')
                    ->get()
                    ->getResult();
        }
        
        return $students ? $students : [];
    }

    public function searchStudents($search)
    {
        $students = $this->db->table('sch_people as people')
                    ->select('people.*, student.id as student_id, student.admission_no, student.student_no, class.name as class_name, class.short_name as class_short_name, stream.name as stream_name')
                    ->where('people.deleted', 0)
                    ->where('people.person_type', 'Student')
                    ->where('people.branch_id', h_session('branch_id'))
                    ->where('people.school_id', h_session('school_id'))
                    ->join('sch_student AS student', 'student.people_id = people.id')
                    ->join("sch_classes as class", 'class.id = student.admission_class_id', 'left')
                    ->join("sch_streams as stream", 'stream.id = student.admission_class_stream_id', 'left')
                    ->limit(10);
        
        // Add search
        if (!empty($search)) {
            $students->groupStart()
                    ->like('people.name', $search)
                    ->orLike('people.people_number', $search)
                    ->groupEnd();
        }

        $students = $students->get()->getResult();
        foreach ($students as $key => $student) {
            $class = $this->db->table('sch_stream_students strem_student')
                    ->select('strem_student.*, stream.name as stream_name, class.name as class_name, class.short_name as class_short_name')
                    ->where('strem_student.student_id', $student->student_id)
                    ->join('sch_streams AS stream', 'stream.id = strem_student.class_stream_id')
                    ->join('sch_classes AS class', 'class.id = stream.class_id')
                    ->orderBy('strem_student.id', 'DESC')
                    ->get()
                    ->getRow();
            
            $student->current_class = $class;
        }

        return $students ? $students : [];
    }

    public function studentDetails($id)
    {
        $student = $this->db->table('sch_people')
                    ->select('*')
                    ->where('id', $id)
                    ->where('person_type', 'Student')
                    ->where('branch_id', h_session('branch_id'))
                    ->where('school_id', h_session('school_id'))
                    ->get()
                    ->getRow();
        
        if ($student) {
            // father details
            $father = $this->db->table('sch_people_relation AS relation')
                    ->select('relation.*, people.*')
                    ->where('relation.person_1', $student->id)
                    ->where('relation.relationship', 'father')
                    ->where('relation.deleted', '0')
                    ->join('sch_people AS people', 'people.id = relation.person_2')
                    ->get()
                    ->getRow();
            
            $student->father = $father;

            // mother details
            $mother = $this->db->table('sch_people_relation AS relation')
                    ->select('relation.*, people.*')
                    ->where('relation.person_1', $student->id)
                    ->where('relation.relationship', 'mother')
                    ->where('relation.deleted', '0')
                    ->join('sch_people AS people', 'people.id = relation.person_2')
                    ->get()
                    ->getRow();
            
            $student->mother = $mother;

            // guardian details
            $guardian = $this->db->table('sch_people_relation AS relation')
                    ->select('relation.*, people.*')
                    ->where('relation.person_1', $student->id)
                    ->where('relation.relationship', 'guardian')
                    ->where('relation.deleted', '0')
                    ->join('sch_people AS people', 'people.id = relation.person_2')
                    ->get()
                    ->getRow();

            $student->guardian = $guardian;

            // admission details
            $admission = $this->db->table('sch_student AS student')
                    ->select('student.*, class.name as class_name, class.short_name as class_short_name, stream.name as stream_name')
                    ->where('student.people_id', $id)
                    ->where('student.deleted', '0')
                    ->join("sch_classes as class", 'class.id = student.admission_class_id', 'left')
                    ->join("sch_streams as stream", 'stream.id = student.admission_class_stream_id', 'left')
                    ->get()
                    ->getRow();

            $student->admission = $admission;

            if ($admission) {
                $class = $this->db->table('sch_stream_students strem_student')
                                ->select('strem_student.*, stream.name as stream_name, class.name as class_name, class.short_name as class_short_name, term.name as term_name, years.name as year_name')
                                ->where('strem_student.student_id', $admission->id)
                                ->join('sch_streams AS stream', 'stream.id = strem_student.class_stream_id')
                                ->join('sch_classes AS class', 'class.id = stream.class_id')
                                ->join('sch_academic_year_terms AS term', 'term.id = strem_student.term_id')
                                ->join('sch_academic_years AS years', 'years.id = term.academic_year_id')
                                ->orderBy('strem_student.id', 'DESC')
                                ->get()
                                ->getRow();
            
                $student->current_class = $class;
            }

            // accomodation
            $accomodation = $this->db->table('sch_people_accomodation AS accomodation')
                    ->select('accomodation.*, acc.name, acc.number_of_beds')
                    ->where('accomodation.people_id', $id)
                    ->join("sch_accomodation as acc", 'acc.id = accomodation.accomodation_id')
                    ->orderBy('accomodation.id', 'DESC')
                    ->get()
                    ->getRow();

            $student->accomodation = $accomodation;
        }

        return $student;
    }

    public function saveStudentAccountTypesData($accounts, $peopleID)
    {
       $response = [];
       $response['success'] = true;
       $response['StatusCode'] = '00';
    
       foreach ($accounts as $key => $account) {
        $data = ['people_id' => $peopleID, 'account_type_id' => $account, 'added_by' => h_session('current_user_id') ];
        $this->db->table('sch_person_account')->insert($data);
       }

       return (object) $response;
    }


    
    public function saveUpdateStudentData($data)
    {
       $response = [];
       $response['success'] = false;
       $response['StatusCode'] = '57';

       try {
            // update student basic
            $studentUpdate = $data['basic'];
            $peopleID = $data['ID'];
            if (!empty($studentUpdate)) {

                $this->db->table('sch_people')->where('id', $peopleID)->update($studentUpdate);

                $response['success'] = true;
                $response['StatusCode'] = '00';
                $response['ID'] = $peopleID;
            }

            // other student field 
            $others = $data['others'];
            $studentID = $data['admissionID'];
            if (!empty($others)) {

                if ($studentID) {
                    $otherFields = ['house_id' => $others['house'], 'house_status' => '0', 'student_no' => $others['student_no'],
                                'admission_no' => $others['admission_no'], 'admission_date' => $others['admission_date']];
                    $this->db->table('sch_student')->where('id', $studentID)->update($otherFields);
                }else{
                    $otherFields = ['people_id' => $peopleID, 'house_id' => $others['house'], 'house_status' => '0', 'student_no' => $others['student_no'],
                                'admission_no' => $others['admission_no'], 'admission_date' => $others['admission_date'] ];
                    $this->db->table('sch_student')->insert($otherFields);
                    $studentID = $this->db->insertID();
                }
                
                $response['success'] = true;
                $response['StatusCode'] = '00';
            }

            // class stream details
            // $class_details = $data['class'];
            // if ($class_details['stream_id']) {
            //     $class_stream_details = ['class_stream_id' => $class_details['stream_id'], 'student_id' => $studentID, 'added_by_id' => h_session('current_user_id') ];
            //     $this->db->table('sch_stream_students')->insert($class_stream_details);
            // }

            $parents = $data['parents'];
            if (!empty($parents)) {
                $father = $parents['father'];
                $mother = $parents['mother'];
                $guardian = $parents['guardian'];

                // save father
                if ($father['name'] && $father['gender'] ) {
                    if ($father['ID']) {
                        $basicData = ['name' => $father['name'], 'gender' => $father['gender'], 'phone' => $father['phone'], 
                        'occupation' => $father['occupation'], 'physical_address' => $father['physical_address'] ];
                    
                        $this->db->table('sch_people')->where('id', $father['ID'])->update($basicData);
                    }else{
                        $basicData = ['person_type' => $father['person_type'], 'name' => $father['name'], 'gender' => $father['gender'], 
                        'school_id' => h_session('school_id'), 'branch_id' => h_session('branch_id'), 'phone' => $father['phone'], 
                        'occupation' => $father['occupation'], 'physical_address' => $father['physical_address'] ];
                    
                        $this->db->table('sch_people')->insert($basicData);
                        $fatherID = $this->db->insertID();

                        $relationData = ['person_1' => $peopleID, 'person_2' => $fatherID, 'relationship' => 'father'];
                        $this->db->table('sch_people_relation')->insert($relationData);
                    }
                    
                }

                // save mother
                if ($mother['name'] && $mother['gender'] ) {
                    if ($mother['ID']) {
                        $basicData = [ 'name' => $mother['name'], 'gender' => $mother['gender'], 'phone' => $mother['phone'], 
                        'occupation' => $mother['occupation'], 'physical_address' => $mother['physical_address'] ];
            
                        $this->db->table('sch_people')->where('id', $mother['ID'])->update($basicData);
                    }else{
                        $basicData = ['person_type' => $mother['person_type'], 'name' => $mother['name'], 'gender' => $mother['gender'], 
                        'school_id' => h_session('school_id'), 'branch_id' => h_session('branch_id'), 'phone' => $mother['phone'], 
                        'occupation' => $mother['occupation'], 'physical_address' => $mother['physical_address'] ];
                    
                        $this->db->table('sch_people')->insert($basicData);
                        $motherID = $this->db->insertID();

                        $relationData = ['person_1' => $peopleID, 'person_2' => $motherID, 'relationship' => 'mother'];
                        $this->db->table('sch_people_relation')->insert($relationData);
                    }
                    
                }

                // save guardian
                if ($guardian['name'] && $guardian['gender'] ) {
                    if ($guardian['ID']) {
                        $basicData = ['name' => $guardian['name'], 'gender' => $guardian['gender'], 'phone' => $guardian['phone'], 
                        'occupation' => $guardian['occupation'], 'physical_address' => $guardian['physical_address'] ];
                    
                        $this->db->table('sch_people')->where('id', $guardian['ID'])->update($basicData);
                    }else{
                        $basicData = ['person_type' => $guardian['person_type'], 'name' => $guardian['name'], 'gender' => $guardian['gender'], 
                        'school_id' => h_session('school_id'), 'branch_id' => h_session('branch_id'), 'phone' => $guardian['phone'], 
                        'occupation' => $guardian['occupation'], 'physical_address' => $guardian['physical_address'] ];
                    
                        $this->db->table('sch_people')->insert($basicData);
                        $guardianID = $this->db->insertID();

                        $relationData = ['person_1' => $peopleID, 'person_2' => $guardianID, 'relationship' => $guardian['relationship'] ];
                        $this->db->table('sch_people_relation')->insert($relationData);
                    }
                }

                $response['success'] = true;
                $response['StatusCode'] = '00';
            }

            $response['success'] = true;
            $response['StatusCode'] = '00';

        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }

       return (object) $response;
    }

    public function studentClassTermDetails($termId, $studentID)
    {
        $class = $this->db->table('sch_stream_students as stream_stud')
                ->select('stream_stud.*, stream.class_id, stream.name as stream_name, class.name as class_name, class.short_name')
                ->where('stream_stud.student_id', $studentID)
                ->where('stream_stud.term_id', $termId)
                ->join('sch_streams AS stream', 'stream.id = stream_stud.class_stream_id')
                ->join('sch_classes AS class', 'class.id = stream.class_id')
                ->get()
                ->getRow();
        
        return $class;
    }


    function generateStudentNumber() {
        $prefix = h_session('student_no_prefix');  // Get the prefix
        $currentYear = date('Y');
        $lastTwoDigits = substr($currentYear, -2);
        $prefix = $prefix . strval($lastTwoDigits);

        // Get the last student number
        $lastStudentQuery = $this->db->table('sch_people')
                               ->select('people_number')
                               ->where('person_type', 'Student')
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
                // for sonshine primary school
                $prefix2 = h_session('student_no_prefix');
                $prefix2 = $prefix2 . '24';
                if (strpos($studentNumber, $prefix2) === 0) {
                    $numericPart = substr($studentNumber, strlen($prefix2));
                }else{
                    $numericPart = $studentNumber;
                }
            }

            // Convert the numeric part to an integer
            $lastStudentNumber = (int) $numericPart;
        }
        
        $newStudentNumber = $prefix . str_pad($lastStudentNumber + 1, 3, '0', STR_PAD_LEFT);
        return $newStudentNumber;
    }


    function generateStudentAdmissionNumber() {
        $prefix = h_session('admission_no_prefix');  // Get the prefix
        $currentYear = date('Y');
        $lastTwoDigits = substr($currentYear, -2);
        $prefix = $prefix . strval($lastTwoDigits);

        // Get the last student number
        $lastStudentQuery = $this->db->table('sch_people as people')
                               ->select('student.admission_no')
                               ->where('people.person_type', 'Student')
                               ->orderBy('people.people_number', 'DESC')
                               ->join('sch_student AS student', 'people.id = student.people_id')
                               ->limit(1)
                               ->get()
                               ->getRow();
    
        
        if (!$lastStudentQuery) {
            $lastStudentNumber = 0;
        } else {
            $studentNumber = $lastStudentQuery->admission_no;
            if (strpos($studentNumber, $prefix) === 0) {
                $numericPart = substr($studentNumber, strlen($prefix));
            } else {
                // for sonshine primary school
                $prefix2 = h_session('admission_no_prefix');
                $prefix2 = $prefix2 . '24';
                if (strpos($studentNumber, $prefix2) === 0) {
                    $numericPart = substr($studentNumber, strlen($prefix2));
                }else {
                    $numericPart = $studentNumber;
                }
            }

            // Convert the numeric part to an integer
            $lastStudentNumber = (int) $numericPart;
        }
    
        $newStudentNumber = $prefix . str_pad($lastStudentNumber + 1, 4, '0', STR_PAD_LEFT);
    
        return $newStudentNumber;
    }

    function saveStudentReportData($data) {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';

        try {

            $student = $this->db->table('sch_student')
                    ->select('*')
                    ->where('people_id', $data['people_id'])
                    ->get()
                    ->getRow();

            if ($student) {
                $exist = $this->db->table('sch_stream_students')
                    ->select('*')
                    ->where('student_id', $student->id)
                    ->where('class_stream_id', $data['class_stream_id'])
                    ->where('term_id', $data['term_id'])
                    ->get()
                    ->getRow();
                
                $exist1 = $this->db->table('sch_stream_students')
                    ->select('*')
                    ->where('student_id', $student->id)
                    ->where('term_id', $data['term_id'])
                    ->get()
                    ->getRow();

                if (!$exist && !$exist1) {
                    // Start a transaction
                    $this->db->transStart();
                
                    $saveData = ['class_stream_id' => $data['class_stream_id'], 'term_id' => $data['term_id'], 'student_id' => $student->id ];
                    $this->db->table('sch_stream_students')->insert($saveData);
                
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

                        // add subjects to student
                        $this->addStudentClassTermSubjects($data['class_stream_id'], $data['term_id'], $student->id );

                        $response['success'] = true;
                        $response['StatusCode'] = '00';
                    }
                }
                
            }
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }

        return (object) $response;
    }

    function listAccomodations() {
        $accomodations = $this->db->table('sch_accomodation as accom')
                    ->select('accom.*')
                    ->where('accom.status', '0')
                    ->get()
                    ->getResult();

        return $accomodations ? $accomodations : [];
    }

    function saveStudentDormitryData($saveData) {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';

        try {
            // Start a transaction
            $this->db->transStart();
            $this->db->table('sch_people_accomodation')->insert($saveData);
            // Complete the transaction
            $this->db->transComplete();
        
            // Check transaction status
            if ($this->db->transStatus() === false) {
                $response['message'] = $e->getMessage();
            }
            else {
                $response['success'] = true;
                $response['StatusCode'] = '00';
            }
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }

        return (object) $response;
    }

    function updateStudentSubjects($termId)  {
        $streamStudents = $this->db->table('sch_stream_students std')
                        ->select('people.id as people_id, people.people_number, people.name,people.first_name,people.last_name, std.*')
                        ->where('std.term_id', $termId)
                        ->where('std.deleted', 0)
                        ->where('std.status', 'active')
                        ->where('people.deleted', 0)
                        ->where('people.status', 'active')
                        ->join('sch_student AS student', 'student.id = std.student_id')
                        ->join('sch_people AS people', 'people.id = student.people_id')
                        ->get()
                        ->getResult();
        
        foreach ($streamStudents as $key => $streamStudent) {
            $this->addStudentClassTermSubjects($streamStudent->class_stream_id, $termId, $streamStudent->student_id );
        }
    }

    function getStudentsEnrollReportData($termId, $classId = 0) {
        $students = []; 

        if ($classId == 0) {
            $students = $this->db->table('sch_people as people')
                    ->select('people.*, student.id as student_id, student.admission_no, student.student_no, class.name as class_name, class.short_name as class_short_name, class_stream.name as stream_name, acc.bed_number, accom.name as dormitry_name')
                    ->where('people.deleted', 0)
                    ->where('people.person_type', 'Student')
                    ->where('people.branch_id', h_session('branch_id'))
                    ->where('people.school_id', h_session('school_id'))
                    ->where('stream.term_id', $termId )
                    ->where('stream.deleted', 0 )
                    ->where('stream.status', 'active' )
                    ->where('acc.term_id', $termId )
                    ->where('stream.is_new_student', 1 )
                    ->join('sch_student AS student', 'student.people_id = people.id')
                    ->join("sch_stream_students as stream", 'student.id = stream.student_id')
                    ->join("sch_streams as class_stream", 'class_stream.id = stream.class_stream_id')
                    ->join("sch_classes as class", 'class.id = class_stream.class_id')
                    ->join('sch_people_accomodation AS acc', 'acc.people_id = people.id')
                    ->join('sch_accomodation AS accom', 'acc.accomodation_id = accom.id')
                    ->get()
                    ->getResult();
        } else {
            $students = $this->db->table('sch_people as people')
                    ->select('people.*, student.id as student_id, student.admission_no, student.student_no, class.name as class_name, class.short_name as class_short_name, class_stream.name as stream_name, acc.bed_number, accom.name as dormitry_name')
                    ->where('people.deleted', 0)
                    ->where('people.person_type', 'Student')
                    ->where('people.branch_id', h_session('branch_id'))
                    ->where('people.school_id', h_session('school_id'))
                    ->where('stream.term_id', $termId )
                    ->where('class_stream.class_id', $classId )
                    ->where('stream.deleted', 0 )
                    ->where('stream.status', 'active' ) 
                    ->where('acc.term_id', $termId )
                    ->where('stream.is_new_student', 1 )
                    ->join('sch_student AS student', 'student.people_id = people.id')
                    ->join("sch_stream_students as stream", 'student.id = stream.student_id')
                    ->join("sch_streams as class_stream", 'class_stream.id = stream.class_stream_id')
                    ->join("sch_classes as class", 'class.id = class_stream.class_id')
                    ->join('sch_people_accomodation AS acc', 'acc.people_id = people.id')
                    ->join('sch_accomodation AS accom', 'acc.accomodation_id = accom.id')
                    ->get()
                    ->getResult();
        }
        
        return $students ? $students : [];
    }
    
}