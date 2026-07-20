<?php

namespace App\Models;

use CodeIgniter\Model;

class PrefixModel extends Model
{
    protected $table = 'prefixes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['prefix', 'operator'];
    
    // Vérifie si un numéro a un préfixe valide
    public function isValidPrefix($phone)
    {
        $prefix = substr($phone, 0, 3);
        return $this->where('prefix', $prefix)->first() !== null;
    }
}