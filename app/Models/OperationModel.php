<?php
namespace App\Models;
use CodeIgniter\Models;


Class OperationModel extends Model {
    protected $table = 'types_operation';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom'];
}