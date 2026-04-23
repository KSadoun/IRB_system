<?php

namespace App\Core;

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Require the PHPMailer files directly
require_once __DIR__ . '/../Libs/PHPMailer/src/Exception.php';
require_once __DIR__ . '/../Libs/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../Libs/PHPMailer/src/SMTP.php';

class Mailer
{
    private array $config;

    public function __construct()
    {
        $this->config = require __DIR__ . '/../../config/mail.php';
    }

    public function send(string $to, string $subject, string $body): bool
    {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = $this->config['host']; 
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->config['username'];
            $mail->Password   = $this->config['password'];
            
            // Set encryption (tls, ssl) or leave empty depending on the port
            if ($this->config['encryption']) {
                $mail->SMTPSecure = $this->config['encryption'];
            }
            
            $mail->Port       = $this->config['port'];

            // Recipients
            $mail->setFrom($this->config['from_address'], $this->config['from_name']);
            $mail->addAddress($to);
            $mail->addReplyTo($this->config['from_address'], $this->config['from_name']);

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = strip_tags($body); // Plain text fallback

            $mail->send();
            return true;
        } catch (Exception $e) {
            // You can log $mail->ErrorInfo here if you need to debug
            return false;
        }
    }
}