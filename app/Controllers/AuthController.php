<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Staff;
use App\Models\Researcher;

class AuthController extends Controller
{
    public function login()
    {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/');
        }

        $this->view('auth/login', [
            'title' => 'Login'
        ]);
    }

    public function authenticate()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $staffModel = new Staff();
        $staff = $staffModel->findByEmail($email);

        if ($staff && (int) ($staff['is_active'] ?? 0) === 1 && $password == $staff['password']) {
            $_SESSION['user_id'] = $staff['id'];
            $_SESSION['user_type'] = 'staff';
            $this->redirect('/');
        }

        $researcherModel = new Researcher();
        $researcher = $researcherModel->findByEmail($email);

        if ($researcher && (int) ($researcher['is_active'] ?? 0) === 1 && $password == $researcher['password']) {
            $_SESSION['user_id'] = $researcher['id'];
            $_SESSION['user_type'] = 'researcher';
            $this->redirect('/');
        }

        $this->view('auth/login', [
            'title' => 'Login',
            'error' => 'Invalid credentials',
            'email' => $email
        ]);
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        $this->redirect('/login');
    }
}
