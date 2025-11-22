<?php
namespace App\Controllers;

use App\Models\Admins_Model;

class Auth extends BaseController
{

    public function login()
    {
        if (session()->get('user')) {
            return redirect()->to(base_url('dashboard'));
        }

        $data = array(
            'title' => 'Login',
        );
        return view('include\head_auth_view', $data)
            . view('auth\login_view')
            . view('include\foot_auth_view');

    }

    public function authenticate()
    {
        $adminmodel = model('Admins_Model');

        $username = strtolower(trim($this->request->getPost('username')));
        $password = $this->request->getPost('password');

        $user = $adminmodel->where('username', $username)
                          ->where('is_deactivated', 0)
                          ->whereIn('role', ['admin', 'sadmin'])
                          ->first();

        if ($user && password_verify($password, $user['password'])) {
            session()->set(['user' => $user]);
            return redirect()->to(base_url('dashboard'));
        } else {
            session()->setFlashdata('error', 'Invalid username or password.');
            return redirect()->back()->withInput();
        }
    }

    public function forgot()
    {
        $data = array(
            'title' => 'Forgot Password',
        );
        return view('include\head_auth_view', $data)
            . view('auth\forgot_view')
            . view('include\foot_auth_view');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'));
    }

}


?>