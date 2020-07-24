<?php namespace App\Models;

use CodeIgniter\Model;
 
class Slide_model extends Model {
 
    protected $table = 'slide';
    protected $primaryKey = 'id_slide';
 
    public function getSlide($id = false)
    {
        if($id === false){
            return $this->findAll();
        } else {
            return $this->getWhere([$this->primaryKey => $id])->getRowObject();
        }  
    }
     
    public function insertSlide($data)
    {
        return $this->db->table($this->table)->insert($data);
    }
 
    public function updateSlide($data, $id)
    {
        return $this->db->table($this->table)->update($data, [$this->primaryKey => $id]);
    }
 
    public function deleteSlide($id)
    {
        return $this->db->table($this->table)->delete([$this->primaryKey => $id]);
    }
} 