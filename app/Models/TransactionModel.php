<?php
namespace App\Models;
use CodeIgniter\Models;


Class TransactionModel extends Model {
    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_client_source', 'id_client_destination', 'id_type_operation', 'montant', 'frais_appliques'];
}