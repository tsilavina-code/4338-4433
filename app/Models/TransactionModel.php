<?php
namespace App\Models;
use CodeIgniter\Models;


Class TransactionModel extends Model {
    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['client_id', 'type', 'amount', 'fee', 'total', 'recipient', 'balance_before', 'balance_after'];
}