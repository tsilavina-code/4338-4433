<?php

namespace App\Models;

use CodeIgniter\Model;

class EpargneModel extends Model
{
    protected $table = 'epargne_client';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'client_id', 'percentage',   ];
    
    // Récupère l'historique d'un client
    public function getByClient($clientId)
    {
        return $this->where('client_id', $clientId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}