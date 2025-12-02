<?php

namespace App\Models\user_models\settings;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;
use Config\Database;

class M_ManageSetting extends Model
{
    protected $table = 'sch_people';
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


    public function listRequirements($type = 'school')
    {
        $requirements = $this->db->table('sch_requirements')
                ->select('*')
                ->where('req_type', $type)
                ->where('status', '0')
                ->get()
                ->getResult();
     
        return $requirements ? $requirements : [];
    }

    function saveDormitryData($saveData) {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';

        try {
            // Start a transaction
            $this->db->transStart();
            $this->db->table('sch_accomodation')->insert($saveData);
            // Complete the transaction
            $this->db->transComplete();
        
            // Check transaction status
            if ($this->db->transStatus() === false) {
                // Log the error if transaction failed
                $logger = \Config\Services::logger();
                $logger->error('Failed to update');

                $response['message'] = $e->getMessage();
            }
            else {
                $response['success'] = true;
                $response['StatusCode'] = '00';
            }
                
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }

        return (object) $response;
    }

    function saverequirementsData($saveData) {
        $response = [];
        $response['success'] = false;
        $response['StatusCode'] = '57';

        try {
            // Start a transaction
            $this->db->transStart();

            $this->db->table('sch_requirements')->insert($saveData);

            // Complete the transaction
            $this->db->transComplete();
        
            // Check transaction status
            if ($this->db->transStatus() === false) {
                // Log the error if transaction failed
                $logger = \Config\Services::logger();
                $logger->error('Failed to update');

                $response['message'] = $e->getMessage();
            }
            else {
                $response['success'] = true;
                $response['StatusCode'] = '00';
            }
                
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
        }

        return (object) $response;
    }

    function listTermRequirements($reqType, $termId) {
        $requirements = $this->db->table('sch_term_requirements req')
                ->select('req.*, class.name, class.short_name')
                ->where('req.term_id', $termId)
                ->where('req.status', '0')
                ->join('sch_classes AS class', 'class.id = req.class_id')
                ->get()
                ->getResult();

        // foreach ($requirements as $key => $requirement) {
            
        // }
     
        return $requirements ? $requirements : [];
    }

    function saveSchoolThemeData($updateData) {
        $response = [];
        $response['success'] = true;
        $response['StatusCode'] = '00';

        $theme = $this->db->table('sch_theme_styling')
                ->select('*')
                ->get()
                ->getRow();

        if ($theme) {
            $this->db->table('sch_theme_styling')
                ->where('id', $theme->id)
                ->update($updateData);
        } else {
            $this->db->table('sch_theme_styling')->insert($updateData); 
        }

        return (object) $response;
    }

    function getSchoolThemeData() {
        $theme = $this->db->table('sch_theme_styling')
                ->select('*')
                ->get()
                ->getRow();
        
        return $theme? $theme : [];
    }

}
