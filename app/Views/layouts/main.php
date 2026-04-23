<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars((string) ($title ?? 'IRB System')) ?></title>
    <style>
        :root {
            --bg: #f6f7fb;
            --surface: #ffffff;
            --text: #1f2937;
            --muted: #6b7280;
            --line: #e5e7eb;
            --accent: #1d4ed8;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text);
            background: linear-gradient(180deg, #eef2ff 0%, var(--bg) 160px);
        }
        .shell {
            max-width: 1040px;
            margin: 32px auto;
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(17, 24, 39, 0.06);
        }
        .shell-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--line);
            background: #f8fafc;
        }
        .shell-header h1 {
            margin: 0;
            font-size: 1.35rem;
        }
        .shell-header p {
            margin: 6px 0 0;
            color: var(--muted);
        }
        .shell-content {
            padding: 24px;
        }
        a { color: var(--accent); }
    </style>
</head>
<body>
    <main class="shell">
        <header class="shell-header">
            <h1><?= htmlspecialchars((string) ($title ?? 'IRB System')) ?></h1>
            <p>Institutional Review Board Management</p>
        </header>
        <section class="shell-content">
            <?= $content ?>
        </section>
    </main>
</body>
</html>
