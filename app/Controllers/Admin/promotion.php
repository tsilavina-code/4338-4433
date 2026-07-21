<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Promotion_CommissionModel;
use App\Models\PrefixModel;

class promotion extends BaseController {
    public function index() {
        $Promotion_CommissionModel = new Promotion_CommissionModel();
        $prefixModel = new PrefixModel();
        
        $data['promotion_commission'] = $Promotion_CommissionModel->findAll();
        $data['active_page'] = 'promotion_commissions';
        
        
        return view('admin/promotion', $data);
    }
    
    public function ajouter() {
        $Promotion_CommissionModel = new Promotion_CommissionModel();
        
        $operator = $this->request->getPost('operator');
        $percentage = $this->request->getPost('percentage');
        
       
        $existing = $Promotion_CommissionModel->where('operator', $operator)->first();
        
        if ($existing) {
            // Mettre à jour
            $Promotion_CommissionModel->update($existing['id'], ['percentage' => $percentage]);
        } else {
            // Créer
            $Promotion_CommissionModel->insert([
                'operator' => $operator,
                'percentage' => $percentage
            ]);
        }
        
        return redirect()->to('admin/promotion');
    }
    
    public function supprimer($id) {
        $Promotion_CommissionModel = new Promotion_CommissionModel();
        $Promotion_CommissionModel->delete($id);
        return redirect()->to('admin/promotion');
    }
}
