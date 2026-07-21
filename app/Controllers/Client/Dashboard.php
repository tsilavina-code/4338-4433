<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\ClientModel;

class Dashboard extends BaseController
{
    public function index()
    {
        // Vérifier connexion
        if (!session()->get('is_logged_in')) {
            return redirect()->to('/client/login');
        }
        
        $clientModel = new ClientModel();
        $client = $clientModel->find(session()->get('client_id'));
        
        return view('client/dashboard', [
            'phone'   => $client['phone'],
            'balance' => $client['balance']
        ]);
    }
}