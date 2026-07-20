<?php
namespace App\Models;
use CodeIgniter\Models;


Class ClientModel extends Model {
    protected $table = 'clients';
    protected $primaryKey = 'id';
    protected $allowedFields = ['phone', 'balance'];
}