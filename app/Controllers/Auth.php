<?php
namespace App\Controllers;

class Auth extends BaseController {

    public function login() {
        $data = array(
            'title' => 'Login',
        );
        return view('include/head_view', $data)
            .view('auth/login_view')
            .view('include/foot_view');

    }

    public function authenticate() {
        $usermodel = model('Users_model');

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $usermodel->where('username', $username)
                          ->where('is_deleted', 0)
                          ->where('role', 'ITSO')
                          ->first();

        if ($user && password_verify($password, $user['password'])) {
            session()->set(['user' => $user]);
            return redirect()->to(base_url('users'));
        } else {
            session()->setFlashdata('error', 'Invalid username or password.');
            return redirect()->back()->withInput();
        }
    }

    public function forgot() {
        $data = array(
            'title' => 'Forgot Password',
        );
        return view('include\head_view', $data)
            .view('auth\forgot_view')
            .view('include\foot_view');
    }

}


?>