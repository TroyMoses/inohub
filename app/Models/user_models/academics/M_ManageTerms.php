<?php

namespace App\Models\user_models\academics;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;
use Config\Database;

class M_ManageTerms extends Model
{
    protected $table = 'sch_academic_years';
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

    public function listTermClasses($termId)
    {
        $termClasses = $this->db->table('sch_academic_term_class_streams as term_class')
            ->select('term_class.class_id as id, class.name, class.short_name')
            ->where('term_class.academic_term_id', $termId)
            ->join('sch_classes AS class', 'class.id = term_class.class_id')
            ->groupBy('term_class.class_id, class.name, class.short_name')
            ->get()
            ->getResult();
        
        return $termClasses ? $termClasses : [];
    }

    public function listTermClassStreams($classId, $termId)
    {
        $termClassStreams = $this->db->table('sch_academic_term_class_streams as term_class')
            ->select('term_class.stream_id as id, stream.name, stream.short_name')
            ->where('term_class.class_id', $classId)
            ->where('term_class.academic_term_id', $termId)
            ->join('sch_streams AS stream', 'stream.id = term_class.stream_id')
            ->groupBy('term_class.stream_id, stream.name, stream.short_name')
            ->get()
            ->getResult();
        
        return $termClassStreams ? $termClassStreams : [];
    }


    public function saveTermClassStreamData($data)
    {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';
        $response['message']= 'Error Occurred';

        try {
                $termClasses = $this->db->table('sch_academic_term_class_streams')
                    ->select('*')
                    ->where('stream_id', $data['stream_id'])
                    ->where('class_id', $data['class_id'])
                    ->where('academic_term_id', $data['academic_term_id'])
                    ->get()
                    ->getResult();
                
                    if (!empty($termClasses)) {
                        $response['success'] = false;
                        $response['StatusCode'] = '58';
                        $response['message']= 'Class/Stream already registered';
                    }else{
                        // Start a transaction
                        $this->db->transStart();

                        $this->db->table('sch_academic_term_class_streams')->insert($data);

                        // Complete the transaction
                        $this->db->transComplete();
                    
                        // Check transaction status
                        if ($this->db->transStatus()) {
                            $response['success'] = true;
                            $response['StatusCode'] = '00';
                            $response['message']= 'Class Stream Saved Successfully';
                        }
                    }
            } catch (\Exception $e) {

            }

        return (object) $response;
    }

    public function listTermClassSubjects($classId, $termId)
    { 
        $termClasses = $this->db->table('sch_academic_term_class_streams')
            ->select('id')
            ->where('class_id', $classId)
            ->where('academic_term_id', $termId)
            ->get()
            ->getResult();
        
        $termClassIds = array_map(function($termClass) {
                return $termClass->id;
            }, $termClasses);
        
        $termClassSubjects = $this->db->table('sch_term_subjects as subjects')
            ->select('subjects.subject_id, subj.name, subj.code, subj.subject_type, subj.short_name, people.name as teacher_name, subjects.subject_type')
            ->whereIn('subjects.term_class_streams_id', $termClassIds)
            ->join('sch_subjects AS subj', 'subj.id = subjects.subject_id')
            ->join('sch_people AS people', 'people.id = subjects.teacher_id')
            ->groupBy('subjects.subject_id, subj.name, subj.code, subj.subject_type, subj.short_name, people.name, subjects.subject_type')
            ->get()
            ->getResult();
        
        return $termClassSubjects ? $termClassSubjects : [];
    }

