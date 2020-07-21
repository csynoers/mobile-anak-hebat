<?php
    namespace App\Models;

    use CodeIgniter\Model;

    class Authors extends Model
    {
        function __construct()
        {
            $this->db = db_connect();
            $this->builder = $this->db->table('author');
        }

        public function getInId($id)
        {
            $this->builder->whereIn('id_author', $id);
            return $this->builder->get();
        }
    }
    