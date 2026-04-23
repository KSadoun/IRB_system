<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars((string) ($title ?? 'Reviewer Desk')) ?></title>
    <style>
        :root {
            --bg: #faf8ff;
            --surface: #ffffff;
            --text: #1f2937;
            --line: #e5e7eb;
            --accent: #6d28d9;
        }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; color: var(--text); background: var(--bg); }
        .shell { max-width: 1120px; margin: 28px auto; background: var(--surface); border: 1px solid var(--line); border-radius: 12px; overflow: hidden; }
        .header { padding: 18px 22px; background: #f5f3ff; border-bottom: 1px solid var(--line); }
        .badge { display: inline-block; padding: 4px 10px; border-radius: 999px; background: var(--accent); color: #fff; font-size: 12px; }
        .content { padding: 22px; }
    </style>
</head>
<body>
    <main class="shell">
        <header class="header">
            <span class="badge">REVIEWER</span>
            <h1><?= htmlspecialchars((string) ($title ?? 'Reviewer Desk')) ?></h1>
        </header>
        <section class="content"><?= $content ?></section>
    </main>
</body>
</html>
