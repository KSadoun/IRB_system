<?php

namespace App\Core;

class Controller
{
    protected ?string $layout = null;
    protected ?string $defaultRoleLayout = null;

    protected array $roleLayouts = [
        'admin' => 'layouts/admin',
        'manager' => 'layouts/manager',
        'officer' => 'layouts/officer',
        'researcher' => 'layouts/researcher',
        'reviewer' => 'layouts/reviewer',
    ];

    public function __construct()
    {
        if ($this->defaultRoleLayout !== null && $this->defaultRoleLayout !== '') {
            $this->setRoleLayout($this->defaultRoleLayout);
        }
    }

    public function setLayout(?string $layout): void
    {
        $this->layout = $layout;
    }

    public function setRoleLayout(string $role): void
    {
        $key = strtolower(trim($role));

        if (!isset($this->roleLayouts[$key])) {
            throw new \InvalidArgumentException("No layout configured for role '$role'.");
        }

        $this->layout = $this->roleLayouts[$key];
    }

    public function view($view, $data = [], ?string $layout = null)
    {
        $viewPath = __DIR__ . "/../Views/$view.php";
        if (!file_exists($viewPath)) {
            throw new \RuntimeException("View '$view' not found.");
        }

        extract($data, EXTR_SKIP);

        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        $layoutToUse = $layout ?? $this->layout;
        if ($layoutToUse === null || $layoutToUse === '') {
            echo $content;
            return;
        }

        $layoutPath = __DIR__ . "/../Views/$layoutToUse.php";
        if (!file_exists($layoutPath)) {
            throw new \RuntimeException("Layout '$layoutToUse' not found.");
        }

        require $layoutPath;
    }
}