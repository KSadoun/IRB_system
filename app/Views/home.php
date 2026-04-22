<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 24px; }
        table { border-collapse: collapse; width: 100%; margin-top: 16px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f4f4f4; }
    </style>
</head>
<body>
    <h1><?= $title ?></h1>

    <h2>Researchers</h2>

    <?php if (!empty($researchers)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Faculty</th>
                    <th>Active</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($researchers as $researcher): ?>
                    <tr>
                        <td><?= htmlspecialchars((string) ($researcher['id'] ?? '')) ?></td>
                        <td><?= htmlspecialchars((string) ($researcher['name'] ?? '')) ?></td>
                        <td><?= htmlspecialchars((string) ($researcher['email'] ?? '')) ?></td>
                        <td><?= htmlspecialchars((string) ($researcher['department'] ?? '')) ?></td>
                        <td><?= htmlspecialchars((string) ($researcher['faculty'] ?? '')) ?></td>
                        <td><?= !empty($researcher['is_active']) ? 'Yes' : 'No' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No researchers found.</p>
    <?php endif; ?>
</body>
</html>