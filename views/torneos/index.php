<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover,user-scalable=no">
    <meta name="theme-color" content="#1b5e20">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>Torneos - <?= htmlspecialchars($escuela['siglas'] ?: $escuela['nombre']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="manifest" href="<?= base_url('/manifest.php') ?>">
    <style>
        * { -webkit-tap-highlight-color: transparent; }
        body { background: #f5f5dc; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; min-height: 100vh; min-height: 100dvh; padding-bottom: 72px; }
        .topbar { position: sticky; top: 0; z-index: 100; background: linear-gradient(135deg, #1b5e20, #2e7d32); padding: 12px 16px; padding-top: max(12px, env(safe-area-inset-top, 12px)); display: flex; align-items: center; justify-content: space-between; }
        .topbar-brand { display: flex; align-items: center; gap: 10px; }
        .topbar-brand .avatar { width: 34px; height: 34px; background: rgba(255,255,255,0.15); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 17px; }
        .topbar-brand .name { color: #fff; font-size: 15px; font-weight: 700; }
        .topbar-brand .sub { color: rgba(255,255,255,0.55); font-size: 9px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; line-height: 1; margin-top: 1px; }
        .topbar-btn { width: 36px; height: 36px; background: rgba(255,255,255,0.08); border: none; border-radius: 10px; color: #fff; font-size: 18px; display: flex; align-items: center; justify-content: center; }
        .topbar-btn:active { background: rgba(255,255,255,0.18); transform: scale(0.92); }
        .content { max-width: 600px; margin: 0 auto; padding: 16px; }
        .section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
        .section-header h2 { font-size: 18px; font-weight: 800; color: #1b5e20; margin: 0; }
        .btn-add { width: 38px; height: 38px; background: #4caf50; border: none; border-radius: 12px; color: #fff; font-size: 20px; display: flex; align-items: center; justify-content: center; }
        .btn-add:active { transform: scale(0.9); }
        .btn-outline { background: transparent; border: 2px dashed #ccc; border-radius: 14px; padding: 10px 16px; font-size: 13px; font-weight: 600; color: #999; width: 100%; }
        .btn-outline:active { border-color: #4caf50; color: #4caf50; }
        .search-box { position: relative; margin-bottom: 14px; }
        .search-box input { background: #fff; border: 2px solid #f0f0f0; border-radius: 14px; padding: 11px 16px 11px 40px; font-size: 14px; width: 100%; outline: none; }
        .search-box input:focus { border-color: #4caf50; box-shadow: 0 0 0 4px rgba(76,175,80,0.08); }
        .search-box .sicon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); font-size: 16px; opacity: 0.4; }
        .item-card { background: #fff; border-radius: 16px; padding: 14px 16px; margin-bottom: 8px; display: flex; align-items: center; gap: 12px; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
        .item-card:active { transform: scale(0.98); }
        .item-card-invited { border-left: 3px solid #ff9800; }
        .item-avatar { width: 44px; height: 44px; border-radius: 14px; background: linear-gradient(135deg, #e3f2fd, #bbdefb); display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
        .item-avatar-invited { background: linear-gradient(135deg, #fff3e0, #ffe0b2); }
        .item-info { flex: 1; min-width: 0; }
        .item-name { font-size: 14px; font-weight: 700; color: #333; }
        .item-meta { font-size: 11px; color: #999; margin-top: 2px; display: flex; gap: 8px; flex-wrap: wrap; }
        .item-meta span { background: #f5f5f5; padding: 1px 8px; border-radius: 20px; }
        .item-code { font-size: 10px; font-weight: 600; color: #4caf50; background: #e8f5e9; padding: 2px 8px; border-radius: 20px; }
        .item-badge-invitado { font-size: 9px; font-weight: 700; color: #e65100; background: #fff3e0; padding: 2px 8px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; }
        .item-inactive { opacity: 0.5; }
        .item-pasado { opacity: 0.6; border-left: 3px solid #e0e0e0; }
        .item-finalizado { opacity: 0.7; border-left: 3px solid #ce93d8; }
        .badge-finalizado { background: #f3e5f5; color: #7b1fa2; font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 20px; }
        .empty-state { text-align: center; padding: 40px 20px; color: #ccc; }
        .empty-state .ei { font-size: 42px; margin-bottom: 8px; }
        .empty-state p { font-size: 13px; font-weight: 500; }
        .divider-section { margin: 20px 0 14px; border-top: 2px dashed #e0e0e0; }
        .help-text { font-size: 11px; color: #aaa; text-align: center; margin-top: 10px; }
        .modal-content { border: none; border-radius: 20px; overflow: hidden; }
        .modal-header { background: linear-gradient(135deg, #1b5e20, #2e7d32); color: #fff; border: none; padding: 18px 20px; }
        .modal-header .btn-close { filter: invert(1); opacity: 0.6; }
        .modal-body { padding: 20px; }
        .modal-body .form-control { border-radius: 12px; padding: 11px 14px; border: 2px solid #f0f0f0; background: #fafafa; font-size: 14px; }
        .modal-body .form-control:focus { border-color: #4caf50; background: #fff; box-shadow: 0 0 0 4px rgba(76,175,80,0.08); }
        .modal-body .form-label { font-size: 10px; font-weight: 600; color: #999; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .btn-dojang { background: linear-gradient(135deg, #2e7d32, #4caf50); border: none; border-radius: 12px; padding: 12px; font-weight: 700; color: #fff; }
        .btn-dojang:active { transform: scale(0.97); }
        .btn-dojang-outline { background: transparent; border: 2px solid #4caf50; border-radius: 12px; padding: 10px; font-weight: 700; color: #2e7d32; }
        .btn-dojang-outline:active { background: #e8f5e9; }
        .btn-danger-sm { border: none; border-radius: 10px; padding: 8px 14px; font-size: 12px; font-weight: 600; background: #fff0f0; color: #d32f2f; }
        .btn-danger-sm:active { background: #ffcdd2; }
        .bottombar { position: fixed; bottom: 0; left: 0; right: 0; background: #fff; border-top: 1px solid #f0f0f0; padding: 6px 0; padding-bottom: max(6px, env(safe-area-inset-bottom, 6px)); display: flex; justify-content: space-around; z-index: 100; box-shadow: 0 -2px 12px rgba(0,0,0,0.04); }
        .bottombar .nav-item { text-decoration: none; display: flex; flex-direction: column; align-items: center; gap: 1px; padding: 4px 12px; border-radius: 12px; border: none; background: none; cursor: pointer; }
        .bottombar .nav-item:active { background: #f5f5f5; }
        .bottombar .bi { font-size: 20px; line-height: 1; }
        .bottombar .bl { font-size: 9px; font-weight: 600; color: #999; text-transform: uppercase; letter-spacing: 0.5px; }
        .bottombar .nav-item.active .bl { color: #2e7d32; }
        .offcanvas-dojang { background: linear-gradient(180deg, #1b5e20, #2e7d32); color: #fff; }
        .offcanvas-dojang .offcanvas-header { border-bottom: 1px solid rgba(255,255,255,0.08); }
        .offcanvas-dojang .offcanvas-header .btn-close { filter: invert(1); opacity: 0.6; }
        .offcanvas-dojang .nav-link { display: flex; align-items: center; gap: 14px; padding: 14px 20px; color: rgba(255,255,255,0.85); text-decoration: none; font-size: 14px; font-weight: 500; }
        .offcanvas-dojang .nav-link:active { background: rgba(255,255,255,0.08); }
        .offcanvas-dojang .hr { height: 1px; background: rgba(255,255,255,0.08); margin: 8px 20px; }
        .badge-activo { background: #e8f5e9; color: #2e7d32; font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 20px; }
        .badge-inactivo { background: #fce4ec; color: #c62828; font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 20px; }
        .participant-chip { display: inline-flex; align-items: center; gap: 6px; background: #f5f5f5; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 500; color: #333; margin: 3px; }
        .participant-chip .escuela-tag { font-size: 9px; background: #e8f5e9; color: #2e7d32; padding: 1px 6px; border-radius: 10px; font-weight: 700; }
        .participant-chip .remove-btn { cursor: pointer; opacity: 0.4; font-size: 14px; margin-left: 2px; }
        .participant-chip .remove-btn:active { opacity: 1; }
        .detalle-info { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 16px; }
        .detalle-info .di { background: #f9f9f9; border-radius: 12px; padding: 12px; }
        .detalle-info .di .lbl { font-size: 9px; text-transform: uppercase; letter-spacing: 1px; color: #999; font-weight: 600; }
        .detalle-info .di .val { font-size: 14px; font-weight: 700; color: #333; margin-top: 2px; }
        .detalle-info .di-full { grid-column: 1 / -1; }
        .selection-list { max-height: 300px; overflow-y: auto; }
        .selection-item { display: flex; align-items: center; gap: 12px; padding: 10px 12px; border-radius: 12px; margin-bottom: 4px; cursor: pointer; }
        .selection-item:active { background: #f5f5f5; }
        .selection-item .cb { width: 22px; height: 22px; border: 2px solid #ccc; border-radius: 6px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
            .selection-item.selected .cb { background: #4caf50; border-color: #4caf50; color: #fff; font-size: 12px; }
        .toggle-switch { position: relative; display: inline-flex; align-items: center; gap: 10px; }
        .toggle-switch input { opacity: 0; width: 0; height: 0; position: absolute; }
        .toggle-switch .slider { position: relative; width: 48px; height: 26px; background: #e0e0e0; border-radius: 13px; cursor: pointer; transition: .3s; flex-shrink: 0; }
        .toggle-switch .slider::after { content: ''; position: absolute; width: 22px; height: 22px; left: 2px; top: 2px; background: #fff; border-radius: 50%; transition: .3s; box-shadow: 0 1px 3px rgba(0,0,0,0.2); }
        .toggle-switch.on .slider { background: #4caf50; }
        .toggle-switch.on .slider::after { left: 24px; }
        .toggle-switch .label { font-size: 12px; font-weight: 600; color: #666; }
        .toggle-switch.on .label { color: #333; }
        .belt-custom-trigger { background: #fafafa; cursor:pointer; border-radius:12px; padding:8px 14px; border:2px solid #f0f0f0; font-size:14px; user-select:none; }
        .belt-dropdown { background: #fff; border:2px solid #f0f0f0; border-radius:12px; max-height:200px; overflow-y:auto; box-shadow:0 4px 20px rgba(0,0,0,0.08); }
        .belt-dropdown>div { padding:8px 12px; font-size:13px; color:#333; cursor:pointer; border-bottom:1px solid #f5f5f5; }
        .belt-dropdown>div:last-child { border-bottom:none; }
        .belt-dropdown>div:hover { background: #f5f5f5; }
        @media (prefers-color-scheme: dark) {
            body { background: #1a1a2e; }
            .item-card { background: #16213e; }
            .item-card-invited { border-left-color: #ff9800; }
            .item-name { color: #e0e0e0; }
            .search-box input { background: #16213e; border-color: #2a2a4e; color: #e0e0e0; }
            .search-box input:focus { border-color: #4caf50; background: #1a1a2e; }
            .section-header h2 { color: #66bb6a; }
            .modal-body .form-control { background: #1a1a2e; border-color: #2a2a4e; color: #e0e0e0; }
            .modal-body .form-control:focus { border-color: #4caf50; background: #16213e; }
            .bottombar { background: #16213e; border-color: #2a2a4e; }
            .bottombar .nav-item:active { background: #1a1a2e; }
            .bottombar .bl { color: #888; }
            .bottombar .nav-item.active .bl { color: #66bb6a; }
            .btn-danger-sm { background: #3e1a1a; color: #ef5350; }
            .btn-danger-sm:active { background: #4e2a2a; }
            .detalle-info .di { background: #1a1a2e; }
            .detalle-info .di .val { color: #e0e0e0; }
            .participant-chip { background: #2a2a4e; color: #e0e0e0; }
            .divider-section { border-color: #2a2a4e; }
            .btn-outline { border-color: #2a2a4e; color: #888; }
            .selection-item:active { background: #2a2a4e; }
            #categoriasLista > div { background: #16213e !important; }
            #categoriasLista > div > div:first-child .cat-name-inner { color: #e0e0e0; }
            #categoriasLista > div > div:last-child { border-color: #2a2a4e !important; }
            #categoriasLista .participant-chip-inner { background: #2a2a4e !important; color: #e0e0e0 !important; }
            .belt-custom-trigger { background: #1a1a2e; border-color: #2a2a4e; color: #e0e0e0; }
            .belt-dropdown { background: #16213e; border-color: #2a2a4e; }
            .belt-dropdown>div { color: #e0e0e0; border-color: #2a2a4e; }
            .belt-dropdown>div:hover { background: #2a2a4e; }
            .juez-opt { background: #1a1a2e !important; border-color: #2a2a4e !important; color: #e0e0e0 !important; }
        }
    </style>
</head>
<body>

<div class="topbar">
    <div class="topbar-brand">
        <div class="avatar">🏆</div>
        <div>
            <div class="name">Torneos</div>
            <div class="sub"><?= count($torneos) ?> creados<?= !empty($torneosInvitados) ? ' · ' . count($torneosInvitados) . ' invitados' : '' ?><?= !empty($invitacionesPendientes) ? ' · 🔔 ' . count($invitacionesPendientes) . ' pendientes' : '' ?></div>
        </div>
    </div>
    <div><button class="topbar-btn" onclick="abrirMenu()">☰</button></div>
</div>

<div class="offcanvas offcanvas-start offcanvas-dojang" tabindex="-1" id="menuOffcanvas">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">🥋 Men&uacute;</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0">
        <a href="<?= base_url('/dashboard') ?>" class="nav-link"><span class="ni">🏠</span> Inicio</a>
        <a href="<?= base_url('/participantes') ?>" class="nav-link"><span class="ni">👥</span> Participantes</a>
        <a href="<?= base_url('/jueces') ?>" class="nav-link"><span class="ni">⚖️</span> Jueces</a>
        <a href="<?= base_url('/torneos') ?>" class="nav-link"><span class="ni">🏆</span> Torneos</a>
        <div class="hr"></div>
        <a href="<?= base_url('/escuela') ?>" class="nav-link"><span class="ni">⚙️</span> Configuraci&oacute;n</a>
        <a href="<?= base_url('/logout') ?>" class="nav-link"><span class="ni">🚪</span> Cerrar Sesi&oacute;n</a>
    </div>
</div>

<div class="content">
    <div class="section-header">
        <h2>🏆 Mis Torneos</h2>
        <button class="btn-add" onclick="abrirModal()">+</button>
    </div>

    <div id="listaContainer">
        <?php if (empty($torneos)): ?>
            <div class="empty-state">
                <div class="ei">🏆</div>
                <p>No hay torneos creados.<br>Toca + para crear el primero.</p>
            </div>
        <?php else:
            $hoy = date('Y-m-d');
            $actuales = array_filter($torneos, fn($t) => $t['fecha'] >= $hoy || $t['estado'] > 0);
            $pasados = array_filter($torneos, fn($t) => $t['fecha'] < $hoy && $t['estado'] == 0);
            foreach (['actuales' => '🏆 Mis Torneos'] as $key => $titulo):
                $lista = $$key;
                if (!empty($lista)):
        ?>
        <div style="font-size:13px;font-weight:700;color:#999;margin:16px 0 8px;text-transform:uppercase;letter-spacing:1px;"><?= $titulo ?></div>
        <?php foreach ($lista as $t):
            $estados = ['📝 Borrador', '▶ En curso', '🏁 Finalizado'];
            $estadosCls = ['badge-inactivo', 'badge-activo', 'badge-finalizado'];
            $estadoIdx = $t['estado'] ?? 0;
        ?>
            <div class="item-card <?= $t['estado'] == 2 ? 'item-finalizado' : ($t['estado'] == 0 && $t['fecha'] < $hoy ? 'item-pasado' : '') ?>" onclick="verDetalle(<?= $t['idTorneo'] ?>)" data-search="<?= htmlspecialchars(strtolower($t['nombre'].' '.($t['ciudad']??'').' '.($t['lugar']??''))) ?>">
                <div class="item-avatar">🏆</div>
                <div class="item-info">
                    <div class="item-name"><?= htmlspecialchars($t['nombre']) ?></div>
                    <div class="item-meta">
                        <span>📅 <?= htmlspecialchars($t['fecha']) ?></span>
                        <?php if ($t['ciudad']): ?><span>📍 <?= htmlspecialchars($t['ciudad']) ?></span><?php endif; ?>
                    </div>
                    <div style="margin-top:4px;display:flex;gap:6px;align-items:center;">
                        <?php if ($t['codigo_acceso']): ?><span class="item-code">🔑 <?= htmlspecialchars($t['codigo_acceso']) ?></span><?php endif; ?>
                        <span class="<?= $estadosCls[$estadoIdx] ?? 'badge-inactivo' ?>"><?= $estados[$estadoIdx] ?? ($t['activo'] ? 'Activo' : 'Inactivo') ?></span>
                    </div>
                </div>
                <div style="color:#ccc;font-size:10px;">›</div>
            </div>
        <?php endforeach; endif; endforeach; endif; ?>

        <?php if (!empty($pasados)): ?>
            <div class="divider-section"></div>
            <div class="section-header" style="margin-top:0;">
                <h2>📜 Torneos Anteriores</h2>
            </div>
            <?php foreach ($pasados as $t):
                $estados = ['📝 Borrador', '▶ En curso', '🏁 Finalizado'];
                $estadosCls = ['badge-inactivo', 'badge-activo', 'badge-finalizado'];
            ?>
                <div class="item-card item-pasado" onclick="verDetalle(<?= $t['idTorneo'] ?>)">
                    <div class="item-avatar">📜</div>
                    <div class="item-info">
                        <div class="item-name"><?= htmlspecialchars($t['nombre']) ?></div>
                        <div class="item-meta">
                            <span>📅 <?= htmlspecialchars($t['fecha']) ?></span>
                            <?php if ($t['ciudad']): ?><span>📍 <?= htmlspecialchars($t['ciudad']) ?></span><?php endif; ?>
                        </div>
                    </div>
                    <div style="color:#ccc;font-size:10px;">›</div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <?php if (!empty($invitacionesPendientes)): ?>
        <div class="divider-section"></div>
        <div class="section-header" style="margin-top:0;">
            <h2>🔔 Invitaciones Pendientes</h2>
        </div>
        <div>
            <?php foreach ($invitacionesPendientes as $t): ?>
                <div class="item-card" style="border-left:3px solid #ff9800;">
                    <div class="item-avatar" style="background:rgba(255,152,0,0.15);">🔔</div>
                    <div class="item-info">
                        <div class="item-name"><?= htmlspecialchars($t['nombre']) ?></div>
                        <div class="item-meta">
                            <span>📅 <?= htmlspecialchars($t['fecha']) ?></span>
                            <?php if ($t['ciudad']): ?><span>📍 <?= htmlspecialchars($t['ciudad']) ?></span><?php endif; ?>
                            <span style="background:#ff9800;color:#fff;font-size:10px;padding:1px 6px;border-radius:8px;">Pendiente</span>
                        </div>
                        <div style="margin-top:2px;font-size:11px;color:#999;">
                            Por: <?= htmlspecialchars($t['creador_nombre']) ?> <?= $t['creador_siglas'] ? '(' . htmlspecialchars($t['creador_siglas']) . ')' : '' ?>
                        </div>
                        <div style="margin-top:4px;font-size:10px;color:#ff9800;">
                            Código: <strong><?= htmlspecialchars($t['codigo_acceso']) ?></strong> — Ingresa el código arriba para unirte
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($torneosInvitados)): ?>
        <div class="divider-section"></div>
        <div class="section-header" style="margin-top:0;">
            <h2>📩 Torneos Invitados</h2>
        </div>
        <div id="listaInvitados">
            <?php foreach ($torneosInvitados as $t): ?>
                <div class="item-card item-card-invited" onclick="verDetalle(<?= $t['idTorneo'] ?>)">
                    <div class="item-avatar item-avatar-invited">📩</div>
                    <div class="item-info">
                        <div class="item-name"><?= htmlspecialchars($t['nombre']) ?></div>
                        <div class="item-meta">
                            <span>📅 <?= htmlspecialchars($t['fecha']) ?></span>
                            <?php if ($t['ciudad']): ?><span>📍 <?= htmlspecialchars($t['ciudad']) ?></span><?php endif; ?>
                            <span class="item-badge-invitado">Invitado</span>
                        </div>
                        <div style="margin-top:2px;font-size:11px;color:#999;">
                            Por: <?= htmlspecialchars($t['creador_nombre']) ?> <?= $t['creador_siglas'] ? '(' . htmlspecialchars($t['creador_siglas']) . ')' : '' ?>
                        </div>
                    </div>
                    <div style="color:#ccc;font-size:10px;">›</div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div style="margin-top:16px;">
        <button class="btn-outline" onclick="abrirJoinModal()">🔑 Unirse a un torneo por c&oacute;digo</button>
        <div class="help-text">Ingresa el c&oacute;digo que te comparti&oacute; otra escuela</div>
    </div>
</div>

<div class="bottombar">
    <button class="nav-item" onclick="location.href='<?= base_url('/dashboard') ?>'"><span class="bi">🏠</span><span class="bl">Inicio</span></button>
    <button class="nav-item" onclick="location.href='<?= base_url('/participantes') ?>'"><span class="bi">👥</span><span class="bl">Alumnos</span></button>
    <button class="nav-item" onclick="location.href='<?= base_url('/jueces') ?>'"><span class="bi">⚖️</span><span class="bl">Jueces</span></button>
    <button class="nav-item active"><span class="bi">🏆</span><span class="bl">Torneos</span></button>
    <button class="nav-item" onclick="location.href='<?= base_url('/escuela') ?>'"><span class="bi">⚙️</span><span class="bl">Ajustes</span></button>
</div>

<div class="modal fade" id="torneoModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalTitle">➕ Crear Torneo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editId" value="0">
                <div class="mb-3">
                    <label class="form-label">🏷️ Nombre *</label>
                    <input type="text" id="fNombre" class="form-control" placeholder="Ej: Torneo de Verano 2026" required>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="form-label">📅 Fecha *</label>
                        <input type="date" id="fFecha" class="form-control" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">📍 Ciudad</label>
                        <input type="text" id="fCiudad" class="form-control" placeholder="Ciudad">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">🏟️ Lugar</label>
                    <input type="text" id="fLugar" class="form-control" placeholder="Gimnasio, coliseo...">
                </div>
                <div class="mb-3">
                    <label class="form-label">📝 Descripci&oacute;n</label>
                    <textarea id="fDescripcion" class="form-control" rows="2" placeholder="Informaci&oacute;n adicional"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">⚖️ Jueces por participante</label>
                    <div style="display:flex;gap:8px;">
                        <label class="juez-opt" style="flex:1;text-align:center;padding:10px;border:2px solid #f0f0f0;border-radius:12px;cursor:pointer;background:#fafafa;font-size:14px;font-weight:700;" onclick="document.getElementById('fNumJueces').value='3';document.querySelectorAll('.juez-opt').forEach(function(e){e.style.borderColor='#f0f0f0';e.style.background='#fafafa'});this.style.borderColor='#4caf50';this.style.background='#e8f5e9'">
                            <div>3</div>
                            <div style="font-size:10px;font-weight:400;color:#999;">Promedio simple</div>
                        </label>
                        <label class="juez-opt" style="flex:1;text-align:center;padding:10px;border:2px solid #f0f0f0;border-radius:12px;cursor:pointer;background:#fafafa;font-size:14px;font-weight:700;" onclick="document.getElementById('fNumJueces').value='5';document.querySelectorAll('.juez-opt').forEach(function(e){e.style.borderColor='#f0f0f0';e.style.background='#fafafa'});this.style.borderColor='#4caf50';this.style.background='#e8f5e9'">
                            <div>5</div>
                            <div style="font-size:10px;font-weight:400;color:#999;">Sin extremos</div>
                        </label>
                        <label class="juez-opt" style="flex:1;text-align:center;padding:10px;border:2px solid #f0f0f0;border-radius:12px;cursor:pointer;background:#fafafa;font-size:14px;font-weight:700;" onclick="document.getElementById('fNumJueces').value='7';document.querySelectorAll('.juez-opt').forEach(function(e){e.style.borderColor='#f0f0f0';e.style.background='#fafafa'});this.style.borderColor='#4caf50';this.style.background='#e8f5e9'">
                            <div>7</div>
                            <div style="font-size:10px;font-weight:400;color:#999;">Sin extremos</div>
                        </label>
                    </div>
                    <input type="hidden" id="fNumJueces" value="3">
                </div>
                <div class="d-flex gap-2 mt-4">
                    <button class="btn btn-dojang w-100" onclick="guardar()">💾 Guardar</button>
                    <button class="btn btn-danger-sm" id="btnEliminar" style="display:none;" onclick="eliminar()">🗑</button>
                </div>
                <div id="codigoDisplay" class="mt-3 text-center" style="display:none;">
                    <div style="font-size:11px;color:#999;margin-bottom:4px;">C&oacute;digo de acceso</div>
                    <div style="font-size:20px;font-weight:800;color:#2e7d32;letter-spacing:2px;" id="codigoTexto"></div>
                    <div style="font-size:11px;color:#999;margin-top:6px;">Comparte este c&oacute;digo con otras escuelas para que se unan al torneo.</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="joinModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background:linear-gradient(135deg,#e65100,#ff9800);">
                <h5 class="modal-title fw-bold">🔑 Unirse a Torneo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">🔑 C&oacute;digo de acceso</label>
                    <input type="text" id="joinCodigo" class="form-control text-center" style="font-size:18px;font-weight:700;letter-spacing:3px;text-transform:uppercase;" placeholder="POOMSAE-XXXXXX" maxlength="20">
                </div>
                <div id="joinError" style="display:none;color:#d32f2f;font-size:13px;text-align:center;margin-bottom:10px;"></div>
                <button class="btn btn-dojang w-100" onclick="unirseTorneo()">🔑 Unirse</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detalleModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="detalleTitle">📋 Detalle del Torneo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="detalleInfo" class="detalle-info"></div>
                <div id="detalleActions" style="display:none;margin-bottom:14px;">
                    <button class="btn btn-dojang-outline w-100" style="padding:8px;font-size:12px;margin-bottom:6px;" onclick="editarTorneo(detalleTorneoId)">✏️ Editar datos del torneo</button>
                    <button class="btn btn-dojang-outline w-100" style="padding:8px;font-size:12px;" onclick="verPuntajes()">📊 Ver puntajes</button>
                </div>
                <div id="detalleEstadoActions" style="margin-bottom:14px;"></div>

                <div style="text-align:center;margin-bottom:14px;font-size:11px;">
                    <a href="<?= base_url('/scoreboard') ?>?id=" onclick="this.href='<?= base_url('/scoreboard') ?>?id='+detalleTorneoId;window.open(this.href,'_blank');return false;" style="color:#4caf50;text-decoration:none;font-weight:600;">📺 Ver scoreboard público</a>
                </div>

                <div id="categoriasSection">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                        <div style="font-size:14px;font-weight:700;color:#333;">📂 Categor&iacute;as (<span id="categoriaCount">0</span>)</div>
                        <button class="btn-add" id="btnAgregarCategoria" style="width:auto;height:32px;font-size:12px;padding:0 12px;gap:4px;display:none;" onclick="abrirCategoriaModal()">➕ Categor&iacute;a</button>
                    </div>
                    <div id="categoriasLista" style="min-height:40px;">
                        <div style="color:#ccc;font-size:13px;width:100%;text-align:center;padding:20px 0;">Cargando categor&iacute;as...</div>
                    </div>
                </div>

                <div style="display:flex;align-items:center;justify-content:space-between;margin:16px 0 10px;padding-top:14px;border-top:1px solid #f0f0f0;">
                    <div style="font-size:14px;font-weight:700;color:#333;">⚖️ Jueces (<span id="juezCount">0</span>)</div>
                    <button class="btn-add" id="btnAgregarJuez" style="width:auto;height:32px;font-size:12px;padding:0 12px;gap:4px;display:none;" onclick="abrirAgregarJuez()">➕ Agregar</button>
                </div>
                <div id="juecesLista" style="display:flex;flex-wrap:wrap;gap:4px;min-height:40px;">
                    <div style="color:#ccc;font-size:13px;width:100%;text-align:center;padding:20px 0;">Cargando jueces...</div>
                </div>

                <div id="codigoSection" class="mt-3 text-center" style="display:none;padding-top:14px;border-top:1px solid #f0f0f0;">
                    <div style="font-size:11px;color:#999;margin-bottom:4px;">🔑 C&oacute;digo para compartir</div>
                    <div style="font-size:18px;font-weight:800;color:#2e7d32;letter-spacing:2px;" id="detalleCodigo"></div>
                    <div style="font-size:11px;color:#999;margin-top:6px;">Comparte este c&oacute;digo para que otras escuelas se unan al torneo.</div>
                </div>
                <div id="detalleDanger" style="display:none;margin-top:16px;padding-top:14px;border-top:1px solid #f0f0f0;">
                    <button class="btn btn-danger-sm w-100" style="padding:10px;border-radius:12px;font-size:13px;" id="btnSalirTorneo" onclick="salirTorneo()">🚪 Salir de este torneo</button>
                    <button class="btn btn-danger-sm w-100" style="padding:10px;border-radius:12px;font-size:13px;margin-top:6px;background:#fce4ec;color:#c62828;" id="btnEliminarTorneo" onclick="eliminarTorneo()">🗑 Eliminar torneo</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="categoriaModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background:linear-gradient(135deg,#00695c,#26a69a);">
                <h5 class="modal-title fw-bold" id="categoriaModalTitle">➕ Crear Categor&iacute;a</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="categoriaEditId" value="0">
                <div class="mb-3">
                    <label class="form-label">🏷️ Nombre *</label>
                    <input type="text" id="catNombre" class="form-control" placeholder="Ej: Infantil Mixto" required>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-4">
                        <label class="form-label">👤 Sexo</label>
                        <select id="catSexo" class="form-control">
                            <option value="X">Mixto</option>
                            <option value="M">♂ Masculino</option>
                            <option value="F">♀ Femenino</option>
                        </select>
                    </div>
                    <div class="col-4">
                        <label class="form-label">👇 Edad m&iacute;n</label>
                        <input type="number" id="catEdadMin" class="form-control" placeholder="0" min="0" max="99">
                    </div>
                    <div class="col-4">
                        <label class="form-label">👆 Edad m&aacute;x</label>
                        <input type="number" id="catEdadMax" class="form-control" placeholder="99" min="0" max="99">
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="form-label">⬇ Cintur&oacute;n m&iacute;n</label>
                        <div class="position-relative">
                            <div class="belt-custom-trigger d-flex align-items-center gap-2 form-control" id="catCintMinTrigger" style="cursor:pointer;border-radius:12px;padding:8px 14px;border:2px solid #f0f0f0;background:#fafafa;font-size:14px;user-select:none;" onclick="toggleBeltDrop('catCintMin')">
                                <span id="catCintMinPreview"><span class="belt-dot" style="width:18px;height:18px;background:#eee;border:2px solid #ddd;display:inline-block;border-radius:50%;"></span></span>
                                <span id="catCintMinText" style="flex:1;color:#999;">—</span>
                                <span style="color:#ccc;font-size:10px;">▼</span>
                            </div>
                            <div id="catCintMinDrop" class="belt-dropdown position-absolute w-100" style="display:none;z-index:999;background:#fff;border:2px solid #f0f0f0;border-radius:12px;max-height:200px;overflow-y:auto;box-shadow:0 4px 20px rgba(0,0,0,0.08);margin-top:2px;">
                                <div style="padding:8px 12px;font-size:13px;color:#999;cursor:pointer;border-bottom:1px solid #f5f5f5;" onclick="selBelt('catCintMin', '', '#eee', '—')" onmouseenter="this.style.background='#f5f5f5'" onmouseleave="this.style.background=''"><span class="belt-dot" style="width:16px;height:16;background:#eee;border:2px solid #ddd;display:inline-block;border-radius:50%;vertical-align:middle;margin-right:8px;"></span>—</div>
                                <?php
                                $beltList = ['Blanco','Blanco punta amarilla','Amarillo','Amarillo punta verde','Verde','Verde punta azul','Azul','Azul punta roja','Rojo','Rojo punta negra','Pum','I Dan','II Dan'];
                                foreach ($beltList as $bn):
                                    $bca = beltColorsAttr($bn);
                                    $bcp = explode('|', $bca);
                                ?>
                                <div style="padding:8px 12px;font-size:13px;color:#333;cursor:pointer;border-bottom:1px solid #f5f5f5;" onclick="selBelt('catCintMin', '<?= htmlspecialchars($bn, ENT_QUOTES) ?>', '<?= $bca ?>', '<?= htmlspecialchars($bn, ENT_QUOTES) ?>')" onmouseenter="this.style.background='#f5f5f5'" onmouseleave="this.style.background=''">
                                    <?php if (count($bcp) === 2): ?>
                                    <span class="belt-dot" style="width:16px;height:16px;background:<?= $bcp[0] ?>;display:inline-block;border-radius:50%;border:1px solid rgba(0,0,0,0.1);vertical-align:middle;margin-right:2px;"></span>
                                    <span class="belt-dot" style="width:16px;height:16px;background:<?= $bcp[1] ?>;display:inline-block;border-radius:50%;border:1px solid rgba(0,0,0,0.1);vertical-align:middle;margin-left:-8px;margin-right:8px;"></span>
                                    <?php else: ?>
                                    <span class="belt-dot" style="width:16px;height:16px;background:<?= $bcp[0] ?>;display:inline-block;border-radius:50%;border:1px solid rgba(0,0,0,0.1);vertical-align:middle;margin-right:8px;"></span>
                                    <?php endif; ?>
                                    <?= htmlspecialchars($bn) ?>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-label">⬆ Cintur&oacute;n m&aacute;x</label>
                        <div class="position-relative">
                            <div class="belt-custom-trigger d-flex align-items-center gap-2 form-control" id="catCintMaxTrigger" style="cursor:pointer;border-radius:12px;padding:8px 14px;border:2px solid #f0f0f0;background:#fafafa;font-size:14px;user-select:none;" onclick="toggleBeltDrop('catCintMax')">
                                <span id="catCintMaxPreview"><span class="belt-dot" style="width:18px;height:18px;background:#eee;border:2px solid #ddd;display:inline-block;border-radius:50%;"></span></span>
                                <span id="catCintMaxText" style="flex:1;color:#999;">—</span>
                                <span style="color:#ccc;font-size:10px;">▼</span>
                            </div>
                            <div id="catCintMaxDrop" class="belt-dropdown position-absolute w-100" style="display:none;z-index:999;background:#fff;border:2px solid #f0f0f0;border-radius:12px;max-height:200px;overflow-y:auto;box-shadow:0 4px 20px rgba(0,0,0,0.08);margin-top:2px;">
                                <div style="padding:8px 12px;font-size:13px;color:#999;cursor:pointer;border-bottom:1px solid #f5f5f5;" onclick="selBelt('catCintMax', '', '#eee', '—')" onmouseenter="this.style.background='#f5f5f5'" onmouseleave="this.style.background=''"><span class="belt-dot" style="width:16px;height:16;background:#eee;border:2px solid #ddd;display:inline-block;border-radius:50%;vertical-align:middle;margin-right:8px;"></span>—</div>
                                <?php foreach ($beltList as $bn):
                                    $bca = beltColorsAttr($bn);
                                    $bcp = explode('|', $bca);
                                ?>
                                <div style="padding:8px 12px;font-size:13px;color:#333;cursor:pointer;border-bottom:1px solid #f5f5f5;" onclick="selBelt('catCintMax', '<?= htmlspecialchars($bn, ENT_QUOTES) ?>', '<?= $bca ?>', '<?= htmlspecialchars($bn, ENT_QUOTES) ?>')" onmouseenter="this.style.background='#f5f5f5'" onmouseleave="this.style.background=''">
                                    <?php if (count($bcp) === 2): ?>
                                    <span class="belt-dot" style="width:16px;height:16px;background:<?= $bcp[0] ?>;display:inline-block;border-radius:50%;border:1px solid rgba(0,0,0,0.1);vertical-align:middle;margin-right:2px;"></span>
                                    <span class="belt-dot" style="width:16px;height:16px;background:<?= $bcp[1] ?>;display:inline-block;border-radius:50%;border:1px solid rgba(0,0,0,0.1);vertical-align:middle;margin-left:-8px;margin-right:8px;"></span>
                                    <?php else: ?>
                                    <span class="belt-dot" style="width:16px;height:16px;background:<?= $bcp[0] ?>;display:inline-block;border-radius:50%;border:1px solid rgba(0,0,0,0.1);vertical-align:middle;margin-right:8px;"></span>
                                    <?php endif; ?>
                                    <?= htmlspecialchars($bn) ?>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="catCintMin" value="">
                <input type="hidden" id="catCintMax" value="">
                <div class="d-flex gap-2 mt-4">
                    <button class="btn btn-dojang w-100" onclick="guardarCategoria()">💾 Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="agregarParticipanteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background:linear-gradient(135deg,#1565c0,#42a5f5);">
                <h5 class="modal-title fw-bold">➕ Agregar Participantes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="addPartCategoriaInfo" style="font-size:12px;color:#2e7d32;background:#e8f5e9;padding:8px 12px;border-radius:10px;margin-bottom:12px;text-align:center;font-weight:600;"></div>
                <div class="search-box" style="margin-bottom:10px;">
                    <span class="sicon">🔍</span>
                    <input type="text" id="searchParticipanteInput" class="form-control" placeholder="Buscar participante..." oninput="filtrarParticipantes()">
                </div>
                <div id="participantesDisponibles" class="selection-list"></div>
                <button class="btn btn-dojang w-100 mt-3" onclick="agregarSeleccionados()">✅ Agregar seleccionados</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="agregarJuezModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background:linear-gradient(135deg,#6a1b9a,#ab47bc);">
                <h5 class="modal-title fw-bold">➕ Agregar Jueces</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p style="font-size:13px;color:#999;margin-bottom:12px;">Selecciona jueces de tu escuela para asignarlos a este torneo.</p>
                <div class="search-box" style="margin-bottom:10px;">
                    <span class="sicon">🔍</span>
                    <input type="text" id="searchJuezInput" class="form-control" placeholder="Buscar juez..." oninput="filtrarJueces()">
                </div>
                <div id="juecesDisponibles" class="selection-list"></div>
                <button class="btn btn-dojang w-100 mt-3" onclick="agregarJuecesSeleccionados()">✅ Agregar seleccionados</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
var modal, joinModal, detalleModal, agregarModal, agregarJuezModal, categoriaModal, menuOffcanvas;
var detalleTorneoId = 0;
var detalleEsCreador = false;
var participantesDisponibles = [];
var juecesDisponibles = [];
var categoriaActivaId = 0;

document.addEventListener('DOMContentLoaded', function() {
    modal = new bootstrap.Modal(document.getElementById('torneoModal'));
    joinModal = new bootstrap.Modal(document.getElementById('joinModal'));
    detalleModal = new bootstrap.Modal(document.getElementById('detalleModal'));
    agregarModal = new bootstrap.Modal(document.getElementById('agregarParticipanteModal'));
    agregarJuezModal = new bootstrap.Modal(document.getElementById('agregarJuezModal'));
    categoriaModal = new bootstrap.Modal(document.getElementById('categoriaModal'));
    menuOffcanvas = new bootstrap.Offcanvas(document.getElementById('menuOffcanvas'));
});

function abrirMenu() { menuOffcanvas.show(); }

function abrirModal() {
    document.getElementById('modalTitle').textContent = '➕ Crear Torneo';
    document.getElementById('editId').value = '0';
    document.getElementById('btnEliminar').style.display = 'none';
    document.getElementById('codigoDisplay').style.display = 'none';
    ['fNombre','fFecha','fCiudad','fLugar','fDescripcion'].forEach(function(id) {
        document.getElementById(id).value = '';
    });
    modal.show();
}

function guardar() {
    var id = document.getElementById('editId').value;
    var data = new URLSearchParams();
    data.append('nombre', document.getElementById('fNombre').value);
    data.append('fecha', document.getElementById('fFecha').value);
    data.append('ciudad', document.getElementById('fCiudad').value);
    data.append('lugar', document.getElementById('fLugar').value);
    data.append('descripcion', document.getElementById('fDescripcion').value);
    data.append('num_jueces', document.getElementById('fNumJueces').value);
    if (id !== '0') data.append('id', id);
    var url = id === '0' ? '<?= base_url('/torneos/guardar') ?>' : '<?= base_url('/torneos/actualizar') ?>';
    fetch(url, { method: 'POST', body: data })
    .then(r => r.json())
    .then(d => {
        if (d.success) { modal.hide(); location.reload(); }
        else alert(d.message);
    });
}

function eliminar() {
    if (!confirm('¿Eliminar este torneo?')) return;
    var id = document.getElementById('editId').value;
    var data = new URLSearchParams();
    data.append('id', id);
    fetch('<?= base_url('/torneos/eliminar') ?>', { method: 'POST', body: data })
    .then(r => r.json())
    .then(d => {
        if (d.success) { modal.hide(); location.reload(); }
        else alert(d.message);
    });
}

function editarTorneo(id) {
    fetch('<?= base_url('/torneos/obtener') ?>?id=' + id)
    .then(r => r.json())
    .then(d => {
        if (d.success === false) { alert(d.message); return; }
        detalleModal.hide();
        document.getElementById('modalTitle').textContent = '✏️ Editar Torneo';
        document.getElementById('editId').value = d.idTorneo;
        document.getElementById('fNombre').value = d.nombre || '';
        document.getElementById('fFecha').value = d.fecha || '';
        document.getElementById('fCiudad').value = d.ciudad || '';
        document.getElementById('fLugar').value = d.lugar || '';
        document.getElementById('fDescripcion').value = d.descripcion || '';
        document.getElementById('fNumJueces').value = d.num_jueces || '3';
        // Visual highlight for num_jueces
        var opts = document.querySelectorAll('.juez-opt');
        opts.forEach(function(e, i) {
            var vals = ['3','5','7'];
            if (vals[i] === (d.num_jueces || '3')) {
                e.style.borderColor = '#4caf50'; e.style.background = '#e8f5e9';
            } else {
                e.style.borderColor = '#f0f0f0'; e.style.background = '#fafafa';
            }
        });
        document.getElementById('btnEliminar').style.display = 'block';
        document.getElementById('codigoDisplay').style.display = 'block';
        document.getElementById('codigoTexto').textContent = d.codigo_acceso || '—';
        modal.show();
    });
}

function abrirJoinModal() {
    document.getElementById('joinCodigo').value = '';
    document.getElementById('joinError').style.display = 'none';
    joinModal.show();
}

function unirseTorneo() {
    var codigo = document.getElementById('joinCodigo').value.trim();
    if (!codigo) { mostrarJoinError('Ingresa un código.'); return; }
    var data = new URLSearchParams();
    data.append('codigo', codigo);
    fetch('<?= base_url('/torneos/unirse') ?>', { method: 'POST', body: data })
    .then(r => r.json())
    .then(d => {
        if (d.success) { joinModal.hide(); location.reload(); }
        else mostrarJoinError(d.message || d.error || 'Código inválido.');
    });
}

function mostrarJoinError(msg) {
    var el = document.getElementById('joinError');
    el.textContent = msg;
    el.style.display = 'block';
}

function verDetalle(id) {
    detalleTorneoId = id;
    document.getElementById('juecesLista').innerHTML = '<div style="color:#ccc;font-size:13px;width:100%;text-align:center;padding:20px 0;">Cargando...</div>';
    document.getElementById('categoriasLista').innerHTML = '<div style="color:#ccc;font-size:13px;width:100%;text-align:center;padding:20px 0;">Cargando categor\u00edas...</div>';
    document.getElementById('detalleModal').querySelector('.modal-dialog').className = 'modal-dialog modal-dialog-centered modal-lg';
    fetch('<?= base_url('/torneos/detalle') ?>?id=' + id)
    .then(r => r.json())
    .then(d => {
        if (!d.success) { alert(d.message); return; }
        var t = d.torneo;
        detalleEsCreador = d.esCreador;
        var estados = ['📝 Borrador', '▶ En curso', '🏁 Finalizado'];
        var estadoTxt = estados[t.estado] || (t.activo ? 'Activo' : 'Inactivo');
        document.getElementById('detalleTitle').textContent = '📋 ' + t.nombre;
        document.getElementById('detalleInfo').innerHTML =
            '<div class="di"><div class="lbl">Fecha</div><div class="val">' + (t.fecha || '—') + '</div></div>' +
            '<div class="di"><div class="lbl">Ciudad</div><div class="val">' + (t.ciudad || '—') + '</div></div>' +
            '<div class="di"><div class="lbl">Lugar</div><div class="val">' + (t.lugar || '—') + '</div></div>' +
            '<div class="di"><div class="lbl">Estado</div><div class="val">' + estadoTxt + '</div></div>' +
            '<div class="di"><div class="lbl">Jueces x part.</div><div class="val">' + (t.num_jueces || '3') + '</div></div>' +
            (t.descripcion ? '<div class="di di-full"><div class="lbl">Descripci\u00f3n</div><div class="val">' + t.descripcion + '</div></div>' : '');
        var estado = t.estado || 0;
        document.getElementById('categoriaCount').textContent = (d.categorias || []).length;
        document.getElementById('juezCount').textContent = (d.jueces || []).length;
        document.getElementById('detalleActions').style.display = detalleEsCreador ? 'block' : 'none';
        document.getElementById('codigoSection').style.display = detalleEsCreador ? 'block' : 'none';
        document.getElementById('detalleDanger').style.display = 'block';
        document.getElementById('btnSalirTorneo').style.display = detalleEsCreador || estado > 0 ? 'none' : 'block';
        document.getElementById('btnEliminarTorneo').style.display = detalleEsCreador && estado == 0 ? 'block' : 'none';
        document.getElementById('btnAgregarCategoria').style.display = detalleEsCreador && estado == 0 ? 'inline-flex' : 'none';

        // Show toggle switch for creator
        var estadoHtml = '';
        if (detalleEsCreador && estado <= 1) {
            var isOn = estado == 1;
            var fechaPasada = t.fecha && t.fecha < new Date().toISOString().slice(0,10);
            var puedeToggle = true;
            var toggleMsg = isOn ? 'Los jueces pueden evaluar' : 'Torneo en preparación';
            if (!isOn && fechaPasada) {
                puedeToggle = false;
                toggleMsg = 'La fecha ya pasó, no se puede activar';
            }
            estadoHtml = '<div style="display:flex;align-items:center;justify-content:space-between;background:#f9f9f9;border-radius:12px;padding:12px 14px;">'
                + '<div><div style="font-size:13px;font-weight:700;color:#333;">' + (isOn ? 'En curso' : 'Borrador') + '</div>'
                + '<div style="font-size:10px;color:#888;">' + toggleMsg + '</div></div>'
                + '<div class="toggle-switch' + (isOn ? ' on' : '') + '" style="' + (!puedeToggle ? 'opacity:0.4;' : '') + '" onclick="' + (puedeToggle ? 'toggleEstadoTorneo()' : '') + '">'
                + '<span class="slider"></span><span class="label">' + (isOn ? 'ON' : 'OFF') + '</span></div></div>';
            if (estado == 1) {
                estadoHtml += '<button class="btn" style="background:#e65100;border:none;border-radius:12px;padding:10px;font-weight:700;color:#fff;width:100%;font-size:13px;margin-top:8px;" onclick="finalizarTorneo()">⏹ Finalizar torneo</button>';
            }
        } else if (estado == 1) {
            estadoHtml = '<div style="text-align:center;font-size:12px;color:#81c784;background:#1b5e20;padding:8px;border-radius:10px;">▶ Torneo en curso</div>';
        } else if (estado == 2) {
            estadoHtml = '<div style="text-align:center;font-size:12px;color:#ce93d8;background:#4a148c;padding:8px;border-radius:10px;">🏁 Torneo finalizado</div>';
        }
        document.getElementById('detalleEstadoActions').innerHTML = estadoHtml;

        if (detalleEsCreador) {
            document.getElementById('detalleCodigo').textContent = t.codigo_acceso || '—';
        }
        renderCategorias(d.categorias || [], d.participantes || [], estado);
        renderJueces(d.jueces || []);
        detalleModal.show();
    });
}

function renderCategorias(categorias, todosParticipantes, estado) {
    var container = document.getElementById('categoriasLista');
    var editable = estado == 0;
    if (!categorias || categorias.length === 0) {
        container.innerHTML = detalleEsCreador
            ? '<div style="color:#ccc;font-size:13px;width:100%;text-align:center;padding:20px 0;">No hay categor\u00edas. Toca + para crear.</div>'
            : '<div style="color:#ccc;font-size:13px;width:100%;text-align:center;padding:20px 0;">No hay categor\u00edas definidas.</div>';
        return;
    }
    var html = '';
    categorias.forEach(function(c) {
        var sexoIcon = c.sexo === 'M' ? '♂' : c.sexo === 'F' ? '♀' : '⚥';
        var edadStr = (c.edad_min || c.edad_max) ? (c.edad_min || '0') + '-' + (c.edad_max || '99') + ' a\u00f1os' : 'Todas las edades';
        var cinturonStr = (c.cinturon_min || c.cinturon_max) ? (c.cinturon_min || '?') + ' → ' + (c.cinturon_max || '?') : 'Todos los cinturones';
        var participantes = todosParticipantes.filter(function(p) { return p.id_categoria == c.id; });
        var count = participantes.length;
        var expanded = categoriaActivaId == c.id ? 'block' : 'none';
        var arrow = categoriaActivaId == c.id ? '▼' : '▶';
        var participantsHtml = '';
        if (count === 0) {
            participantsHtml = '<div style="color:#ccc;font-size:12px;padding:12px 0;text-align:center;">Sin participantes</div>';
        } else {
            participantsHtml = '<div style="display:flex;flex-wrap:wrap;gap:4px;padding:8px 0;">';
            participantes.forEach(function(p) {
                var sexoIconP = p.sexo === 'M' ? '♂' : p.sexo === 'F' ? '♀' : '⚥';
                var edad = p.edad ? p.edad + 'a' : '';
                var beltColor = getBeltColor(p.cinturon || p.grado || '');
                var escuelaTag = '';
                if (detalleEsCreador && (p.escuela_siglas || p.escuela_nombre)) {
                    escuelaTag = '<span style="font-size:9px;background:#e8f5e9;color:#2e7d32;padding:1px 6px;border-radius:10px;font-weight:700;margin-right:4px;">' + (p.escuela_siglas || p.escuela_nombre) + '</span>';
                }
                var removeBtn = '';
                if (editable && ((!detalleEsCreador) || (detalleEsCreador && p.id_escuela == <?= $_SESSION['escuela_id'] ?>))) {
                    removeBtn = '<span style="cursor:pointer;opacity:0.4;font-size:12px;margin-left:2px;" onclick="removerParticipante(' + p.id + ')" title="Quitar">✕</span>';
                }
                participantsHtml += '<span style="display:inline-flex;align-items:center;gap:4px;background:#f5f5f5;padding:4px 10px;border-radius:16px;font-size:12px;font-weight:500;color:#333;margin:2px;">'
                    + escuelaTag
                    + renderBeltDots(p.cinturon || p.grado || '') + ' '
                    + htmlspecialchars(p.nombre + ' ' + p.apellido)
                    + ' <span style="color:#999;font-size:11px;">' + edad + '</span>'
                    + ' <span style="font-size:11px;">' + sexoIconP + '</span>'
                    + removeBtn
                    + '</span>';
            });
            participantsHtml += '</div>';
        }
        html += '<div style="background:#fff;border-radius:14px;margin-bottom:8px;box-shadow:0 1px 4px rgba(0,0,0,0.06);overflow:hidden;">'
            + '<div style="display:flex;align-items:center;padding:12px 14px;cursor:pointer;" onclick="toggleCategoria(' + c.id + ')">'
            + '<div style="flex:1;">'
            + '<div style="font-size:14px;font-weight:700;color:#333;">' + htmlspecialchars(c.nombre) + ' <span style="font-size:13px;">' + sexoIcon + '</span></div>'
            + '<div style="font-size:11px;color:#888;margin-top:2px;display:flex;gap:10px;flex-wrap:wrap;">'
            + '<span>🎂 ' + edadStr + '</span>'
            + '<span><span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:' + getBeltColor(c.cinturon_min || 'Blanco') + ';border:1px solid rgba(0,0,0,0.1);"></span> ' + cinturonStr + '</span>'
            + '</div>'
            + '</div>'
            + '<div style="text-align:right;flex-shrink:0;">'
            + '<div style="font-size:13px;font-weight:800;color:#2e7d32;">' + count + '</div>'
            + '<div style="font-size:9px;color:#999;">part.</div>'
            + '</div>'
            + '<div style="margin-left:10px;color:#ccc;font-size:12px;">' + arrow + '</div>'
            + '</div>'
            + '<div style="display:' + expanded + ';padding:0 14px 12px;border-top:1px solid #f5f5f5;">'
            + participantsHtml
            + (editable ? '<div style="margin-top:8px;display:flex;gap:6px;flex-wrap:wrap;">'
            + '<button class="btn-add" style="width:auto;height:28px;font-size:11px;padding:0 10px;gap:3px;background:#42a5f5;display:inline-flex;" onclick="abrirAgregarParticipante(' + c.id + ')">➕ Agregar participante</button>'
            + (detalleEsCreador ? '<button class="btn-add" style="width:auto;height:28px;font-size:11px;padding:0 10px;gap:3px;background:#ef6c00;display:inline-flex;border:none;border-radius:8px;color:#fff;" onclick="abrirCategoriaModal(' + c.id + ')">✏️ Editar</button><button class="btn-add" style="width:auto;height:28px;font-size:11px;padding:0 10px;gap:3px;background:#e53935;display:inline-flex;border:none;border-radius:8px;color:#fff;" onclick="eliminarCategoria(' + c.id + ')">🗑 Eliminar</button>' : '')
            + '</div>' : '')
            + '</div>'
            + '</div>';
    });
    container.innerHTML = html;
}

function toggleCategoria(id) {
    if (categoriaActivaId == id) categoriaActivaId = 0;
    else categoriaActivaId = id;
    verDetalle(detalleTorneoId);
}

function renderJueces(lista) {
    var container = document.getElementById('juecesLista');
    var btnAgregar = document.getElementById('btnAgregarJuez');
    btnAgregar.style.display = detalleEsCreador ? 'inline-flex' : 'none';
    if (!lista || lista.length === 0) {
        container.innerHTML = detalleEsCreador
            ? '<div style="color:#ccc;font-size:13px;width:100%;text-align:center;padding:20px 0;">No hay jueces asignados. Toca + para agregar.</div>'
            : '<div style="color:#ccc;font-size:13px;width:100%;text-align:center;padding:20px 0;">No hay jueces asignados.</div>';
        return;
    }
    var html = '';
    lista.forEach(function(j) {
        var escuelaTag = '';
        if (detalleEsCreador && (j.escuela_siglas || j.escuela_nombre)) {
            escuelaTag = '<span class="escuela-tag">' + (j.escuela_siglas || j.escuela_nombre) + '</span>';
        }
        var removeBtn = detalleEsCreador ? '<span class="remove-btn" onclick="removerJuez(' + j.id + ')" title="Quitar">✕</span>' : '';
        html += '<span class="participant-chip">⚖️ ' + escuelaTag + htmlspecialchars(j.nombre + ' ' + j.apellido) + removeBtn + '</span>';
    });
    container.innerHTML = html;
}

function abrirCategoriaModal(id) {
    if (id) {
        document.getElementById('categoriaModalTitle').textContent = '✏️ Editar Categor\u00eda';
        document.getElementById('categoriaEditId').value = id;
        fetch('<?= base_url('/torneos/categorias') ?>?id=' + detalleTorneoId)
        .then(r => r.json())
        .then(lista => {
            var c = lista.find(function(x) { return x.id == id; });
            if (!c) return;
            document.getElementById('catNombre').value = c.nombre || '';
            document.getElementById('catSexo').value = c.sexo || 'X';
            document.getElementById('catEdadMin').value = c.edad_min || '';
            document.getElementById('catEdadMax').value = c.edad_max || '';
            document.getElementById('catCintMin').value = c.cinturon_min || '';
            document.getElementById('catCintMax').value = c.cinturon_max || '';
            setBeltValue('catCintMin', c.cinturon_min || '');
            setBeltValue('catCintMax', c.cinturon_max || '');
            categoriaModal.show();
        });
    } else {
        document.getElementById('categoriaModalTitle').textContent = '➕ Crear Categor\u00eda';
        document.getElementById('categoriaEditId').value = '0';
        document.getElementById('catNombre').value = '';
        document.getElementById('catSexo').value = 'X';
        document.getElementById('catEdadMin').value = '';
        document.getElementById('catEdadMax').value = '';
        document.getElementById('catCintMin').value = '';
        document.getElementById('catCintMax').value = '';
        setBeltValue('catCintMin', '');
        setBeltValue('catCintMax', '');
        categoriaModal.show();
    }
}

function guardarCategoria() {
    var editId = document.getElementById('categoriaEditId').value;
    var data = new URLSearchParams();
    data.append('id_torneo', detalleTorneoId);
    data.append('nombre', document.getElementById('catNombre').value);
    data.append('sexo', document.getElementById('catSexo').value);
    data.append('edad_min', document.getElementById('catEdadMin').value || '0');
    data.append('edad_max', document.getElementById('catEdadMax').value || '0');
    data.append('cinturon_min', document.getElementById('catCintMin').value);
    data.append('cinturon_max', document.getElementById('catCintMax').value);
    if (editId !== '0') data.append('id', editId);
    var url = editId === '0' ? '<?= base_url('/torneos/guardar-categoria') ?>' : '<?= base_url('/torneos/actualizar-categoria') ?>';
    fetch(url, { method: 'POST', body: data })
    .then(r => r.json())
    .then(d => {
        if (d.success) {
            categoriaModal.hide();
            verDetalle(detalleTorneoId);
        } else {
            alert(d.message);
        }
    });
}

function eliminarCategoria(id) {
    if (!confirm('¿Eliminar esta categor\u00eda?')) return;
    var data = new URLSearchParams();
    data.append('id', id);
    fetch('<?= base_url('/torneos/eliminar-categoria') ?>', { method: 'POST', body: data })
    .then(r => r.json())
    .then(d => {
        if (d.success) verDetalle(detalleTorneoId);
        else alert(d.message);
    });
}

function abrirAgregarParticipante(categoriaId) {
    categoriaActivaId = categoriaId;
    var cat = document.querySelector('#categoriasLista .cat-name');
    var catNombre = '';
    var cats = document.querySelectorAll('#categoriasLista > div');
    document.getElementById('searchParticipanteInput').value = '';
    document.getElementById('participantesDisponibles').innerHTML = '<div style="color:#ccc;text-align:center;padding:20px;">Cargando...</div>';
    document.getElementById('addPartCategoriaInfo').textContent = 'Agregando a categor\u00eda #' + categoriaId;
    fetch('<?= base_url('/torneos/categorias') ?>?id=' + detalleTorneoId)
    .then(r => r.json())
    .then(lista => {
        var c = lista.find(function(x) { return x.id == categoriaId; });
        if (c) document.getElementById('addPartCategoriaInfo').textContent = '📂 ' + htmlspecialchars(c.nombre);
        else document.getElementById('addPartCategoriaInfo').style.display = 'none';
    });
    fetch('<?= base_url('/participantes/listar') ?>')
    .then(r => r.json())
    .then(lista => {
        participantesDisponibles = lista || [];
        renderParticipantesDisponibles();
        agregarModal.show();
    });
}

function renderParticipantesDisponibles() {
    var q = document.getElementById('searchParticipanteInput').value.toLowerCase();
    var container = document.getElementById('participantesDisponibles');
    var filtrados = participantesDisponibles.filter(function(p) {
        return (p.nombre + ' ' + p.apellido).toLowerCase().includes(q);
    });
    if (filtrados.length === 0) {
        container.innerHTML = '<div style="color:#ccc;text-align:center;padding:20px;">No hay participantes disponibles.</div>';
        return;
    }
    var html = '';
    filtrados.forEach(function(p) {
        var sel = p._selected ? 'selected' : '';
        var sexoIcon = p.sexo === 'M' ? '♂' : p.sexo === 'F' ? '♀' : '⚥';
        html += '<div class="selection-item ' + sel + '" onclick="toggleParticipante(' + p.id + ')">' +
            '<div class="cb">' + (p._selected ? '✓' : '') + '</div>' +
            '<div style="flex:1;display:flex;align-items:center;gap:8px;">' +
            '<div><strong>' + htmlspecialchars(p.nombre + ' ' + p.apellido) + '</strong>' +
            '<br><span style="font-size:11px;color:#999;">' + (p.edad ? p.edad + ' a\u00f1os' : '') + ' ' + sexoIcon + ' ' + renderBeltDots(p.cinturon || p.grado || '') + '</span></div>' +
            '</div>' +
            '</div>';
    });
    container.innerHTML = html;
}

function toggleParticipante(id) {
    participantesDisponibles.forEach(function(p) {
        if (p.id == id) p._selected = !p._selected;
    });
    renderParticipantesDisponibles();
}

function filtrarParticipantes() {
    renderParticipantesDisponibles();
}

function agregarSeleccionados() {
    var seleccionados = participantesDisponibles.filter(function(p) { return p._selected; });
    if (seleccionados.length === 0) { alert('Selecciona al menos un participante.'); return; }
    var pendientes = seleccionados.length;
    seleccionados.forEach(function(p) {
        var data = new URLSearchParams();
        data.append('id_torneo', detalleTorneoId);
        data.append('id_participante', p.id);
        data.append('id_categoria', categoriaActivaId);
        fetch('<?= base_url('/torneos/agregar-participante') ?>', { method: 'POST', body: data })
        .then(r => r.json())
        .then(d => {
            pendientes--;
            if (pendientes === 0) {
                agregarModal.hide();
                verDetalle(detalleTorneoId);
            }
        });
    });
}

function removerParticipante(id) {
    if (!confirm('¿Quitar este participante del torneo?')) return;
    var data = new URLSearchParams();
    data.append('id_torneo', detalleTorneoId);
    data.append('id_participante', id);
    fetch('<?= base_url('/torneos/remover-participante') ?>', { method: 'POST', body: data })
    .then(r => r.json())
    .then(d => {
        verDetalle(detalleTorneoId);
    });
}

function htmlspecialchars(s) {
    if (!s) return '';
    var d = document.createElement('div');
    d.appendChild(document.createTextNode(s));
    return d.innerHTML;
}

function getBeltColor(cinturon) {
    if (!cinturon) return '#ccc';
    var map = {
        'blanco': '#f5f5f5',
        'blanco punta amarilla': '#f5f5f5',
        'amarillo': '#fdd835',
        'amarillo punta verde': '#fdd835',
        'verde': '#43a047',
        'verde punta azul': '#43a047',
        'azul': '#1e88e5',
        'azul punta roja': '#1e88e5',
        'rojo': '#e53935',
        'rojo punta negra': '#e53935',
        'pum': '#333',
        'i dan': '#111',
        'ii dan': '#111',
        'iii dan': '#111',
    };
    return map[(cinturon || '').toLowerCase()] || '#ccc';
}

function renderBeltDots(cinturon) {
    if (!cinturon) return '<span style="width:8px;height:8px;border-radius:50%;background:#ccc;display:inline-block;border:1px solid rgba(0,0,0,0.1);"></span>';
    var parts = cinturon.split(/[\/\-\s]+/).filter(function(s){return s.length>0});
    var html = '';
    parts.forEach(function(p) {
        var c = getBeltColor(p);
        html += '<span style="width:8px;height:8px;border-radius:50%;background:' + c + ';display:inline-block;border:1px solid rgba(0,0,0,0.1);margin-right:2px;"></span>';
    });
    return html || '<span style="width:8px;height:8px;border-radius:50%;background:#ccc;display:inline-block;border:1px solid rgba(0,0,0,0.1);"></span>';
}

function toggleBeltDrop(name) {
    var drop = document.getElementById(name + 'Drop');
    var isOpen = drop.style.display === 'block';
    // Close all belt dropdowns
    document.querySelectorAll('.belt-dropdown').forEach(function(el) { el.style.display = 'none'; });
    if (!isOpen) drop.style.display = 'block';
}

function selBelt(name, value, colors, label) {
    document.getElementById(name).value = value;
    document.getElementById(name + 'Text').textContent = label;
    document.getElementById(name + 'Text').style.color = value ? '#333' : '#999';
    // Build preview dots
    var parts = colors.split('|');
    var preview = '';
    parts.forEach(function(c) {
        preview += '<span class="belt-dot" style="width:18px;height:18px;background:' + c + ';display:inline-block;border-radius:50%;border:1px solid rgba(0,0,0,0.1);';
        if (parts.length > 1 && preview) preview += 'margin-left:-8px;';
        preview += '"></span>';
    });
    document.getElementById(name + 'Preview').innerHTML = preview || '<span class="belt-dot" style="width:18px;height:18px;background:#eee;border:2px solid #ddd;display:inline-block;border-radius:50%;"></span>';
    document.getElementById(name + 'Drop').style.display = 'none';
}

// Close belt dropdowns when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('.belt-custom-trigger') && !e.target.closest('.belt-dropdown')) {
        document.querySelectorAll('.belt-dropdown').forEach(function(el) { el.style.display = 'none'; });
    }
});

function setBeltValue(name, value) {
    // Find the matching option in the dropdown and call selBelt
    var label = value || '—';
    var colors = value ? getBeltColor(value) : '#eee';
    selBelt(name, value, colors, label);
}

function abrirAgregarJuez() {
    document.getElementById('searchJuezInput').value = '';
    document.getElementById('juecesDisponibles').innerHTML = '<div style="color:#ccc;text-align:center;padding:20px;">Cargando...</div>';
    fetch('<?= base_url('/jueces/listar') ?>')
    .then(r => r.json())
    .then(lista => {
        juecesDisponibles = lista || [];
        renderJuecesDisponibles();
        agregarJuezModal.show();
    });
}

function renderJuecesDisponibles() {
    var q = document.getElementById('searchJuezInput').value.toLowerCase();
    var container = document.getElementById('juecesDisponibles');
    var filtrados = juecesDisponibles.filter(function(j) {
        return (j.nombre + ' ' + j.apellido + ' ' + j.user).toLowerCase().includes(q);
    });
    if (filtrados.length === 0) {
        container.innerHTML = '<div style="color:#ccc;text-align:center;padding:20px;">No hay jueces disponibles. Cr\u00e9alos en la secci\u00f3n Jueces.</div>';
        return;
    }
    var html = '';
    filtrados.forEach(function(j) {
        var sel = j._selected ? 'selected' : '';
        html += '<div class="selection-item ' + sel + '" onclick="toggleJuez(' + j.id + ')">' +
            '<div class="cb">' + (j._selected ? '✓' : '') + '</div>' +
            '<div style="flex:1;"><strong>' + htmlspecialchars(j.nombre + ' ' + j.apellido) + '</strong><br><span style="font-size:11px;color:#999;">\ud83d\udc64 ' + htmlspecialchars(j.user) + (j.ciudad ? ' \u00b7 ' + j.ciudad : '') + '</span></div>' +
            '</div>';
    });
    container.innerHTML = html;
}

function toggleJuez(id) {
    juecesDisponibles.forEach(function(j) {
        if (j.id == id) j._selected = !j._selected;
    });
    renderJuecesDisponibles();
}

function filtrarJueces() {
    renderJuecesDisponibles();
}

function agregarJuecesSeleccionados() {
    var seleccionados = juecesDisponibles.filter(function(j) { return j._selected; });
    if (seleccionados.length === 0) { alert('Selecciona al menos un juez.'); return; }
    var pendientes = seleccionados.length;
    seleccionados.forEach(function(j) {
        var data = new URLSearchParams();
        data.append('id_torneo', detalleTorneoId);
        data.append('id_juez', j.id);
        fetch('<?= base_url('/torneos/agregar-juez') ?>', { method: 'POST', body: data })
        .then(r => r.json())
        .then(d => {
            pendientes--;
            if (pendientes === 0) {
                agregarJuezModal.hide();
                verDetalle(detalleTorneoId);
            }
        });
    });
}

function removerJuez(id) {
    if (!confirm('\u00bfQuitar este juez del torneo?')) return;
    var data = new URLSearchParams();
    data.append('id_torneo', detalleTorneoId);
    data.append('id_juez', id);
    fetch('<?= base_url('/torneos/remover-juez') ?>', { method: 'POST', body: data })
    .then(r => r.json())
    .then(d => {
        verDetalle(detalleTorneoId);
    });
}

function salirTorneo() {
    if (!confirm('\u00bfSalir de este torneo? Tus participantes seguir\u00e1n registrados en el torneo.')) return;
    var data = new URLSearchParams();
    data.append('id', detalleTorneoId);
    fetch('<?= base_url('/torneos/salir') ?>', { method: 'POST', body: data })
    .then(r => r.json())
    .then(d => {
        if (d.success) { detalleModal.hide(); location.reload(); }
        else alert(d.message);
    });
}

function eliminarTorneo() {
    if (!confirm('\u00bfEliminar este torneo? Todos los datos asociados se perder\u00e1n.')) return;
    var data = new URLSearchParams();
    data.append('id', detalleTorneoId);
    fetch('<?= base_url('/torneos/eliminar') ?>', { method: 'POST', body: data })
    .then(r => r.json())
    .then(d => {
        if (d.success) { detalleModal.hide(); location.reload(); }
        else alert(d.message);
    });
}

function verPuntajes() {
    detalleModal.hide();
    var url = '<?= base_url('/scoreboard') ?>?id=' + detalleTorneoId;
    window.open(url, '_blank');
}

function toggleEstadoTorneo() {
    var data = new URLSearchParams();
    data.append('id', detalleTorneoId);
    fetch('<?= base_url('/torneos/toggle-estado') ?>', { method: 'POST', body: data })
    .then(r => r.json())
    .then(d => {
        if (d.success) { detalleModal.hide(); location.reload(); }
        else alert(d.message);
    });
}

function finalizarTorneo() {
    if (!confirm('\u00bfFinalizar el torneo? Ya no se podr\u00e1n hacer m\u00e1s evaluaciones.')) return;
    var data = new URLSearchParams();
    data.append('id', detalleTorneoId);
    fetch('<?= base_url('/torneos/finalizar') ?>', { method: 'POST', body: data })
    .then(r => r.json())
    .then(d => {
        if (d.success) { detalleModal.hide(); location.reload(); }
        else alert(d.message);
    });
}
</script>
</body>
</html>
