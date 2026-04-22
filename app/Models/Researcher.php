<?php

namespace App\Models;

use App\Core\Model;

class Researcher extends Model
{
    protected string $table = 'researcher';
    protected string $primaryKey = 'id';

    protected array $fillable = [
        'name',
        'email',
        'password',
        'national_id',
        'serial_number',
        'phone_no',
        'department',
        'faculty',
        'specialization',
        'id_front',
        'id_back',
        'is_active',
        'created_at',
        'updated_at',
    ];

    public function register(array $data): int|string
    {
        if (!isset($data['password'])) {
            throw new \InvalidArgumentException('Password is required.');
        }

        $now = date('Y-m-d H:i:s');

        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $data['is_active'] = $data['is_active'] ?? 0;
        $data['created_at'] = $data['created_at'] ?? $now;
        $data['updated_at'] = $data['updated_at'] ?? $now;

        return $this->create($data);
    }

    public function findByEmail(string $email): ?array
    {
        return $this->firstWhere('email', $email);
    }

    public function findById(int $id): ?array
    {
        return $this->getById($id);
    }

    public function findByNationalId(string $nationalId): ?array
    {
        return $this->firstWhere('national_id', $nationalId);
    }

    public function findBySerialNumber(string $serialNumber): ?array
    {
        return $this->firstWhere('serial_number', $serialNumber);
    }

    public function getActiveResearchers(): array
    {
        return $this->where('is_active', 1);
    }

    public function getPendingActivation(): array
    {
        return $this->where('is_active', 0);
    }

    public function updateProfile(int $id, array $data): bool
    {
        $data['updated_at'] = date('Y-m-d H:i:s');

        return $this->update($id, $data);
    }

    public function activateResearcher(int $id, string $serialNumber): bool
    {
        return $this->update($id, [
            'serial_number' => $serialNumber,
            'is_active' => 1,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function updateIdentityDocuments(int $id, string $idFrontPath, string $idBackPath): bool
    {
        return $this->update($id, [
            'id_front' => $idFrontPath,
            'id_back' => $idBackPath,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function changePassword(int $id, string $plainPassword): bool
    {
        return $this->update($id, [
            'password' => password_hash($plainPassword, PASSWORD_BCRYPT),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function deleteResearcher(int $id): bool
    {
        return $this->delete($id);
    }

    public function emailExists(string $email, ?int $excludeId = null): bool
    {
        $sql = "SELECT id FROM {$this->table} WHERE email = :email";
        $params = ['email' => $email];

        if ($excludeId !== null) {
            $sql .= " AND id != :exclude_id";
            $params['exclude_id'] = $excludeId;
        }

        $sql .= ' LIMIT 1';

        $stmt = $this->query($sql, $params);

        return (bool) $stmt->fetch();
    }
}
