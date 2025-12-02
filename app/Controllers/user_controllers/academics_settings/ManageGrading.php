<?php

namespace App\Controllers\user_controllers\academics_settings;

use App\Controllers\BaseController;
use App\Models\user_models\academics_settings\M_ManageGrading;
use App\Models\user_models\academics_settings\M_ManageAcademicYears;
use App\Models\user_models\academics\M_ManageTerms;

class ManageGrading extends BaseController
{
    protected $modal;
    protected $modal1;
    protected $modal2;

    public function __construct()
    {

        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        // initiate school db connection
        $this->modal = new M_ManageGrading();
        $this->modal1 = new M_ManageAcademicYears();
        $this->modal2 = new M_ManageTerms();
    }

    public function index()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = $this->modal->listRegisteredClassGrades();
        $data['grades'] = $results;

        h_set_session('current_page', 'Class Grading');
        return view('user_pages/academics_settings/grading/list-grades', $data);
    }

    public function submitClassesGrading()
    {

        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        // Initialize the array to hold the transformed data
        $grades = [];
        $grade = h_post('grade');
        $grade_min = h_post('grade_min');
        $grade_max = h_post('grade_max');
        $grade_agg = h_post('grade_agg');
        $grade_remark = h_post('grade_remark');

        $grade_title = h_post('grade_title');
        $class_ids = h_post('class_ids');
        $description = h_post('description');

        $numberOfGrades = count($grade);
        // Iterate over each position in the arrays
        for ($i = 0; $i < $numberOfGrades; $i++) {
            $grades[] = [
                'grade' => $grade[$i],
                'min' => $grade_min[$i],
                'max' => $grade_max[$i],
                'aggregate' => $grade_agg[$i],
                'remarks' => $grade_remark[$i]
            ];
        }

        $data = [
            "grade" => ["title" => $grade_title, "description" => $description],
            "classes" =>  $class_ids,
            "grades" => $grades
        ];
        $response = $this->modal->saveClassGradeData($data);

        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Grade Saved Successfully';
        }

        return $this->response->setJSON($results);
    }

    public function viewGradeInfo()
    {
        if (!is_logged_in()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $gradeId = h_post('grade_id');
        $grade = $this->modal->getGradeById($gradeId);

        if (!$grade) {
            return $this->response->setJSON(['success' => false, 'message' => 'Grade not found']);
        }

        // get all classes
        $classes = $this->modal->listAllSchoolClasses();

        $html = view('user_pages/academics_settings/grading/edit-grade', [
            'grade' => $grade,
            'classes' => $classes
        ]);

        return $this->response->setJSON(['success' => true, 'html' => $html]);
    }

    public function updateClassGrade()
    {
        if (!is_logged_in()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $results = ['success' => false, 'message' => 'Update failed'];

        $id = h_post('grade_id');
        $grade_title = h_post('grade_title');
        $description = h_post('description');
        $class_ids = h_post('class_ids');
        $grades = [];

        $grade = h_post('grade');
        $grade_min = h_post('grade_min');
        $grade_max = h_post('grade_max');
        $grade_agg = h_post('grade_agg');
        $grade_remark = h_post('grade_remark');

        if ($id && $grade_title) {
            for ($i = 0; $i < count($grade); $i++) {
                $grades[] = [
                    'grade' => $grade[$i],
                    'min' => $grade_min[$i],
                    'max' => $grade_max[$i],
                    'aggregate' => $grade_agg[$i],
                    'remarks' => $grade_remark[$i]
                ];
            }

            $data = [
                "grade" => ["title" => $grade_title, "description" => $description],
                "classes" => $class_ids,
                "grades" => $grades
            ];

            $response = $this->modal->updateClassGradeData($id, $data);

            if ($response->success) {
                $results['success'] = true;
                $results['message'] = 'Grade updated successfully';
            } else {
                $results['message'] = $response->message ?? 'Update failed';
            }
        }

        return $this->response->setJSON($results);
    }

    public function listExaminations()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = $this->modal->listRegisteredExams();
        $data['exams'] = $results;

        h_set_session('current_page', 'Examinations');
        return view('user_pages/academics_settings/exam/index', $data);
    }

    public function submitExaminationForm()
    {

        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $name = h_post('name');
        $shortName = h_post('short_name');
        $description = h_post('description');

        $data = ['name' => $name, 'short_name' => $shortName, 'description' => $description, 'added_by_id' => h_session('current_user_id')];
        $response = $this->modal->saveExamData($data);

        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Exam Saved Successfully';
        }

        return $this->response->setJSON($results);
    }

    public function viewExaminationInfo()
    {
        if (!is_logged_in()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $examId = h_post('exam_id');

        if (!$examId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Missing exam ID']);
        }

        $exam = $this->modal->getExamById($examId);

        if (!$exam) {
            return $this->response->setJSON(['success' => false, 'message' => 'Exam not found']);
        }

        try {
            $html = view('user_pages/academics_settings/exam/edit-exam', ['exam' => $exam]);

            return $this->response->setJSON([
                'success' => true,
                'html' => $html
            ]);
        } catch (\Throwable $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'View error: ' . $e->getMessage()
            ]);
        }
    }

    public function updateExaminationForm()
    {
        if (!is_logged_in()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $examId = h_post('exam_id');
        $data = [
            'name' => h_post('name'),
            'short_name' => h_post('short_name'),
            'description' => h_post('description'),
        ];

        $response = $this->modal->updateExamData($examId, $data);

        if ($response->success) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Exam updated successfully',
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => $response->message ?? 'Update failed'
        ]);
    }

    public function deleteExam()
    {
        if (!is_logged_in()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized request.'
            ]);
        }

        $examId = h_post('id');

        if (!$examId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Missing exam ID.'
            ]);
        }

        $response = $this->modal->markExamAsDeleted($examId);

        return $this->response->setJSON($response);
    }


    public function listReportCardsTemplatesIndex()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = $this->modal1->listRegisteredAcademicYears();
        $data['academic_years'] = $results;

        h_set_session('current_page', 'Report Cards Templates');
        return view('user_pages/academics_settings/report_cards/index', $data);
    }

    function listReportCardsTemplatesView()
    {
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        $termId = h_post('term_id');
        $data['templates'] = $this->modal->listRegisteredTemplates($termId);
        $data['classes'] = $this->modal2->listTermClasses($termId);
        $data['termId'] = $termId;

        $response = ['success' => true, "html" => view('user_pages/academics_settings/report_cards/templates-view', $data)];
        return $this->response->setJSON($response);
    }

    function listReportCardsTemplates()
    {
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];
            return $this->response->setJSON($response);
        }

        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';
        // template
        $template = h_post('template');
        $page = "user_pages/academics_settings/report_cards/templates/template1";

        if ($template == 'template_2') {
            $page = "user_pages/academics_settings/report_cards/templates/template2";
        }

        $data = [];
        $response = ['success' => true, "html" => view($page, $data)];
        return $this->response->setJSON($response);
    }

    function submitReportCardsTemplate()
    {
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];
            return $this->response->setJSON($response);
        }

        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $classes = h_post('classes');
        $template = h_post('template');
        $name = h_post('name');
        $termId = h_post('termId');

        $directory = "report-card-templates";
        $school_id = h_session('school_id');
        $uploadsPath = ROOTPATH . 'public/assets/uploads/' . $school_id . '/' . $directory . '/';

        // Create the directory if it doesn't exist
        if (!is_dir($uploadsPath)) {
            mkdir($uploadsPath, 0755, true);
        }

        // Save $content to a file
        $fileName = 'template' . '_' . time() . '.php';
        file_put_contents($uploadsPath . $fileName, json_decode($template));
        // Set proper permissions on the uploaded file
        chmod($uploadsPath . $fileName, 0644);

        // Construct the URL to the uploaded image
        $templateURL = 'assets/uploads/' . $school_id . '/' . $directory . '/' . $fileName;

        $data = ['classes' => json_decode($classes), 'template' => $templateURL, 'name' => $name, 'term_id' => $termId, 'file_name' => explode('.', $fileName)[0]];
        $response = $this->modal->saveReportCardTemplateData($data);

        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Template Saved Successfully';
        } else {

            $file = $uploadsPath . $fileName;
            if (file_exists($file)) {
                unlink($file);
            }

            $results['message'] = 'Template Already Exist';
        }

        return $this->response->setJSON($results);
    }

    function updateReportCardsTemplateView()
    {
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];
            return $this->response->setJSON($response);
        }

        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $template = h_post('template');
        $termId = h_post('term_id');
        $title = "";
        $classesList = [];
        $filePath = "";

        $templates = $this->modal->getRegisteredTemplate($template, $termId);
        foreach ($templates as $key => $template) {
            $title = $template->name;
            $classesList[] = $template->class_id;
            $filePath = $template->url;
        }

        $data['classes'] = $this->modal2->listTermClasses($termId);
        $data['classesList'] = $classesList;
        $data['title'] = $title;
        $data['termId'] = $termId;

        $fileContent = "";
        if (file_exists($filePath)) {
            $fileContent = file_get_contents($filePath);
        }

        $student_pic = 'https://media.licdn.com/dms/image/v2/D4D03AQGAEvNqc5WNaA/profile-displayphoto-shrink_800_800/profile-displayphoto-shrink_800_800/0/1698398514651?e=1743638400&v=beta&t=buTfEQ-sp7n7-NXkB1o-Tf5_GCeaV_Il8WVdCV0lT4U';
        $school_logo = 'https://schoolhub.inocrate.com/assets/uploads/7/logo/inocrate-logo-removebg-preview_1719054676.png';
        $fileContent = str_replace("{school_logo}", $school_logo, $fileContent);
        $fileContent = str_replace("{student_profile_image}", $student_pic, $fileContent);
        $response = ['success' => true, 'template' => $fileContent, "html" => view('user_pages/academics_settings/report_cards/templates/edit-template', $data)];
        return $this->response->setJSON($response);
    }
}
