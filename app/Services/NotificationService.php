<?php

namespace App\Services;

use App\Core\Mailer;

class NotificationService
{
    private Mailer $mailer;

    public function __construct()
    {
        $this->mailer = new Mailer();
    }


    public function sendWelcomeEmail(string $email, string $name): bool
    {
        $subject = "Welcome to the IRB System!";
        
        $body = "
        <html>
        <head>
            <title>Welcome to IRB</title>
        </head>
        <body>
            <h2>Hello, {$name}!</h2>
            <p>Thank you for registering on our system. We are happy to have you on board.</p>
            <br>
            <p>Best regards,<br>The IRB System Team</p>
        </body>
        </html>
        ";

        return $this->mailer->send($email, $subject, $body);
    }

    public function sendApplicationStatusUpdate(string $email, string $applicationTitle, string $status): bool
    {
        $subject = "Application Status Updated: {$applicationTitle}";
        
        $body = "
        <html>
        <head>
            <title>Application Update</title>
        </head>
        <body>
            <h2>Application Status Change</h2>
            <p>Your research application <strong>\"{$applicationTitle}\"</strong> has been updated.</p>
            <p>New Status: <span style='font-weight: bold; color: #4CAF50;'>{$status}</span></p>
            <br>
            <p>Login to the portal to view full details.</p>
        </body>
        </html>
        ";

        return $this->mailer->send($email, $subject, $body);
    }
}
