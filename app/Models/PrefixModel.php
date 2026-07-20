<?php
namespace App\Models;
use CodeIgniter\Models;


Class PrefixModel extends Model {
    protected $table = 'prefixes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['prefix', 'operator'];
}