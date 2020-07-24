<?php namespace App\Models;

use CodeIgniter\Model;
 
class Sub_kat_imprint_model extends Model {
 
    protected $table = 'sub_kat_imprint';
    protected $primaryKey = 'id_sub_kat_imprint';
 
    public function getKategori($id = false)
    {
        if($id === false){
            return $this->findAll();
        } else {
            return $this->getWhere([$this->primaryKey => $id])->getRowObject();
        }  
    }
     
    public function insertKategori($data)
    {
        return $this->db->table($this->table)->insert($data);
    }
 
    public function updateKategori($data, $id)
    {
        return $this->db->table($this->table)->update($data, [$this->primaryKey => $id]);
    }
 
    public function deleteKategori($id)
    {
        return $this->db->table($this->table)->delete([$this->primaryKey => $id]);
    }
} 