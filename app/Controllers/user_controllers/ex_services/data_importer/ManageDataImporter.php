<?php

namespace App\Controllers\user_controllers\ex_services\data_importer;

use App\Controllers\BaseController;
use App\Models\user_models\ex_services\data_importer\M_ManageDataImporter;
use App\Models\user_models\academics_settings\M_ManageAcademicYears;
use App\Models\user_models\academics\M_ManageClassStudents;
use App\Models\user_models\academics\M_ManageTerms;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ManageDataImporter extends BaseController 
{
    protected $modal;

	public function __construct()
	{

        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        // initiate school db connection
        $this->modal = new M_ManageDataImporter();
        $this->modal2 = new M_ManageAcademicYears();
        $this->modal3 = new M_ManageClassStudents();
        $this->modal4 = new M_ManageTerms();
    }

    public function index()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        h_set_session('current_page','Data Importer');
        $results = $this->modal->listStudentsImportInitation();
        $data['results'] = $results;

        $years = $this->modal2->listRegisteredAcademicYears();
        $data['academic_years'] = $years;

        $marks = $this->modal->listMarksImportInitation();
        $data['marks'] = $marks;
        return view('user_pages/ex_services/data_importer/index', $data);
    }

    public function submitStudentsUpload()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $tranType = h_post('transType');
        if ($tranType == 'file') {
            $file = h_file_post('file');
            if ($file) {

                // Check if the file is valid and has a CSV extension
                if ($file && $file->isValid() && $file->getClientExtension() === 'csv') {
                    $filePath = WRITEPATH . 'uploads/' . $file->getName();  // Save to writable/uploads
                    $file->move(WRITEPATH . 'uploads/');  // Move the file to the uploads folder

                    // Open and read the CSV file
                    $csvData = array();
                    $ID = 0;
                    $totalRows = 0;
                    if (($handle = fopen($filePath, 'r')) !== false) {

                        $header = fgetcsv($handle);  // Read the first row as header
                        // Count total rows in the file
                        while (($row = fgetcsv($handle)) !== false) {
                            $totalRows++;
                        }
                        // Close and reopen the file to start processing from the beginning
                        fclose($handle);
                        $handle = fopen($filePath, 'r');
                        fgetcsv($handle);

                        while (($row = fgetcsv($handle)) !== false) {
                            $message = "";
                            // STUDENT
                            $firstName = $row[0];
                            $lastName = $row[1];
                            $dob = $row[2];
                            $studentNo = $row[3];
                            $admissionNo = $row[4];
                            $admissionDate = $row[5];
                            $gender = $row[6];
                            $class = $row[7];
                            $stream = $row[8];
                            $academicYearId = $row[9];
                            $termId = $row[10];

                            // parent
                            $parentFirstName = $row[11];
                            $parentLastName = $row[12];
                            $parentGender = $row[13];
                            $parentContact = $row[14];

                            $obj = ["student_name" => ucwords($firstName) . ' ' . ucwords($lastName), 'first_name' => ucwords($firstName), 'last_name' => ucwords($lastName), 
                                    "student_number" => $studentNo, 'gender' => $gender, 'class_id' => $class, 'stream_id' => $stream, 
                                    'initiation_id' => $ID, 'dob' => $dob, 'admission_number' => $admissionNo, 'admission_date' => $admissionDate,
                                    'academic_year_id' => $academicYearId, 'term_id' => $termId, 'guardian_first_name' => ucwords($parentFirstName), 'guardian_last_name' => ucwords($parentLastName),
                                    'guardian_gender' => $parentGender, 'guardian_contact' => $parentContact ];
                            $ID = $this->modal->saveStudentDataImport($obj, $totalRows);
                        }
                        fclose($handle);
                    }
                }

                $response = ['success' => true, 'message' => 'Upload Successfully'];
                return $this->response->setJSON($response);
            }
            else{
                $response = ['success' => false, "url" => '', 'message' => 'No_file_attached'];
                return $this->response->setJSON($response);
            }
        }

        if ($tranType == 'ToDatabase') {
            $ID = h_post('id') ? h_post('id') : 0;
            if ($ID != 0) {
                $results = $this->modal->migrateStudentDataImportToMain($ID);
                if ($results->success) {
                    $response = ['success' => true, 'message' => 'Migrated Successfully'];
                    return $this->response->setJSON($response);
                }
            }
        }

        $response = ['success' => false, 'message' => 'Something Went Wrong'];
        return $this->response->setJSON($response);
    }

    public function downloadImportTemplate()
    {
        if (!is_logged_in()) {
            return redirect()->route('serviceAuth/logout');
        }

        $response = ['success' => false, 'message' => 'Failed to download' ];
        $type = h_post('type') ? h_post('type') : 'student_template';

        if ($type == 'student_template') {
            $filePath = base_url('/assets/templates/Schoolhub_Students_Upload.csv');
            $response = ['success' => true, 'message' => 'Download Successful', 'url' => $filePath];
        }
        if ($type == 'bulk_upload_sms') {
            $filePath = base_url('/assets/templates/schoolhub_bulk_upload_sms.csv');
            $response = ['success' => true, 'message' => 'Download Successful', 'url' => $filePath];
        }
        return $this->response->setJSON($response);
    }

    function downloadMarksTemplate() {
        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        $response = ['success' => false, 'message' => 'Failed to download' ];

        $yearId = h_post('year');
        $termId = h_post('term');
        $classId = h_post('class');

        $stundents = [];
        $subjects = [];

        $students = $this->modal3->listClassStudents($classId, $termId);
        $subjects = $this->modal4->listTermClassSubjects($classId, $termId);

        if ($students && $subjects ) {
            // Create a new Spreadsheet object
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Set document properties
            $spreadsheet->getProperties()
                ->setCreator("SchoolHub")
                ->setTitle("Marks Upload Template");

            // Add data to the spreadsheet
            $allHeaders = ["Name", "Student No"];
            $clasName = "";
            foreach ($subjects as $key => $subject) {
                $allHeaders[] = $subject->subject_id . '-' . $subject->name;
            }

            $columnIndex = 'A'; // Start from column A
            foreach ($allHeaders as $header) {
                $sheet->setCellValue($columnIndex . '1', $header);
                $columnIndex++;
            }

            // Add data to the rows
            $row = 2; // Start from row 2 for data
            foreach ($students as $student) {
                $clasName = $student->class_name; 
                $sheet->setCellValue('A' . $row, $student->name);
                $sheet->setCellValue('B' . $row, $student->people_number);
                $row++;
            }

            // Save the Excel file to the server
            $writer = new Xlsx($spreadsheet);
            $fileName = $clasName . ' Marks Entry.xlsx';
            // $writer->save($fileName);

            // Download the file
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . $fileName . '"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
            exit;
        }
        return $this->response->setJSON($response);
    }

    function submitStudentMarksUpload() {
        $response = ['success' => false, 'message' => 'Error Occured'];

        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        $file = h_file_post('file');
        $termId = h_post('term');
        $examId = h_post('exam');

        if ($file && $file->isValid() && $file->getClientExtension() === 'xlsx') {
            // Save the uploaded file to the writable/uploads directory
            $newName = $file->getRandomName(); // generates a unique random filename
            $file->move(WRITEPATH . 'uploads/', $newName);
            $filePath = WRITEPATH . 'uploads/' . $newName;

            // $filePath = WRITEPATH . 'uploads/' . $file->getName();
            // $file->move(WRITEPATH . 'uploads/');

            try {
                // Load the .xlsx file using PhpSpreadsheet
                $spreadsheet = IOFactory::load($filePath);
                $worksheet = $spreadsheet->getActiveSheet();

                $rows = $worksheet->toArray(); // Convert worksheet data to an array
                $header = array_shift($rows); // Extract and remove the header row

                // Filter out rows that are completely empty
                $filteredRows = array_filter($rows, function ($row) {
                    // Check if all cells in the row are empty
                    return array_filter($row); // Keep rows where at least one cell is not empty
                });

                $totalRows = count($filteredRows);

                // Separate the fixed and dynamic headers
                $fixedHeaders = array_slice($header, 0, 2); // First two headers (Name, Student No)
                $dynamicHeaders = array_slice($header, 2); // Dynamic columns (subjectID-subjectName)

                $fileName = $file->getName();
                $fileNameWithoutExtension = pathinfo($fileName, PATHINFO_FILENAME);
                $intiation = $this->modal->saveStudentMarksInitiation(["name" => $fileNameWithoutExtension, 'total' => $totalRows ]);

                if ($intiation->success) {
                    // Iterate through rows
                    foreach ($filteredRows as $row) {
                        // Get fixed values
                        $studentName = $row[0];
                        $studentNo = $row[1];

                        // Collect subjects and marks dynamically
                        $subjects = [];
                        for ($i = 2; $i < count($row); $i++) {
                            $subjectDetails = explode('-', $dynamicHeaders[$i - 2]); // Split subjectID and subjectName
                            $subjectID = $subjectDetails[0] ?? 0;
                            $subjectName = $subjectDetails[1] ?? 'Unknown';

                            $mark = $row[$i]; // Student's mark for the subject
                            if (!isset($subjectID) || $subjectID == 0 || $subjectID == '') {
                                break;
                            }

                            $subjects[] = [
                                'subject_id' => $subjectID ? $subjectID: '',
                                'subject_name' => $subjectName,
                                'mark' => $mark ? $mark : 0,
                            ];
                        }

                        // Prepare the data object
                        $studentData = [
                            'name' => $studentName,
                            'student_no' => $studentNo,
                            'subjects' => $subjects,
                            'initiation_id' => $intiation->ID,
                            'term_id' => $termId,
                            'exam_id' => $examId
                        ];

                        // Save the data
                        $this->modal->saveStudentMarks($studentData);
                    }

                    // Then delete it
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }

                    $response = ['success' => true, 'message' => 'Upload completed successfully'];
                }

            } catch (\Exception $e) {
                // Handle exceptions
                echo 'Error reading file: ' . $e->getMessage();
            }
        }

        return $this->response->setJSON($response);
    }


    function importTermStudents() {
        $response = ['success' => false, 'message' => 'Error Occured'];

        if (!is_logged_in()) {
            $response = ['success' => false, "url" => base_url('/serviceAuth/logout')];

            return $this->response->setJSON($response);
        }

        $results = [];
        $results['success'] = false;
        $results['message'] = 'Error Occured';

        $from_term = h_post('from_term');
        $to_term = h_post('to_term');

        $data = ['from_term' => $from_term, 'to_term' => $to_term];
        $response = $this->modal->saveImportTermStudents($data);
        if ($response->success) {
            $results['success'] = true;
            $results['message'] = 'Import Successfully';
        }

        return $this->response->setJSON($results);
    }

}