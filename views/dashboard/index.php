<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover,user-scalable=no">
    <meta name="theme-color" content="#1b5e20">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title><?= htmlspecialchars($escuela['siglas'] ?: $escuela['nombre'] ?: 'Poomsae') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="manifest" href="<?= base_url('/manifest.php') ?>">
    <style>
        * { -webkit-tap-highlight-color:transparent; }
        body { background:#f5f5dc; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif; min-height:100vh; min-height:100dvh; padding-bottom:72px; }
        .topbar { position:sticky; top:0; z-index:100; background:linear-gradient(135deg,#1b5e20,#2e7d32); padding:12px 16px; padding-top:max(12px,env(safe-area-inset-top,12px)); display:flex; align-items:center; justify-content:space-between; }
        .topbar-brand { display:flex; align-items:center; gap:10px; }
        .topbar-brand .avatar { width:34px; height:34px; background:rgba(255,255,255,0.15); border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:17px; }
        .topbar-brand .name { color:#fff; font-size:15px; font-weight:700; }
        .topbar-brand .sub { color:rgba(255,255,255,0.55); font-size:9px; font-weight:600; text-transform:uppercase; letter-spacing:1px; line-height:1; margin-top:1px; }
        .topbar-btn { width:36px; height:36px; background:rgba(255,255,255,0.08); border:none; border-radius:10px; color:#fff; font-size:18px; display:flex; align-items:center; justify-content:center; transition:all .15s; }
        .topbar-btn:active { background:rgba(255,255,255,0.18); transform:scale(0.92); }
        .content { max-width:600px; margin:0 auto; padding:16px; animation:fadeUp .4s ease-out; }
        @keyframes fadeUp { 0%{opacity:0;transform:translateY(16px)} 100%{opacity:1;transform:translateY(0)} }
        .greeting h2 { font-size:20px; font-weight:800; color:#1b5e20; }
        .greeting p { color:#999; font-size:13px; margin-top:2px; }
        .stat-card { background:#fff; border:none; border-radius:16px; padding:16px 8px; text-align:center; transition:all .2s; box-shadow:0 2px 12px rgba(0,0,0,0.04); cursor:pointer; }
        .stat-card:active { transform:scale(0.95); }
        .stat-card .num { font-size:22px; font-weight:800; color:#1b5e20; }
        .stat-card .lbl { font-size:10px; color:#999; font-weight:600; text-transform:uppercase; letter-spacing:1px; margin-top:2px; }
        .quick-item { background:#fff; border:2px solid transparent; border-radius:16px; padding:18px 12px; text-align:center; cursor:pointer; transition:all .2s; box-shadow:0 2px 12px rgba(0,0,0,0.04); }
        .quick-item:active { transform:scale(0.95); border-color:#e8f5e9; background:#fafff5; }
        .quick-item .qicon { font-size:26px; margin-bottom:4px; }
        .quick-item .qname { font-size:13px; font-weight:600; color:#333; }
        .quick-item .qsub { font-size:10px; color:#bbb; margin-top:1px; }
        .card-info { background:#fff; border:none; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,0.04); overflow:hidden; }
        .card-info .row-item { display:flex; justify-content:space-between; padding:10px 16px; border-bottom:1px solid #f5f5f5; font-size:13px; }
        .card-info .row-item:last-child { border-bottom:none; }
        .card-info .lbl { color:#999; font-weight:500; }
        .card-info .val { color:#333; font-weight:600; text-align:right; }
        .bottombar { position:fixed; bottom:0; left:0; right:0; background:#fff; border-top:1px solid #f0f0f0; padding:6px 0; padding-bottom:max(6px,env(safe-area-inset-bottom,6px)); display:flex; justify-content:space-around; z-index:100; box-shadow:0 -2px 12px rgba(0,0,0,0.04); }
        .bottombar .nav-item { text-decoration:none; display:flex; flex-direction:column; align-items:center; gap:1px; padding:4px 12px; border-radius:12px; transition:all .15s; border:none; background:none; cursor:pointer; }
        .bottombar .nav-item:active { background:#f5f5f5; }
        .bottombar .bi { font-size:20px; line-height:1; }
        .bottombar .bl { font-size:9px; font-weight:600; color:#999; text-transform:uppercase; letter-spacing:0.5px; }
        .bottombar .nav-item.active .bl { color:#2e7d32; }
        .offcanvas-dojang { background:linear-gradient(180deg,#1b5e20,#2e7d32); color:#fff; }
        .offcanvas-dojang .offcanvas-header { border-bottom:1px solid rgba(255,255,255,0.08); }
        .offcanvas-dojang .offcanvas-title { font-weight:700; font-size:17px; }
        .offcanvas-dojang .btn-close { filter:invert(1); opacity:0.6; }
        .offcanvas-dojang .nav-link { display:flex; align-items:center; gap:14px; padding:14px 20px; color:rgba(255,255,255,0.85); text-decoration:none; font-size:14px; font-weight:500; transition:all .15s; border-radius:0; }
        .offcanvas-dojang .nav-link:active { background:rgba(255,255,255,0.08); }
        .offcanvas-dojang .nav-link .ni { font-size:20px; }
        .offcanvas-dojang .hr { height:1px; background:rgba(255,255,255,0.08); margin:8px 20px; }
        .section-title { font-size:12px; font-weight:700; color:#333; text-transform:uppercase; letter-spacing:1px; margin-bottom:10px; display:flex; align-items:center; gap:6px; }
        .badge-count { background:#e8f5e9; color:#2e7d32; font-size:10px; font-weight:700; border-radius:20px; padding:2px 8px; margin-left:6px; }
        @media (prefers-color-scheme:dark) {
            body { background:#1a1a2e; }
            .stat-card { background:#16213e; }
            .stat-card .num { color:#66bb6a; }
            .quick-item { background:#16213e; }
            .quick-item .qname { color:#e0e0e0; }
            .card-info { background:#16213e; }
            .card-info .val { color:#e0e0e0; }
            .card-info .row-item { border-color:#2a2a4e; }
            .section-title { color:#e0e0e0; }
            .greeting h2 { color:#66bb6a; }
            .bottombar { background:#16213e; border-color:#2a2a4e; }
            .bottombar .nav-item:active { background:#1a1a2e; }
            .bottombar .bl { color:#888; }
            .bottombar .nav-item.active .bl { color:#66bb6a; }
            .badge-count { background:#1b5e20; color:#a5d6a7; }
        }
    </style>
</head>
<body>

<div class="topbar">
    <div class="topbar-brand">
        <div class="avatar">🥋</div>
        <div><div class="name"><?= htmlspecialchars($escuela['siglas'] ?: $escuela['nombre'] ?: 'Poomsae') ?></div><div class="sub">Sistema de Evaluaci&oacute;n</div></div>
    </div>
    <div><button class="topbar-btn" onclick="abrirMenu()">☰</button></div>
</div>

<div class="offcanvas offcanvas-start offcanvas-dojang" tabindex="-1" id="menuOffcanvas">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">🥋 Men&uacute;</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0">
        <a href="<?= base_url('/participantes') ?>" class="nav-link"><span class="ni">👥</span> Participantes</a>
        <a href="<?= base_url('/jueces') ?>" class="nav-link"><span class="ni">⚖️</span> Jueces</a>
        <a href="<?= base_url('/torneos') ?>" class="nav-link"><span class="ni">🏆</span> Torneos</a>
        <div class="hr"></div>
        <a href="<?= base_url('/escuela') ?>" class="nav-link"><span class="ni">⚙️</span> Configuraci&oacute;n</a>
        <a href="<?= base_url('/logout') ?>" class="nav-link"><span class="ni">🚪</span> Cerrar Sesi&oacute;n</a>
    </div>
</div>

<div class="content">
    <div class="greeting mb-3">
        <h2>👋 Hola, <?= htmlspecialchars(explode(' ', $escuela['nombre'] ?? '')[0]) ?>!</h2>
        <p><?= htmlspecialchars($escuela['ciudad'] ? $escuela['ciudad'].', '.$escuela['pais'] : 'Bienvenido a tu panel') ?></p>
    </div>

    <div class="section-title">⚡ Acceso R&aacute;pido</div>
    <div class="row g-2 mb-4">
        <div class="col-6"><button class="quick-item w-100" onclick="location.href='<?= base_url('/participantes') ?>'"><div class="qicon">👥</div><div class="qname">Participantes</div><div class="qsub">Agregar y gestionar</div></button></div>
        <div class="col-6"><button class="quick-item w-100" onclick="location.href='<?= base_url('/jueces') ?>'"><div class="qicon">⚖️</div><div class="qname">Jueces</div><div class="qsub">Registrar jueces</div></button></div>
        <div class="col-6"><button class="quick-item w-100" onclick="location.href='<?= base_url('/torneos') ?>'"><div class="qicon">🏆</div><div class="qname">Torneos</div><div class="qsub">Crear y administrar</div></button></div>
        <div class="col-6"><button class="quick-item w-100" onclick="location.href='<?= base_url('/escuela') ?>'"><div class="qicon">⚙️</div><div class="qname">Configuraci&oacute;n</div><div class="qsub">Datos del Dojang</div></button></div>
    </div>

    <div class="section-title">📋 Tu Dojang</div>
    <div class="card card-info">
        <div class="row-item"><span class="lbl">Nombre</span><span class="val"><?= htmlspecialchars($escuela['nombre'] ?? '') ?></span></div>
        <div class="row-item"><span class="lbl">Instructor</span><span class="val"><?= htmlspecialchars($escuela['instructor_nombre'] ?? '') ?> <?= htmlspecialchars($escuela['instructor_grado'] ?? '') ?></span></div>
        <div class="row-item"><span class="lbl">Correo</span><span class="val"><?= htmlspecialchars($escuela['correo'] ?? '') ?></span></div>
    </div>
</div>

<div class="bottombar">
    <button class="nav-item active" onclick="aviso('inicio')"><span class="bi">🏠</span><span class="bl">Inicio</span></button>
    <button class="nav-item" onclick="location.href='<?= base_url('/participantes') ?>'"><span class="bi">👥</span><span class="bl">Alumnos</span></button>
    <button class="nav-item" onclick="location.href='<?= base_url('/jueces') ?>'"><span class="bi">⚖️</span><span class="bl">Jueces</span></button>
    <button class="nav-item" onclick="location.href='<?= base_url('/torneos') ?>'"><span class="bi">🏆</span><span class="bl">Torneos</span></button>
    <button class="nav-item" onclick="location.href='<?= base_url('/escuela') ?>'"><span class="bi">⚙️</span><span class="bl">Ajustes</span></button>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
var menuOffcanvas;
document.addEventListener('DOMContentLoaded', function() {
    menuOffcanvas = new bootstrap.Offcanvas(document.getElementById('menuOffcanvas'));
});
function abrirMenu() { menuOffcanvas.show(); }
function aviso(s) {
    if (s === 'config') { location.href = '<?= base_url('/escuela') ?>'; return; }
    if (s === 'inicio') return;
    alert('🔧 Módulo de ' + s + ' en construcción. ¡Próximamente!');
}
</script>
</body>
</html>
