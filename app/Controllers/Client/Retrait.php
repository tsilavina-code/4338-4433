<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\ClientModel;
use App\Models\FeeModel;
use App\Models\TransactionModel;

class Retrait extends BaseController
{
    public function index()
    {
        if (!session()->get('is_logged_in')) {
            return redirect()->to('/');
        }
        return view('client/retrait');
    }
    
    public function doRetrait()
    {
        $amount = (float) $this->request->getPost('amount');
        
        if ($amount <= 0) {
            return redirect()->back()->with('error', 'Montant invalide');
        }
        
        $clientId = session()->get('client_id');
        $clientModel = new ClientModel();
        $client = $clientModel->find($clientId);
        
        // Calculer frais selon barème
        $feeModel = new FeeModel();
        $fee = $feeModel->getFeeForAmount('RETRAIT', $amount);
        $total = $amount + $fee;
        
        // Vérifier solde suffisant
        if ($client['balance'] < $total) {
            return redirect()->back()->with('error', 
                'Solde insuffisant. Nécessaire : ' . number_format($total, 0, ',', ' ') . 
                ' Ar (dont ' . number_format($fee, 0, ',', ' ') . ' Ar de frais)');
        }
        
        $newBalance = $client['balance'] - $total;
        
        // Mettre à jour solde
        $clientModel->updateBalance($clientId, $newBalance);
        
        // Enregistrer transaction
        $transactionModel = new TransactionModel();
        $transactionModel->insert([
            'client_id'      => $clientId,
            'type'           => 'RETRAIT',
            'amount'         => $amount,
            'fee'            => $fee,
            'total'          => $total,
            'recipient'      => null,
            'balance_before' => $client['balance'],
            'balance_after'  => $newBalance
        ]);
        
        return redirect()->to('/client/dashboard')->with('success', 
            'Retrait de ' . number_format($amount, 0, ',', ' ') . 
            ' Ar effectué (frais: ' . number_format($fee, 0, ',', ' ') . ' Ar)');
    }
}