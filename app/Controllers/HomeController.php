<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Staff;
use App\Models\Researcher;

class HomeController extends Controller
{
    protected ?string $defaultRoleLayout = 'researcher';

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }

        $user = null;

        $userType = $_SESSION['user_type'] ?? 'staff';
        $userId = (int) $_SESSION['user_id'];

        if ($userType === 'researcher') {
            $user = (new Researcher())->findById($userId);
        } else {
            $user = (new Staff())->find($userId);
        }


        $this->view('home', [
            'title' => 'Welcome to IRB System',
            'user' => $user
        ]);
    }
}