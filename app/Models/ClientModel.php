<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'id';
    protected $allowedFields = ['phone', 'balance'];
    
    // Trouve un client par son numéro de téléphone
    public function findByPhone($phone)
    {
        return $this->where('phone', $phone)->first();
    }
    
    // Crée un nouveau client avec solde 0
    public function createClient($phone)
    {
        return $this->insert([
            'phone' => $phone,
            'balance' => 0
        ]);
    }
    
    // Met à jour le solde d'un client
    public function updateBalance($id, $newBalance)
    {
        return $this->update($id, ['balance' => $newBalance]);
    }
}