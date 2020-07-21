<?php
    namespace App\Models;

    use CodeIgniter\Model;

    class Books extends Model
    {
        function __construct()
        {
            $this->db = db_connect();
            $this->builder = $this->db->table('book');
        }

        public function get($id)
        {
            $this->builder->select("*,concat('Rp. ', format( harga, 0)) AS hargaMod");
            $this->builder->where('id_book', $id);
            return $this->builder->get();
        }
        public function get_new_release()
        {
            $this->builder->select("*,concat('Rp. ', format( harga, 0)) AS hargaMod");
            $this->builder->where('new_release', 'new_release');
            $this->builder->limit(9);
            return $this->builder->get();
        }
        public function get_coming_soon()
        {
            $this->builder->select("*,concat('Rp. ', format( harga, 0)) AS hargaMod");
            $this->builder->where('coming_soon', 'coming_soon');
            $this->builder->limit(9);
            return $this->builder->get();
        }
        public function get_best_seller()
        {
            $this->builder->select("*,concat('Rp. ', format( harga, 0)) AS hargaMod");
            $this->builder->where('best_seller', 'best_seller');
            $this->builder->limit(9);
            return $this->builder->get();
        }
    }
    