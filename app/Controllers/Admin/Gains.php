<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

class Gains extends BaseController 
{
    public function index() 
    {
        $db = \Config\Database::connect();
        
        
        $data['gains_interne'] = $db->table('transactions')
                                    ->selectSum('fee')
                                    ->get()->getRow()->fee ?? 0;
        
       
        $data['gains_inter'] = $db->table('transactions')
                                  ->selectSum('commission')
                                  ->get()->getRow()->commission ?? 0;
        
        // Total global de tes gains
        $data['total_gains'] = $data['gains_interne'] + $data['gains_inter'];

        
        $data['montants_par_operateur'] = $db->table('transactions')
            ->select('p.operator, SUM(transactions.amount) as total_envoye, SUM(transactions.commission) as commissions_generees')
            ->join('prefixes p', 'SUBSTR(transactions.recipient, 1, 3) = p.prefix')
            ->where('p.is_our_operator', 0) // Uniquement les autres opérateurs
            ->groupBy('p.operator')
            ->get()->getResultArray();

        return view('admin/gains', $data);
    }
}