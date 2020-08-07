<?php namespace App\Controllers;

use App\Models\UserModel;

class User extends BaseController
{
	public function index()
	{
	    $data = [];
	    helper(['form']);

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'email' => 'required|min_length[6]|max_length[50]|valid_email',
                'password' => 'required|min_length[8]|max_length[255]|validateUser[email,password]',
            ];

            $errors = [
                'password' => [
                    'validateUser' => 'Email and password don\'t match'
                ]
            ];

            if (!$this->validate($rules, $errors)) {
                $data['validation'] = $this->validator;
            }else {
                $model = new UserModel();

                $user = $model->where('email', $this->request->getVar('email'))->first();

                $this->setUserSession($user);

                return redirect()->to('dashboard');

            }
        }

	    echo view('templates/header', $data);
	    echo view('login', $data);
	    echo view('templates/footer' , $data);
//		echo view('userView');
	}

	private function setUserSession($user)
    {
        $data = [
            'id' => $user['id'],
            'firstname' => $user['firstname'],
            'lastname' => $user['lastname'],
            'email' => $user['email'],
            'isLoggedIn' => true,
        ];

        session()->set($data);
        return true;
    }

	public function register()
    {
        $data = [];

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'firstname' => 'required|min_length[3]|max_length[20]',
                'lastname' => 'required|min_length[3]|max_length[20]',
                'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[8]|max_length[255]',
                'password_confirm' => 'matches[password]',
            ];

            if (! $this->validate($rules)) {
                $data['validation'] = $this->validator;
            }else {
                $model = new UserModel();

                $userData = [
                    'firstname' => $this->request->getPost('firstname'),
                    'lastname' => $this->request->getPost('lastname'),
                    'email' => $this->request->getPost('email'),
                    'password' => $this->request->getPost('password'),
                ];

                $model->save($userData);
                $session = session();
                $session->setFlashdata('success', 'Registered!!!');
                return redirect()->to(site_url());
            }
        }

        echo view('templates/header', $data);
        echo view('register', $data);
        echo view('templates/footer', $data);
//		echo view('userView');
    }

    public function profile()
    {
        $data = [];

        $model = new UserModel();

        if ($this->request->getMethod() == 'post') {

            $rules = [
                'firstname' => 'required|min_length[3]|max_length[20]',
                'lastname' => 'required|min_length[3]|max_length[20]',
            ];

            if ($this->request->getPost('password') != '')
            {
                $rules['password'] = 'required|min_length[8]|max_length[255]';
                $rules['password_confirm'] = 'matches[password]';
            }

            if (! $this->validate($rules)) {
                $data['validation'] = $this->validator;
            }else {

                $userData = [
                    'id' => session()->get('id'),
                    'firstname' => $this->request->getPost('firstname'),
                    'lastname' => $this->request->getPost('lastname'),
                ];

                if ($this->request->getPost('password') != '')
                {
                    $userData['password'] = $this->request->getPost('password');
                }

                $model->save($userData);

                session()->setFlashdata('success', 'Updated successfully');
                return redirect()->to('/profile');
            }

        }
        $data['user'] = $model->where('id', session()->get('id'))->first();
        echo view('templates/header', $data);
        echo view('profile');
        echo view('templates/footer');
    }

	//--------------------------------------------------------------------

}
