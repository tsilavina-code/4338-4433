<?php

namespace App\Models;

use CodeIgniter\Model;

class FeeModel extends Model
{
    protected $table = 'fees';
    protected $primaryKey = 'id';
    protected $allowedFields = ['operation_id', 'min_amount', 'max_amount', 'fee_amount'];
    
    // Trouve le frais applicable pour un montant donné
    public function getFeeForAmount($operationCode, $amount)
    {
        $operationModel = new OperationModel();
        $operation = $operationModel->where('code', $operationCode)->first();
        
        if (!$operation) {
            return 0;
        }
        
        $fee = $this->where('operation_id', $operation['id'])
                    ->where('min_amount <=', $amount)
                    ->where('max_amount >=', $amount)
                    ->first();
        
        return $fee ? $fee['fee_amount'] : 0;
    }
}