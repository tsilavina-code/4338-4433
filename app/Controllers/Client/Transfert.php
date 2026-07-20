<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\ClientModel;
use App\Models\FeeModel;
use App\Models\PrefixModel;
use App\Models\TransactionModel;

class Transfert extends BaseController
{
    public function index()
    {
        if (!session()->get('is_logged_in')) {
            return redirect()->to('/');
        }
        return view('client/transfert');
    }
    
    public function doTransfert()
    {
        $amount = (float) $this->request->getPost('amount');
        $recipientPhone = $this->request->getPost('recipient');
        
        if ($amount <= 0) {
            return redirect()->back()->with('error', 'Montant invalide');
        }
        
        // Vérifier que le destinataire a un préfixe valide
        $prefixModel = new PrefixModel();
        if (!$prefixModel->isValidPrefix($recipientPhone)) {
            return redirect()->back()->with('error', 'Numéro destinataire invalide');
        }
        
        // Empêcher transfert vers soi-même
        if ($recipientPhone == session()->get('client_phone')) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas vous transférer à vous-même');
        }
        
        $clientId = session()->get('client_id');
        $clientModel = new ClientModel();
        $client = $clientModel->find($clientId);
        
        // Calculer frais de transfert
        $feeModel = new FeeModel();
        $fee = $feeModel->getFeeForAmount('TRANSFERT', $amount);
        $total = $amount + $fee;
        
        // Vérifier solde suffisant
        if ($client['balance'] < $total) {
            return redirect()->back()->with('error', 'Solde insuffisant pour ce transfert');
        }
        
        // Débiter l'émetteur
        $newBalance = $client['balance'] - $total;
        $clientModel->updateBalance($clientId, $newBalance);
        
        // Créer ou trouver le destinataire
        $recipient = $clientModel->findByPhone($recipientPhone);
        if (!$recipient) {
            $recipientId = $clientModel->createClient($recipientPhone);
            $recipient = $clientModel->find($recipientId);
        }
        
        // Créditer le destinataire (montant brut, sans frais)
        $recipientNewBalance = $recipient['balance'] + $amount;
        $clientModel->updateBalance($recipient['id'], $recipientNewBalance);
        
        $transactionModel = new TransactionModel();
        
        // Transaction émetteur
        $transactionModel->insert([
            'client_id'      => $clientId,
            'type'           => 'TRANSFERT',
            'amount'         => $amount,
            'fee'            => $fee,
            'total'          => $total,
            'recipient'      => $recipientPhone,
            'balance_before' => $client['balance'],
            'balance_after'  => $newBalance
        ]);
        
        // Transaction destinataire (reçoit un dépôt)
        $transactionModel->insert([
            'client_id'      => $recipient['id'],
            'type'           => 'DEPOT',
            'amount'         => $amount,
            'fee'            => 0,
            'total'          => $amount,
            'recipient'      => null,
            'balance_before' => $recipient['balance'],
            'balance_after'  => $recipientNewBalance
        ]);
        
        return redirect()->to('/client/dashboard')->with('success', 
            'Transfert de ' . number_format($amount, 0, ',', ' ') . 
            ' Ar envoyé à ' . $recipientPhone);
    }
}