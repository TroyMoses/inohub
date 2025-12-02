<?php

namespace App\Controllers\user_controllers\reports;

use App\Controllers\BaseController;
use App\Models\user_models\academics_settings\M_ManageAcademicYears;
use App\Models\user_models\staff\M_ManageStaff;

class ManageReports extends BaseController 
{
    protected $modal;

	public function __construct()
	{

        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        // initiate school db connection
        // $this->modal = new M_FinancialReports();
        $this->modal1 = new M_ManageAcademicYears();
        $this->modal2 = new M_ManageStaff();
    }

    public function listTeachers()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = $this->modal1->listRegisteredAcademicYears();

        h_set_session('current_page','TEACHERS REPORT');
        $data['academic_years'] = $results;

        return view('user_pages/reports/teacher/index', $data);
    }

    function getTermTeachersList() {
        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        $termId = h_post('termId');
        $classId = h_post('classId');

        $page = "user_pages/reports/teacher/teachers-list";
        $reports['teachers'] = $this->modal2->listStaffByTerm($termId, $classId);
        $response = ['success' => true, "html" => view($page, $reports) ];
        return $this->response->setJSON($response);
    }


    function getListFees() {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $results = $this->modal1->listRegisteredAcademicYears();

        h_set_session('current_page', 'FEES REPORT');
        $data['academic_years'] = $results;

        return view('user_pages/reports/fees/index', $data);
    }

}