    function removeClassTermSubjects($data)  {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';

        $subjectid = $data['subjectid'];
        $classid = $data['classid'];
        $termid = $data['termid'];

        try {
            $students = $this->db->table('sch_stream_student_term_subjects as student')
                ->select('student.id, student.student_id')
                ->where('student.term_id', $termid)
                ->where('student.subject_id', $subjectid)
                ->where('stream.class_id', $classid)
                ->join('sch_streams AS stream', 'stream.id = student.stream_id')
                ->get()
                ->getResult();

            foreach ($students as $key => $student) {
                $this->db->table('sch_marksheet')
                    ->where('student_id', $student->student_id)
                    ->where('subject_id', $subjectid)
                    ->where('term_id', $termid)
                    ->delete();

                $this->db->table('sch_stream_student_term_subjects')
                    ->where('id', $student->id)
                    ->delete();
            }

            $subjects = $this->db->table('sch_term_subjects as term_sub')
                    ->select('term_sub.id')
                    ->where('term_sub.subject_id', $subjectid)
                    ->where('stream.academic_term_id', $termid)
                    ->where('str.class_id', $classid)
                    ->join('sch_academic_term_class_streams AS stream', 'stream.id = term_sub.term_class_streams_id')
                    ->join('sch_streams AS str', 'str.id = stream.stream_id')
                    ->get()
                    ->getResult();

            foreach ($subjects as $key => $subject) {
                $this->db->table('sch_term_subjects')
                    ->where('id', $subject->id)
                    ->delete();
            }

            $response['success'] = true;
            $response['StatusCode'] = '00';
            $response['message'] = 'deleted Successfully';

        } catch (\Exception $e) {  }

        return (object) $response;
    }

    public function saveTermClassSubjectData($data, $classId, $termId)
    { 
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';
        $response['message']= 'Subject already registered';
        
        $termClasses = $this->db->table('sch_academic_term_class_streams')
            ->select('id')
            ->where('class_id', $classId)
            ->where('academic_term_id', $termId)
            ->get()
            ->getResult();
        
        foreach ($termClasses as $key => $termClass) {
            $termClassSubject = $this->db->table('sch_term_subjects')
                ->select('id')
                ->where('term_class_streams_id', $termClass->id)
                ->where('subject_id', $data['subject_id'])
                ->get()
                ->getResult();
                
            if (empty($termClassSubject)) {
                try {
                    $data['term_class_streams_id'] = $termClass->id;
                    // Start a transaction
                    $this->db->transStart();

                    $this->db->table('sch_term_subjects')->insert($data);

                    // Complete the transaction
                    $this->db->transComplete();
                
                    // Check transaction status
                    if ($this->db->transStatus()) {
                        $response['success'] = true;
                        $response['StatusCode'] = '00';
                        $response['message']= 'Subject Saved Successfully';
                    }
                } catch (\Exception $e) {
    
                }
            }
        }

        return (object) $response;
    }

    function listTermClassExams($term_id, $classId = 0) {
        if ($classId > 0) {
            $exams = $this->db->table('sch_term_class_exam term_exam')
                ->select('term_exam.*, exam.name, exam.short_name, class.name as class_name, class.short_name as class_short_name')
                ->where('term_exam.deleted', 0)
                ->where('term_exam.status', 0 )
                ->where('term_exam.term_id', $term_id)
                ->where('term_exam.class_id', $classId)
                ->where('exam.status', 0)
                ->join('sch_examinations AS exam', 'exam.id = term_exam.exam_id')
                ->join('sch_classes AS class', 'class.id = term_exam.class_id')
                ->get()
                ->getResult();
        }
        else {
            $exams = $this->db->table('sch_term_class_exam term_exam')
                ->select('term_exam.*, exam.name, exam.short_name, class.name as class_name, class.short_name as class_short_name')
                ->where('term_exam.deleted', 0)
                ->where('term_exam.status', 0 )
                ->where('term_exam.term_id', $term_id)
                ->where('exam.status', 0)
                ->join('sch_examinations AS exam', 'exam.id = term_exam.exam_id')
                ->join('sch_classes AS class', 'class.id = term_exam.class_id')
                ->get()
                ->getResult();
        }
        
        $formattedResults = [];
        // Process the result
        foreach ($exams as $exam) {
            
            $examIndex = array_search($exam->exam_id, array_column($formattedResults, 'exam_id'));
            if ($examIndex === false) {
                // If not, create a new entry for this exam_id
                $formattedResults[] = [
                    'id' => $exam->id,
                    'exam_id' => $exam->exam_id,
                    'name' => $exam->name,
                    'short_name' => $exam->short_name,
                    'term_id' => $exam->term_id,
                    'classes' => [
                        [
                            'id' => $exam->class_id,
                            'class_name' => $exam->class_name,
                            'short_name' => $exam->class_short_name,
                            'total_mark' => $exam->total_mark,
                            'final_mark_contribution' => $exam->final_mark_contribution
                        ]
                    ]
                ];
            } else {
                // If it exists, add the class and amount under the existing fees_type_name
                $formattedResults[$examIndex]['classes'][] = [
                    'id' => $exam->class_id,
                    'class_name' => $exam->class_name,
                    'short_name' => $exam->class_short_name,
                    'total_mark' => $exam->total_mark,
                    'final_mark_contribution' => $exam->final_mark_contribution
                ];
            }
        }

        return $formattedResults ? $formattedResults : [];
    }

