<?php
    namespace App\Models;

    use CodeIgniter\Model;

    class Resensies extends Model
    {
        function __construct()
        {
            $this->db = db_connect();
            $this->builder = $this->db->table('resensi');
        }

        public function get($id)
        {
            $this->builder->where('id_book', $id);
            return $this->builder->get();
        }
    }
    