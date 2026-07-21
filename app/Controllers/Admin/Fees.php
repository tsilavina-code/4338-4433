<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\FeeModel;

class Fees extends BaseController {
    public function index() {
        $db = \Config\Database::connect();
        $data['fees'] = $db->table('fees')
                           ->select('fees.*, operations.name as op_name')
                           ->join('operations', 'operations.id = fees.operation_id')
                           ->get()->getResultArray();
        $data['active_page'] = 'fees';
        return view('admin/fees', $data);
    }

    public function modifier() {
        $feeModel = new FeeModel();
        $id = $this->request->getPost('id');
        
        $feeModel->update($id, [
            'min_amount' => $this->request->getPost('min_amount'),
            'max_amount' => $this->request->getPost('max_amount'),
            'fee_amount' => $this->request->getPost('fee_amount')
        ]);
        return redirect()->to('admin/fees');
    }
}