    function saveClassTermExam($data) {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';
        $response['message']= 'Error Occurred';

        foreach ($data['classes'] as $key => $class) {
            $termClassExam = $this->db->table('sch_term_class_exam')
                                ->select('id')
                                ->where('exam_id', $data['exam_id'])
                                ->where('term_id', $data['term_id'])
                                ->where('class_id', $class->classID)
                                ->get()
                                ->getResult();
            if ($termClassExam) {
                continue;
            }

            try {

                // Start a transaction
                $this->db->transStart();

                $saveData = ['class_id' => $class->classID, 'term_id' => $data['term_id'], 'exam_id' => $data['exam_id'], 'added_by_id' => h_session('current_user_id'), 'total_mark' => $class->markedOut, 'final_mark_contribution' => $class->finalMark ];
                $this->db->table('sch_term_class_exam')->insert($saveData);

                // Complete the transaction
                $this->db->transComplete();
            
                // Check transaction status
                if ($this->db->transStatus()) {
                    $response['success'] = true;
                    $response['StatusCode'] = '00';
                    $response['message']= 'Saved Successfully';
                }
            } catch (\Exception $e) {

            }

        }

        return (object) $response;
    }

    function listTermClassStudents($streamId, $termId) {

        $streamStudents = $this->db->table('sch_stream_students std')
                        ->select('people.id as people_id, people.people_number, people.name,people.first_name,people.last_name, std.*')
                        ->where('std.term_id', $termId)
                        ->where('std.class_stream_id', $streamId)
                        ->where('std.deleted', 0)
                        ->where('std.status', 'active')
                        ->where('people.deleted', 0)
                        ->where('people.status', 'active')
                        ->join('sch_student AS student', 'student.id = std.student_id')
                        ->join('sch_people AS people', 'people.id = student.people_id')
                        ->get()
                        ->getResult();

        foreach ($streamStudents as $key => $streamStudent) {

            $studentSubjects = $this->db->table('sch_stream_student_term_subjects std')
                            ->select('subject.*, std.*')
                            ->where('std.student_id', $streamStudent->student_id)
                            ->where('std.term_id', $termId)
                            ->where('std.stream_id', $streamId)
                            ->where('std.deleted', '0')
                            ->where('std.status', 'active')
                            ->join('sch_subjects AS subject', 'subject.id = std.subject_id')
                            ->get()
                            ->getResult();

            $streamStudent->subjects = $studentSubjects ? $studentSubjects : [];
        }

        return $streamStudents? $streamStudents: [];
    }

    function saveStudentTermSubjects($data)  {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';
        $response['message']= 'Error Occurred';

        foreach ($data['subjects'] as $key => $subjectId) {
            $studentSubjects = $this->db->table('sch_stream_student_term_subjects')
                                ->select('id')
                                ->where('student_id', $data['student_id'])
                                ->where('subject_id', $subjectId)
                                ->where('term_id', $data['term_id'])
                                ->get()
                                ->getResult();
            if ($studentSubjects) {
                continue;
            }

            try {
                // Start a transaction
                $this->db->transStart();

                $saveData = ['subject_id' => $subjectId, 'term_id' => $data['term_id'], 'stream_id' => $data['stream_id'], 'student_id' => $data['student_id'], 'added_by_id' => h_session('current_user_id') ];
                $this->db->table('sch_stream_student_term_subjects')->insert($saveData);

                // Complete the transaction
                $this->db->transComplete();
            
                // Check transaction status
                if ($this->db->transStatus()) {
                    $response['success'] = true;
                    $response['StatusCode'] = '00';
                    $response['message']= 'Saved Successfully';
                }
            } catch (\Exception $e) {

            }

        }

        return (object) $response;
    }

