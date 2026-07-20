<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'client_id', 'type', 'amount', 'fee', 'total', 
        'recipient', 'balance_before', 'balance_after'
    ];
    
    // Récupère l'historique d'un client
    public function getByClient($clientId)
    {
        return $this->where('client_id', $clientId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}