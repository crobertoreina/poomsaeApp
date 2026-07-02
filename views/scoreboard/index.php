<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=5">
    <title>Scoreboard - <?= htmlspecialchars($torneo['nombre']) ?></title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #0a0a23; color: #fff; min-height: 100vh; }
        .header { background: linear-gradient(135deg, #1a237e, #283593); padding: 20px 16px; text-align: center; }
        .header h1 { font-size: 20px; font-weight: 800; }
        .header .sub { font-size: 12px; opacity: 0.6; margin-top: 4px; }
        .content { max-width: 600px; margin: 0 auto; padding: 12px; }
        .categoria-title { font-size: 14px; font-weight: 700; color: #81c784; text-transform: uppercase; letter-spacing: 1px; margin: 16px 0 8px; }
        .card { background: #1a1a3e; border-radius: 14px; padding: 12px 14px; margin-bottom: 6px; display: flex; align-items: center; gap: 10px; }
        .card .pos { width: 28px; height: 28px; border-radius: 50%; background: rgba(255,255,255,0.08); display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 800; flex-shrink: 0; }
        .card .pos.gold { background: #ff8f00; color: #fff; }
        .card .pos.silver { background: #78909c; color: #fff; }
        .card .pos.bronze { background: #a1887f; color: #fff; }
        .card .info { flex: 1; min-width: 0; }
        .card .name { font-size: 14px; font-weight: 700; }
        .card .meta { font-size: 11px; opacity: 0.5; margin-top: 2px; }
        .card .score { font-size: 22px; font-weight: 900; color: #4caf50; }
        .card .score.pending { color: #666; }
        .card .subscores { display:flex; gap:6px; margin-top:4px; flex-wrap:wrap; }
        .card .subscores .sub { font-size:9px; padding:1px 6px; border-radius:8px; background:rgba(255,255,255,0.06); white-space:nowrap; }
        .empty { text-align: center; padding: 40px; opacity: 0.4; }
        .empty .ei { font-size: 48px; margin-bottom: 8px; }
        .legend { text-align: center; font-size: 11px; opacity: 0.3; margin-top: 20px; padding-bottom: 20px; }
        .belt-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; border: 1px solid rgba(255,255,255,0.1); vertical-align: middle; margin-right: 2px; }
        @media (prefers-color-scheme: light) {
            body { background: #f5f5f5; color: #333; }
            .header { background: linear-gradient(135deg, #1a237e, #283593); }
            .header h1 { color: #fff; }
            .card { background: #fff; }
            .card .pos { background: #f0f0f0; }
            .card .meta { opacity: 0.6; }
            .card .subscores .sub { background: #f0f0f0; }
            .legend { opacity: 0.5; }
        }
    </style>
</head>
<body>
<div class="header">
    <h1>🏆 <?= htmlspecialchars($torneo['nombre']) ?></h1>
    <div class="sub"><?= htmlspecialchars($torneo['ciudad'] ?? '') ?> · <?= htmlspecialchars($torneo['fecha'] ?? '') ?> · <?= $torneo['num_jueces'] ?? 3 ?> jueces</div>
</div>
<div class="content" id="app">
    <?php
    $lastCat = '';
    $posGlobal = 0;
    foreach ($puntajes as $p):
        $catName = $p['categoria_nombre'] ?: 'Sin categoría';
        if ($catName !== $lastCat):
            if ($lastCat !== '') echo '</div>';
            $lastCat = $catName;
            $posGlobal = 0;
    ?>
    <div class="categoria-title">🥋 <?= htmlspecialchars($catName) ?></div>
    <?php endif; $posGlobal++; ?>
    <div class="card">
        <div class="pos <?= $posGlobal === 1 ? 'gold' : ($posGlobal === 2 ? 'silver' : ($posGlobal === 3 ? 'bronze' : '')) ?>"><?= $posGlobal ?></div>
        <div class="info">
            <div class="name">
                <?php
                $belt = $p['cinturon'] ?: $p['grado'] ?: '';
                if ($belt):
                    $parts = preg_split('/[\/\-\s]+/', $belt);
                    foreach ($parts as $part):
                        $part = trim($part);
                        if ($part) {
                            $bc = beltColor($part);
                            echo '<span class="belt-dot" style="background:' . $bc . '"></span>';
                        }
                    endforeach;
                endif;
                ?>
                <?= htmlspecialchars($p['nombre'] . ' ' . $p['apellido']) ?>
            </div>
            <div class="meta"><?= $p['sexo'] === 'M' ? '♂' : ($p['sexo'] === 'F' ? '♀' : '⚥') ?> <?= $p['edad'] ?? '' ?>a</div>
            <?php if ($p['promedio_presentacion'] !== null): ?>
            <div class="subscores">
                <span class="sub">P: <?= number_format($p['promedio_presentacion'], 1) ?></span>
                <span class="sub">F/V: <?= number_format($p['promedio_fuerza'], 1) ?></span>
                <span class="sub">R/T: <?= number_format($p['promedio_ritmo'], 1) ?></span>
                <span class="sub">E: <?= number_format($p['promedio_expresion'], 1) ?></span>
            </div>
            <?php endif; ?>
        </div>
        <div class="score <?= $p['promedio_total'] === null ? 'pending' : '' ?>"><?= $p['promedio_total'] !== null ? number_format($p['promedio_total'], 1) : '—' ?></div>
    </div>
    <?php endforeach; if (empty($puntajes)): ?>
    <div class="empty"><div class="ei">🏆</div><p>No hay participantes o puntajes aún.</p></div>
    <?php endif; ?>
</div>
<div class="legend">Los puntajes se actualizan automáticamente al recargar</div>
</body>
</html>