    function listSubjectTermStudents($streamId, $termId, $subjectId) {
        $termstudents = [];
        if ($subjectId && $termId && $streamId) {
            $termstudents = $this->db->table('sch_stream_student_term_subjects std')
                                ->select('std.*, people.id as people_id, people.people_number, people.name,people.first_name,people.last_name')
                                ->where('std.subject_id', $subjectId)
                                ->where('std.term_id', $termId)
                                ->where('std.stream_id', $streamId)
                                ->where('std.deleted', '0')
                                ->where('std.status', 'active')
                                ->join('sch_student AS student', 'student.id = std.student_id')
                                ->join('sch_people AS people', 'people.id = student.people_id')
                                ->get()
                                ->getResult();

            foreach ($termstudents as $key => $termstudent) {
                $marksObj = [];
                $marks = $this->db->table('sch_marksheet')
                                ->select('*')
                                ->where('student_id', $termstudent->student_id)
                                ->where('subject_id', $termstudent->subject_id)
                                ->where('term_id', $termstudent->term_id)
                                ->get()
                                ->getResult();

                foreach ($marks as $markKey => $mark) {
                    $keyName = "{$mark->student_id}_{$mark->subject_id}_{$mark->term_id}_{$mark->exam_id}";
                    $marksObj[$keyName] = $mark->mark;
                }

                $termstudent->marks = $marksObj;
            }
        }

        return $termstudents ? $termstudents: [];
    }

    function saveStudentTermSubjectMarksheet($data) {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';
        $response['message']= 'Error Occurred';

        $studentSubjects = $this->db->table('sch_marksheet')
                                ->select('id')
                                ->where('student_id', $data['student_id'])
                                ->where('subject_id', $data['subject_id'])
                                ->where('exam_id', $data['exam_id'])
                                ->where('term_id', $data['term_id'])
                                ->get()
                                ->getRow();
        if (empty($studentSubjects)) {
            try {
                // Start a transaction
                $this->db->transStart();

                $saveData = ['student_id' => $data['student_id'], 'subject_id' => $data['subject_id'], 'exam_id' => $data['exam_id'], 'term_id' => $data['term_id'], 'mark' => $data['mark'], 'added_by_id' => h_session('current_user_id') ];
                $this->db->table('sch_marksheet')->insert($saveData);

                // Complete the transaction
                $this->db->transComplete();
            
                // Check transaction status
                if ($this->db->transStatus()) {
                    $response['success'] = true;
                    $response['StatusCode'] = '00';
                    $response['message']= 'Saved Successfully';
                }
            } catch (\Exception $e) {

            }
        }else {
            // Start a transaction
            $this->db->transStart();
        
            // Perform the update
            $updateData = ['mark' => $data['mark'] ];
            $this->db->table('sch_marksheet')
                ->where('id', $studentSubjects->id)
                ->update($updateData);
        
            // Complete the transaction
            $this->db->transComplete();
        
            // Check transaction status
            if ($this->db->transStatus() === true) {
                $response['success'] = true;
                $response['StatusCode'] = '00';
            } 
        }

        return (object) $response;
    }

    function listTermClassGrading($termId) {
        $grades = $this->db->table('sch_term_grading grade')
                ->select('grade.*, class.id as class_id, class.name as class_name, class.short_name as class_short_name')
                ->where('grade.deleted', 0)
                ->where('grade.status', 0 )
                ->where('grade.term_id', $termId)
                ->join('sch_classes AS class', 'class.id = grade.class_id')
                ->get()
                ->getResult();
        
        $formattedResults = [];
        // Process the result
        foreach ($grades as $grade) {
            
            $gradeIndex = array_search($grade->grading_key, array_column($formattedResults, 'grading_key'));
            if ($gradeIndex === false) {
                // If not, create a new entry for this grading_key
                $formattedResults[] = [
                    'id' => $grade->id,
                    'name' => $grade->name,
                    'grading_key' => $grade->grading_key,
                    'date_added' => $grade->date_added,
                    'term_id' => $grade->term_id,
                    'classes' => [
                        [
                            'id' => $grade->class_id,
                            'class_name' => $grade->class_name,
                            'short_name' => $grade->class_short_name
                        ]
                    ]
                ];
            } else {
                // If it exists, add the class and amount under the existing fees_type_name
                $formattedResults[$gradeIndex]['classes'][] = [
                    'id' => $grade->class_id,
                    'class_name' => $grade->class_name,
                    'short_name' => $grade->class_short_name
                ];
            }
        }

        return $formattedResults ? $formattedResults : [];
    }

