<?php

namespace App\Controllers\user_controllers\academics;

use App\Controllers\BaseController;
use App\Models\user_models\academics_settings\M_ManageAcademicYears;
use App\Models\user_models\academics\M_ManageTerms;
use App\Models\user_models\staff\M_ManageStaff;
use App\Models\user_models\academics_settings\M_ManageGrading;

class ManageTerms extends BaseController 
{
    protected $modal;

	public function __construct()
	{

        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        // // initiate school db connection
        $this->modal = new M_ManageTerms();
        $this->modal1 = new M_ManageStaff();
        $this->modal2 = new M_ManageAcademicYears();
        $this->modal3 = new M_ManageGrading();
    }

    public function listTermClasses()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = $this->modal2->listRegisteredAcademicYears();
        $data['academic_years'] = $results;

        h_set_session('current_page','Term Classes');
        return view('user_pages/academics/term_classes/index', $data);
    }


    public function listTermSubjects()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = $this->modal2->listRegisteredAcademicYears();
        $data['academic_years'] = $results;
        h_set_session('current_page','Term Subjects');
        return view('user_pages/academics/term_subjects/index', $data);
    }

    public function listStudentSubjects()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = $this->modal2->listRegisteredAcademicYears();
        $data['academic_years'] = $results;
        h_set_session('current_page','Student Subjects');
        return view('user_pages/academics/term_student_subjects/index', $data);
    }

    function listTermClassesList() {
        $response = [];
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        $termId = h_post('termId');
        $results = $this->modal->listTermClasses($termId);
        $response = ['success' => true, "classes" => $results];
        return $this->response->setJSON($response);
    }

    function listTermClassStreams()  {
        $response = [];
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        $classId = h_post('classId');
        $termId = h_post('termId');
        $streams = $this->modal->listTermClassStreams($classId, $termId);
        $response = ['streams' => $streams, 'success' => true ];
        return $this->response->setJSON($response);
    }

    public function listTermClassStreamsView()
    {
        $response = [];
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        if (h_is_ajax_request()) {
            $type = h_post('type');
            if ($type == 'list-classes') {
                $termId = h_post('termId');
                $class = '';
                $classID = '';
                $streams = [];

                $results = $this->modal->listTermClasses($termId);
                if ($results) {
                    $class = $results[0];
                    $classID = $class->id;
                }

                if ($classID != '') {
                    $streams = $this->modal->listTermClassStreams($classID, $termId);
                }
                $data = ['classes' => $results, 'streams' => $streams, 'class' => $class, 'class_id' => $classID ];
                $response = ['success' => true, "html" => view('user_pages/academics/term_classes/class-streams-view', $data) ];
            }

            else if ($type == 'list-class-streams') {
                $classId = h_post('classId');
                $termId = h_post('termId');
                $streams = [];
               
                if ($classId != '') {
                    $streams = $this->modal->listTermClassStreams($classId, $termId);
                }
                $data = ['streams' => $streams, 'class' => '', 'class_id' => $classId ];
                $response = ['success' => true, "html" => view('user_pages/academics/term_classes/class-stream-table', $data) ];
            }
        }
        
        return $this->response->setJSON($response);
    }

    public function submitTermClassesForm()
    {
        $response = [];
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $stream = h_post('stream');
        $class = h_post('class');
        $termId = h_post('term');

        $data = ['stream_id' => $stream, 'academic_term_id' => $termId, 'class_id' => $class, 'added_by' => h_session('current_user_id') ];
        $response = $this->modal->saveTermClassStreamData($data);

        $results['success'] = $response->success;
        $results['message'] = $response->message;
        
        return $this->response->setJSON($results);
    }

    public function listTermClassSubjectsView()
    {
        $response = [];
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        if (h_is_ajax_request()) {
            $type = h_post('type');
            if ($type == 'list-classes') {
                $termId = h_post('termId');
                $class = '';
                $classID = '';
                $subjects = [];

                $results = $this->modal->listTermClasses($termId);
                if ($results) {
                    $class = $results[0];
                    $classID = $class->id;
                }

                if ($classID != '') {
                    $subjects = $this->modal->listTermClassSubjects($classID, $termId);
                }
                $data = ['classes' => $results, 'subjects' => $subjects, 'class' => $class, 'class_id' => $classID ];
                $response = ['success' => true, "html" => view('user_pages/academics/term_subjects/term-subjects-view', $data) ];
            }

            else if ($type == 'list-class-subjects') {
                $classId = h_post('classId');
                $termId = h_post('termId');
                $subjects = [];
               
                if ($classId != '') {
                    $subjects = $this->modal->listTermClassSubjects($classId, $termId);
                }
                $data = ['subjects' => $subjects, 'class' => '', 'class_id' => $classId ];
                $response = ['success' => true, "html" => view('user_pages/academics/term_subjects/term-subjects-table', $data) ];
            }

            else if ($type == 'list-subjects-teachers') {
                $subjects = $this->modal2->listRegisteredSubjects();
                $teachers = $this->modal1->listSchoolTeachers();
                
                $response = ['success' => true, 'teachers' => $teachers, 'subjects' => $subjects ];
            }
        }
        
        return $this->response->setJSON($response);
    }


    public function submitTermClassSubjectForm()
    {
        $response = [];
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $classId = h_post('class');
        $termId = h_post('term');

        $subject = h_post('subject');
        $teacher = h_post('teacher');
        $type =  h_post('subject_type'); 

        $data = ['subject_id' => $subject, 'subject_type' => $type, 'teacher_id' => $teacher, 'added_by_id' => h_session('current_user_id') ];
        $response = $this->modal->saveTermClassSubjectData($data, $classId, $termId);

        $results['success'] = $response->success;
        $results['message'] = $response->message;
        
        return $this->response->setJSON($results);
    }
   
    function listTermExaminations() {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = $this->modal2->listRegisteredAcademicYears();
        $data['academic_years'] = $results;
        h_set_session('current_page','Term Exams');
        return view('user_pages/academics/term_exams/index', $data);
    }

    public function listTermClassExams()
    {
        $response = [];
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        $term_id = h_post('term_id');
        $results = $this->modal->listTermClassExams($term_id);

        $data = ['exams' => $results ];
        $response = ['success' => true, 'exams' => $results, "html" => view('user_pages/academics/term_exams/list-term-class-exam', $data) ];

        return $this->response->setJSON($response);
    }

    function listTermClassExamEdit() {
        $response = [];
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        $termId = h_post('term_id');
        $results = $this->modal->listTermClasses($termId);
        $exams = $this->modal3->listRegisteredExams();

        $data = ['classes' => $results, 'exams' => $exams, 'termId' => $termId ];
        $response = ['success' => true, "html" => view('user_pages/academics/term_exams/add-term-exam', $data) ];
        return $this->response->setJSON($response);
    }

    function submitTermClassExam()  {
        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        $examId = h_post('examId');
        $class = h_post('class');
        $termId = h_post('termId');
        $data = [ 'exam_id' => $examId, 'classes' =>  json_decode($class), 'term_id' => $termId ];
        $response = $this->modal->saveClassTermExam($data);
        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Saved Successfully';
        }

        return $this->response->setJSON($results);
    }

    function termClassMarksheetsIndex() {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = $this->modal2->listRegisteredAcademicYears();
        $data['academic_years'] = $results;
        h_set_session('current_page','Marksheet');
        return view('user_pages/academics/marksheets/index', $data);
    }

    function termClassMarksheetView()  {
        
        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        $type = h_post('type');
        $streamId = h_post('streamId');
        $termId = h_post('termId');
        $classId = h_post('classId');
        $page = '';
        $data = [];
        if ($type == 'view-subjects') {
            $page = 'user_pages/academics/marksheets/class-marksheet-view';

            $subjects = $this->modal->listTermClassSubjects($classId, $termId);
            $subject = !empty($subjects)? $subjects[0]: [];
            $data['subjects'] = $subjects;
            $data['subject'] = $subject;

            if ($subject) {
                $subjectId = $subject->subject_id;
            }
            $exams = $this->modal->listTermClassExams($termId, $classId);
            $data['exams'] = $exams;

            $students = $this->modal->listSubjectTermStudents($streamId, $termId, $subjectId);
            $data['students'] = $students;
            $data['subjectId'] = $subjectId;
            $data['termId'] = $termId;
        }
        if ($type == 'view-subjects-table') {
            $page = 'user_pages/academics/marksheets/class-marksheet-table';
            $subjectId = h_post('subjectId');

            $exams = $this->modal->listTermClassExams($termId, $classId);
            $data['exams'] = $exams;

            $students = $this->modal->listSubjectTermStudents($streamId, $termId, $subjectId);
            $data['students'] = $students;
            $data['subjectId'] = $subjectId;
            $data['termId'] = $termId;
        }

        $response = ['success' => true, "html" => view($page, $data) ];
        return $this->response->setJSON($response);
    }

    function termStudentSubjectsView() {
        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        $type = h_post('type');
        $page = "";
        $data = [];
        $students = [];
        if ($type == 'view') {
            $termId = h_post('termId');
            $classId = h_post('classId');
            $page = "user_pages/academics/term_student_subjects/term-student-subjects-view";

            $streams = [];
            $stream = [];
            $streamId = '';
               
            if ($classId != '') {
                $streams = $this->modal->listTermClassStreams($classId, $termId);
                if (!empty($streams)) {
                    $stream = $streams[0];
                    $streamId = $streams[0]->id;
                }
            }

            if ($stream) {
                $students = $this->modal->listTermClassStudents($stream->id, $termId);
            }

            $data = ['streams' => $streams, 'stream' => $stream, 'streamId' => $streamId, 'students' => $students ];
        }
        if ($type == 'student-subject-table') {
            $page = "user_pages/academics/term_student_subjects/term-student-subjects-table";

            $termId = h_post('termId');
            $streamId = h_post('streamId');

            if ($streamId) {
                $students = $this->modal->listTermClassStudents($streamId, $termId);
            }

            $data = ['students' => $students, 'streamId' => $streamId ];
        }
        if ($type == 'edit-student-subject') {
            $page = "user_pages/academics/term_student_subjects/edit-student-subjects";
            $studentId = h_post('studentId');
            $termId = h_post('termId');
            $classId = h_post('classId');
            $streamId = h_post('streamId');

            $subjects = $this->modal->listTermClassSubjects($classId, $termId);
            $data = ['subjects' => $subjects, 'studentId' => $studentId, 'termId' => $termId, 'classId' => $classId, 'streamId' => $streamId ];
        }

        $response = ['success' => true, "html" => view($page, $data) ];
        return $this->response->setJSON($response);
    }

    function submitTermStudentSubjects() {
        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        $streamId = h_post('streamId');
        $subjects = h_post('subjects');
        $termId = h_post('termId');
        $studentId = h_post('studentId');

        $data = [ 'stream_id' => $streamId, 'subjects' =>  json_decode($subjects), 'term_id' => $termId, 'student_id' => $studentId ];
        $response = $this->modal->saveStudentTermSubjects($data);
        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Saved Successfully';
        }

        return $this->response->setJSON($results);
    }

    function submitTermClassMarksheet() {
        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        $mark = h_post('mark');
        $studentId = h_post('studentId');
        $examId = h_post('examId');
        $termId = h_post('termId');
        $subjectId = h_post('subjectId');

        $data = [ 'mark' => $mark, 'subject_id' => $subjectId, 'term_id' => $termId, 'exam_id' => $examId, 'student_id' => $studentId ];
        $response = $this->modal->saveStudentTermSubjectMarksheet($data);
        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Saved Successfully';
        }

        return $this->response->setJSON($results);
    }

    function listTermOtherSettingsIndex() {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = $this->modal2->listRegisteredAcademicYears();
        $data['academic_years'] = $results;

        $data['grade_ranges'] = $this->modal->listGradeRanges();

        h_set_session('current_page','Academics Other Settings');
        return view('user_pages/academics/other_settings/index', $data );
    }

    function termOtherSettingsView() {
        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        $view = h_post('view');
        $termId = h_post('termId');
        $page = "";
        $data = [];
        if ($view == 'grading') {
            $page = "user_pages/academics/other_settings/grading/term-grading-table";

            $data['grades'] = $this->modal->listTermClassGrading($termId);;
        }
        if ($view == 'grading-form') {
            $page = "user_pages/academics/other_settings/grading/add-term-grading";
            $results = $this->modal->listTermClasses($termId);
            $data['classes'] = $results;
        }

        $data['termId'] = $termId;

        $response = ['success' => true, "html" => view($page, $data) ];
        return $this->response->setJSON($response);
    }

    function submitTermGradingForm() {
        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        $grading = h_post('grading');
        $classes = h_post('classes');
        $termId = h_post('termId');

        $data = [ 'grading' => $grading, 'classes' => json_decode($classes), 'termId' => $termId ];
        $response = $this->modal->saveTermClassGrade($data);
        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Saved Successfully';
        }

        return $this->response->setJSON($results);
    }

    function generateSingleStudentReportCard() {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = $this->modal2->listRegisteredAcademicYears();
        $data['academic_years'] = $results;

        h_set_session('current_page','Generate Report Card');
        return view('user_pages/academics/report_cards/single/index', $data);
    }

    function generateClassReportCard() {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = $this->modal2->listRegisteredAcademicYears();
        $data['academic_years'] = $results;

        h_set_session('current_page','Generate Report Card');
        return view('user_pages/academics/report_cards/bulk/index', $data);
    }

    function generateStudentReportCard() {
        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        $termId = h_post('termId');
        $studentId = h_post('studentId');
        $examId = h_post('examId');
        $classId = h_post('classId');

        $page = "user_pages/academics/report_cards/grading-report-card-table";
        $reports = $this->modal->generateStudentReportCard([ 'termId' => $termId, 'studentId' => $studentId, 'classId' => $classId, 'examId' => $examId ]);
        $reports['studentId'] = intval($studentId);
        $response = ['success' => true, 'reports'=> $reports, "html" => view($page, $reports) ];
        return $this->response->setJSON($response);
    }


    function generateStudentReportCardpdf() {
        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        helper('h_report_cards');        

        $termId = h_post('termId');
        $teacherComment = h_post('teacherComment');
        $hmComment = h_post('hmComment');
        $studentId = h_post('studentId');
        $classId = 0;
        $examId = h_post('examId');

        $school_name = h_session('school_name');
        $school_logo = h_session('school_logo');
        $email = h_session('email');
        $physical_address = h_session('physical_address');
        $phone = h_session('phone');

        $studentData = [];

        // term
        $termBeginsson = "";
        $termEndsOn = "";

        $studentData['next_term_begins_on'] = $termBeginsson;
        $studentData['next_term_ends_on'] = $termEndsOn;

        $studentData['school_name'] = $school_name;
        $studentData['school_address'] = $physical_address;
        $studentData['school_email'] = $email;
        $studentData['school_phone'] = $phone;

        $termName = "";
        $moto = "";
        $result = $this->modal2->getAcademicYearTermById($termId);
        if ($result) {
            $termName = $result->name;
        }

        $studentData['term_name'] = strtoupper($termName);

        $studentData['motto'] = $moto;
        $studentData['school_logo'] = $school_logo;
        $studentData['school_section'] = strtoupper("PRIMARY SCHOOL");
        $studentData['class_teacher_comment'] = $teacherComment;
        $studentData['head_teacher_comment'] = $hmComment;
        $studentData['head_teacher_sign'] = '';

        $result = $this->modal->generateStudentReportCard([ 'termId' => $termId, 'studentId' => $studentId, 'classId' => $classId, 'examId' => $examId ]);

        if ($result) {
            $studentObj = $result['students'][0];
            $studentData['student_info_name'] = $studentObj->name;
            $studentData['student_info_class'] = $studentObj->short_name;
            $studentData['student_info_gender'] = $studentObj->gender; 
            $studentData['student_profile_image'] = $studentObj->image_url? $studentObj->image_url:'';

            $studentData['student_obj'] = $studentObj;

            $exams = $result['exams'];
            $examsAdded = [];
            $studentExams = [];
            $subjectsMark = [];
            foreach ($exams as $index => $exam) {

                if (in_array($exam['short_name'], ['B.O.T', 'M.T.E', 'E.O.T'])) {
                    $examsAdded[] = $exam['short_name'];
                }

                $examGrading = [];
                $examGrading['grading_type_key'] = $result['grading_type_key'];
                // $examGrading['grading_type_key'] = 'grading';
                if ($result['grading_type_key'] == "positioning") {
                    $position = isset($studentObj->scores['marks'][$exam['id']]['position'])? $studentObj->scores['marks'][$exam['id']]['position']: '-';
                    $examGrading['position'] = $position;
                    $examGrading['number_of_students'] = $result['number_of_students'];
                } else {
                    $grading = !empty($studentObj->scores['marks'][$exam['id']]['grading'])? $studentObj->scores['marks'][$exam['id']]['grading']['grade_number']: '-';
                    $examGrading['position'] = $grading;
                }

                $studentExams[ $exam['short_name'] ] = $examGrading;
                
                $subjects = $result['subjects'];
                $subjectExamMarks = ["subjects" => $subjects, 'exam_id' => $exam['id'] ];

                $subjectsMark[ $exam['short_name'] ] = $subjectExamMarks;
            }
        }

        $studentData['exams_added'] = $examsAdded;
        $studentData['student_exams'] = $studentExams;
        $studentData['exam_marks'] = $subjectsMark;
        $pdf = "";

        if (count($examsAdded) == 1 && in_array('E.O.T', $examsAdded)) {
            $pdf = generateENDReportCard($studentData);
        }

        else if (count($examsAdded) == 1 && !in_array('E.O.T', $examsAdded)) {
            $pdf = generateBOTMTEReportCard($studentData);
        }

        else if (count($examsAdded) == 2 && in_array('E.O.T', $examsAdded) ) {
            $pdf = generateBOTORMTEEndReportCard($studentData);
        }

        else if (count($examsAdded) == 2 && !in_array('E.O.T', $examsAdded) ) {
            $pdf = generateBOTAndMTEReportCard($studentData);
        }

        else if (count($examsAdded) == 3 && in_array('E.O.T', $examsAdded) ) {
            $pdf = generateBOTMTEEndReportCard($studentData);
        }

        // Get the PDF content as a string
        // $fileContent = $pdf->Output('S'); // 'S' returns the PDF as a string
        $fileContent = $pdf->Output('', 'S');
        
        // Encode the content as base64
        $base64Content = base64_encode($fileContent);
        $response = [
            'success' => true,
            'template' => $base64Content // Base64-encoded PDF
        ];

        return $this->response->setJSON($response);
    }

    function generateBulkStudentReportCardspdf()  {
        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        helper('h_report_bulk_cards');

        $studentsData = [];

        $termId = h_post('termId');
        $teacherComment = h_post('teacherComment');
        $hmComment = h_post('hmComment');
        $examId = h_post('examId');

        $school_name = h_session('school_name');
        $school_logo = h_session('school_logo');
        $email = h_session('email');
        $physical_address = h_session('physical_address');
        $phone = h_session('phone');

        $selectedIds = h_post('selectedIds');
        $reortFileContent = "";
        foreach ($selectedIds as $key => $selectedId) {

            $studentData = [];

            // term
            $termBeginsson = "";
            $termEndsOn = "";

            $studentData['next_term_begins_on'] = $termBeginsson;
            $studentData['next_term_ends_on'] = $termEndsOn;

            $studentData['school_name'] = $school_name;
            $studentData['school_address'] = $physical_address;
            $studentData['school_email'] = $email;
            $studentData['school_phone'] = $phone;

            $termName = "";
            $moto = "";
            $result = $this->modal2->getAcademicYearTermById($termId);
            if ($result) {
                $termName = $result->name;
            }

            $studentData['term_name'] = strtoupper($termName);

            $studentData['motto'] = $moto;
            $studentData['school_logo'] = $school_logo;
            $studentData['school_section'] = strtoupper("PRIMARY SCHOOL");
            $studentData['class_teacher_comment'] = $teacherComment;
            $studentData['head_teacher_comment'] = $hmComment;
            $studentData['head_teacher_sign'] = '';

            $fileContent = "";
            $studentId = $selectedId;
            $classId = 0;
            
            $result = $this->modal->generateStudentReportCard([ 'termId' => $termId, 'studentId' => $studentId, 'classId' => $classId, 'examId' => $examId ]);
    
            if ($result) {
                $studentObj = $result['students'][0];
                $studentData['student_info_name'] = $studentObj->name;
                $studentData['student_info_class'] = $studentObj->short_name;
                $studentData['student_info_gender'] = $studentObj->gender;

                $studentData['student_obj'] = $studentObj;
                $studentData['student_profile_image'] = $studentObj->image_url? $studentObj->image_url:'';

                $exams = $result['exams'];
                $examsAdded = [];
                $studentExams = [];
                $subjectsMark = [];
                foreach ($exams as $index => $exam) {
                    if (in_array($exam['short_name'], ['B.O.T', 'M.T.E', 'E.O.T'])) {
                        $examsAdded[] = $exam['short_name'];
                    }

                    $examGrading = [];
                    $examGrading['grading_type_key'] = $result['grading_type_key'];
                    // $examGrading['grading_type_key'] = 'grading';
                    if ($result['grading_type_key'] == "positioning") {
                        $position = isset($studentObj->scores['marks'][$exam['id']]['position'])? $studentObj->scores['marks'][$exam['id']]['position']: '-';
                        $examGrading['position'] = $position;
                        $examGrading['number_of_students'] = $result['number_of_students'];
                    } else {
                        $grading = !empty($studentObj->scores['marks'][$exam['id']]['grading'])? $studentObj->scores['marks'][$exam['id']]['grading']['grade_number']: '-';
                        $examGrading['position'] = $grading;
                    }

                    $studentExams[ $exam['short_name'] ] = $examGrading;

                    $subjects = $result['subjects'];
                    $subjectExamMarks = ["subjects" => $subjects, 'exam_id' => $exam['id'] ];

                    $subjectsMark[ $exam['short_name'] ] = $subjectExamMarks;
                }
            }
    
            $studentData['exams_added'] = $examsAdded;
            $studentData['student_exams'] = $studentExams;
            $studentData['exam_marks'] = $subjectsMark;
            $studentsData[] = $studentData;
        }
        
        $pdf = "";
        if (count($examsAdded) == 1 && in_array('E.O.T', $examsAdded)) {
            $pdf = generateENDReportCard($studentsData);
        }

        else if (count($examsAdded) == 1 && !in_array('E.O.T', $examsAdded)) {
            $pdf = generateBOTMTEReportCard($studentsData);
        }

        else if (count($examsAdded) == 2 && in_array('E.O.T', $examsAdded) ) {
            $pdf = generateBOTORMTEEndReportCard($studentsData);
        }

        else if (count($examsAdded) == 2 && !in_array('E.O.T', $examsAdded) ) {
            $pdf = generateBOTAndMTEReportCard($studentsData);
        }

        else if (count($examsAdded) == 3 && in_array('E.O.T', $examsAdded) ) {
            $pdf = generateBOTMTEEndReportCard($studentsData);
        }

        // Get the PDF content as a string
        // $fileContent = $pdf->Output('S'); // 'S' returns the PDF as a string
        $fileContent = $pdf->Output('', 'S');
        
        // Encode the content as base64
        $base64Content = base64_encode($fileContent);
        $response = [
            'success' => true,
            'template' => $base64Content // Base64-encoded PDF
        ];

        return $this->response->setJSON($response);
    }

    function removeTermClassSubjects()  {
        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        $subjectid = h_post('subjectid');
        $classid = h_post('classid');
        $termid = h_post('termid');

        $data = [ 'subjectid' => $subjectid, 'termid' => $termid, 'classid' => $classid ];
        $response = $this->modal->removeClassTermSubjects($data);
        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Removed Successfully';
        }

        return $this->response->setJSON($results);
    }
}