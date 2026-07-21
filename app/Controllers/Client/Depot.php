<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\ClientModel;
use App\Models\TransactionModel;

class Depot extends BaseController
{
    // Affiche le formulaire
    public function index()
    {
        if (!session()->get('is_logged_in')) {
            return redirect()->to('/client/login');
        }
        return view('client/depot');
    }
    
    // Traite le dépôt
    public function doDepot()
    {
        $amount = (float) $this->request->getPost('amount');
        
        if ($amount <= 0) {
            return redirect()->back()->with('error', 'Montant invalide');
        }
        
        $clientId = session()->get('client_id');
        $clientModel = new ClientModel();
        $client = $clientModel->find($clientId);
        
        $newBalance = $client['balance'] + $amount;
        
        // Mettre à jour solde
        $clientModel->updateBalance($clientId, $newBalance);
        
        // Enregistrer transaction
        $transactionModel = new TransactionModel();
        $transactionModel->insert([
            'client_id'      => $clientId,
            'type'           => 'DEPOT',
            'amount'         => $amount,
            'fee'            => 0,
            'total'          => $amount,
            'recipient'      => null,
            'balance_before' => $client['balance'],
            'balance_after'  => $newBalance
        ]);
        
        return redirect()->to('/client/dashboard')->with('success', 
            'Dépôt de ' . number_format($amount, 0, ',', ' ') . ' Ar effectué');
    }
}