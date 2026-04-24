<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?> - IRB System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900 flex items-center justify-center min-h-screen p-4 font-sans">
    <div class="bg-white p-10 rounded-xl shadow-lg w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">IRB System</h1>
            <p class="text-gray-500 mt-2 text-sm"><?= htmlspecialchars($title) ?> to your account</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="bg-red-100 text-red-600 p-3 rounded-md text-sm mb-6 text-center border border-red-300">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="flex flex-col gap-5">
            <div class="flex flex-col gap-2">
                <label for="email" class="text-sm font-medium text-gray-700">Email Address</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" placeholder="name@example.com" required autofocus
                    class="px-4 py-3 border border-gray-300 rounded-lg outline-none transition-colors duration-200 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-600/20 text-md">
            </div>

            <div class="flex flex-col gap-2">
                <label for="password" class="text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required
                    class="px-4 py-3 border border-gray-300 rounded-lg outline-none transition-colors duration-200 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-600/20 text-md">
            </div>

            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg mt-2 transition-all duration-200 active:translate-y-px">
                Sign in
            </button>
        </form>
    </div>
</body>
</html>