    function saveTermClassGrade($data) {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';
        $response['message']= 'Error Occurred';

        if (!empty($data['classes'])) {
            foreach ($data['classes'] as $key => $classId) {
                $classGrade = $this->db->table('sch_term_grading')
                                ->select('id')
                                ->where('class_id', $classId )
                                ->where('term_id', $data['termId'])
                                ->get()
                                ->getRow();

                if (empty($classGrade)) {
                    try {
                        // Start a transaction
                        $this->db->transStart();

                        $saveData = ['class_id' => $classId, 'term_id' => $data['termId'], 'name' => $data['grading'] == 'grading'? 'Grading': 'Positioning', 'grading_key' => $data['grading'], 'added_by_id' => h_session('current_user_id') ];
                        $this->db->table('sch_term_grading')->insert($saveData);

                        // Complete the transaction
                        $this->db->transComplete();
                    
                        // Check transaction status
                        if ($this->db->transStatus()) {
                            $response['success'] = true;
                            $response['StatusCode'] = '00';
                            $response['message']= 'Saved Successfully';
                        }
                    } catch (\Exception $e) {

                    }
                }
            }
        }
        
        return (object) $response;
    }

    public function listGradeRanges()
    { 
        $ranges = $this->db->table('sch_grade_ranges')
            ->select('*')
            ->get()
            ->getResult();

        return $ranges ? $ranges : [];
    }

