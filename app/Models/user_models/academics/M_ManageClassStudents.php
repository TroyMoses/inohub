<?php

namespace App\Models\user_models\academics;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;
use Config\Database;

class M_ManageClassStudents extends Model
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
            }
            else{
                $db = Database::connect();
            }
        }
        $this->db = $db;
    }

    public function listClassStreamStudents($streamId = 0, $termId = 0)
    {
        if ($streamId == 0 && $termId == 0) {
            $students = $this->db->table('sch_stream_students as stream_std')
                ->select('stream_std.*, people.*, student.*')
                ->where('stream_std.deleted', 0)
                ->where('people.status', 'active')
                ->where('people.deleted', 0)
                ->where('people.branch_id', h_session('branch_id'))
                ->join('sch_student AS student', 'student.id = stream_std.student_id')
                ->join('sch_people AS people', 'people.id = student.people_id')
                ->get()
                ->getResult();
        }
        else{

            $students = $this->db->table('sch_stream_students as stream_std')
                        ->select('stream_std.*, people.*, student.*')
                        ->where('stream_std.class_stream_id', $streamId)
                        ->where('stream_std.term_id', $termId)
                        ->where('stream_std.deleted', 0)
                        ->where('people.status', 'active')
                        ->where('people.deleted', 0)
                        ->where('people.branch_id', h_session('branch_id') )
                        ->join('sch_student AS student', 'student.id = stream_std.student_id')
                        ->join('sch_people AS people', 'people.id = student.people_id')
                        ->get()
                        ->getResult();
        }
        
        return $students ? $students : [];
    }

    public function listClassStudents($classId, $termId)
    {
        $students = $this->db->table('sch_stream_students as stream_std')
                ->select('stream_std.*, people.*, student.*, sch_class.name as class_name')
                ->where('sch_stream.class_id', $classId)
                ->where('stream_std.term_id', $termId)
                ->where('stream_std.deleted', 0)
                ->where('people.branch_id', h_session('branch_id') )
                ->where('people.status', 'active')
                ->where('people.deleted', 0)
                ->join('sch_streams AS sch_stream', 'sch_stream.id = stream_std.class_stream_id')
                ->join('sch_classes AS sch_class', 'sch_class.id = sch_stream.class_id')
                ->join('sch_student AS student', 'student.id = stream_std.student_id')
                ->join('sch_people AS people', 'people.id = student.people_id')
                ->get()
                ->getResult();

        return $students ? $students : [];
    }

}