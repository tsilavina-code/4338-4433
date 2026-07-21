<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\PrefixModel;

class Prefixes extends BaseController {
    public function index() {
        $model = new PrefixModel();
        $data['prefixes'] = $model->findAll();
        $data['active_page'] = 'prefixes';
        return view('admin/prefixes', $data);
    }

    public function ajouter() {
        $model = new PrefixModel();
        $model->insert([
            'prefix'   => $this->request->getPost('prefix'),
            'operator' => $this->request->getPost('operator') // Ajouté car obligatoire dans ton SQL
        ]);
        return redirect()->to('admin/prefixes');
    }

    public function supprimer($id) {
        $model = new PrefixModel();
        $model->delete($id);
        return redirect()->to('admin/prefixes');
    }
}