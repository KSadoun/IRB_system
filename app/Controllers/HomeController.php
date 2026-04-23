<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Researcher;
use App\Services\NotificationService;

class HomeController extends Controller
{
    protected ?string $defaultRoleLayout = 'researcher';

    public function testMail()
    {
        $notificationService = new NotificationService();
        $email = 'amarkhaled701@gmail.com';
        
        echo "Attempting to send email to {$email}...<br><br>";
        
        $result = $notificationService->sendWelcomeEmail($email, 'Test User');
        
        if ($result) {
            echo "<span style='color: green; font-weight: bold;'>Email successfully processed by PHP!</span><br>";
        } else {
            echo "<span style='color: red; font-weight: bold;'>Failed to send email.</span><br>";
            echo "Make sure your local SMTP (like sendmail in XAMPP) is correctly configured for external sending.";
        }
    }

    public function index()
    {
        $researcherModel = new Researcher();
        $researchers = $researcherModel->getAll('id', 'DESC');

        $this->view('home', [
            'title' => 'Welcome to IRB System',
            'researchers' => $researchers,
        ]);
    }
}