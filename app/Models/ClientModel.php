<?php
namespace App\Models;
use CodeIgniter\Models;


Class ClientModel extends Model {
    protected $table = 'Clients';
    protected $primaryKey = 'id';
    protected $allowedFields = ['numero_telephone', 'solde'];
}