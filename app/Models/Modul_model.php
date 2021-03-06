<?php namespace App\Models;

use CodeIgniter\Model;
 
class Modul_model extends Model {
 
    protected $table = 'modul';
    protected $primaryKey = 'id_modul';
 
    public function getModul($id = false)
    {
        if($id === false){
            return $this->findAll();
        } else {
            return $this->getWhere([$this->primaryKey => $id])->getRowObject();
        }  
    }
     
    public function insertModul($data)
    {
        return $this->db->table($this->table)->insert($data);
    }
 
    public function updateModul($data, $id)
    {
        return $this->db->table($this->table)->update($data, [$this->primaryKey => $id]);
    }
 
    public function deleteModul($id)
    {
        return $this->db->table($this->table)->delete([$this->primaryKey => $id]);
    }
} 