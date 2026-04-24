<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($title) ?></title>
</head>
<body>
    <h1><?= htmlspecialchars($title) ?></h1>
    <?php if (!empty($user)): ?>
        <p>Signed in as <?= htmlspecialchars($user['name']) ?> (<a href="logout">Logout</a>)</p>
    <?php else: ?>
        <p><a href="login">Login</a></p>
    <?php endif; ?>
</body>
</html>
