<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\ClientModel;

class Comptes extends BaseController {
    public function index() {
        $model = new ClientModel();
        $data['clients'] = $model->findAll();
        $data['active_page'] = 'comptes';
        return view('admin/comptes', $data);
    }
}