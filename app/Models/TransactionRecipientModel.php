<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionRecipientModel extends Model
{
    protected $table = 'transaction_recipients';
    protected $primaryKey = 'id';
    protected $allowedFields = ['transaction_id', 'recipient_phone', 'amount'];
}