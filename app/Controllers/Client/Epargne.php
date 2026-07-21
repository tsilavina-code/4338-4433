<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\ClientModel;
use App\Models\TransactionModel;

class Epargne extends BaseController
{
    // Affiche le formulaire
    public function index()
    {
        if (!session()->get('is_logged_in')) {
            return redirect()->to('/client/login');
        }
        return view('client/epargne');
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
        $epargneModel = new EpargneModel();
        
        // Calculer montant par destinataire
        $amountPerRecipient = $amount / count($recipients);
        
        // Calculer frais de transfert
        $transferFee = $feeModel->getFeeForAmount('TRANSFERT', $amountPerRecipient);
        
        // Calculer commission et frais de retrait pour chaque destinataire
        $totalFee = 0;
        $totalCommission = 0;
        $totalepargne = 0;
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
        
       
       
        $epargneModel = new EpargneModel();
        $epargneId = $epargneModel->insert([
            'client_id'            => $clientId,
            'percentage'           => $percentage
        ]);
       
        return redirect()->to('/client/epargne')->with('success', $msg);
    }
} 
