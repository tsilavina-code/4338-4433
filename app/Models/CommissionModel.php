<?php

namespace App\Models;

use CodeIgniter\Model;

class CommissionModel extends Model
{
    protected $table = 'commissions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['operator', 'percentage'];
    
    // Récupère le % de commission pour un opérateur
    public function getPercentage($operator)
    {
        $result = $this->where('operator', $operator)->first();
        return $result ? $result['percentage'] : 0;
    }
}