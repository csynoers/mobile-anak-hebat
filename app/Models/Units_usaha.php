<?php
    namespace App\Models;

    use CodeIgniter\Model;

    class Units_usaha extends Model
    {
        function __construct()
        {
            $this->db = db_connect();
            $this->builder = $this->db->table('unit_usaha');
        }

        public function get($id)
        {
            $this->builder->where('id_unit_usaha', $id);
            return $this->builder->get();
        }
    }
    