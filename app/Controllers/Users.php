<?php
namespace App\Controllers;

use App\Models\Users_Model;

class Users extends BaseController
{

    public function index()
    {
        if (!session()->get('admin')) {
            return redirect()->to(base_url('auth/login'));
        }

        $usermodel = new Users_Model();

        // Use pagination to limit results and provide pager object to the view
        $perPage = 10; // change this number to show more/less rows per page
        $users = $usermodel
            ->where('is_deactivated', 0)
            ->where('is_verified', 1)
            ->orderBy('role', 'ASC')
            ->paginate($perPage);

        $data = [
            'title' => 'Users Dashboard',
            'admin' => session()->get('admin'),
            // keep the existing 'pages' key for backward compatibility and also provide 'pager'
            'pages' => $usermodel->pager,
            'pager' => $usermodel->pager,
            'users' => $users,
        ];

        return view('include/head_view', $data)
            . view('include/nav_view')
            . view('users/users_dashboard', $data)
            . view('include/foot_view');
    }

    public function insert()
    {
        // Only Super Administrators can add users
        $admin = session()->get('admin');
        if (!$admin || strtolower($admin['role']) !== 'sadmin') {
            return redirect()->to('users')->with('error', 'Unauthorized: only Super Administrators can add users.');
        }

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
        if (!session()->get('admin')) {
            return redirect()->to(base_url('auth/login'));
        }
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
        if (!session()->get('admin')) {
            return redirect()->to(base_url('auth/login'));
        }
        // Only Super Administrators can add users
        $admin = session()->get('admin');
        if (!$admin || strtolower($admin['role']) !== 'sadmin') {
            return redirect()->to('users')->with('error', 'Unauthorized: only Super Administrators can add users.');
        }

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
        // Only Super Administrators can add users
        $admin = session()->get('admin');
        if (!$admin || strtolower($admin['role']) !== 'sadmin') {
            return redirect()->to('users')->with('error', 'Unauthorized: only Super Administrators can add users.');
        }
        $usermodel = new Users_Model();
        $validation = service('validation');

        $data = [
            'firstname' => $this->request->getPost('firstname'),
            'lastname' => $this->request->getPost('lastname'),
            'email' => $this->request->getPost('email'),
        ];

        // Build rules for update: ensure email is unique except for this user id
        $rules = [
            'firstname' => 'required|min_length[2]|max_length[50]|regex_match[/^[A-Za-z][A-Za-z\' -]*$/]',
            'lastname' => 'required|min_length[2]|max_length[50]|regex_match[/^[A-Za-z][A-Za-z\' -]*$/]',
            'email' => 'required|valid_email|is_unique[users.email,user_id,' . $id . ']',
        ];

        // Set the rules and run validation against the provided data
        $validation->setRules($rules);
        if (!$validation->run($data)) {
            // If validation fails, redirect back to the edit page with errors and old input
            $errors = $validation->getErrors();
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $usermodel->update($id, $data);

        return redirect()->to('users')->with('success', 'User updated successfully!');
    }

    public function delete($id)
    {
        // Only Super Administrators can add users
        $admin = session()->get('admin');
        if (!$admin || strtolower($admin['role']) !== 'sadmin') {
            return redirect()->to('users')->with('error', 'Unauthorized: only Super Administrators can add users.');
        }

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
<?php
