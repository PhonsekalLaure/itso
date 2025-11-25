<?php
namespace App\Controllers;

use App\Models\Users_Model;

class Users extends BaseController
{

    public function index()
    {
        if (!session()->get('user')) {
            return redirect()->to(base_url('auth/login'));
        }

        $usermodel = new Users_Model();

        $data = [
            'title' => 'Users Dashboard',
            'user' => session()->get('user'),
            'users' => $usermodel->where('is_deactivated', 0)
                                ->where('is_verified', 1)
                                ->orderBy('role','ASC')
                                ->findAll()
        ];

        return view('include/head_view', $data)
            . view('include/nav_view')
            . view('users/users_dashboard', $data)
            . view('include/foot_view');
    }

    public function insert()
    {
        $usermodel = new Users_Model();
        $validation = service('validation');

        $data = [
            'firstname' => $this->request->getPost('firstname'),
            'lastname' => $this->request->getPost('lastname'),
            'email' => $this->request->getPost('email'),
            'role' => $this->request->getPost('acctype'),
        ];

        // Runs the validation
        if (!$validation->run($data, 'create_user')) {
            // If validation fails, redirect back to the users page with errors and old input
            $errors = $validation->getErrors();
            return redirect()->to('users')->withInput()->with('errors', $errors);
        }

        $data_insert = [
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'role' => $data['role'],
            'is_deactivated' => 0,
            'is_verified' => 0,
            'token' => bin2hex(random_bytes(16)),
        ];

        $message = "<h2>Hello " . $data['firstname'] . ",</h2><br>
            Click <a href=" . base_url('users/verify/' . $data_insert['token']) . ">here</a> to verify your Account.<br>From FEU Tech ITSO";

        $email = service('email');
        $email->setTo($data['email']);
        $email->setSubject('EMAIL VERIFICATION');
        $email->setMessage($message);
        if (!$email->send()) {
            echo "MAY PROBLEMA!";
            return;
        }


        $usermodel->insert($data_insert);

        return redirect()->to('users')->with('success', 'User added successfully!');
    }

    public function verify($token)
    {
        $usermodel = model('Users_Model');
        $usermodel->where(['token' => $token]);
        $user = $usermodel->first();
        // dd($user);
        if ($user) {
            // dd($user);
            $usermodel->update($user['user_id'], ['is_verified' => 1]);

            // TODO: Create session to inform user that verification is successful, redirect(0)->to('user/login')

            return redirect()->to('users')->with('success', 'User Account Verified.');
        }
    }

    public function view($id)
    {
        $usermodel = model('Users_Model');

        $data = [
            'title' => 'View User',
            'user' => $usermodel->find($id)
        ];

        return view('include/head_view', $data)
            . view('include/nav_view')
            . view('users/view_view', $data)
            . view('include/foot_view');
    }

    public function edit($id)
    {
        $usermodel = new Users_Model();

        $data = [
            'title' => 'Edit User',
            'user' => $usermodel->find($id)
        ];

        return view('include/head_view', $data)
            . view('include/nav_view')
            . view('users/edit_view', $data)
            . view('include/foot_view');
    }

    public function update($id)
    {
        $usermodel = new Users_Model();

        $data = [
            'firstname' => $this->request->getPost('firstname'),
            'lastname' => $this->request->getPost('lastname'),
            'email' => $this->request->getPost('email'),
        ];

        // Only update password if provided
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $usermodel->update($id, $data);

        return redirect()->to('users')->with('success', 'User updated successfully!');
    }

    public function delete($id)
    {
        $usermodel = new Users_Model();

        $user = $usermodel->find($id);
        if (!$user) {
            return redirect()->to('users')->with('error', 'User not found.');
        }

        // Soft delete
        $usermodel->update($id, ['is_deactivated' => 1]);

        return redirect()->to('users')->with('success', 'User deleted successfully.');
    }
}
?>