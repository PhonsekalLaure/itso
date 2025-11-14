<?php
namespace App\Controllers;

class Users extends BaseController {
    public function index() {
        $usermodel = model('Users_model');

        $data = array(
            'title' => 'Users List',
            'users' => $usermodel->where('is_deleted', 0)->findAll()
        );

        return view('include\head_view', $data)
            .view('include\nav_view')
            .view('userslist_view', $data)
            .view('include\foot_view');
    }

        public function add(){
        $data = array(
            'title' => 'Add User',
        );
        return view('include\head_view', $data)
            .view('include\nav_view')
            .view('users\add_view')
            .view('include\foot_view');
    }

    public function insert() {
        $usermodel = model('Users_model');

        $data = [
            'role' => 'user',
            'username' => $this->request->getPost('username'),
            'fullname' => $this->request->getPost('fullname'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'is_deleted' => 0,
        ];

        $usermodel->insert($data);
        return redirect()->to('users');
    }

    public function view($id) {
        $usermodel = model('Users_model');

        $data = array(
            'title' => 'View User',
            'user' => $usermodel->find($id)
        );
        return view('include\head_view', $data)
            .view('include\nav_view')
            .view('users\view_view', $data)
            .view('include\foot_view');
    }

    public function edit($id){
        $usermodel = model('Users_model');
        $data = array(
            'title' => 'Edit User',
            'user' => $usermodel->find($id)
        );
        return view('include\head_view', $data)
            .view('include\nav_view')
            .view('users\edit_view', $data)
            .view('include\foot_view');
    }

    public function update($id) {
        $usermodel = model('Users_model');

        $data = [
            'username' => $this->request->getPost('username'),
            'fullname' => $this->request->getPost('fullname'),
            'password' => $this->request->getPost('password'),
            'email' => $this->request->getPost('email'),
        ];

        $usermodel->update($id, $data);

        return redirect()->to('users');
    }

    public function delete($id) {
        $usermodel = model('Users_model');

        $data = [
            'is_deleted' => 1,
        ];

        $usermodel->update($id, $data);

        return redirect()->to('users');
    }
}
?>