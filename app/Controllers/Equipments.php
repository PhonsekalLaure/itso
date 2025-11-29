<?php
namespace App\Controllers;
use App\Models\Equipments_Model; // <- must match your model class name

class Equipments extends BaseController
{
    public function index()
    {
        if (!session()->get('admin')) {
            return redirect()->to(base_url('auth/login'));
        }

        $equipmentmodel = model('Equipments_Model');
        $perPage = 10;
        $equipments = $equipmentmodel
            ->where('is_deactivated', 0)
            ->paginate($perPage);
        $perPage = 10;


        $data = array(
            'title' => 'Equipment Dashboard',
            'admin' => session()->get('admin'),
            'pages' => $equipmentmodel->pager,
            'equipments' => $equipments
        );

        return view('include\head_view', $data)
            . view('include\nav_view')
            . view('equipments\equipments_dashboard', $data)
            . view('include\foot_view');
    }
    public function insert()
    {
        $model = new Equipments_Model();

        // Get POST data
        $totalCount = $this->request->getPost('total_count');
        $availableCount = $this->request->getPost('available_count');

        // Option 2: default available_count to total_count if not provided
        if ($availableCount === null || $availableCount === '') {
            $availableCount = $totalCount;
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'accessories' => $this->request->getPost('accessories'),
            'total_count' => $totalCount,
            'available_count' => $availableCount,
            'is_deactivated' => $this->request->getPost('is_deactivated') ?? 0,
            'date_added' => date('Y-m-d H:i:s'),
        ];

        $model->insert($data);

        return redirect()->to(base_url('equipments')); // redirect back to listing
    }

    public function delete($id = null)
    {
        if ($id === null) {
            return redirect()->to(base_url('equipments'))->with('error', 'No equipment ID provided.');
        }

        $model = new Equipments_Model();

        if ($model->find($id)) {
            $model->update($id, ['is_deactivated' => 1]);
            return redirect()->to(base_url('equipments'))->with('success', 'Equipment deleted successfully.');
        } else {
            return redirect()->to(base_url('equipments'))->with('error', 'Equipment not found.');
        }
    }
    public function view($id = null)
    {
        if ($id === null) {
            return redirect()->to(base_url('equipments'))->with('error', 'No equipment ID provided.');
        }

        $model = new Equipments_Model();
        $equipment = $model->find($id);

        if (!$equipment) {
            return redirect()->to(base_url('equipments'))->with('error', 'Equipment not found.');
        }

        $data = [
            'title' => 'View Equipment',
            'admin' => session()->get('admin'),
            'equipment' => $equipment
        ];

        return view('include\head_view', $data)
            . view('include\nav_view')
            . view('equipments\view_view', $data) // point to view_view.php
            . view('include\foot_view');
    }
    public function edit($id)
    {
        $equipmentModel = new Equipments_Model(); // instantiate the model

        $data = [
            'title' => 'Edit Equipment',
            'equipment' => $equipmentModel->find($id),
        ];

        if (!$data['equipment']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Equipment not found');
        }
        return view('include\head_view', $data)
            . view('include\nav_view')
            . view('equipments/edit_view', $data) // point to view_view.php
            . view('include\foot_view');
    }



}

?>