<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\ClientModel;
use App\Models\FeeModel;
use App\Models\PrefixModel;
use App\Models\CommissionModel;
use App\Models\TransactionModel;
use App\Models\TransactionRecipientModel;

class Transfert extends BaseController
{
    public function index()
    {
        if (!session()->get('is_logged_in')) {
            return redirect()->to('/client/login');
        }
        
        // Récupérer tous les clients sauf soi-même pour la liste déroulante
        $clientModel = new ClientModel();
        $clients = $clientModel->where('phone !=', session()->get('client_phone'))
                               ->findAll();
        
        return view('client/transfert', ['clients' => $clients]);
    }
    
    public function doTransfert()
    {
        $amount = (float) $this->request->getPost('amount');
        $recipients = $this->request->getPost('recipients'); // Tableau de numéros
        $includeWithdrawFee = $this->request->getPost('include_withdraw_fee') ? 1 : 0;
        
        if ($amount <= 0) {
            return redirect()->back()->with('error', 'Montant invalide');
        }
        
        if (empty($recipients) || !is_array($recipients)) {
            return redirect()->back()->with('error', 'Veuillez sélectionner au moins un destinataire');
        }
        
        // Filtrer les doublons et vides
        $recipients = array_unique(array_filter($recipients));
        
        if (empty($recipients)) {
            return redirect()->back()->with('error', 'Veuillez sélectionner au moins un destinataire');
        }
        
        $clientId = session()->get('client_id');
        $clientModel = new ClientModel();
        $client = $clientModel->find($clientId);
        
        $prefixModel = new PrefixModel();
        $feeModel = new FeeModel();
        $commissionModel = new CommissionModel();
        
        // Calculer montant par destinataire
        $amountPerRecipient = $amount / count($recipients);
        
        // Calculer frais de transfert
        $transferFee = $feeModel->getFeeForAmount('TRANSFERT', $amountPerRecipient);
        
        // Calculer commission et frais de retrait pour chaque destinataire
        $totalFee = 0;
        $totalCommission = 0;
        $totalWithdrawFee = 0;
        
        foreach ($recipients as $recipientPhone) {
            // Vérifier préfixe valide
            if (!$prefixModel->isValidPrefix($recipientPhone)) {
                return redirect()->back()->with('error', 'Numéro invalide : ' . $recipientPhone);
            }
            
            // Vérifier pas soi-même
            if ($recipientPhone == session()->get('client_phone')) {
                return redirect()->back()->with('error', 'Vous ne pouvez pas vous envoyer de l\'argent');
            }
            
            // Commission si autre opérateur
            $prefix = substr($recipientPhone, 0, 3);
            $prefixInfo = $prefixModel->where('prefix', $prefix)->first();
            
            if ($prefixInfo && $prefixInfo['is_our_operator'] == 0) {
                $commission = $amountPerRecipient * ($commissionModel->getPercentage($prefixInfo['operator']) / 100);
                $totalCommission += $commission;
            }
            
            // Frais de retrait inclus ?
            if ($includeWithdrawFee) {
                $withdrawFee = $feeModel->getFeeForAmount('RETRAIT', $amountPerRecipient);
                $totalWithdrawFee += $withdrawFee;
            }
        }
        
        $totalFee = $transferFee * count($recipients);
        $totalDebit = $amount + $totalFee + $totalCommission + $totalWithdrawFee;
        
        // Vérifier solde
        if ($client['balance'] < $totalDebit) {
            return redirect()->back()->with('error', 'Solde insuffisant. Nécessaire : ' . number_format($totalDebit, 0) . ' Ar');
        }
        
        // Débiter l'émetteur
        $newBalance = $client['balance'] - $totalDebit;
        $clientModel->updateBalance($clientId, $newBalance);
        
        // Créer la transaction principale
        $transactionModel = new TransactionModel();
        $transactionId = $transactionModel->insert([
            'client_id'            => $clientId,
            'type'                 => 'TRANSFERT',
            'amount'               => $amount,
            'fee'                  => $totalFee,
            'commission'           => $totalCommission,
            'total'                => $totalDebit,
            'recipient'            => implode(', ', $recipients),
            'include_withdraw_fee' => $includeWithdrawFee,
            'is_multiple'          => count($recipients) > 1 ? 1 : 0,
            'balance_before'       => $client['balance'],
            'balance_after'        => $newBalance
        ]);
        
        // Créer les destinataires et créditer
        $transactionRecipientModel = new TransactionRecipientModel();
        
        foreach ($recipients as $recipientPhone) {
            $recipient = $clientModel->findByPhone($recipientPhone);
            if (!$recipient) {
                $recipientId = $clientModel->createClient($recipientPhone);
                $recipient = $clientModel->find($recipientId);
            }
            
            $recipientNewBalance = $recipient['balance'] + $amountPerRecipient;
            $clientModel->updateBalance($recipient['id'], $recipientNewBalance);
            
            $transactionRecipientModel->insert([
                'transaction_id'    => $transactionId,
                'recipient_phone'   => $recipientPhone,
                'amount'            => $amountPerRecipient
            ]);
            
            // Transaction DEPOT pour le destinataire
            $transactionModel->insert([
                'client_id'       => $recipient['id'],
                'type'            => 'DEPOT',
                'amount'          => $amountPerRecipient,
                'fee'             => 0,
                'commission'      => 0,
                'total'           => $amountPerRecipient,
                'recipient'       => null,
                'balance_before'  => $recipient['balance'],
                'balance_after'   => $recipientNewBalance
            ]);
        }
        
        $msg = 'Transfert de ' . number_format($amount, 0) . ' Ar effectué';
        if (count($recipients) > 1) {
            $msg .= ' (' . count($recipients) . ' destinataires)';
        }
        
        return redirect()->to('/client/dashboard')->with('success', $msg);
    }
}