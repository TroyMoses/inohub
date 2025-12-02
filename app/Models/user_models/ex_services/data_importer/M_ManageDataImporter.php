<?php

namespace App\Models\user_models\ex_services\data_importer;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;
use Config\Database;
use App\Models\user_models\students\M_ManageStudents;

class M_ManageDataImporter extends Model
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

    public function saveStudentDataImport($data, $totalRows = 0)
    {
        $this->db->transStart();
        
        $initiationId = $data['initiation_id'];
        if ($initiationId == 0) {
            $initiationData = ["name" => "Students-". date('mYdHis'), "total_records" => $totalRows, 'branch_id' => h_session('branch_id'), 'added_by_id' => h_session('current_user_id') ];
            $this->db->table('sch_import_initiation')->insert($initiationData);
            $initiationId = $this->db->insertID();
        }

        if ($initiationId != 0) {
            $data['initiation_id'] = $initiationId;
            $this->db->table('sch_students_import')->insert($data);
            $this->db->transComplete();
        }

        return $initiationId;
    }

    public function listStudentsImportInitation()
    {
        $studentsInitiation = $this->db->table('sch_import_initiation')
                    ->select('*')
                    ->where('deleted', 0)
                    ->where('initiation_type', 'students')
                    ->where('branch_id', h_session('branch_id'))
                    ->get()
                    ->getResult();

        return $studentsInitiation ? $studentsInitiation : [];
    }

    public function migrateStudentDataImportToMain($ID)
    {
        $studentInitiations = $this->db->table('sch_students_import')
            ->select('*')
            ->where('deleted', 0)
            ->where('initiation_id', $ID)
            ->where('status', 'pending')
            ->get()
            ->getResult();
            
        $studentModal = new M_ManageStudents();
        foreach ($studentInitiations as $studentInitiation) {

            // Start transaction
            $this->db->transStart();

            // Save people
            $studentNumber = $studentInitiation->student_number? $studentInitiation->student_number: $studentModal->generateStudentNumber();
            $basicData = [
                'person_type' => 'Student',
                'people_number' => $studentNumber,
                'name' => $studentInitiation->student_name,
                'first_name' => $studentInitiation->first_name,
                'last_name' => $studentInitiation->last_name,
                'gender' => $studentInitiation->gender,
                'dob'    => $studentInitiation->dob,
                'school_id' => h_session('school_id'),
                'branch_id' => h_session('branch_id')
            ];

            $this->db->table('sch_people')->insert($basicData);
            $peopleID = $this->db->insertID();  // Retrieve the last inserted ID

            if (!$peopleID) {
                continue;  // Skip this iteration if insertion failed
            }

            $admissionNumber = $studentInitiation->admission_number? $studentInitiation->admission_number: $studentModal->generateStudentAdmissionNumber();
            // Save student
            $studentDetails = [
                'people_id' => $peopleID,
                'student_no' => $studentNumber,
                'admission_no' => $admissionNumber,
                'admission_date' => $studentInitiation->admission_date,
                'admission_class_id' => $studentInitiation->class_id,
                'admission_class_stream_id' => $studentInitiation->stream_id
            ];

            $this->db->table('sch_student')->insert($studentDetails);
            $studentID = $this->db->insertID();  // Retrieve the last inserted student ID

            // Save stream student details if stream ID is provided
            if ($studentInitiation->stream_id) {
                $class_stream_details = [
                    'class_stream_id' => $studentInitiation->stream_id,
                    'student_id' => $studentID,
                    'term_id' => $studentInitiation->term_id,
                    'added_by_id' => h_session('current_user_id')
                ];
                $this->db->table('sch_stream_students')->insert($class_stream_details);
            }

            // save guardian
            if ($studentInitiation->guardian_first_name) {
                $guardian_contact = $studentInitiation->guardian_contact;
                // Check if the phone number starts with '0', if not, prepend '0'
                $formatted_contact = $guardian_contact && substr($guardian_contact, 0, 1) !== '0' ? '0' . $guardian_contact : $guardian_contact;
                $guardianData = [
                    'person_type' => 'Guardian',
                    'people_number' => '',
                    'name' => $studentInitiation->guardian_first_name. ' '. $studentInitiation->guardian_last_name,
                    'first_name' => $studentInitiation->guardian_first_name,
                    'last_name' => $studentInitiation->guardian_last_name,
                    'gender' => $studentInitiation->guardian_gender,
                    'phone' => $formatted_contact,
                    'school_id' => h_session('school_id'),
                    'branch_id' => h_session('branch_id')
                ];

                $this->db->table('sch_people')->insert($guardianData);
                $guardianID = $this->db->insertID();  // Retrieve the last inserted ID

                if (!$guardianID) {
                    continue;
                }

                $relationData = ['person_1' => $peopleID, 'person_2' => $guardianID, 'relationship' => 'guardian' ];
                $this->db->table('sch_people_relation')->insert($relationData);
            }

            // Update the status of the student initiation
            $this->db->table('sch_students_import')
                ->where('id', $studentInitiation->id)
                ->update(['status' => 'migrated']);

            // Complete transaction
            $this->db->transComplete();
        }

        // Update the status of the import initiation
        $this->db->table('sch_import_initiation')
            ->where('id', $ID)
            ->update(['status' => 'migrated']);

        // Response object
        $response = [
            'success' => true,
            'StatusCode' => '00'
        ];

        return (object) $response;
    }

    function saveStudentMarksInitiation($data) {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';
        $response['message']= 'Error Occurred';
        $initiationId = 0;

        try {
            $this->db->transStart();
            
            $initiationData = ["name" => $data['name'], "total_records" => $data['total'], 'branch_id' => h_session('branch_id'), 'initiation_type' => 'marks', 'added_by_id' => h_session('current_user_id') ];
            $this->db->table('sch_import_initiation')->insert($initiationData);
            $initiationId = $this->db->insertID();

            // Complete transaction
            $this->db->transComplete();

            // Check transaction status
            if ($this->db->transStatus()) {
                $response['success'] = true;
                $response['StatusCode'] = '00';
                $response['ID'] = $initiationId;
                $response['message']= 'Saved Successfully';
            }
        } catch (\Exception $e) {}

        return (object) $response;
    }

    function saveStudentMarks($studentData) {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';
        $response['message']= 'Error Occurred';

        try {
            foreach ($studentData['subjects'] as $key => $subject) {

                if ($subject['subject_id'] == '') {
                    continue;
                }

                $initiationData = ['student_no' => $studentData['student_no'], 'mark' => $subject['mark'], 'initiation_id' => $studentData['initiation_id'],
                'term_id' => $studentData['term_id'], 'exam_id' => $studentData['exam_id'], 'subject_id' => $subject['subject_id'], 'added_by_id' => h_session('current_user_id') ];
                $this->db->table('sch_marks_import')->insert($initiationData);
                $initiationId = $this->db->insertID();

                // Complete transaction
                if ($initiationId > 0) {
                    // migrate
                    $student = $this->db->table('sch_people as people')
                                ->select('student.*')
                                ->where('people.people_number', $studentData['student_no'] )
                                ->join('sch_student AS student', 'student.people_id = people.id')
                                ->get()
                                ->getRow();
                
                    if ($student) {
                        $mark = $this->db->table('sch_marksheet')
                                ->select('*')
                                ->where('subject_id', $subject['subject_id'] )
                                ->where('student_id', $student->id )
                                ->where('exam_id', $studentData['exam_id'] )
                                ->where('term_id', $studentData['term_id'] )
                                ->get()
                                ->getRow();
                        if ($mark) {

                            // update if already existing
                            $this->db->table('sch_marksheet')
                                ->where('id', $mark->id)
                                ->update(['mark' => $subject['mark'] ]);

                        } else {
                            $marksData = ['student_id' => $student->id, 'subject_id' => $subject['subject_id'], 'exam_id' => $studentData['exam_id'], 'term_id' => $studentData['term_id'], 'mark' => $subject['mark'], 'added_by_id' => h_session('current_user_id'), 'date_added' => date('Y-m-d H:i:s') ];
                            $this->db->table('sch_marksheet')->insert($marksData);
                        }
        
                        $this->db->table('sch_marks_import')
                            ->where('id', $initiationId)
                            ->update(['status' => 'SUCCESS']);
                    }
                }
            }

            $response['success'] = true;
            $response['StatusCode'] = '00';
            $response['message']= 'Success';
        } catch (\Exception $e) {}

        return (object) $response; 
    }

    function listMarksImportInitation()  {
        $marksInitiation = $this->db->table('sch_import_initiation')
                    ->select('*')
                    ->where('deleted', 0)
                    ->where('initiation_type', 'marks')
                    ->where('added_by_id', h_session('current_user_id'))
                    ->get()
                    ->getResult();

        foreach ($marksInitiation as $key => $markInitiation) {
            $success = $this->db->table('sch_marks_import')
                    ->select('*')
                    ->where('status', 'SUCCESS')
                    ->where('initiation_id', $markInitiation->id)
                    ->get()
                    ->getResult();
            
            $markInitiation->successCount = count($success);

            $failed = $this->db->table('sch_marks_import')
                    ->select('*')
                    ->where('status', 'FAILED')
                    ->where('initiation_id', $markInitiation->id)
                    ->get()
                    ->getResult();

            $markInitiation->failedCount = count($failed);
        }

        return $marksInitiation ? $marksInitiation : [];
    }

    function saveImportTermStudents($data) {

        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';
        $response['message']= 'Error Occurred';

        $from = $data['from_term'];
        $to = $data['to_term'];

        $fromterms = $this->db->table('sch_stream_students')
                    ->select('*')
                    ->where('term_id', $from)
                    ->where('deleted', 0)
                    ->where('status', 'active')
                    ->get()
                    ->getResult();

        foreach ($fromterms as $key => $fromterm) {
            $exist = $this->db->table('sch_stream_students')
                    ->select('*')
                    ->where('term_id', $to)
                    ->where('student_id', $fromterm->student_id)
                    ->get()
                    ->getResult();

            if (empty($exist)) {
                $studentData = ["student_id" => $fromterm->student_id, "class_stream_id" => $fromterm->class_stream_id, 'term_id' =>$to, 'is_new_student' => 0, 'added_by_id' => h_session('current_user_id') ];
                $this->db->table('sch_stream_students')->insert($studentData);

                $subjects = $this->db->table('sch_stream_student_term_subjects')
                    ->select('*')
                    ->where('term_id', $from)
                    ->where('student_id', $fromterm->student_id)
                    ->get()
                    ->getResult();

                foreach ($subjects as $key => $subject) {
                    $subjectData = ["student_id" => $subject->student_id, "subject_id" => $subject->subject_id, 'term_id' =>$to, 'stream_id' => $subject->stream_id, 'added_by_id' => h_session('current_user_id') ];
                    $this->db->table('sch_stream_student_term_subjects')->insert($subjectData);
                }
            }
        }

        $response['success'] = true;
        $response['StatusCode'] = '00';
        $response['message']= 'Success';

        return (object) $response; 
    }
}