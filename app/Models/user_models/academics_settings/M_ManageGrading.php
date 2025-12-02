<?php

namespace App\Models\user_models\academics_settings;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;
use Config\Database;

class M_ManageGrading extends Model
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
            } else {
                $db = Database::connect();
            }
        }
        $this->db = $db;
    }

    public function saveClassGradeData($data)
    {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';

        // Begin transaction
        $this->db->transBegin();

        try {
            $grade = $data['grade'];
            $this->db->table('sch_grading')->insert($grade);
            $ID = $this->db->insertID();

            $classes = $data['classes'];
            foreach ($classes as $key => $class) {
                $grade_class = ['class_id' => $class, "grading_id" => $ID];
                $this->db->table('sch_grading_classes')->insert($grade_class);
            }

            $grades = $data['grades'];
            foreach ($grades as $_grade) {
                $_grade["grading_id"] = $ID;
                $this->db->table('sch_grading_grades')->insert($_grade);
            }

            // Commit transaction
            $this->db->transCommit();

            $response['success'] = true;
            $response['StatusCode'] = '00';
            $response['ID'] = $ID;
        } catch (\Exception $e) {
            // Rollback transaction on error
            $this->db->transRollback();
            $response['message'] = $e->getMessage();
        }

        return (object) $response;
    }

    public function listRegisteredClassGrades()
    {
        $grades = $this->db->table('sch_grading')
            ->select('*')
            ->where('deleted', 0)
            ->where('status', 0)
            ->get()
            ->getResult();

        foreach ($grades as $grade) {
            $classes = $this->db->table('sch_grading_classes AS class')
                ->select('class.*, sch_class.name, sch_class.short_name')
                ->where('class.grading_id', $grade->id)
                ->where('class.deleted', 0)
                ->where('class.status', 0)
                ->join('sch_classes AS sch_class', 'sch_class.id = class.class_id')
                ->get()
                ->getResult();

            $grade->classes = $classes ? $classes : [];

            $gradings = $this->db->table('sch_grading_grades')
                ->select('*')
                ->where('grading_id', $grade->id)
                ->where('deleted', 0)
                ->where('status', 0)
                ->get()
                ->getResult();

            $grade->grades = $gradings ? $gradings : [];
        }

        return $grades ? $grades : [];
    }

    public function getGradeById($id)
    {
        $grade = $this->db->table('sch_grading')
            ->select('*')
            ->where('id', $id)
            ->where('deleted', 0)
            ->where('status', 0)
            ->get()
            ->getRow();

        if ($grade) {
            $classes = $this->db->table('sch_grading_classes AS class')
                ->select('class.class_id, sch_class.name, sch_class.short_name')
                ->where('class.grading_id', $id)
                ->where('class.deleted', 0)
                ->where('class.status', 0)
                ->join('sch_classes AS sch_class', 'sch_class.id = class.class_id')
                ->get()
                ->getResult();

            $grade->classes = $classes ? $classes : [];

            $gradings = $this->db->table('sch_grading_grades')
                ->select('*')
                ->where('grading_id', $id)
                ->where('deleted', 0)
                ->where('status', 0)
                ->get()
                ->getResult();

            $grade->grades = $gradings ? $gradings : [];
        }

        return $grade;
    }

    public function updateClassGradeData($id, $data)
    {
        $response = ['success' => false];

        $this->db->transBegin();

        try {
            // Update grading title/description
            $this->db->table('sch_grading')
                ->where('id', $id)
                ->update($data['grade']);

            // Delete old class links & grades
            $this->db->table('sch_grading_classes')->where('grading_id', $id)->delete();
            $this->db->table('sch_grading_grades')->where('grading_id', $id)->delete();

            // Re-insert classes
            foreach ($data['classes'] as $class) {
                $this->db->table('sch_grading_classes')->insert([
                    'class_id' => $class,
                    'grading_id' => $id
                ]);
            }

            // Re-insert grades
            foreach ($data['grades'] as $_grade) {
                $_grade['grading_id'] = $id;
                $this->db->table('sch_grading_grades')->insert($_grade);
            }

            $this->db->transCommit();
            $response['success'] = true;
        } catch (\Exception $e) {
            $this->db->transRollback();
            $response['message'] = $e->getMessage();
        }

        return (object)$response;
    }

    public function listAllSchoolClasses()
    {
        return $this->db->table('sch_classes')
            ->where('deleted', 0)
            ->where('status', 0)
            ->get()
            ->getResult();
    }

    function listRegisteredExams()
    {
        $exams = $this->db->table('sch_examinations')
            ->select('*')
            ->where('deleted', 0)
            ->where('status', 0)
            ->get()
            ->getResult();

        return $exams ? $exams : [];
    }

    function saveExamData($data)
    {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';

        try {
            // Begin transaction
            $this->db->transBegin();

            $this->db->table('sch_examinations')->insert($data);
            $ID = $this->db->insertID();

            // Commit transaction
            $this->db->transCommit();

            $response['success'] = true;
            $response['StatusCode'] = '00';
            $response['ID'] = $ID;
        } catch (\Exception $e) {
            // Rollback transaction on error
            $this->db->transRollback();
            $response['message'] = $e->getMessage();
        }

        return (object) $response;
    }

    public function markExamAsDeleted($id)
    {
        $response = ['success' => false];

        try {
            $this->db->table('sch_examinations')
                ->where('id', $id)
                ->update(['deleted' => '1']);

            $response['success'] = true;
            $response['message'] = 'Exam deleted successfully.';
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }

        return $response;
    }


    public function getExamById($id)
    {
        return $this->db->table('sch_examinations')
            ->where('id', $id)
            ->where('deleted', 0)
            ->get()
            ->getRow();
    }

    public function updateExamData($id, $data)
    {
        $response = ['success' => false];

        try {
            $this->db->table('sch_examinations')
                ->where('id', $id)
                ->update($data);

            $response['success'] = true;
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }

        return (object) $response;
    }

    function listRegisteredTemplates($termId)
    {
        $formattedResults = [];
        $templates = $this->db->table('sch_report_card_templates as temp')
            ->select('temp.*, class.name as class_name, class.short_name')
            ->where('temp.status', '0')
            ->where('temp.term_id', $termId)
            ->join('sch_classes AS class', 'class.id = temp.class_id')
            ->get()
            ->getResult();

        foreach ($templates as $template) {
            $fileNameIndex = array_search($template->file_name, array_column($formattedResults, 'file_name'));
            if ($fileNameIndex === false) {
                // If not, create a new entry for this fees_type_name
                $formattedResults[] = [
                    'id' => $template->id,
                    'name' => $template->name,
                    'file_name' => $template->file_name,
                    'status' => $template->status,
                    'term_id' => $template->term_id,
                    'url'     => $template->url,
                    'date_added' => $template->date_added,
                    'classes' => [
                        [
                            'id' => $template->class_id,
                            'class_name' => $template->class_name,
                            'short_name' => $template->short_name
                        ]
                    ]
                ];
            } else {
                // If it exists, add the class and amount under the existing fees_type_name
                $formattedResults[$fileNameIndex]['classes'][] = [
                    'id' => $template->class_id,
                    'class_name' => $template->class_name,
                    'short_name' => $template->short_name
                ];
            }
        }

        return $formattedResults ? $formattedResults : [];
    }

    function saveReportCardTemplateData($data)
    {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';

        try {
            foreach ($data['classes'] as $key => $classId) {

                $class_template = $this->db->table('sch_report_card_templates')
                    ->select('*')
                    ->where('class_id', $classId)
                    ->where('term_id', $data['term_id'])
                    ->get()
                    ->getResult();

                if ($class_template) {
                    continue;
                }

                // Begin transaction
                $this->db->transBegin();

                $saveData = ['name' => $data['name'], '	url' => $data['template'], 'class_id' => $classId, 'term_id' => $data['term_id'], 'added_by_id' => h_session('current_user_id'), 'file_name' => $data['file_name']];
                $this->db->table('sch_report_card_templates')->insert($saveData);

                // Commit transaction
                $this->db->transCommit();

                $response['success'] = true;
                $response['StatusCode'] = '00';
            }
        } catch (\Exception $e) {
            // Rollback transaction on error
            $this->db->transRollback();
            $response['message'] = $e->getMessage();
        }


        return (object) $response;
    }

    function getRegisteredTemplate($template, $termId)
    {

        $template = $this->db->table('sch_report_card_templates as temp')
            ->select('temp.*, class.name as class_name, class.short_name')
            ->where('temp.status', '0')
            ->where('temp.term_id', $termId)
            ->where('temp.file_name', $template)
            ->join('sch_classes AS class', 'class.id = temp.class_id')
            ->get()
            ->getResult();

        return $template ? $template : [];
    }

    function getClassReportCardTemplate($classId, $termId, $studentId = 0)
    {
        $classID = $classId;
        if ($classID == 0) {
            $student = $this->db->table('sch_stream_students student')
                ->select('student.*, stream.class_id')
                ->where('student.student_id', $studentId)
                ->where('student.term_id', $termId)
                ->where('student.status', 'active')
                ->where('student.deleted', '0')
                ->join('sch_streams AS stream', 'stream.id = student.class_stream_id')
                ->get()
                ->getRow();

            if ($student) {
                $classID = $student->class_id;
            }
        }

        $template = $this->db->table('sch_report_card_templates as temp')
            ->select('temp.*, class.name as class_name, class.short_name')
            ->where('temp.status', '0')
            ->where('temp.deleted', '0')
            ->where('temp.term_id', $termId)
            ->where('temp.class_id', $classID)
            ->join('sch_classes AS class', 'class.id = temp.class_id')
            ->get()
            ->getRow();

        return $template ? $template : [];
    }
}
