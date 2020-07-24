<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Photos extends ResourceController
{
    protected $modelName = 'App\Models\MyApps';
    protected $format    = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll(),200);
    }

    
}