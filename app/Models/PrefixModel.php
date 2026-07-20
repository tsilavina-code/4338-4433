<?php

namespace App\Models;

use CodeIgniter\Model;

class PrefixModel extends Model
{
    protected $table = 'prefixes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['prefix', 'operator', 'is_our_operator'];
    
    // Vérifie si un numéro a un préfixe valide
    public function isValidPrefix($phone)
    {
        $prefix = substr($phone, 0, 3);
        return $this->where('prefix', $prefix)->first() !== null;
    }
   
    // Vérifie si c'est un numéro Yas (notre opérateur)
    public function isOurOperator($phone)
    {
        $prefix = substr($phone, 0, 3);
        $result = $this->where('prefix', $prefix)
                       ->where('is_our_operator', 1)
                       ->first();
        return $result !== null;
    }
}