<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\CommissionModel;
use App\Models\PrefixModel;

class Commissions extends BaseController {
    public function index() {
        $commissionModel = new CommissionModel();
        $prefixModel = new PrefixModel();
        
        $data['commissions'] = $commissionModel->findAll();
        $data['active_page'] = 'commissions';
        
        // Récupérer les opérateurs qui ne sont pas les nôtres
        $data['other_operators'] = $prefixModel->where('is_our_operator', 0)
                                                ->groupBy('operator')
                                                ->findAll();
        
        return view('admin/commissions', $data);
    }
    
    public function ajouter() {
        $commissionModel = new CommissionModel();
        
        $operator = $this->request->getPost('operator');
        $percentage = $this->request->getPost('percentage');
        
        // Vérifier si une commission existe déjà pour cet opérateur
        $existing = $commissionModel->where('operator', $operator)->first();
        
        if ($existing) {
            // Mettre à jour
            $commissionModel->update($existing['id'], ['percentage' => $percentage]);
        } else {
            // Créer
            $commissionModel->insert([
                'operator' => $operator,
                'percentage' => $percentage
            ]);
        }
        
        return redirect()->to('admin/commissions');
    }
    
    public function supprimer($id) {
        $commissionModel = new CommissionModel();
        $commissionModel->delete($id);
        return redirect()->to('admin/commissions');
    }
}
