<?php

namespace App\Controllers\user_controllers\academics_settings;

use App\Controllers\BaseController;
use App\Models\user_models\academics_settings\M_ManageAcademicYears;

class ManageAcademicYears extends BaseController
{
    protected $modal;

    public function __construct()
    {

        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        // initiate school db connection
        $this->modal = new M_ManageAcademicYears();
    }

    public function index()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = $this->modal->listRegisteredAcademicYears();

        if (h_is_ajax_request()) {
            // Handle AJAX request
            return $this->response->setJSON(['academic_years' => $results, 'success' => true]);
        }

        $data['academic_years'] = $results;
        h_set_session('current_page', 'Academic Years');
        return view('user_pages/academics_settings/academic_years/list-academic-years', $data);
    }

    public function submitAcademicYearForm()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $academicYearLabel = h_post('academic_year_label');
        $startDate = h_post('start_date');
        $endDate = h_post('end_date');

        $data = ['name' => $academicYearLabel, 'start_date' => $startDate, 'end_date' => $endDate, 'branch_id' => h_session('branch_id')];
        $response = $this->modal->saveAcademicYearData($data);
        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Academic Year Saved Successfully';
        }

        return $this->response->setJSON($results);
    }

    public function submitUpdateAcademicYearForm()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = ['success' => false, 'message' => 'Error Occurred'];

        $academicYearId = h_post('academic_year_id');
        $label = h_post('academic_year_label');
        $startDate = h_post('start_date');
        $endDate = h_post('end_date');

        if ($academicYearId && $label && $startDate && $endDate) {
            $data = [
                'name' => $label,
                'start_date' => $startDate,
                'end_date' => $endDate
            ];

            $response = $this->modal->updateAcademicYearData($academicYearId, $data);

            if ($response->success) {
                $results['success'] = true;
                $results['message'] = 'Academic Year Updated Successfully';
            } else {
                $results['message'] = $response->message ?? 'Failed to update.';
            }
        } else {
            $results['message'] = 'Missing required fields.';
        }

        return $this->response->setJSON($results);
    }

    public function submitAcademicYearTermForm()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $termLabel = h_post('term_label');
        $startDate = h_post('start_date');
        $endDate = h_post('end_date');
        $termAcademicYear = h_post('term_academic_year');
        $orderNumber = h_post('order_number');

        $data = ['name' => $termLabel, 'start_date' => $startDate, 'end_date' => $endDate, 'academic_year_id' => $termAcademicYear, 'order_number' => $orderNumber];
        $response = $this->modal->saveAcademicYearTermData($data);
        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Academic Year Term Saved Successfully';
        }

        return $this->response->setJSON($results);
    }



    // submitEditAcademicYearTermForm

    public function submitEditAcademicYearTermForm()
    {
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $termLabel = h_post('term_label');
        $startDate = h_post('start_date');
        $endDate = h_post('end_date');
        $id = h_post('id');

        $data = ['name' => $termLabel, 'start_date' => $startDate, 'end_date' => $endDate];
        $response = $this->modal->saveEditAcademicYearTermData($data, $id);
        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Term Updated Successfully';
        }

        return $this->response->setJSON($results);
    }

    public function listAcademicYearTerms()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = $this->modal->listRegisteredAcademicYearTerms();

        if (h_is_ajax_request()) {
            // Handle AJAX request
            return $this->response->setJSON(['academic_year_terms' => $results]);
        }

        $data['academic_year_terms'] = $results;
        h_set_session('current_page', 'Academic Year Terms');
        return view('user_pages/academics_settings/terms/list-terms', $data);
    }

    public function submitSchoolClassForm()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $className = h_post('name');
        $shortName = h_post('short_name');

        $data = ['name' => $className, 'short_name' => $shortName, 'branch_id' => h_session('branch_id')];
        $response = $this->modal->saveSchoolClassData($data);

        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Class Saved Successfully';
        }

        return $this->response->setJSON($results);
    }

    public function listSchoolClasses()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = $this->modal->listRegisteredSchoolClasses();

        if (h_is_ajax_request()) {
            // Handle AJAX request
            return $this->response->setJSON(['success' => true, 'classes' => $results]);
        }

        $data['classes'] = $results;
        h_set_session('current_page', 'List Classes');
        return view('user_pages/academics_settings/classes/list-classes', $data);
    }

    public function viewClassInfo()
    {
        if (!is_logged_in()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized access.',
            ]);
        }

        $classId = h_post('class_id');
        $class = $this->modal->getClassById($classId);

        if (!$class) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Class not found.',
            ]);
        }

        $html = view('user_pages/academics_settings/classes/edit-class', ['class' => $class]);

        log_message('debug', 'Class ID: ' . $classId);
        log_message('debug', 'Class Info: ' . print_r($class, true));

        return $this->response->setJSON([
            'success' => true,
            'html' => $html,
        ]);
    }

    public function updateSchoolClass()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = ['success' => false, 'message' => 'Update failed'];

        $classId = h_post('class_id');
        $name = h_post('name');
        $shortName = h_post('short_name');

        if ($classId && $name && $shortName) {
            $data = [
                'name' => $name,
                'short_name' => $shortName,
            ];

            $response = $this->modal->updateSchoolClassData($classId, $data);

            if ($response->success) {
                $results['success'] = true;
                $results['message'] = 'Class updated successfully';
            } else {
                $results['message'] = $response->message ?? 'Update failed';
            }
        } else {
            $results['message'] = 'Missing required fields';
        }

        return $this->response->setJSON($results);
    }

    public function deleteClass()
    {
        if (!is_logged_in()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $id = h_post('id');
        $response = $this->modal->softDeleteClass($id);
        return $this->response->setJSON($response);
    }

    public function submitClassStreamForm()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $stream = h_post('name');
        $class = h_post('class');

        $data = ['name' => $stream, 'class_id' => $class, 'short_name' => $stream, 'branch_id' => h_session('branch_id')];
        $response = $this->modal->saveClassStreamData($data);

        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Class Stream Saved Successfully';
        }

        return $this->response->setJSON($results);
    }

    public function listClassStreams()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = $this->modal->listRegisteredClassStreams();

        if (h_is_ajax_request()) {
            // Handle AJAX request
            return $this->response->setJSON(['streams' => $results]);
        }

        $data['streams'] = $results;
        h_set_session('current_page', 'List Streams');
        return view('user_pages/academics_settings/streams/list-streams', $data);
    }

    public function viewStreamInfo()
    {
        if (!is_logged_in()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized access.',
            ]);
        }

        $streamId = h_post('stream_id');
        $stream = $this->modal->getStreamById($streamId);
        $classes = $this->modal->listRegisteredSchoolClasses(); // For the class dropdown

        if (!$stream) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Stream not found.',
            ]);
        }

        $html = view('user_pages/academics_settings/streams/edit-stream', [
            'stream' => $stream,
            'classes' => $classes,
        ]);

        return $this->response->setJSON([
            'success' => true,
            'html' => $html,
        ]);
    }

    public function updateClassStreamForm()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = ['success' => false, 'message' => 'Update failed'];

        $streamId = h_post('stream_id');
        $name = h_post('name');
        $classId = h_post('class');

        if ($streamId && $name && $classId) {
            $data = [
                'name' => $name,
                'short_name' => $name,
                'class_id' => $classId,
            ];

            $response = $this->modal->updateClassStreamData($streamId, $data);

            if ($response->success) {
                $results['success'] = true;
                $results['message'] = 'Stream updated successfully';
            } else {
                $results['message'] = $response->message ?? 'Update failed';
            }
        } else {
            $results['message'] = 'Missing required fields';
        }

        return $this->response->setJSON($results);
    }

    public function deleteStream()
    {
        if (!is_logged_in()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $id = h_post('id');
        $response = $this->modal->softDeleteStream($id);
        return $this->response->setJSON($response);
    }

    public function listSubjects()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = $this->modal->listRegisteredSubjects();

        if (h_is_ajax_request()) {
            // Handle AJAX request
            return $this->response->setJSON(['subjects' => $results]);
        }

        $data['subjects'] = $results;
        h_set_session('current_page', 'List Subjects');
        return view('user_pages/academics_settings/subjects/list-subjects', $data);
    }

    public function submitNewSubjectForm()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $name = h_post('name');
        $shortName = h_post('short_name');
        $subjectCode = h_post('subject_code');
        $subjectType = h_post('subject_type');

        $data = ['name' => $name, 'short_name' => $shortName, 'code' => $subjectCode, 'subject_type' => $subjectType];
        $response = $this->modal->saveSubjectData($data);

        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Subject Saved Successfully';
        }

        return $this->response->setJSON($results);
    }

    public function viewSubjectInfo()
    {
        if (!is_logged_in()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized access.',
            ]);
        }

        $subjectId = h_post('subject_id');
        $subject = $this->modal->getSubjectById($subjectId);
        $subjects = $this->modal->listRegisteredSubjects(); // For Related Subject dropdown

        if (!$subject) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Subject not found.',
            ]);
        }

        $html = view('user_pages/academics_settings/subjects/edit-subject', [
            'subject' => $subject,
            'subjects' => $subjects
        ]);

        return $this->response->setJSON([
            'success' => true,
            'html' => $html,
        ]);
    }

    public function updateSubjectForm()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = ['success' => false, 'message' => 'Update failed'];

        $subjectId = h_post('subject_id');
        $name = h_post('name');
        $shortName = h_post('short_name');
        $subjectCode = h_post('subject_code');
        $subjectType = h_post('subject_type');

        if ($subjectId && $name && $shortName && $subjectCode && $subjectType) {
            $data = [
                'name' => $name,
                'short_name' => $shortName,
                'code' => $subjectCode,
                'subject_type' => $subjectType,
            ];

            $response = $this->modal->updateSubjectData($subjectId, $data);

            if ($response->success) {
                $results['success'] = true;
                $results['message'] = 'Subject updated successfully';
            } else {
                $results['message'] = $response->message ?? 'Update failed';
            }
        } else {
            $results['message'] = 'Missing required fields';
        }

        return $this->response->setJSON($results);
    }
}
