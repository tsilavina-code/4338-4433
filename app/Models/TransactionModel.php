<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'client_id', 'type', 'amount', 'fee', 'commission', 'total',
        'recipient', 'include_withdraw_fee', 'is_multiple',
        'balance_before', 'balance_after'
    ];
    
    // Récupère l'historique d'un client
    public function getByClient($clientId)
    {
        return $this->where('client_id', $clientId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}