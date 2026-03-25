<?php
declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Números Aleatorios</title>
    <style>
        :root {
            --color-bg: #0f1117;
            --color-surface: #1a1d27;
            --color-border: #2d3142;
            --color-text: #e8eaf0;
            --color-text-muted: #8b90a0;
            --color-accent: #6c63ff;
            --color-accent-hover: #5a52e0;
            --color-success: #22c55e;
            --color-warning: #f59e0b;
            --color-error: #ef4444;
            --color-info: #3b82f6;
            --radius: 10px;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background-color: var(--color-bg);
            color: var(--color-text);
            min-height: 100vh;
            padding: 40px 20px;
            line-height: 1.6;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius);
            padding: 32px;
            margin-bottom: 24px;
            box-shadow: var(--shadow);
        }

        h1 {
            font-size: 1.8rem;
            margin-bottom: 8px;
            color: var(--color-accent);
        }

        .subtitle {
            color: var(--color-text-muted);
            margin-bottom: 32px;
            font-size: 0.95rem;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            color: var(--color-text);
        }

        .label-hint {
            font-weight: 400;
            color: var(--color-text-muted);
            font-size: 0.85rem;
        }

        input[type="number"] {
            width: 100%;
            padding: 12px 14px;
            background: var(--color-bg);
            border: 1px solid var(--color-border);
            border-radius: 8px;
            color: var(--color-text);
            font-size: 1rem;
            margin-bottom: 16px;
            transition: border-color 0.2s;
        }

        input[type="number"]:focus {
            outline: none;
            border-color: var(--color-accent);
        }

        .input-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        @media (max-width: 500px) {
            .input-row {
                grid-template-columns: 1fr;
            }
        }

        button {
            background: var(--color-accent);
            color: #fff;
            border: none;
            padding: 14px 32px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.1s;
            width: 100%;
        }

        button:hover {
            background: var(--color-accent-hover);
        }

        button:active {
            transform: scale(0.98);
        }

        .error-list {
            list-style: none;
            padding: 0;
        }

        .error-list li {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid var(--color-error);
            border-radius: 8px;
            padding: 12px 16px;
            color: #fca5a5;
            margin-bottom: 10px;
            font-size: 0.9rem;
        }

        .error-list li:last-child {
            margin-bottom: 0;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        @media (max-width: 600px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .stat-card {
            background: var(--color-bg);
            border-radius: 8px;
            padding: 16px;
            text-align: center;
            border: 1px solid var(--color-border);
        }

        .stat-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--color-text-muted);
            margin-bottom: 6px;
        }

        .stat-value {
            font-size: 1.4rem;
            font-weight: 700;
        }

        .stat-suma .stat-value { color: var(--color-success); }
        .stat-promedio .stat-value { color: var(--color-warning); }
        .stat-minimo .stat-value { color: var(--color-info); }
        .stat-maximo .stat-value { color: #a78bfa; }

        .param-info {
            color: var(--color-text-muted);
            font-size: 0.85rem;
            margin-bottom: 20px;
            padding: 10px 14px;
            background: rgba(59, 130, 246, 0.08);
            border: 1px solid rgba(59, 130, 246, 0.2);
            border-radius: 8px;
        }

        .table-wrapper {
            overflow-x: auto;
            border-radius: 8px;
            border: 1px solid var(--color-border);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 300px;
        }

        thead {
            background: var(--color-bg);
        }

        th {
            padding: 12px 16px;
            text-align: left;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--color-text-muted);
            font-weight: 600;
            border-bottom: 1px solid var(--color-border);
        }

        td {
            padding: 10px 16px;
            font-size: 0.95rem;
            border-bottom: 1px solid var(--color-border);
        }

        tr:last-child td {
            border-bottom: none;
        }

        tbody tr:hover {
            background: rgba(108, 99, 255, 0.04);
        }

        .empty {
            text-align: center;
            color: var(--color-text-muted);
            padding: 40px;
            font-size: 0.95rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>Generador de Números Aleatorios</h1>
            <p class="subtitle">OOP · PHP 7.4+ · Patrón PRG</p>
            <?php require_once __DIR__ . '/form.php'; ?>
        </div>

        <?php if (count($errores) > 0): ?>
        <div class="card">
            <?php require_once __DIR__ . '/errors.php'; ?>
        </div>
        <?php endif; ?>

        <?php if ($resultado !== null): ?>
        <div class="card">
            <div class="param-info">
                Se generaron <strong><?php echo htmlspecialchars((string) $resultado['n'], ENT_QUOTES, 'UTF-8'); ?></strong>
                números entre <strong><?php echo htmlspecialchars((string) $resultado['rangoMin'], ENT_QUOTES, 'UTF-8'); ?></strong>
                y <strong><?php echo htmlspecialchars((string) $resultado['rangoMax'], ENT_QUOTES, 'UTF-8'); ?></strong>.
            </div>
            <?php require_once __DIR__ . '/results.php'; ?>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
