<?php

namespace App\Models\user_models\academics_settings;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;
use Config\Database;

class M_ManageAcademicYears extends Model
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

    function getCurrentYear() {
        $current_year = '';
        $academic_years = $this->db->table('sch_academic_years')
            ->select('*')
            ->where('deleted', 0)
            ->where('branch_id', h_session('branch_id'))
            ->orderBy('id', 'desc')
            ->get()
            ->getResult();

        $currentDate = date('Y-m-d');
        foreach ($academic_years as $academic_year) {
            $startDate = $academic_year->start_date;
            $endDate = $academic_year->end_date;

            if ($currentDate >= $startDate && $currentDate <= $endDate) {
                $current_year = $academic_year;
            }
        }

        if ($current_year == '') {
            $current_year = $this->db->table('sch_academic_years')
                    ->select('*')
                    ->where('deleted', 0)
                    ->where('branch_id', h_session('branch_id'))
                    ->orderBy('id', 'desc')
                    ->get()
                    ->getRow();
        }

        return $current_year == '' ? [] : $current_year;
    }

    public function listRegisteredAcademicYears()
    {
        $academic_years = $this->db->table('sch_academic_years')
            ->select('*')
            ->where('deleted', 0)
            ->where('branch_id', h_session('branch_id'))
            ->orderBy('id', 'desc')
            ->get()
            ->getResult();

        // Get the current date in 'Y-m-d' format
        $currentDate = date('Y-m-d');
        foreach ($academic_years as $academic_year) {

            $startDate = $academic_year->start_date;
            $endDate = $academic_year->end_date;
            if ($currentDate >= $startDate && $currentDate <= $endDate) {
                $academic_year->is_current_year = '0';
            } else {
                $academic_year->is_current_year = '1';
            }

            $academic_year_terms = $this->db->table('sch_academic_year_terms')
                ->select('*')
                ->where('deleted', 0)
                ->where('academic_year_id', $academic_year->id)
                ->orderBy('id', 'desc')
                ->get()
                ->getResult();

            foreach ($academic_year_terms as $key => $academic_year_term) {
                $termStartDate = $academic_year_term->start_date;
                $termEndDate = $academic_year_term->end_date;
                if ($currentDate >= $termStartDate && $currentDate <= $termEndDate) {
                    $academic_year_term->is_current_term = '0';
                } else {
                    $academic_year_term->is_current_term = '1';
                }
            }

            $academic_year->terms = $academic_year_terms;
        }

        return $academic_years ? $academic_years : [];
    }

    public function saveAcademicYearData($data)
    {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';

        // Begin transaction
        $this->db->transBegin();

        try {

            $this->db->table('sch_academic_years')->insert($data);
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

    public function updateAcademicYearData($id, $data)
    {
        $response = ['success' => false];

        try {
            $this->db->table('sch_academic_years')
                ->where('id', $id)
                ->update($data);

            $response['success'] = true;
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }

        return (object) $response;
    }

    public function saveAcademicYearTermData($data)
    {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';

        // Begin transaction
        $this->db->transBegin();

        try {

            $this->db->table('sch_academic_year_terms')->insert($data);
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

    public function listRegisteredAcademicYearTerms($year = '')
    {
        if ($year) {
            $academic_year_terms = $this->db->table('sch_academic_year_terms AS academic_term')
                ->select('academic_term.*, academic.name AS academic_year_name, academic.id AS academic_year_id')
                ->where('academic_term.deleted', 0)
                ->where('academic.deleted', 0)
                ->where('academic_term.academic_year_id', $year)
                ->join('sch_academic_years AS academic', 'academic.id = academic_term.academic_year_id')
                ->get()
                ->getResult();
        } else {
            $academic_year_terms = $this->db->table('sch_academic_year_terms AS academic_term')
                ->select('academic_term.*, academic.name AS academic_year_name, academic.id AS academic_year_id')
                ->where('academic_term.deleted', 0)
                ->where('academic.deleted', 0)
                ->join('sch_academic_years AS academic', 'academic.id = academic_term.academic_year_id')
                ->get()
                ->getResult();
        }

        return $academic_year_terms ? $academic_year_terms : [];
    }

    public function saveSchoolClassData($data)
    {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';

        // Begin transaction
        $this->db->transBegin();

        try {

            $this->db->table('sch_classes')->insert($data);
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

    public function getClassById($id)
    {
        return $this->db->table('sch_classes')
            ->where('id', $id)
            ->where('deleted', 0)
            ->get()
            ->getRow();
    }

    public function updateSchoolClassData($id, $data)
    {
        $response = ['success' => false];

        try {
            $this->db->table('sch_classes')
                ->where('id', $id)
                ->update($data);

            $response['success'] = true;
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }

        return (object) $response;
    }

    public function softDeleteClass($id)
    {
        $response = ['success' => false];

        try {
            $this->db->table('sch_classes')
                ->where('id', $id)
                ->update(['deleted' => '1']);

            $response['success'] = true;
            $response['message'] = 'Class deleted successfully.';
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }

        return $response;
    }

    public function listRegisteredSchoolClasses()
    {
        $classes = $this->db->table('sch_classes')
            ->select('*')
            ->where('branch_id', h_session('branch_id'))
            ->where('deleted', 0)
            ->get()
            ->getResult();

        foreach ($classes as $class) {
            $streams = $this->db->table('sch_streams')
                ->select('*')
                ->where('class_id', $class->id)
                ->where('deleted', 0)
                ->where('status', 'active')
                ->get()
                ->getResult();

            $class->streams = $streams;
        }

        return $classes ? $classes : [];
    }

    public function saveClassStreamData($data)
    {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';

        // Begin transaction
        $this->db->transBegin();

        try {

            $this->db->table('sch_streams')->insert($data);
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

    public function listRegisteredClassStreams($classId = 0)
    {
        if ($classId == 0) {
            $streams = $this->db->table('sch_streams AS stream')
                ->select('stream.*, class.name AS class_name, class.short_name AS class_short_name')
                ->where('class.deleted', 0)
                ->where('stream.deleted', 0)
                ->where('stream.branch_id', h_session('branch_id'))
                ->join('sch_classes AS class', 'class.id = stream.class_id')
                ->get()
                ->getResult();
        } else {
            $streams = $this->db->table('sch_streams AS stream')
                ->select('stream.*, class.name AS class_name, class.short_name AS class_short_name')
                ->where('class.deleted', 0)
                ->where('stream.deleted', 0)
                ->where('stream.branch_id', h_session('branch_id'))
                ->where('class.id', $classId)
                ->join('sch_classes AS class', 'class.id = stream.class_id')
                ->get()
                ->getResult();
        }
        return $streams ? $streams : [];
    }

    public function getStreamById($id)
    {
        return $this->db->table('sch_streams')
            ->where('id', $id)
            ->where('deleted', 0)
            ->get()
            ->getRow();
    }

    public function updateClassStreamData($id, $data)
    {
        $response = ['success' => false];

        try {
            $this->db->table('sch_streams')
                ->where('id', $id)
                ->update($data);

            $response['success'] = true;
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }

        return (object) $response;
    }

    public function softDeleteStream($id)
    {
        $response = ['success' => false];

        try {
            $this->db->table('sch_streams')
                ->where('id', $id)
                ->update(['deleted' => '1']);

            $response['success'] = true;
            $response['message'] = 'Stream deleted successfully.';
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }

        return $response;
    }

    public function listRegisteredSubjects()
    {
        $subjects = $this->db->table('sch_subjects')
            ->select('*')
            ->where('deleted', 0)
            ->get()
            ->getResult();

        return $subjects ? $subjects : [];
    }

    public function saveSubjectData($data)
    {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';

        // Begin transaction
        $this->db->transBegin();

        try {

            $this->db->table('sch_subjects')->insert($data);
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

    public function getSubjectById($id)
    {
        return $this->db->table('sch_subjects')
            ->where('id', $id)
            ->where('deleted', 0)
            ->get()
            ->getRow();
    }

    public function updateSubjectData($id, $data)
    {
        $response = ['success' => false];

        try {
            $this->db->table('sch_subjects')
                ->where('id', $id)
                ->update($data);

            $response['success'] = true;
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }

        return (object) $response;
    }

    function getAcademicYearTermById($id)
    {
        $academic_year_term = $this->db->table('sch_academic_year_terms AS academic_term')
            ->select('academic_term.*, academic.name AS academic_year_name, academic.id AS academic_year_id')
            ->where('academic_term.deleted', 0)
            ->where('academic.deleted', 0)
            ->where('academic_term.id', $id)
            ->join('sch_academic_years AS academic', 'academic.id = academic_term.academic_year_id')
            ->get()
            ->getRow();
        return $academic_year_term;
    }

    function saveEditAcademicYearTermData($updateData, $id)
    {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';

        try {
            // Start a transaction
            $this->db->transStart();

            $this->db->table('sch_academic_year_terms')
                ->where('id', $id)
                ->update($updateData);

            // Complete the transaction
            $this->db->transComplete();

            // Check transaction status
            if ($this->db->transStatus() === false) {
                // Log the error if transaction failed
                $response['message'] = $e->getMessage();
            } else {
                $response['success'] = true;
                $response['StatusCode'] = '00';
            }
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }

        return (object) $response;
    }
}