    function generateStudentReportCard($data) {
        $response = [];
        $classId = intval($data['classId']);
        $streamId = 0;
        $termId = $data['termId'];
        $studentId = intval($data['studentId']);
        $examId = $data['examId'];
        $subjectsList = [];
        $examsList = [];
        $gradingTypeKey = 'grading';
        $classStudents = [];

        if ($studentId > 0) {
            $student = $this->db->table('sch_stream_students student')
                ->select('student.*, stream.class_id')
                ->where('student.student_id', $studentId )
                ->where('student.term_id', $termId )
                ->where('student.status', 'active' )
                ->where('student.deleted', '0')
                ->join('sch_streams AS stream', 'stream.id = student.class_stream_id')
                ->get()
                ->getRow();

            if ($student) {
                $classId = $student->class_id;
                $streamId = $student->class_stream_id;
                $data['classId'] = $classId;
                $data['streamId'] = $streamId;
            }
        }

        $subjects = $this->db->table('sch_term_subjects term')
                    ->select('subject.id, subject.name, subject.code, subject.short_name, subject.subject_type, people.name as teacher_name, people.initials')
                    ->where('stream.class_id', $classId )
                    ->where('term.subject_type', 'Mandatory' )
                    ->where('stream.academic_term_id', $termId )
                    ->join('sch_academic_term_class_streams AS stream', 'stream.id = term.term_class_streams_id')
                    ->join('sch_subjects AS subject', 'subject.id = term.subject_id')
                    ->join('sch_people as people', 'people.id = term.teacher_id', 'left')
                    ->get()
                    ->getResult();

        if ($subjects) {
            // Filter subjects to ensure uniqueness by subject ID
            $uniqueSubjects = [];
            $subjectsList = array_filter(array_map(function($subject) use (&$uniqueSubjects) {
                if (!isset($uniqueSubjects[$subject->id])) {
                    $uniqueSubjects[$subject->id] = true;
                    return [
                        'id' => $subject->id,
                        'name' => $subject->name,
                        'code' => $subject->code,
                        'short_name' => $subject->short_name,
                        'subject_type' => $subject->subject_type,
                        'initials' => $subject->initials ? $subject->initials :'',
                        'teacher_name' => $subject->teacher_name
                    ];
                }
                return null;
            }, $subjects));
            // Remove null values from array_filter
            $subjectsList = array_values(array_filter($subjectsList));
        }

        if ($examId == 0 || $examId == '0') {
            $exams = $this->db->table('sch_term_class_exam class_exam')
                    ->select('exam.*, class_exam.total_mark, class_exam.final_mark_contribution')
                    ->where('class_exam.class_id', $classId )
                    ->where('class_exam.term_id', $termId )
                    ->where('class_exam.status', '0' )
                    ->where('class_exam.deleted', '0')
                    ->where('exam.status', '0' )
                    ->join('sch_examinations AS exam', 'exam.id = class_exam.exam_id')
                    ->orderBy('exam.id', 'ASC')
                    ->get()
                    ->getResult();
        }else {
            $exams = $this->db->table('sch_term_class_exam class_exam')
                    ->select('exam.*, class_exam.total_mark, class_exam.final_mark_contribution')
                    ->where('class_exam.class_id', $classId )
                    ->where('class_exam.term_id', $termId )
                    ->where('class_exam.exam_id', $examId )
                    ->where('class_exam.status', '0' )
                    ->where('class_exam.deleted', '0')
                    ->where('exam.status', '0' )
                    ->join('sch_examinations AS exam', 'exam.id = class_exam.exam_id')
                    ->orderBy('exam.id', 'ASC')
                    ->get()
                    ->getResult();
        }
        
        if ($exams) {
            $examsList = array_map(function($exam) {
                return ['id' => $exam->id, 'name' => $exam->name, 'short_name' => $exam->short_name, 'mark' => $exam->total_mark, 'final' => $exam->final_mark_contribution];
            }, $exams);
        }

        $data['subjects'] = $subjectsList;
        $data['exams'] = $examsList;

        // grade type
        $gradingType = $this->db->table('sch_term_grading')
            ->select('*')
            ->where('class_id', $classId )
            ->where('term_id', $termId )
            ->where('status', '0' )
            ->where('deleted', '0')
            ->get()
            ->getRow();

        if ($gradingType) {
            $gradingTypeKey = $gradingType->grading_key;
        }

        $students = [];
        if ($studentId > 0) {
            $students = $this->db->table('sch_stream_students as stream')
                ->select('people.*, stream.student_id, stream_class.name as class_name, stream_class.short_name, class.name as stream_name')
                ->where('stream.student_id', $studentId )
                ->where('stream.term_id', $termId )
                ->where('stream.status', 'active' )
                ->where('stream.deleted', '0')
                ->join('sch_student AS student', 'student.id = stream.student_id')
                ->join('sch_people AS people', 'people.id = student.people_id')
                ->join('sch_streams AS class', 'class.id = stream.class_stream_id')
                ->join('sch_classes AS stream_class', 'stream_class.id = class.class_id')
                ->get()
                ->getResult();
        } else {
            $students = $this->db->table('sch_stream_students as stream')
                ->select('people.*, stream.student_id, stream_class.name as class_name, stream_class.short_name, class.name as stream_name')
                ->where('stream.term_id', $termId )
                ->where('class.class_id', $classId )
                ->where('stream.status', 'active' )
                ->where('stream.deleted', '0')
                ->join('sch_student AS student', 'student.id = stream.student_id')
                ->join('sch_people AS people', 'people.id = student.people_id')
                ->join('sch_streams AS class', 'class.id = stream.class_stream_id')
                ->join('sch_classes AS stream_class', 'stream_class.id = class.class_id')
                ->get()
                ->getResult();
        }

        foreach ($students as $key => $student) {
            $data['studentId'] = $student->student_id;
            
            // generate report card
            if ($gradingTypeKey == 'grading') {
                $reportresponse = $this->generateGradingReportCard($data);
                $student->scores = $reportresponse;
            }

            if ($gradingTypeKey == 'positioning') {
                $classStudents = $this->db->table('sch_stream_students as stream')
                    ->select('people.*, stream.student_id, stream_class.name as class_name, stream_class.short_name, class.name as stream_name')
                    ->where('stream.term_id', $termId )
                    ->where('class.class_id', $classId )
                    ->where('stream.status', 'active' )
                    ->where('stream.deleted', '0')
                    ->join('sch_student AS student', 'student.id = stream.student_id')
                    ->join('sch_people AS people', 'people.id = student.people_id')
                    ->join('sch_streams AS class', 'class.id = stream.class_stream_id')
                    ->join('sch_classes AS stream_class', 'stream_class.id = class.class_id')
                    ->get()
                    ->getResult();
                $reportresponse = $this->generatePositioningReportCard($data, $classStudents);
                $student->scores = $reportresponse;
            }
        }
        
        $response['students'] = $students;
        $response['exams'] = $examsList;
        $response['subjects'] = $subjectsList;
        $response['number_of_students'] = count($classStudents);
        $response['grading_type_key'] = $gradingTypeKey;
        return $response;
    }

