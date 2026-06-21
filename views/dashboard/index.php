<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover,user-scalable=no">
    <meta name="theme-color" content="#1b5e20">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title><?= htmlspecialchars($escuela['siglas'] ?: $escuela['nombre'] ?: 'Poomsae') ?></title>
    <link rel="manifest" href="<?= base_url('/manifest.php') ?>">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; -webkit-tap-highlight-color:transparent; }
        body { background:#f5f5dc; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif; min-height:100vh; min-height:100dvh; padding-bottom:80px; }
        .topbar { position:sticky; top:0; z-index:100; background:linear-gradient(135deg,#1b5e20,#2e7d32); padding:14px 18px; padding-top:max(14px,env(safe-area-inset-top,14px)); display:flex; align-items:center; justify-content:space-between; }
        .topbar-brand { display:flex; align-items:center; gap:10px; }
        .topbar-brand .avatar { width:36px; height:36px; background:rgba(255,255,255,0.15); border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:18px; }
        .topbar-brand .info { }
        .topbar-brand .name { color:#fff; font-size:15px; font-weight:700; }
        .topbar-brand .sub { color:rgba(255,255,255,0.6); font-size:10px; font-weight:600; text-transform:uppercase; letter-spacing:1px; }
        .topbar-actions { display:flex; gap:6px; }
        .topbar-btn { width:38px; height:38px; background:rgba(255,255,255,0.1); border:none; border-radius:12px; color:#fff; font-size:18px; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:all .15s; }
        .topbar-btn:active { background:rgba(255,255,255,0.2); transform:scale(0.92); }
        .content { padding:16px; max-width:600px; margin:0 auto; animation:fadeUp .4s ease-out; }
        @keyframes fadeUp { 0%{opacity:0;transform:translateY(16px)} 100%{opacity:1;transform:translateY(0)} }
        .greeting { margin-bottom:20px; }
        .greeting h2 { font-size:22px; font-weight:800; color:#1b5e20; }
        .greeting p { color:#999; font-size:13px; margin-top:2px; }
        .stats { display:grid; grid-template-columns:repeat(3,1fr); gap:10px; margin-bottom:20px; }
        .stat-card { background:#fff; border-radius:16px; padding:16px 10px; text-align:center; box-shadow:0 2px 12px rgba(0,0,0,0.04); transition:all .2s; }
        .stat-card:active { transform:scale(0.95); }
        .stat-card .icon { font-size:24px; margin-bottom:4px; }
        .stat-card .num { font-size:22px; font-weight:800; color:#1b5e20; }
        .stat-card .label { font-size:10px; color:#999; font-weight:600; text-transform:uppercase; letter-spacing:1px; margin-top:2px; }
        .section-title { font-size:13px; font-weight:700; color:#333; margin-bottom:10px; display:flex; align-items:center; gap:6px; }
        .quick-menu { display:grid; grid-template-columns:repeat(2,1fr); gap:10px; margin-bottom:20px; }
        .quick-item { background:#fff; border-radius:16px; padding:18px 14px; text-align:center; box-shadow:0 2px 12px rgba(0,0,0,0.04); cursor:pointer; transition:all .2s; border:none; }
        .quick-item:active { transform:scale(0.95); background:#fafff5; }
        .quick-item .qicon { font-size:28px; margin-bottom:6px; }
        .quick-item .qname { font-size:13px; font-weight:600; color:#333; }
        .quick-item .qsub { font-size:10px; color:#bbb; margin-top:2px; }
        .info-card { background:#fff; border-radius:16px; padding:18px; box-shadow:0 2px 12px rgba(0,0,0,0.04); }
        .info-card .row { display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #f5f5f5; font-size:13px; }
        .info-card .row:last-child { border-bottom:none; }
        .info-card .row .lbl { color:#999; font-weight:500; }
        .info-card .row .val { color:#333; font-weight:600; text-align:right; }
        .bottombar { position:fixed; bottom:0; left:0; right:0; background:#fff; border-top:1px solid #f0f0f0; padding:8px 0; padding-bottom:max(8px,env(safe-area-inset-bottom,8px)); display:flex; justify-content:space-around; box-shadow:0 -2px 12px rgba(0,0,0,0.04); z-index:100; }
        .bottombar a { text-decoration:none; display:flex; flex-direction:column; align-items:center; gap:2px; padding:6px 12px; border-radius:12px; transition:all .15s; }
        .bottombar a:active { background:#f5f5f5; }
        .bottombar .bi { font-size:22px; }
        .bottombar .bl { font-size:9px; font-weight:600; color:#999; text-transform:uppercase; letter-spacing:0.5px; }
        .bottombar a.active .bl { color:#2e7d32; }
        .offcanvas-dojang { background:linear-gradient(180deg,#1b5e20,#2e7d32); color:#fff; }
        .offcanvas-dojang .offcanvas-header { border-bottom:1px solid rgba(255,255,255,0.08); padding:16px 20px; padding-top:max(16px,env(safe-area-inset-top,16px)); }
        .offcanvas-dojang .offcanvas-title { font-weight:700; font-size:17px; }
        .offcanvas-dojang .btn-close { filter:invert(1); opacity:0.6; }
        .offcanvas-dojang .nav-item { display:flex; align-items:center; gap:14px; padding:14px 20px; color:rgba(255,255,255,0.85); text-decoration:none; font-size:14px; font-weight:500; transition:all .15s; border-radius:0; }
        .offcanvas-dojang .nav-item:active { background:rgba(255,255,255,0.08); }
        .offcanvas-dojang .nav-item .ni { font-size:20px; }
        .offcanvas-dojang .hr { height:1px; background:rgba(255,255,255,0.08); margin:8px 20px; }
        @media (prefers-color-scheme:dark) {
            body { background:#1a1a2e; }
            .stat-card { background:#16213e; }
            .quick-item { background:#16213e; }
            .quick-item .qname { color:#e0e0e0; }
            .info-card { background:#16213e; }
            .info-card .row .val { color:#e0e0e0; }
            .section-title { color:#e0e0e0; }
            .greeting h2 { color:#4caf50; }
            .bottombar { background:#16213e; border-color:#2a2a4e; }
            .bottombar a:active { background:#1a1a2e; }
            .bottombar .bl { color:#888; }
            .bottombar a.active .bl { color:#66bb6a; }
        }
    </style>
</head>
<body>

<!-- TOPBAR -->
<div class="topbar">
    <div class="topbar-brand">
        <div class="avatar">🥋</div>
        <div class="info">
            <div class="name"><?= htmlspecialchars($escuela['siglas'] ?: $escuela['nombre'] ?: 'Poomsae') ?></div>
            <div class="sub">Sistema de Evaluaci&oacute;n</div>
        </div>
    </div>
    <div class="topbar-actions">
        <button class="topbar-btn" onclick="abrirMenu()">☰</button>
    </div>
</div>

<!-- OFFCANVAS MENU -->
<div class="offcanvas offcanvas-start offcanvas-dojang" tabindex="-1" id="menuOffcanvas">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">🥋 Men&uacute;</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0">
        <div class="nav-item"><span class="ni">👥</span> Participantes</div>
        <div class="nav-item"><span class="ni">⚖️</span> Jueces</div>
        <div class="nav-item"><span class="ni">🏆</span> Torneos</div>
        <div class="hr"></div>
        <div class="nav-item" onclick="location.href='<?= base_url('/escuela') ?>'"><span class="ni">⚙️</span> Configuraci&oacute;n</div>
        <div class="nav-item" onclick="location.href='<?= base_url('/logout') ?>'"><span class="ni">🚪</span> Cerrar Sesi&oacute;n</div>
    </div>
</div>

<!-- CONTENT -->
<div class="content">
    <div class="greeting">
        <h2>👋 Hola, <?= htmlspecialchars(explode(' ', $escuela['nombre'] ?? '')[0]) ?>!</h2>
        <p><?= htmlspecialchars($escuela['ciudad'] ? $escuela['ciudad'].', '.$escuela['pais'] : 'Bienvenido a tu panel') ?></p>
    </div>

    <div class="stats">
        <div class="stat-card"><div class="icon">👥</div><div class="num" id="statParts">0</div><div class="label">Participantes</div></div>
        <div class="stat-card"><div class="icon">⚖️</div><div class="num" id="statJueces">0</div><div class="label">Jueces</div></div>
        <div class="stat-card"><div class="icon">🏆</div><div class="num" id="statTorneos">0</div><div class="label">Torneos</div></div>
    </div>

    <div class="section-title">⚡ Acceso R&aacute;pido</div>
    <div class="quick-menu">
        <button class="quick-item" onclick="irA('participantes')">
            <div class="qicon">👥</div>
            <div class="qname">Participantes</div>
            <div class="qsub">Agregar y gestionar</div>
        </button>
        <button class="quick-item" onclick="irA('jueces')">
            <div class="qicon">⚖️</div>
            <div class="qname">Jueces</div>
            <div class="qsub">Registrar jueces</div>
        </button>
        <button class="quick-item" onclick="irA('torneos')">
            <div class="qicon">🏆</div>
            <div class="qname">Torneos</div>
            <div class="qsub">Crear y administrar</div>
        </button>
        <button class="quick-item" onclick="irA('config')">
            <div class="qicon">⚙️</div>
            <div class="qname">Configuraci&oacute;n</div>
            <div class="qsub">Datos del Dojang</div>
        </button>
    </div>

    <div class="section-title">📋 Tu Dojang</div>
    <div class="info-card">
        <div class="row"><span class="lbl">Nombre</span><span class="val"><?= htmlspecialchars($escuela['nombre'] ?? '') ?></span></div>
        <div class="row"><span class="lbl">Siglas</span><span class="val"><?= htmlspecialchars($escuela['siglas'] ?? '') ?></span></div>
        <div class="row"><span class="lbl">Instructor</span><span class="val"><?= htmlspecialchars($escuela['instructor_nombre'] ?? '') ?> <?= htmlspecialchars($escuela['instructor_grado'] ?? '') ?></span></div>
        <div class="row"><span class="lbl">Correo</span><span class="val"><?= htmlspecialchars($escuela['correo'] ?? '') ?></span></div>
        <div class="row"><span class="lbl">Tel&eacute;fono</span><span class="val"><?= htmlspecialchars($escuela['telefono'] ?? '') ?></span></div>
        <div class="row"><span class="lbl">Ubicaci&oacute;n</span><span class="val"><?= htmlspecialchars($escuela['ciudad'] ?? '') ?>, <?= htmlspecialchars($escuela['pais'] ?? '') ?></span></div>
    </div>
</div>

<!-- BOTTOMBAR -->
<div class="bottombar">
    <a href="#" class="active"><span class="bi">🏠</span><span class="bl">Inicio</span></a>
    <a href="#" onclick="irA('participantes')"><span class="bi">👥</span><span class="bl">Alumnos</span></a>
    <a href="#" onclick="irA('jueces')"><span class="bi">⚖️</span><span class="bl">Jueces</span></a>
    <a href="#" onclick="irA('torneos')"><span class="bi">🏆</span><span class="bl">Torneos</span></a>
    <a href="#" onclick="irA('config')"><span class="bi">⚙️</span><span class="bl">Ajustes</span></a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
var menuOffcanvas;
document.addEventListener('DOMContentLoaded', function() {
    menuOffcanvas = new bootstrap.Offcanvas(document.getElementById('menuOffcanvas'));
});
function abrirMenu() { menuOffcanvas.show(); }
function irA(s) {
    var msg = 'Pr&oacute;ximamente: ' + s;
    if (s === 'config') { location.href = '<?= base_url('/escuela') ?>'; return; }
    alert(msg);
}
</script>
</body>
</html>
