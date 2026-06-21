<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - <?= htmlspecialchars($escuela['nombre'] ?? '') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { background:#f5f5dc; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif; min-height:100vh; }
        .topbar { background:linear-gradient(135deg,#2e7d32,#4caf50); padding:12px 16px; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:1000; box-shadow:0 2px 8px rgba(0,0,0,0.1); }
        .topbar .brand { color:#fff; font-size:16px; font-weight:700; }
        .topbar .brand small { font-weight:400; opacity:0.8; font-size:12px; }
        .topbar-btn { background:none; border:none; color:#fff; font-size:20px; cursor:pointer; padding:4px 8px; border-radius:8px; transition:background 0.15s; }
        .topbar-btn:hover { background:rgba(255,255,255,0.15); }
        .content { max-width:800px; margin:0 auto; padding:20px 16px; }
        .welcome-card { background:#fff; border-radius:14px; padding:24px; box-shadow:0 2px 12px rgba(0,0,0,0.05); text-align:center; }
        .welcome-card h1 { color:#2e7d32; font-size:20px; font-weight:700; margin-bottom:4px; }
        .welcome-card p { color:#999; font-size:13px; margin-bottom:20px; }
        .menu-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(140px,1fr)); gap:12px; margin-top:16px; }
        .menu-item { background:#fff; border-radius:12px; padding:20px 12px; text-align:center; cursor:pointer; box-shadow:0 2px 8px rgba(0,0,0,0.04); transition:all 0.15s; border:none; }
        .menu-item:hover { transform:translateY(-2px); box-shadow:0 4px 16px rgba(0,0,0,0.08); }
        .menu-item .icon { font-size:32px; margin-bottom:8px; }
        .menu-item .label { font-size:12px; font-weight:600; color:#555; }
        .offcanvas-dojang { background:linear-gradient(180deg,#2e7d32,#1b5e20); color:#fff; }
        .offcanvas-dojang .offcanvas-header { border-bottom:1px solid rgba(255,255,255,0.1); }
        .offcanvas-dojang .offcanvas-title { color:#fff; font-weight:700; }
        .offcanvas-dojang .btn-close { filter:invert(1); }
        .offcanvas-dojang .nav-link { color:rgba(255,255,255,0.85); padding:12px 16px; border-radius:10px; margin:2px 0; font-size:14px; font-weight:500; transition:all 0.15s; }
        .offcanvas-dojang .nav-link:hover { background:rgba(255,255,255,0.1); color:#fff; }
        .info-card { background:#fff; border-radius:12px; padding:16px; margin-top:16px; box-shadow:0 2px 8px rgba(0,0,0,0.04); }
        .info-card .row { font-size:13px; padding:6px 0; border-bottom:1px solid #f5f5f5; }
        .info-card .row:last-child { border-bottom:none; }
        .info-card .label { color:#888; font-weight:600; }
        .info-card .value { color:#333; }
    </style>
</head>
<body>

<!-- TOPBAR -->
<div class="topbar">
    <div>
        <button class="topbar-btn" onclick="abrirMenu()">☰</button>
        <span class="brand ms-2"><?= htmlspecialchars($escuela['siglas'] ?: $escuela['nombre'] ?: '') ?> <small>· Poomsae</small></span>
    </div>
    <div>
        <span style="color:rgba(255,255,255,0.7);font-size:13px;margin-right:12px;"><?= htmlspecialchars($escuela['nombre'] ?? '') ?></span>
        <a href="<?= base_url('/logout') ?>" class="topbar-btn" title="Cerrar sesi&oacute;n">🚪</a>
    </div>
</div>

<!-- OFFCANVAS MENU -->
<div class="offcanvas offcanvas-start offcanvas-dojang" tabindex="-1" id="menuOffcanvas">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">☰ Men&uacute;</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-3">
        <div class="nav flex-column">
            <span style="color:rgba(255,255,255,0.4);font-size:11px;text-transform:uppercase;letter-spacing:1px;padding:8px 16px 4px;">Pr&oacute;ximamente</span>
            <a href="#" class="nav-link disabled" style="opacity:0.5;">👥 Participantes</a>
            <a href="#" class="nav-link disabled" style="opacity:0.5;">⚖️ Jueces</a>
            <a href="#" class="nav-link disabled" style="opacity:0.5;">🏆 Torneos</a>
        </div>
    </div>
</div>

<!-- CONTENT -->
<div class="content">
    <div class="welcome-card">
        <h1>👋 Bienvenido, <?= htmlspecialchars($escuela['nombre'] ?? '') ?></h1>
        <p>Panel de administraci&oacute;n de tu Dojang</p>

        <div class="menu-grid">
            <div class="menu-item">
                <div class="icon">👥</div>
                <div class="label">Participantes</div>
            </div>
            <div class="menu-item">
                <div class="icon">⚖️</div>
                <div class="label">Jueces</div>
            </div>
            <div class="menu-item">
                <div class="icon">🏆</div>
                <div class="label">Torneos</div>
            </div>
            <div class="menu-item" onclick="location.href='<?= base_url('/escuela') ?>'">
                <div class="icon">⚙️</div>
                <div class="label">Configuraci&oacute;n</div>
            </div>
        </div>
    </div>

    <div class="info-card">
        <h6 style="font-size:13px;font-weight:700;color:#2e7d32;margin-bottom:10px;">📋 Datos del Dojang</h6>
        <div class="row"><span class="label">Nombre:</span><span class="value"><?= htmlspecialchars($escuela['nombre'] ?? '') ?></span></div>
        <div class="row"><span class="label">Siglas:</span><span class="value"><?= htmlspecialchars($escuela['siglas'] ?? '') ?></span></div>
        <div class="row"><span class="label">Instructor:</span><span class="value"><?= htmlspecialchars($escuela['instructor_nombre'] ?? '') ?> (<?= htmlspecialchars($escuela['instructor_grado'] ?? '') ?>)</span></div>
        <div class="row"><span class="label">Ubicaci&oacute;n:</span><span class="value"><?= htmlspecialchars($escuela['ciudad'] ?? '') ?>, <?= htmlspecialchars($escuela['pais'] ?? '') ?></span></div>
        <div class="row"><span class="label">Correo:</span><span class="value"><?= htmlspecialchars($escuela['correo'] ?? '') ?></span></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
var menuOffcanvas;
document.addEventListener('DOMContentLoaded', function() {
    menuOffcanvas = new bootstrap.Offcanvas(document.getElementById('menuOffcanvas'));
});
function abrirMenu() { menuOffcanvas.show(); }
</script>
</body>
</html>
