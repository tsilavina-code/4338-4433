<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FeeModel;
use App\Models\OperationModel;

class Fees extends BaseController {

    public function index() {
        $db = \Config\Database::connect();
        $data['fees'] = $db->table('fees')
                           ->select('fees.*, operations.name as op_name')
                           ->join('operations', 'operations.id = fees.operation_id')
                           ->get()
                           ->getResultArray();
                           
        $data['active_page'] = 'fees';
        return view('admin/fees', $data);
    }

    public function modifier() {
        $feeModel = new FeeModel();
        $id = $this->request->getPost('id');

        if (!$id) {
            return redirect()->back()->with('error', 'ID invalide.');
        }

        $feeModel->update($id, [
            'min_amount' => $this->request->getPost('min_amount'),
            'max_amount' => $this->request->getPost('max_amount'),
            'fee_amount' => $this->request->getPost('fee_amount')
        ]);

        return redirect()->to('admin/fees')->with('success', 'Barème modifié avec succès.');
    }

    public function ajouter() {
        $feeModel = new FeeModel();
        $operationModel = new OperationModel();
        
        // Récupérer l'ID de l'opération
        $operation = $operationModel->where('code', $this->request->getPost('operation_code'))->first();
        
        if (!$operation) {
            return redirect()->back()->with('error', "Type d'opération invalide");
        }
        
        $feeModel->insert([
            'operation_id' => $operation['id'],
            'min_amount'   => $this->request->getPost('min_amount'),
            'max_amount'   => $this->request->getPost('max_amount'),
            'fee_amount'   => $this->request->getPost('fee_amount')
        ]);
        
        return redirect()->to('admin/fees')->with('success', 'Barème ajouté avec succès.');
    }
}