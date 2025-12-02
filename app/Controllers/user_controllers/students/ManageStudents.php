<?php

namespace App\Controllers\user_controllers\students;

use App\Controllers\BaseController;
use App\Models\user_models\students\M_ManageStudents;
use App\Models\user_models\academics_settings\M_ManageAcademicYears;
use App\Models\user_models\treasury\M_ManageTreasury;
use App\Models\user_models\fees_payment\M_ManageFeesPayment;

class ManageStudents extends BaseController 
{
    
    protected $modal;

	public function __construct()
	{

        // initiate school db connection
        $this->modal = new M_ManageStudents();
        $this->modal2 = new M_ManageAcademicYears();
        $this->modal3 = new M_ManageTreasury();
        $this->modal4 = new M_ManageFeesPayment();
    }


    public function index()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        h_set_session('current_page','Students Enrollment');
        $data['academic_years'] = $this->modal2->listRegisteredAcademicYears();

        return view('user_pages/students/manage/index', $data);
    }

    public function listStudentsView()
    {
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        $termId = h_post('termId');
        $classId = h_post('classId');

        $data['students'] = $this->modal->listStudents($termId, $classId);

        // $this->modal->updateStudentSubjects($termId);

        $response = ['success' => true, "html" => view('user_pages/students/manage/list-students', $data) ];
        return $this->response->setJSON($response);
    }

    public function addStudentForm()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        h_set_session('current_page','Add Student');
        $classes = $this->modal2->listRegisteredSchoolClasses();
        $data['classes'] = $classes;

        // account types
        $data['account_types'] = $this->modal3->listAccountTypes();

        $data['academic_years'] = $this->modal2->listRegisteredAcademicYears();

        $data['accomodations'] = $this->modal->listAccomodations();

        return view('user_pages/students/manage/add-student-admission', $data);
    }

    function submitUpdateStudentForm() {

        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $peopleID = h_post('student_id');
        $admissionID = h_post('admission_id');
        $studentNumber = h_post('student_number');
        $firstName = h_post('first_name');
        $dob = h_post('dob');
        $admissionNumber = h_post('admission_number');
        $lastName = h_post('last_name');
        $photo = h_file_post('photo');
        $admissionDate = h_post('admission_date');
        $gender = h_post('gender');
        $house = h_post('house');
        $bloodGroup = h_post('blood_group');
        $religion = h_post('religion');

        // $class = h_post('class');
        // $stream = h_post('stream');

        $basicData = ['people_number' => $studentNumber, 'name' => ucwords($firstName) . ' '. ucwords($lastName), 'first_name' => ucwords($firstName), 'last_name' => ucwords($lastName), 'gender' => $gender, 
            'dob' => $dob, 'blood_group' => $bloodGroup, 'religion' => $religion ];
        $others = ['admission_no' => $admissionNumber, 'admission_date' => $admissionDate, 'student_no' => $studentNumber, 'house' => $house];
        $data = ['ID' => $peopleID, 'admissionID' => $admissionID, 'basic' => $basicData, 'parents' => [], 'others' => $others, 'class' => [] ];

        $response = $this->modal->saveUpdateStudentData($data);
        if ($response->success) {
            if ($photo) {
                $url = h_upload_file_uploads($photo, h_session('school_id'), 'profile');
                if ($url) {
                    // updated staff image
                    $updateData = ["image_url" => $url];
                    $this->modal->updateStudent($updateData, $response->ID);
                }
            }
        
            // save update parent details
            $fatherID = h_post('father_id');
            $fatherName = h_post('father_name');
            $fatherPhone = h_post('father_phone');
            $fatherOccupation = h_post('father_occupation');
            // $fatherPhoto = h_file_post('father_photo');

            $motherID = h_post('mother_id');
            $motherName = h_post('mother_name');
            $motherPhone = h_post('mother_phone');
            $motherOccupation = h_post('mother_occupation');
            // $motherPhoto = h_file_post('mother_photo');

            $gardianID = h_post('gardian_id');
            $guardianName = h_post('guardian_name');
            $guardianGender = h_post('guardian_gender');
            // $guardianPhoto = h_file_post('guardian_photo');
            $guardianPhone = h_post('guardian_phone');
            $guardianOccupation = h_post('guardian_occupation');
            $guardianAddress = h_post('guardian_address');

            $father = ['ID' => $fatherID, 'person_type' => 'Parent', 'name' => ucwords($fatherName), 'gender' => 'F', 'phone' => $fatherPhone, 'occupation' => $fatherOccupation, 'relationship' => 'father', 'physical_address' => ''  ];
            $mother = ['ID' => $motherID, 'person_type' => 'Parent', 'name' => ucwords($motherName), 'gender' => 'M', 'phone' => $motherPhone, 'occupation' => $motherOccupation, 'relationship' => 'mother', 'physical_address' => '' ];
            $guardian = ['ID' => $gardianID, 'person_type' => 'Guardian', 'name' => ucwords($guardianName), 'gender' => $guardianGender, 'phone' => $guardianPhone, 'occupation' => $guardianOccupation, 'relationship' => 'guardian', 'physical_address' => $guardianAddress ];

            $data = ['ID' => $peopleID, 'admissionID' => $admissionID, 'basic' => [], 'parents' => ['father' => $father, 'mother' => $mother, 'guardian' => $guardian ], 'others' => [] ];
            $this->modal->saveUpdateStudentData($data);

            $results['success'] = true;
            $results['ID'] = h_encrypt_decrypt($response->ID);
            $results['message'] = 'Student Updated Successfully';
        }

        return $this->response->setJSON($results);
    }

    public function submitStudentForm()
    {
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $studentNumber = h_post('student_number')? h_post('student_number'): $this->modal->generateStudentNumber();
        $firstName = h_post('first_name');
        $dob = h_post('dob');
        $admissionNumber = h_post('admission_number')? h_post('admission_number'): $this->modal->generateStudentAdmissionNumber();
        $lastName = h_post('last_name');
        $photo = h_file_post('photo');
        $admissionDate = h_post('admission_date');
        $gender = h_post('gender');
        $house = h_post('house');
        $bloodGroup = h_post('blood_group');
        $religion = h_post('religion');
        $term_id = h_post('term_id');

        $class = h_post('class');
        $stream = h_post('stream');
        $accounts = h_post('accounts');

        $dormitry = h_post('dormitry');
        $bed_number = h_post('bed_number');

        $basicData = ['person_type' => 'Student', 'people_number' => $studentNumber, 'name' => ucwords($firstName) . ' '. ucwords($lastName), 'first_name' => ucwords($firstName), 'last_name' => ucwords($lastName), 'gender' => $gender, 
                'school_id' => h_session('school_id'), 'branch_id' => h_session('branch_id'), 'dob' => $dob, 
                'blood_group' => $bloodGroup, 'religion' => $religion ];
        $others = ['admission_no' => $admissionNumber, 'admission_date' => $admissionDate, 'student_no' => $studentNumber, 'house' => $house];
        $class_details = ['class_id' => $class, 'stream_id' => $stream, 'term_id' => $term_id, 'is_new_student' => '0'];
        $data = ['ID' => '', 'basic' => $basicData, 'parents' => [], 'others' => $others, 'class' => $class_details ];

        $response = $this->modal->saveStudentData($data);
        if ($response->success) {
            $this->modal->saveStudentAccountTypesData($accounts, $response->ID);

            if ($dormitry) {
                $domData = ['people_id' => $response->ID, 'accomodation_id' => $dormitry, 'term_id' => $term_id, 'added_by_id' => h_session('current_user_id'), 'bed_number' => $bed_number ];
                $this->modal->saveStudentDormitryData($domData);
            }

            if ($photo) {
                $url = h_upload_file_uploads($photo, $response->ID, 'profile');
                if ($url) {
                    // updated staff image
                    $updateData = ["image_url" => $url];
                    $this->modal->updateStudent($updateData, $response->ID);
                }
            }

            // save parent details
            $fatherName = h_post('father_name');
            $fatherPhone = h_post('father_phone');
            $fatherOccupation = h_post('father_occupation');
            $fatherPhoto = h_file_post('father_photo');

            $motherName = h_post('mother_name');
            $motherPhone = h_post('mother_phone');
            $motherOccupation = h_post('mother_occupation');
            $motherPhoto = h_file_post('mother_photo');

            $guardianName = h_post('guardian_name');
            $guardianGender = h_post('guardian_gender');
            $guardianPhoto = h_file_post('guardian_photo');
            $guardianPhone = h_post('guardian_phone');
            $guardianOccupation = h_post('guardian_occupation');
            $guardianAddress = h_post('guardian_address');

            $father = ['person_type' => 'Parent', 'name' => ucwords($fatherName), 'gender' => 'F', 'phone' => $fatherPhone, 'occupation' => $fatherOccupation, 'photo' => $fatherPhoto, 'relationship' => 'father', 'physical_address' => ''  ];
            $mother = ['person_type' => 'Parent', 'name' => ucwords($motherName), 'gender' => 'M', 'phone' => $motherPhone, 'occupation' => $motherOccupation, 'photo' => $motherPhoto, 'relationship' => 'mother', 'physical_address' => '' ];
            $guardian = ['person_type' => 'Guardian', 'name' => ucwords($guardianName), 'gender' => $guardianGender, 'phone' => $guardianPhone, 'occupation' => $guardianOccupation, 'photo' => $guardianPhoto, 'relationship' => 'guardian', 'physical_address' => $guardianAddress ];

            $data = ['ID' => $response->ID, 'basic' => [], 'parents' => ['father' => $father, 'mother' => $mother, 'guardian' => $guardian ], 'others' => [] ];
            $this->modal->saveStudentData($data);
            
            $results['success'] = true;
            $results['ID'] = h_encrypt_decrypt($response->ID);
            $results['message'] = 'Student Registered Successfully';
        }
        
        return $this->response->setJSON($results);
    }

    public function studentBasicProfile()
    {
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }
        
        $data = [];
        $id = h_post('id');
        $peopleID =h_encrypt_decrypt($id, 'decrypt');
        if ($peopleID) {
            $data['student'] = $this->modal->studentDetails($peopleID);
        }

        $response = ['success' => true, "html" => view('user_pages/students/profile/basic-profile', $data) ];
        return $this->response->setJSON($response);
    }

    public function studentTermReportingView()
    {
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }
        
        $data = [];
        $id = h_post('id');
        $peopleID =h_encrypt_decrypt($id, 'decrypt');
        if ($peopleID) {
            $data['student'] = $this->modal->studentDetails($peopleID);
        }

        $classes = $this->modal2->listRegisteredSchoolClasses();
        $data['classes'] = $classes;
        
        $data['academic_years'] = $this->modal2->listRegisteredAcademicYears();
        $data['peopleId'] = $peopleID;

        $data['accomodations'] = $this->modal->listAccomodations();

        $response = ['success' => true, "html" => view('user_pages/students/term_reporting/reporting-form', $data) ];
        return $this->response->setJSON($response);
    }

    public function searchStudents()
    {
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        $search = h_post('search');
        $type = h_post('type');
        $results = $this->modal->searchStudents($search);
        $data['results'] = $results;
        $page = 'user_pages/students/profile/search-results';
        if ($type == 'pay-fees') {
            $page = 'user_pages/fees_payments/pay_fees/search-results';
        }
        if ($type== 'reporting-view-details') {
            $page = 'user_pages/students/term_reporting/search-results';
        }
        if ($type== 'report-card') {
            $page = 'user_pages/academics/report_cards/single/search-student-results';
        }
        $response = ['success' => true, "html" => view($page, $data) ];
        return $this->response->setJSON($response);
    }

    public function studentBasicProfileView()
    {
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];
            
            return $this->response->setJSON($response);
        }
        
        $data = [];
        $id = h_post('id');
        $type = h_post('type');
        $peopleID =h_encrypt_decrypt($id, 'decrypt');
        if ($peopleID) {
            $data['student'] = $this->modal->studentDetails($peopleID);
        }
        $page = "user_pages/students/profile/edit-profile";
        if ($type == 'edit-basic') {
            $classes = $this->modal2->listRegisteredSchoolClasses();
            $data['classes'] = $classes;
        }

        if ($type == 'fees-ledger-index') {
            $page = "user_pages/students/profile/fees-ledger";
            $data['academic_years'] = $this->modal2->listRegisteredAcademicYears();
        }

        if ($type == 'fees-ledger-view-trans') {
            $termId = h_post('term_id');
            $page = "user_pages/students/profile/fees-ledger-transactions";

            $data['transactions'] = $this->modal4->studentFeesPaymentsLedger($peopleID,$termId);
        }
        
        $response = ['success' => true, "html" => view($page, $data) ];
        return $this->response->setJSON($response);
    }

    function studentsEnrollmentReport() {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        h_set_session('current_page','Students Enrollment Report');
        $data['academic_years'] = $this->modal2->listRegisteredAcademicYears();
        
        return view('user_pages/reports/students/index', $data);
    }

    function listBoardingStudents() {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        h_set_session('current_page','Boarding Students Report');
        $data['students'] = [];
        // $this->modal->listStudents()
        $data['academic_years'] = $this->modal2->listRegisteredAcademicYears();
        return view('user_pages/reports/students/boarding-index', $data);
    }

    function listBoardingStudentsView() {
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];
            
            return $this->response->setJSON($response);
        }

        $classId = h_post('classId');
        $termId = h_post('termId');

        $page = "user_pages/reports/students/boarding-list";
        $data['students'] = $this->modal->getBoardingStudentReportData($termId, $classId);

        $response = ['success' => true, "html" => view($page, $data) ];
        return $this->response->setJSON($response);
    }

    function submitStudentReportingForm()  {
        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];
            return $this->response->setJSON($response);
        }
        
        $data = [];
        $year_id = h_post('year_id');
        $term_id = h_post('term_id');
        $class_id = h_post('class_id');
        $stream_id = h_post('stream_id');
        $peopleID = h_post('people_id');

        $dormitry = h_post('dormitry');
        $bed_number = h_post('bed_number');

        $data = ['class_stream_id' => $stream_id, 'term_id' => $term_id, 'people_id' => $peopleID ];
        $response = $this->modal->saveStudentReportData($data);
        if ($response->success) {

            if ($dormitry) {
                $domData = ['people_id' => $peopleID, 'accomodation_id' => $dormitry, 'term_id' => $term_id, 'added_by_id' => h_session('current_user_id'), 'bed_number' => $bed_number ];
                $this->modal->saveStudentDormitryData($domData);
            }

            $results['success'] = true;
            $results['message'] = 'Saved Successfully';
        }

        return $this->response->setJSON($results);
    }

    function submitDeleteStudent() {
        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];
            return $this->response->setJSON($response);
        }

        $id = h_post('id');
        $peopleID =h_encrypt_decrypt($id, 'decrypt');
        if ($peopleID) {
            $updateData = ['deleted' => 1, 'status' => 'inactive' ];
            $response = $this->modal->updateStudent($updateData, $peopleID);
            if ($response->success) {
                $results['success'] = true;
                $results['message'] = 'Saved Successfully';
            }
        }

        return $this->response->setJSON($results);
    }

    function listStudentsEnrollmentView() {

        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];
            return $this->response->setJSON($response);
        }

        $classId = h_post('classId');
        $termId = h_post('termId');

        $page = "user_pages/reports/students/enrollment-list";
        $data['students'] = $this->modal->getStudentsEnrollReportData($termId, $classId);

        $response = ['success' => true, "html" => view($page, $data) ];
        return $this->response->setJSON($response);
    }

}
