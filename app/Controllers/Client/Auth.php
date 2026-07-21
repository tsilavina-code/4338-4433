<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\ClientModel;
use App\Models\PrefixModel;

class Auth extends BaseController
{
    // Affiche la page de login
    public function index()
    {
        return view('client/login');
    }
    
    // Traite le login
    public function login()
    {
        $phone = $this->request->getPost('phone');
        
        // Vérifier que le numéro n'est pas vide
        if (empty($phone)) {
            return redirect()->back()->with('error', 'Veuillez entrer un numéro');
        }
        
        $prefixModel = new PrefixModel();
        
        // Vérifier que le préfixe est valide
        if (!$prefixModel->isValidPrefix($phone)) {
            return redirect()->back()->with('error', 'Numéro invalide (préfixe non reconnu)');
        }
        
        // Vérifier que c'est un numéro Yas (notre opérateur)
        if (!$prefixModel->isOurOperator($phone)) {
            return redirect()->back()->with('error', 'Ce numéro n\'est pas un client Yas');
        }
        
        $clientModel = new ClientModel();
        $client = $clientModel->findByPhone($phone);
        
        // Si le client n'existe pas, création automatique
        if (!$client) {
            $clientId = $clientModel->createClient($phone);
            $client = $clientModel->find($clientId);
        }
        
        // Mettre en session
        session()->set([
            'client_id'    => $client['id'],
            'client_phone' => $client['phone'],
            'is_logged_in' => true
        ]);
        
        return redirect()->to('/client/dashboard');
    }
    
    // Déconnexion
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/client/login');
    }
}