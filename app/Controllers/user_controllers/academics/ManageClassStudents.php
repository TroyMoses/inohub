<?php

namespace App\Controllers\user_controllers\academics;

use App\Controllers\BaseController;
use App\Models\user_models\academics\M_ManageClassStudents;
use App\Models\user_models\academics_settings\M_ManageAcademicYears;
use App\Models\user_models\academics\M_ManageTerms;

class ManageClassStudents extends BaseController 
{
    protected $modal;

	public function __construct()
	{

        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        // initiate school db connection
        $this->modal = new M_ManageClassStudents();
        $this->modal2 = new M_ManageAcademicYears();
        $this->modal3 = new M_ManageTerms();
    }

    public function listClassStreamStudents()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = $this->modal2->listRegisteredAcademicYears();
        $data['academic_years'] = $results;

        h_set_session('current_page','Class Stream Students');
        return view('user_pages/academics/stream_students/index', $data);
    }


    public function listClassStreamStudentsView()
    {
        $response = [];
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        if (h_is_ajax_request()) {
            $type = h_post('type');
            if ($type == 'list-streams') {
                $classId = h_post('classId');
                $termId = h_post('termId');
                $stream = '';
                $streamID = '';
                $students = [];

                $results = $this->modal3->listTermClassStreams($classId, $termId);
                if ($results) {
                    $stream = $results[0];
                    $streamID = $stream->id;
                }

                if ($stream != '') {
                    $students = $this->modal->listClassStreamStudents($stream->id, $termId);
                }
                $data = ['students' => $students, 'streams' => $results, 'stream' => $stream, 'stream_id' => $streamID ];
                $response = ['success' => true, "html" => view('user_pages/academics/stream_students/students_view', $data) ];
            }

            if ($type == 'list-stream-students') {
                $classStreamId = h_post('classStreamId');
                $termId = h_post('termId');
                $students = [];
               
                if ($classStreamId != '') {
                    $students = $this->modal->listClassStreamStudents($classStreamId, $termId);
                }
                $data = ['students' => $students, 'streams' => [], 'stream' => '', 'stream_id' => $classStreamId ];
                $response = ['success' => true, "html" => view('user_pages/academics/stream_students/students_table', $data) ];
            }

            // Handle AJAX request
            return $this->response->setJSON($response);
        }
    }
}