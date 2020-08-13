<?php namespace App\Models;

use CodeIgniter\Model;
 
class Faq_model extends Model {
 
    protected $table = 'faq';
    protected $primaryKey = 'id_faq';
 
    public function getFaq($id = false)
    {
        if($id === false){
            return $this->findAll();
        } else {
            return $this->getWhere([$this->primaryKey => $id])->getRowObject();
        }  
    }
     
    public function insertFaq($data)
    {
        return $this->db->table($this->table)->insert($data);
    }
 
    public function updateFaq($data, $id)
    {
        return $this->db->table($this->table)->update($data, [$this->primaryKey => $id]);
    }
 
    public function deleteFaq($id)
    {
        return $this->db->table($this->table)->delete([$this->primaryKey => $id]);
    }
} 