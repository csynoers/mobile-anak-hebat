<?php namespace App\Models;

use CodeIgniter\Model;
 
class Author_model extends Model {
 
    protected $table = 'author';
    protected $primaryKey = 'id_author';
 
    public function get($id = false)
    {
        if($id === false){
            return $this->findAll();
        } else {
            return $this->getWhere([$this->primaryKey => $id])->getRowObject();
        }  
    }
     
    public function insertAuthor($data)
    {
        return $this->db->table($this->table)->insert($data);
    }
 
    public function updateAuthor($data, $id)
    {
        return $this->db->table($this->table)->update($data, [$this->primaryKey => $id]);
    }
 
    public function deleteAuthor($id)
    {
        return $this->db->table($this->table)->delete([$this->primaryKey => $id]);
    }
} 