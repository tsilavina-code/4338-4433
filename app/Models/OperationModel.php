<?php
namespace App\Models;
use CodeIgniter\Models;


Class OperationModel extends Model {
    protected $table = 'operations';
    protected $primaryKey = 'id';
    protected $allowedFields = ['code', 'name', 'description'];
}