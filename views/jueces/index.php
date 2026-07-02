<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover,user-scalable=no">
    <meta name="theme-color" content="#1b5e20">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>Jueces - <?= htmlspecialchars($escuela['siglas'] ?: $escuela['nombre']) ?></title>
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
        .search-box { position: relative; margin-bottom: 14px; }
        .search-box input { background: #fff; border: 2px solid #f0f0f0; border-radius: 14px; padding: 11px 16px 11px 40px; font-size: 14px; width: 100%; outline: none; }
        .search-box input:focus { border-color: #4caf50; box-shadow: 0 0 0 4px rgba(76,175,80,0.08); }
        .search-box .sicon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); font-size: 16px; opacity: 0.4; }
        .item-card { background: #fff; border-radius: 16px; padding: 14px 16px; margin-bottom: 8px; display: flex; align-items: center; gap: 12px; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
        .item-card:active { transform: scale(0.98); }
        .item-avatar { width: 44px; height: 44px; border-radius: 14px; background: linear-gradient(135deg, #fff3e0, #ffe0b2); display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
        .item-info { flex: 1; min-width: 0; }
        .item-name { font-size: 14px; font-weight: 700; color: #333; }
        .item-meta { font-size: 11px; color: #999; margin-top: 2px; display: flex; gap: 8px; flex-wrap: wrap; }
        .item-meta span { background: #f5f5f5; padding: 1px 8px; border-radius: 20px; }
        .empty-state { text-align: center; padding: 60px 20px; color: #ccc; }
        .empty-state .ei { font-size: 56px; margin-bottom: 12px; }
        .empty-state p { font-size: 14px; font-weight: 500; }
        .modal-content { border: none; border-radius: 20px; overflow: hidden; }
        .modal-header { background: linear-gradient(135deg, #1b5e20, #2e7d32); color: #fff; border: none; padding: 18px 20px; }
        .modal-header .btn-close { filter: invert(1); opacity: 0.6; }
        .modal-body { padding: 20px; }
        .modal-body .form-control { border-radius: 12px; padding: 11px 14px; border: 2px solid #f0f0f0; background: #fafafa; font-size: 14px; }
        .modal-body .form-control:focus { border-color: #4caf50; background: #fff; box-shadow: 0 0 0 4px rgba(76,175,80,0.08); }
        .modal-body .form-label { font-size: 10px; font-weight: 600; color: #999; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .btn-dojang { background: linear-gradient(135deg, #2e7d32, #4caf50); border: none; border-radius: 12px; padding: 12px; font-weight: 700; color: #fff; }
        .btn-dojang:active { transform: scale(0.97); }
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
        .pass-toggle { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; font-size: 16px; opacity: 0.4; cursor: pointer; padding: 4px; }
        .pass-wrap { position: relative; }
        @media (prefers-color-scheme: dark) {
            body { background: #1a1a2e; }
            .item-card { background: #16213e; }
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
        }
    </style>
</head>
<body>

<div class="topbar">
    <div class="topbar-brand">
        <div class="avatar">⚖️</div>
        <div><div class="name">Jueces</div><div class="sub"><?= count($jueces) ?> registrados</div></div>
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
        <h2>⚖️ Jueces</h2>
        <button class="btn-add" onclick="abrirModal()">+</button>
    </div>

    <div class="search-box">
        <span class="sicon">🔍</span>
        <input type="text" id="searchInput" placeholder="Buscar juez..." oninput="filtrar()">
    </div>

    <div id="listaContainer">
        <?php if (empty($jueces)): ?>
            <div class="empty-state">
                <div class="ei">⚖️</div>
                <p>No hay jueces registrados.<br>Toca + para agregar el primero.</p>
            </div>
        <?php else: ?>
            <?php foreach ($jueces as $j): ?>
                <div class="item-card" onclick="editar(<?= $j['id'] ?>)" data-search="<?= htmlspecialchars(strtolower($j['nombre'].' '.$j['apellido'].' '.$j['user'])) ?>">
                    <div class="item-avatar">⚖️</div>
                    <div class="item-info">
                        <div class="item-name"><?= htmlspecialchars($j['nombre'].' '.$j['apellido']) ?></div>
                        <div class="item-meta">
                            <span>👤 <?= htmlspecialchars($j['user']) ?></span>
                            <?php if ($j['ciudad']): ?><span>📍 <?= htmlspecialchars($j['ciudad']) ?></span><?php endif; ?>
                        </div>
                    </div>
                    <div style="color:#ccc;font-size:10px;">›</div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<div class="bottombar">
    <button class="nav-item" onclick="location.href='<?= base_url('/dashboard') ?>'"><span class="bi">🏠</span><span class="bl">Inicio</span></button>
    <button class="nav-item" onclick="location.href='<?= base_url('/participantes') ?>'"><span class="bi">👥</span><span class="bl">Alumnos</span></button>
    <button class="nav-item active"><span class="bi">⚖️</span><span class="bl">Jueces</span></button>
    <button class="nav-item" onclick="location.href='<?= base_url('/torneos') ?>'"><span class="bi">🏆</span><span class="bl">Torneos</span></button>
    <button class="nav-item" onclick="location.href='<?= base_url('/escuela') ?>'"><span class="bi">⚙️</span><span class="bl">Ajustes</span></button>
</div>

<div class="modal fade" id="juezModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalTitle">➕ Agregar Juez</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editId" value="0">
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="form-label">Nombre *</label>
                        <input type="text" id="fNombre" class="form-control" placeholder="Nombre" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Apellido *</label>
                        <input type="text" id="fApellido" class="form-control" placeholder="Apellido" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">👤 Usuario *</label>
                    <input type="text" id="fUser" class="form-control" placeholder="Nombre de usuario" required>
                </div>
                <div class="mb-3 pass-wrap">
                    <label class="form-label">🔑 Contrase&ntilde;a <span id="passLabel" style="color:#999;font-weight:400;text-transform:none;letter-spacing:0;">*</span></label>
                    <input type="password" id="fPass" class="form-control" placeholder="M&iacute;nimo 6 caracteres" style="padding-right:40px;">
                    <button class="pass-toggle" type="button" onclick="togglePass()">👁️</button>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="form-label">📞 Tel&eacute;fono</label>
                        <input type="text" id="fTelefono" class="form-control" placeholder="Opcional">
                    </div>
                    <div class="col-6">
                        <label class="form-label">📍 Ciudad</label>
                        <input type="text" id="fCiudad" class="form-control" placeholder="Ciudad">
                    </div>
                </div>
                <div class="d-flex gap-2 mt-4">
                    <button class="btn btn-dojang w-100" onclick="guardar()">💾 Guardar</button>
                    <button class="btn btn-danger-sm" id="btnEliminar" style="display:none;" onclick="eliminar()">🗑</button>
                </div>
                <div class="mt-2" style="font-size:11px;color:#bbb;text-align:center;">Los jueces pueden iniciar sesi&oacute;n para evaluar torneos.</div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
var modal, menuOffcanvas;

document.addEventListener('DOMContentLoaded', function() {
    modal = new bootstrap.Modal(document.getElementById('juezModal'));
    menuOffcanvas = new bootstrap.Offcanvas(document.getElementById('menuOffcanvas'));
});

function abrirMenu() { menuOffcanvas.show(); }

function abrirModal() {
    document.getElementById('modalTitle').textContent = '➕ Agregar Juez';
    document.getElementById('editId').value = '0';
    document.getElementById('btnEliminar').style.display = 'none';
    document.getElementById('passLabel').textContent = '*';
    document.getElementById('fPass').required = true;
    document.getElementById('fPass').value = '';
    ['fNombre','fApellido','fUser','fTelefono','fCiudad'].forEach(function(id) {
        document.getElementById(id).value = '';
    });
    modal.show();
}

function editar(id) {
    fetch('<?= base_url('/jueces/obtener') ?>?id=' + id)
    .then(r => r.json())
    .then(d => {
        if (d.success === false) { alert(d.message); return; }
        document.getElementById('modalTitle').textContent = '✏️ Editar Juez';
        document.getElementById('editId').value = d.id;
        document.getElementById('fNombre').value = d.nombre || '';
        document.getElementById('fApellido').value = d.apellido || '';
        document.getElementById('fUser').value = d.user || '';
        document.getElementById('fPass').value = '';
        document.getElementById('fPass').required = false;
        document.getElementById('passLabel').textContent = '(dejar vac&iacute;o para mantener)';
        document.getElementById('fTelefono').value = d.telefono || '';
        document.getElementById('fCiudad').value = d.ciudad || '';
        document.getElementById('btnEliminar').style.display = 'block';
        modal.show();
    });
}

function guardar() {
    var id = document.getElementById('editId').value;
    var data = new URLSearchParams();
    data.append('nombre', document.getElementById('fNombre').value);
    data.append('apellido', document.getElementById('fApellido').value);
    data.append('user', document.getElementById('fUser').value);
    data.append('pass', document.getElementById('fPass').value);
    data.append('telefono', document.getElementById('fTelefono').value);
    data.append('ciudad', document.getElementById('fCiudad').value);

    if (id !== '0') data.append('id', id);
    var url = id === '0' ? '<?= base_url('/jueces/guardar') ?>' : '<?= base_url('/jueces/actualizar') ?>';

    fetch(url, { method: 'POST', body: data })
    .then(r => r.json())
    .then(d => {
        if (d.success) { modal.hide(); location.reload(); }
        else alert(d.message);
    });
}

function eliminar() {
    if (!confirm('¿Eliminar este juez?')) return;
    var id = document.getElementById('editId').value;
    var data = new URLSearchParams();
    data.append('id', id);
    fetch('<?= base_url('/jueces/eliminar') ?>', { method: 'POST', body: data })
    .then(r => r.json())
    .then(d => {
        if (d.success) { modal.hide(); location.reload(); }
        else alert(d.message);
    });
}

function togglePass() {
    var p = document.getElementById('fPass');
    p.type = p.type === 'password' ? 'text' : 'password';
}

function filtrar() {
    var q = document.getElementById('searchInput').value.toLowerCase();
    document.querySelectorAll('.item-card').forEach(function(el) {
        el.style.display = el.getAttribute('data-search').includes(q) ? 'flex' : 'none';
    });
}
</script>
</body>
</html>
