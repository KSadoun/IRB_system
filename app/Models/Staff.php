<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Staff extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function find(int $id)
    {
        $stmt = self::$db->prepare('SELECT * FROM staff WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByEmail(string $email)
    {
        $stmt = self::$db->prepare('SELECT * FROM staff WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function register(string $name, string $role, string $email, string $password, ?string $ssn = null, bool $is_active = true)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $created_at = date('Y-m-d H:i:s');

        $stmt = self::$db->prepare('INSERT INTO staff (name, role, email, password, ssn, is_active, created_at) VALUES (:name, :role, :email, :password, :ssn, :is_active, :created_at)');
        $stmt->execute([
            'name' => $name,
            'role' => $role,
            'email' => $email,
            'password' => $hash,
            'ssn' => $ssn,
            'is_active' => $is_active ? 1 : 0,
            'created_at' => $created_at,
        ]);

        return (int) self::$db->lastInsertId();
    }

    public function verifyPasswordByEmail(string $email, string $password)
    {
        $staff = $this->findByEmail($email);
        if (!$staff) {
            return false;
        }

        return $password == $staff['password'];
    }

    public function updateActive(int $id, bool $is_active)
    {
        $stmt = self::$db->prepare('UPDATE staff SET is_active = :is_active WHERE id = :id');
        return $stmt->execute(['is_active' => $is_active ? 1 : 0, 'id' => $id]);
    }
}
