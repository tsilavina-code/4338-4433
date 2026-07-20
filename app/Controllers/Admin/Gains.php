<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

class Gains extends BaseController {
    public function index() {
        $db = \Config\Database::connect();
        
        $data['total_gains'] = $db->table('transactions')->selectSum('fee')->get()->getRow()->fee ?? 0;
        
        $data['gains_details'] = $db->table('transactions')
                                    ->select('type, SUM(fee) as total')
                                    ->groupBy('type')
                                    ->get()->getResultArray();

        return view('admin/gains', $data);
    }
}