<?php namespace App\Models;

use CodeIgniter\Model;
 
class Profil_model extends Model {
 
    protected $table = 'profil';
    protected $primaryKey = 'id_profil';
 
    public function getProfil($id = false)
    {
        if($id === false){
            return $this->findAll();
        } else {
            return $this->getWhere([$this->primaryKey => $id])->getRowObject();
        }  
    }
     
    public function insertProfil($data)
    {
        return $this->db->table($this->table)->insert($data);
    }
 
    public function updateProfil($data, $id)
    {
        return $this->db->table($this->table)->update($data, [$this->primaryKey => $id]);
    }
 
    public function deleteProfil($id)
    {
        return $this->db->table($this->table)->delete([$this->primaryKey => $id]);
    }
} 