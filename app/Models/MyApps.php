<?php namespace App\Models;

use CodeIgniter\Model;

class MyApps extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['name', 'email'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function get($id=NULL)
    {
        if ( $id ) {
            return $this->findAll();
        } else {
            return $this->getWhere(['id'=>$id])->getRowObject();
        }
        
    }
}