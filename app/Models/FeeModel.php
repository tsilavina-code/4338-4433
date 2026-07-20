<?php
namespace App\Models;
use CodeIgniter\Models;


Class FeeModel extends Model {
    protected $table = 'Baremes_frais';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_type_operation', 'montant_min', 'montant_max', 'frais'];
}