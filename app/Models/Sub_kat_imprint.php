<?php
    namespace App\Models;

    use CodeIgniter\Model;

    class Sub_kat_imprint extends Model
    {
        function __construct()
        {
            $this->db = db_connect();
            $this->builder = $this->db->table('sub_kat_imprint');
        }

        public function get($id)
        {
            $this->builder->where('id_sub_kat_imprint', $id);
            return $this->builder->get();
        }
    }
    