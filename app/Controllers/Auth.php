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

    public function reset_request()
    {
        $adminmodel = model('Admins_Model');

        $username = (string) strtolower($this->request->getPost('username'));
        $user = $adminmodel->where('username', $username)
                           ->where('is_deactivated', 0)
                           ->whereIn('role', ['admin', 'sadmin'])
                           ->first();

        if (!$user) {
            session()->setFlashdata('error', 'Account not found.');
            return redirect()->back();
        }

        $message = "<h2>Hello " . $user['firstname'] . ",</h2><br>
            Reset your password <a href=" . base_url('auth/reset/' . $user['admin_id']) . ">here</a>.<br>From FEU Tech ITSO";

        $email = service('email');
        $email->setTo($user['email']);
        $email->setSubject('PASSWORD RESET');
        $email->setMessage($message);

        if (!$email->send()) {
            echo "MAY PROBLEMA!";
            return;
        }
        return redirect()->to('/');

    }
    public function reset_page($id)
    {
        $data = array(
            'title' => 'Reset Password',
            'admin_id' => $id
        );
        return view('include\head_auth_view', $data)
            . view('auth\reset_view', $data)
            . view('include\foot_auth_view');
    }

    public function reset($id)
    {
        $adminmodel = model('Admins_Model');

        $password = (string) $this->request->getPost('password');
        $confirm_password = (string) $this->request->getPost('confirm_password');

        if (empty($password) || empty($confirm_password)) {
            session()->setFlashdata('error', 'All fields are required.');
            return redirect()->back()->withInput();
        }

        if ($password !== $confirm_password) {
            session()->setFlashdata('error', 'Passwords do not match.');
            return redirect()->back()->withInput();
        }

        $updated = $adminmodel->update($id, ['password' => password_hash($password, PASSWORD_DEFAULT)]);
        if (!$updated) {
            session()->setFlashdata('error', 'Failed to reset password.');
            return redirect()->back()->withInput();
        }

        session()->setFlashdata('message', 'Password has been reset. You can now sign in.');
        return redirect()->to(base_url('auth/login'));
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'));
    }

}


?>