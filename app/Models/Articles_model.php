<?php namespace App\Models;

use CodeIgniter\Model;
 
class Articles_model extends Model {
 
    protected $table = 'articles';
    protected $primaryKey = 'id_articles';
 
    public function getArticles($id = false)
    {
        if($id === false){
            return $this->findAll();
        } else {
            return $this->getWhere([$this->primaryKey => $id])->getRowObject();
        }  
    }
     
    public function insertArticles($data)
    {
        return $this->db->table($this->table)->insert($data);
    }
 
    public function updateArticles($data, $id)
    {
        return $this->db->table($this->table)->update($data, [$this->primaryKey => $id]);
    }
 
    public function deleteArticles($id)
    {
        return $this->db->table($this->table)->delete([$this->primaryKey => $id]);
    }
} 