    function generatePositioningReportCard($data, $classStudents) {
        $response = [];

        $subjectsList = $data['subjects'];
        $examsList = $data['exams'];
        $classId = $data['classId'];
        $termId = $data['termId'];
        $studentId = $data['studentId'];

        foreach ($examsList as $exam) {
            $subjectsData = []; // Holds subjects and their marks for the current exam
            $total_marks = 0;
        
            foreach ($subjectsList as $subject) {
                $mark = $this->db->table('sch_marksheet')
                    ->select('*')
                    ->where('exam_id', $exam['id'])
                    ->where('term_id', $termId)
                    ->where('student_id', $studentId)
                    ->where('subject_id', $subject['id'])
                    ->get()
                    ->getRow();
                
                $final_mark = 0;
                if ($mark) {
                    $final_mark = $exam['mark'] < 100 ? round(($mark->mark / $exam['mark']) * 100) : $mark->mark;
                    $total_marks += $final_mark;
                }

                $subjectsData[$subject['id']] = [
                    'subject_id' => $subject['id'],
                    'name' => $subject['name'],
                    'code' => $subject['code'],
                    'short_name' => $subject['short_name'],
                    'subject_type' => $subject['subject_type'],
                    'mark' => $mark ? $mark->mark: 0,
                    'final_mark' => $final_mark,
                    'agg' => '',
                    'grade' => '',
                    'remarks' => ''
                ];
            }

            // Add the exam and its related subjects to the response
            $position = $this->positionExamStudents($classStudents, $exam, $subjectsList, $termId, $studentId);
            $response[$exam['id']] = [
                'exam_id' => $exam['id'],
                'name' => $exam['name'],
                'short_name' => $exam['short_name'],
                'total_mark' => $exam['mark'],
                'final_cont' => $exam['final'],
                'total' => $total_marks,
                'total_agg' => 0,
                'position' => $position,
                'subjects' => $subjectsData // Attach subjects with their marks
            ];
        }

        $resp = ['marks' => $response ];
        return $resp;
    }

    function positionExamStudents($classStudents, $exam, $subjectsList, $termId, $studentId) {
        $postioning = [];
        foreach ($classStudents as $key => $classStudent) {

            foreach ($subjectsList as $subject) {
                $mark = $this->db->table('sch_marksheet')
                    ->select('*')
                    ->where('exam_id', $exam['id'])
                    ->where('term_id', $termId)
                    ->where('student_id', $classStudent->student_id)
                    ->where('subject_id', $subject['id'])
                    ->get()
                    ->getRow();
                
                $final_mark = 0;
                if ($mark) {
                    $final_mark = $exam['mark'] < 100 ? round(($mark->mark / $exam['mark']) * 100) : $mark->mark;
                }

                $postioning[] = [
                    'student_id' => $classStudent->student_id,
                    'final_mark' => $final_mark
                ];
            }
        }

        // Sort by final_mark in descending order
        usort($postioning, function ($a, $b) {
            return $b['final_mark'] <=> $a['final_mark'];
        });

        // Assign positions
        $position = 0;
        $lastMark = null;
        $rankedPositioning = [];

        foreach ($postioning as $index => $student) {
            // Update position only if the mark is different from the last mark
            if ($student['final_mark'] !== $lastMark) {
                $position = $index + 1; // Position is index + 1 in the sorted array
            }
            $lastMark = $student['final_mark'];

            $rankedPositioning[] = [
                'student_id' => $student['student_id'],
                'final_mark' => $student['final_mark'],
                'position' => $position
            ];
        }

        foreach ($rankedPositioning as $student) {
            if ($student['student_id'] === $studentId) {
                return $student['position']; // Return the position for the matching student_id
            }
        }

        return 0;
    }

