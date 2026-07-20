<?php
namespace App\Models;
use CodeIgniter\Models;


Class FeeModel extends Model {
    protected $table = 'fees';
    protected $primaryKey = 'id';
    protected $allowedFields = ['operation_id', 'min_amount', 'max_amount', 'fee_amount'];
}