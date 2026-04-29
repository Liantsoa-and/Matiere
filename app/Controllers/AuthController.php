<?php
namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        // Si déjà connecté, rediriger
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        // Valeurs par défaut comme demandé dans le TP
        $data = [
            'default_email' => 'admin@example.com',
            'default_password' => 'password'
        ];

        return view('auth/login', $data);
    }

    public function authenticate()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user->password)) {
            session()->set([
                'isLoggedIn' => true,
                'userId' => $user->id,
                'userEmail' => $user->email
            ]);
            return redirect()->to('/dashboard');
        }

        session()->setFlashdata('error', 'Email ou mot de passe incorrect');
        return redirect()->back()->withInput();
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}