    function generateGradingReportCard($data) {
        $response = [];

        $subjectsList = $data['subjects'];
        $examsList = $data['exams'];
        $classId = $data['classId'];
        $termId = $data['termId'];
        $studentId = $data['studentId'];
        $all_agg = 0;

        foreach ($examsList as $exam) {
            $subjectsData = []; // Holds subjects and their marks for the current exam
            $total_marks = 0;
            $total_agg = 0;
        
            foreach ($subjectsList as $subject) {
                $mark = $this->db->table('sch_marksheet')
                    ->select('*')
                    ->where('exam_id', $exam['id'])
                    ->where('term_id', $termId)
                    ->where('student_id', $studentId)
                    ->where('subject_id', $subject['id'])
                    ->get()
                    ->getRow();
        
                if ($mark) {
                    $final_mark = $exam['mark'] < 100 ? round(($mark->mark / $exam['mark']) * 100) : $mark->mark;
                    $agg = $this->getSubjectMarksAgg($final_mark, $classId);
        
                    $total_marks += $final_mark;
                    $total_agg += ($agg ? $agg['agg'] : 0);
        
                    $subjectsData[$subject['id']] = [
                        'subject_id' => $subject['id'],
                        'name' => $subject['name'],
                        'code' => $subject['code'],
                        'short_name' => $subject['short_name'],
                        'subject_type' => $subject['subject_type'],
                        'mark' => $mark->mark,
                        'final_mark' => $final_mark,
                        'agg' => $agg ? $agg['agg'] : '',
                        'grade' => $agg ? $agg['grade'] : '',
                        'remarks' => $agg ? $agg['remarks'] : ''
                    ];
                }
            }
        
            // Add the exam and its related subjects to the response
            $grade = $this->db->table('sch_grade_ranges')
                ->select('*')
                ->where('max >=', $total_agg)
                ->where('min <=', $total_agg)
                ->get()
                ->getRow();

            $gradeObj = [];
            if ($grade) {
                $gradeObj = ['name' => $grade->name, 'grade' => $grade->short_name, 'grade_number' => $grade->grade_number,
                    'teacher_comment' => $grade->teacher_comment, 'hm_comment' => $grade->hm_comment, 'total_agg' => $total_agg ];
            }
            $response[$exam['id']] = [
                'exam_id' => $exam['id'],
                'name' => $exam['name'],
                'short_name' => $exam['short_name'],
                'total_mark' => $exam['mark'],
                'final_cont' => $exam['final'],
                'total' => $total_marks,
                'total_agg' => $total_agg,
                'subjects' => $subjectsData, // Attach subjects with their marks
                'grading' => $gradeObj
            ];

            $all_agg += $total_agg;
        }

        $grade = $this->db->table('sch_grade_ranges')
                ->select('*')
                ->where('max >=', $all_agg)
                ->where('min <=', $all_agg)
                ->get()
                ->getRow();
        
        $gradeObj = [];
        if ($grade) {
            $gradeObj = ['name' => $grade->name, 'grade' => $grade->short_name, 'grade_number' => $grade->grade_number,
                'teacher_comment' => $grade->teacher_comment, 'hm_comment' => $grade->hm_comment, 'total_agg' => $all_agg ];
        }
        
        $resp = ['grade' => $gradeObj, 'marks' => $response ];
        return $resp;
    }

    function getSubjectMarksAgg($mark, $classId) {
        $response = [];
        $grade = $this->db->table('sch_grading_classes class')
                    ->select('grade.*')
                    ->where('class.class_id', $classId )
                    ->where('class.status', '0' )
                    ->where('class.deleted', '0' )
                    ->where('grade.max >=', $mark )
                    ->where('grade.min <=', $mark )
                    ->join('sch_grading_grades AS grade', 'grade.grading_id = class.grading_id')
                    ->get()
                    ->getRow();
        if ($grade) {
            $response = ['grade' => $grade->grade, 'agg' => $grade->aggregate, 'remarks' => $grade->remarks];
        }

        return $response;
    }
}