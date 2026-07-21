<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\TransactionModel;

class Historique extends BaseController
{
    public function index()
    {
        if (!session()->get('is_logged_in')) {
            return redirect()->to('/client/login');
        }
        
        $transactionModel = new TransactionModel();
        $transactions = $transactionModel->getByClient(session()->get('client_id'));
        
        return view('client/historique', ['transactions' => $transactions]);
    }
}