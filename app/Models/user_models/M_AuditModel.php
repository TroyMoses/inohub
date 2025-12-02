<?php

namespace App\Models\user_models;

use CodeIgniter\Model;

class M_AuditModel extends Model
{
    protected $table = 'audit_trail';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'action', 'table_name', 'record_id', 'changes', 'date_added'];
    protected $returnType = 'array';

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

    public function logAudit($user_id, $action, $table_name, $record_id, $changes)
    {

        $data = [
            'user_id'    => $user_id,
            'action'     => $action,
            'table_name' => $table_name,
            'record_id'  => $record_id,
            'changes'    => json_encode($changes),
            'date_added' => date('Y-m-d H:i:s')
        ];
        
        $this->db->table('sch_audit_trail')->insert($data);
    }
}
