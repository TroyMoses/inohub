<?php

namespace App\Controllers\user_controllers\settings;
use App\Models\user_models\academics_settings\M_ManageAcademicYears;
use App\Models\user_models\students\M_ManageStudents;
use App\Models\user_models\settings\M_ManageSetting;

use App\Controllers\BaseController;

class ManageSettings extends BaseController 
{
    protected $modal;

	public function __construct()
	{

        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        // initiate school db connection
        $this->modal = new M_ManageSetting();
        $this->modal1 = new M_ManageAcademicYears();
        $this->modal2 = new M_ManageStudents();
    }

    public function index()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        // $this->modal->listStaff(); 
        h_set_session('current_page','Other Settings');

        $data['school_requirements'] = $this->modal->listRequirements();
        $data['student_requirements'] = $this->modal->listRequirements('student');

        $results = $this->modal1->listRegisteredAcademicYears();
        $data['academic_years'] = $results;

        $data['accomodations'] = $this->modal2->listAccomodations();

        return view('user_pages/settings/index', $data);
    }

    function submitNewDormitryForm() {
        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];
            return $this->response->setJSON($response);
        }

        $name = h_post('name');
        $no_of_beds = h_post('no_of_beds');

        $data = ['name' => $name, 'number_of_beds' => $no_of_beds, 'added_by_id' => h_session('current_user_id') ];
        $response = $this->modal->saveDormitryData($data);
        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Saved Successfully';
        }

        return $this->response->setJSON($results);
    }

    function submitSchRequirementsForm() {
        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];
            return $this->response->setJSON($response);
        }

        $name = h_post('name');
        $description = h_post('description');
        $req_type = h_post('req_type');

        $data = ['name' => $name, 'description' => $description, 'added_by_id' => h_session('current_user_id'), 'req_type' => $req_type ];
        $response = $this->modal->saverequirementsData($data);
        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Saved Successfully';
        }

        return $this->response->setJSON($results);
    }


    public function listSchoolTermRequirements()
    {
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];
            return $this->response->setJSON($response);
        }
        
        $term_id = h_post('term_id');
        $data['school_requirements'] = $this->modal->listTermRequirements('school', $term_id);
      
        $page = "user_pages/settings/term_requirements/school-requirements";
        $response = ['success' => true, "html" => view($page, $data) ];
        return $this->response->setJSON($response);
    }

    function submitThemeSettings() {
        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];
            return $this->response->setJSON($response);
        }

        $left_menu_color = h_post('left_menu_color');
        $navigation_style = h_post('navigation_style');
        $light_theme_primary_color = h_post('light_theme_primary_color');
        $layout_position_scroll = h_post('layout_position_scroll');
        $sidemenu =  h_post('sidemenu');

        $data = ['left_menu_style' => $left_menu_color, 'branch_id' => h_session('branch_id'), 'section_id' => h_session('branch_id'), 'navigation_style' => $navigation_style ];

        $data = ['left_menu_style' => $left_menu_color, 'branch_id' => h_session('branch_id'), 'section_id' => h_session('branch_id'),
         'navigation_style' => $navigation_style, 'light_theme_primary_color' => $light_theme_primary_color, "layout_position_scroll" => $layout_position_scroll,
        'side_menu_layout_style' => $sidemenu ];

        $response = $this->modal->saveSchoolThemeData($data);
        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Saved Successfully';
        }

        return $this->response->setJSON($results);
    }

    public function themeSettings()
    {
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];
            return $this->response->setJSON($response);
        }
        
        $theme = $this->modal->getSchoolThemeData();
      
        $response = ['success' => true, "theme" => $theme ];
        return $this->response->setJSON($response);
    }

}