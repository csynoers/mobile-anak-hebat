<?php
    namespace App\Models;

    use CodeIgniter\Model;

    class Tes extends Model
    {
        function __construct()
        {
            $this->db = db_connect();
            $this->builder = $this->db->table('slide');
        }

        public function get()
        {
            return $this->builder->get();
        }
    }
    