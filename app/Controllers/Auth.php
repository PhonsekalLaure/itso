<?php
namespace App\Controllers;

use App\Models\Admins_Model;

class Auth extends BaseController
{

    public function login()
    {
        if (session()->get('admin')) {
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

        $data = [
            'username' => strtolower(trim($this->request->getPost('username'))),
            'password' => $this->request->getPost('password'),
        ];

        $admin = $adminmodel->where('username', $data['username'])
            ->where('is_deactivated', 0)
            ->whereIn('role', ['admin', 'sadmin'])
            ->first();

        if (!$admin) {
            session()->setFlashdata('error', 'Invalid username or password.');
            return redirect()->back()->withInput();
        }

        if ($admin && password_verify($data['password'], $admin['password'])) {
            session()->set(['admin' => $admin]);
            return redirect()->to(base_url('dashboard'));
        } else {
            session()->setFlashdata('error', 'Invalid username or password.');
            return redirect()->back()->withInput();
        }
    }

    public function forgot()
    {
        if (session()->get('admin')) {
            return redirect()->to(base_url('dashboard'));
        }

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
        $admin = $adminmodel->where('username', $username)
            ->where('is_deactivated', 0)
            ->whereIn('role', ['admin', 'sadmin'])
            ->first();

        if (!$admin) {
            session()->setFlashdata('error', 'Account not found.');
            return redirect()->back();
        }

        $message = "<h2>Hello " . $admin['firstname'] . ",</h2><br>
            Reset your password <a href=" . base_url('auth/reset/' . $admin['token']) . ">here</a>.<br>From FEU Tech ITSO";

        $email = service('email');
        $email->setTo($admin['email']);
        $email->setSubject('PASSWORD RESET');
        $email->setMessage($message);

        if (!$email->send()) {
            return redirect()->back()->withInput()->with('errors', $email->printDebugger());
        }
        return redirect()->to('/');

    }
    public function reset_page($token)
    {
        if (session()->get('admin')) {
            return redirect()->to(base_url('dashboard'));
        }
        $data = array(
            'title' => 'Reset Password',
            'token' => $token
        );
        return view('include\head_auth_view', $data)
            . view('auth\reset_view', $data)
            . view('include\foot_auth_view');
    }

    public function reset($token)
    {
        $adminmodel = model('Admins_Model');
        $validation = service('validation');

        $data = [
            'password' => (string) $this->request->getPost('password'),
            'confirm_password' => (string) $this->request->getPost('confirm_password'),
        ];

        $admin = $adminmodel->where('token', $token)
            ->where('is_deactivated', 0)
            ->whereIn('role', ['admin', 'sadmin'])
            ->first();

        if (!$admin) {
            return redirect()->to('auth/login')->with('error', 'Invalid or expired token.');
        }

        if (!$validation->run($data, 'reset')) {
            // If validation fails, redirect back to the reset page with errors and old input
            $errors = $validation->getErrors();
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $password = $data['password'];
        $confirm_password = $data['confirm_password'];

        if (empty($password) || empty($confirm_password)) {
            return redirect()->back()->withInput()->with('error', 'All fields are required.');
        }

        if ($password !== $confirm_password) {
            return redirect()->back()->withInput()->with('error', 'Passwords do not match.');
        }

        $updated = $adminmodel->update($admin['admin_id'], [
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'token' => bin2hex(random_bytes(16))
        ]);
        if (!$updated) {
            return redirect()->back()->withInput()->with('error', 'Failed to reset password.');
        }
        return redirect()->to(base_url('auth/login'))->with('success', 'Password has been reset. You can now sign in.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'));
    }

}


?>