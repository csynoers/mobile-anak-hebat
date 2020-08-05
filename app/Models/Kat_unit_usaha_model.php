<?php namespace App\Models;

use CodeIgniter\Model;
 
class Kat_unit_usaha_model extends Model {
 
    protected $table = 'kat_unit_usaha';
    protected $primaryKey = 'id_kat_unit_usaha';
 
    public function getKatUnitUsaha($id = false)
    {
        if($id === false){
            return $this->findAll();
        } else {
            return $this->getWhere([$this->primaryKey => $id])->getRowObject();
        }  
    }
     
    public function insertKatUnitUsaha($data)
    {
        return $this->db->table($this->table)->insert($data);
    }
 
    public function updateKatUnitUsaha($data, $id)
    {
        return $this->db->table($this->table)->update($data, [$this->primaryKey => $id]);
    }
 
    public function deleteKatUnitUsaha($id)
    {
        return $this->db->table($this->table)->delete([$this->primaryKey => $id]);
    }
} 