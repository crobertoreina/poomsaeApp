<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover,user-scalable=no">
    <meta name="theme-color" content="#1b5e20">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>Participantes - <?= htmlspecialchars($escuela['siglas'] ?: $escuela['nombre']) ?></title>
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
        .topbar-btn { width: 36px; height: 36px; background: rgba(255,255,255,0.08); border: none; border-radius: 10px; color: #fff; font-size: 18px; display: flex; align-items: center; justify-content: center; transition: all .15s; }
        .topbar-btn:active { background: rgba(255,255,255,0.18); transform: scale(0.92); }
        .content { max-width: 600px; margin: 0 auto; padding: 16px; }
        .section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
        .section-header h2 { font-size: 18px; font-weight: 800; color: #1b5e20; margin: 0; }
        .btn-add { width: 38px; height: 38px; background: #4caf50; border: none; border-radius: 12px; color: #fff; font-size: 20px; display: flex; align-items: center; justify-content: center; transition: all .15s; }
        .btn-add:active { transform: scale(0.9); }
        .search-box { position: relative; margin-bottom: 14px; }
        .search-box input { background: #fff; border: 2px solid #f0f0f0; border-radius: 14px; padding: 11px 16px 11px 40px; font-size: 14px; width: 100%; outline: none; transition: all .15s; }
        .search-box input:focus { border-color: #4caf50; box-shadow: 0 0 0 4px rgba(76,175,80,0.08); }
        .search-box .sicon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); font-size: 16px; opacity: 0.4; }
        .participant-item { background: #fff; border-radius: 16px; padding: 14px 16px; margin-bottom: 8px; display: flex; align-items: center; gap: 12px; cursor: pointer; transition: all .15s; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
        .participant-item:active { transform: scale(0.98); }
        .p-avatar { width: 44px; height: 44px; border-radius: 14px; background: linear-gradient(135deg, #e8f5e9, #c8e6c9); display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
        .p-info { flex: 1; min-width: 0; }
        .p-name { font-size: 14px; font-weight: 700; color: #333; }
        .p-meta { font-size: 11px; color: #999; margin-top: 2px; display: flex; gap: 8px; flex-wrap: wrap; }
        .p-meta span { background: #f5f5f5; padding: 1px 8px; border-radius: 20px; }
        .empty-state { text-align: center; padding: 60px 20px; color: #ccc; }
        .empty-state .ei { font-size: 56px; margin-bottom: 12px; }
        .empty-state p { font-size: 14px; font-weight: 500; }
        .modal-content { border: none; border-radius: 20px; overflow: hidden; }
        .modal-header { background: linear-gradient(135deg, #1b5e20, #2e7d32); color: #fff; border: none; padding: 18px 20px; }
        .modal-header .btn-close { filter: invert(1); opacity: 0.6; }
        .modal-body { padding: 20px; }
        .modal-body .form-control, .modal-body .form-select { border-radius: 12px; padding: 11px 14px; border: 2px solid #f0f0f0; background: #fafafa; font-size: 14px; transition: all .15s; }
        .modal-body .form-control:focus, .modal-body .form-select:focus { border-color: #4caf50; background: #fff; box-shadow: 0 0 0 4px rgba(76,175,80,0.08); }
        .modal-body .form-label { font-size: 10px; font-weight: 600; color: #999; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
        .btn-dojang { background: linear-gradient(135deg, #2e7d32, #4caf50); border: none; border-radius: 12px; padding: 12px; font-weight: 700; color: #fff; transition: all .15s; }
        .btn-dojang:hover { transform: translateY(-1px); box-shadow: 0 4px 16px rgba(76,175,80,0.3); }
        .btn-dojang:active { transform: scale(0.97); }
        .btn-danger-sm { border: none; border-radius: 10px; padding: 8px 14px; font-size: 12px; font-weight: 600; background: #fff0f0; color: #d32f2f; transition: all .15s; }
        .btn-danger-sm:active { background: #ffcdd2; }
        .sex-badge { display: inline-flex; align-items: center; justify-content: center; width: 20px; height: 20px; border-radius: 50%; font-size: 11px; font-weight: 700; }
        .sex-badge.M { background: #e3f2fd; color: #1565c0; }
        .sex-badge.F { background: #fce4ec; color: #c62828; }
        .belt-dot { display: inline-block; width: 12px; height: 12px; border-radius: 50%; border: 1px solid rgba(0,0,0,0.1); vertical-align: middle; margin-right: 3px; }
        .bottombar { position: fixed; bottom: 0; left: 0; right: 0; background: #fff; border-top: 1px solid #f0f0f0; padding: 6px 0; padding-bottom: max(6px, env(safe-area-inset-bottom, 6px)); display: flex; justify-content: space-around; z-index: 100; box-shadow: 0 -2px 12px rgba(0,0,0,0.04); }
        .bottombar .nav-item { text-decoration: none; display: flex; flex-direction: column; align-items: center; gap: 1px; padding: 4px 12px; border-radius: 12px; transition: all .15s; border: none; background: none; cursor: pointer; }
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
        .toast-container { position: fixed; top: 16px; right: 16px; z-index: 9999; }
        #belOptions div:hover { background:#f5f5f5; }
        @media (prefers-color-scheme: dark) {
            body { background: #1a1a2e; }
            .participant-item { background: #16213e; }
            .p-name { color: #e0e0e0; }
            .search-box input { background: #16213e; border-color: #2a2a4e; color: #e0e0e0; }
            .search-box input:focus { border-color: #4caf50; background: #1a1a2e; }
            .section-header h2 { color: #66bb6a; }
            .modal-body .form-control, .modal-body .form-select { background: #1a1a2e; border-color: #2a2a4e; color: #e0e0e0; }
            .modal-body .form-control:focus, .modal-body .form-select:focus { border-color: #4caf50; background: #16213e; }
            .bottombar { background: #16213e; border-color: #2a2a4e; }
            .bottombar .nav-item:active { background: #1a1a2e; }
            .bottombar .bl { color: #888; }
            .bottombar .nav-item.active .bl { color: #66bb6a; }
            .btn-danger-sm { background: #3e1a1a; color: #ef5350; }
            .btn-danger-sm:active { background: #4e2a2a; }
            .sex-badge.M { background: #1a3a5e; color: #64b5f6; }
            .sex-badge.F { background: #3e1a2e; color: #f06292; }
            #belCustom { background: #16213e !important; border-color: #2a2a4e !important; }
            #belCustom #belText { color: #e0e0e0 !important; }
            #belOptions { background: #16213e !important; border-color: #2a2a4e !important; }
            #belOptions div:hover { background: #1a1a2e !important; }
        }
    </style>
</head>
<body>

<div class="topbar">
    <div class="topbar-brand">
        <div class="avatar">👥</div>
        <div><div class="name">Participantes</div><div class="sub"><?= count($participantes) ?> registrados</div></div>
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
        <a href="#" class="nav-link"><span class="ni">⚖️</span> Jueces</a>
        <a href="#" class="nav-link"><span class="ni">🏆</span> Torneos</a>
        <div class="hr"></div>
        <a href="<?= base_url('/escuela') ?>" class="nav-link"><span class="ni">⚙️</span> Configuraci&oacute;n</a>
        <a href="<?= base_url('/logout') ?>" class="nav-link"><span class="ni">🚪</span> Cerrar Sesi&oacute;n</a>
    </div>
</div>

<div class="content">
    <div class="section-header">
        <h2>👥 Participantes</h2>
        <button class="btn-add" onclick="abrirModal()">+</button>
    </div>

    <div class="search-box">
        <span class="sicon">🔍</span>
        <input type="text" id="searchInput" placeholder="Buscar por nombre o cintur&oacute;n..." oninput="filtrar()">
    </div>

    <div id="listaContainer">
        <?php if (empty($participantes)): ?>
            <div class="empty-state">
                <div class="ei">🥋</div>
                <p>No hay participantes a&uacute;n.<br>Toca + para agregar el primero.</p>
            </div>
        <?php else: ?>
            <?php foreach ($participantes as $p): ?>
                <div class="participant-item" onclick="editar(<?= $p['id'] ?>)" data-search="<?= htmlspecialchars(strtolower($p['nombre'].' '.$p['apellido'].' '.($p['cinturon']??'').' '.($p['grado']??''))) ?>">
                    <div class="p-avatar">🥋</div>
                    <div class="p-info">
                        <div class="p-name"><?= htmlspecialchars($p['nombre'].' '.$p['apellido']) ?></div>
                        <div class="p-meta">
                            <?php if ($p['sexo']): ?><span><span class="sex-badge <?= $p['sexo'] ?>"><?= $p['sexo'] ?></span></span><?php endif; ?>
                            <?php if ($p['cinturon']):
                                $cinturonParts = preg_split('/[\/\-]/', $p['cinturon']);
                                $isCompound = count($cinturonParts) === 2;
                                $c1 = beltColor($cinturonParts[0]);
                                $c2 = $isCompound ? beltColor($cinturonParts[1]) : null;
                            ?><span><?php if ($isCompound): ?><span class="belt-dot" style="background:<?= $c1 ?>"></span><span class="belt-dot" style="background:<?= $c2 ?>;margin-left:-4px;"></span><?php else: ?><span class="belt-dot" style="background:<?= $c1 ?>"></span><?php endif; ?></span><?php endif; ?>
                            <?php if ($p['edad']): ?><span>🎂 <?= (int)$p['edad'] ?>a</span><?php endif; ?>
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
    <button class="nav-item active"><span class="bi">👥</span><span class="bl">Alumnos</span></button>
    <button class="nav-item" onclick="aviso('jueces')"><span class="bi">⚖️</span><span class="bl">Jueces</span></button>
    <button class="nav-item" onclick="aviso('torneos')"><span class="bi">🏆</span><span class="bl">Torneos</span></button>
    <button class="nav-item" onclick="location.href='<?= base_url('/escuela') ?>'"><span class="bi">⚙️</span><span class="bl">Ajustes</span></button>
</div>

<div class="modal fade" id="participanteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalTitle">➕ Agregar Participante</h5>
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
                <div class="row g-3 mb-3">
                    <div class="col-4">
                        <label class="form-label">Sexo</label>
                        <select id="fSexo" class="form-select">
                            <option value="">—</option>
                            <option value="M">👦 Masculino</option>
                            <option value="F">👧 Femenino</option>
                        </select>
                    </div>
                    <div class="col-4">
                        <label class="form-label">Edad</label>
                        <input type="number" id="fEdad" class="form-control" placeholder="Edad">
                    </div>
                    <div class="col-4">
                        <label class="form-label">Fecha Nac.</label>
                        <input type="date" id="fFechaNac" class="form-control">
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-4">
                        <label class="form-label">Peso (kg)</label>
                        <input type="number" step="0.01" id="fPeso" class="form-control" placeholder="0.00">
                    </div>
                    <div class="col-4">
                        <label class="form-label">Estatura (m)</label>
                        <input type="number" step="0.01" id="fEstatura" class="form-control" placeholder="0.00">
                    </div>
                    <div class="col-4">
                        <label class="form-label">Categor&iacute;a</label>
                        <select id="fCategoria" class="form-select">
                            <option value="">—</option>
                            <?php foreach ($categorias as $cat): ?>
                            <option value="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="form-label">Grado</label>
                        <select id="fGrado" class="form-select">
                            <option value="">—</option>
                            <?php foreach ($grados as $g): ?>
                            <option value="<?= htmlspecialchars($g) ?>"><?= htmlspecialchars($g) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Cintur&oacute;n</label>
                        <div class="position-relative">
                            <select id="fIdCinturon" class="form-select" style="display:none;">
                                <option value="">—</option>
                                <?php foreach ($cinturones as $c): ?>
                                <option value="<?= $c['idCinturon'] ?>" data-colors="<?= htmlspecialchars(beltColorsAttr($c['nombre'])) ?>"><?= htmlspecialchars($c['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="d-flex align-items-center gap-2 form-control" id="belCustom" style="cursor:pointer;border-radius:12px;padding:8px 14px;border:2px solid #f0f0f0;background:#fafafa;font-size:14px;user-select:none;" onclick="customDrop()">
                                <span id="belPreview" class="d-inline-flex align-items-center" style="min-width:24px;height:20px;"><span class="belt-dot" style="width:20px;height:20px;background:#eee;border:2px solid #ddd;"></span></span>
                                <span id="belText" style="flex:1;color:#999;">—</span>
                                <span style="color:#ccc;font-size:10px;">▼</span>
                            </div>
                            <div id="belOptions" class="position-absolute w-100" style="display:none;z-index:999;background:#fff;border:2px solid #f0f0f0;border-radius:12px;max-height:200px;overflow-y:auto;box-shadow:0 4px 20px rgba(0,0,0,0.08);margin-top:2px;">
                                <?php foreach ($cinturones as $c):
                                    $bca = beltColorsAttr($c['nombre']);
                                    $bcParts = explode('|', $bca);
                                ?>
                                <div class="d-flex align-items-center gap-2 px-3 py-2" style="cursor:pointer;font-size:14px;" onclick="selCustom(<?= $c['idCinturon'] ?>)" onmouseenter="this.style.background='#f5f5f5'" onmouseleave="this.style.background=''">
                                    <?php if (count($bcParts) === 2): ?>
                                    <span class="belt-dot" style="background:<?= $bcParts[0] ?>;width:16px;height:16px;flex-shrink:0;"></span>
                                    <span class="belt-dot" style="background:<?= $bcParts[1] ?>;width:16px;height:16px;flex-shrink:0;margin-left:-8px;"></span>
                                    <?php else: ?>
                                    <span class="belt-dot" style="background:<?= $bcParts[0] ?>;width:16px;height:16px;flex-shrink:0;"></span>
                                    <?php endif; ?>
                                    <span><?= htmlspecialchars($c['nombre']) ?></span>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Correo</label>
                    <input type="email" id="fCorreo" class="form-control" placeholder="correo@ejemplo.com">
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="form-label">Tel&eacute;fono</label>
                        <input type="text" id="fTelefono" class="form-control" placeholder="Opcional">
                    </div>
                    <div class="col-6">
                        <label class="form-label">Ciudad</label>
                        <input type="text" id="fCiudad" class="form-control" placeholder="Ciudad">
                    </div>
                </div>
                <div class="d-flex gap-2 mt-4">
                    <button class="btn btn-dojang w-100" onclick="guardar()">💾 Guardar</button>
                    <button class="btn btn-danger-sm" id="btnEliminar" style="display:none;" onclick="eliminar()">🗑</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
var modal, menuOffcanvas, _customOpen = false;

document.addEventListener('DOMContentLoaded', function() {
    modal = new bootstrap.Modal(document.getElementById('participanteModal'));
    menuOffcanvas = new bootstrap.Offcanvas(document.getElementById('menuOffcanvas'));
    document.getElementById('participanteModal').addEventListener('hidden.bs.modal', function() {
        document.getElementById('belOptions').style.display = 'none';
        _customOpen = false;
    });
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#belCustom') && !e.target.closest('#belOptions')) {
            document.getElementById('belOptions').style.display = 'none';
            _customOpen = false;
        }
    });
});

function abrirMenu() { menuOffcanvas.show(); }

function abrirModal() {
    document.getElementById('modalTitle').textContent = '➕ Agregar Participante';
    document.getElementById('editId').value = '0';
    document.getElementById('btnEliminar').style.display = 'none';
    ['fNombre','fApellido','fSexo','fEdad','fFechaNac','fPeso','fEstatura','fCategoria','fGrado','fCorreo','fTelefono','fCiudad'].forEach(function(id) {
        var el = document.getElementById(id);
        if (el) el.value = '';
    });
    resetCustomBelt();
    modal.show();
}

function editar(id) {
    fetch('<?= base_url('/participantes/obtener') ?>?id=' + id)
    .then(r => r.json())
    .then(d => {
        if (d.success === false) { alert(d.message); return; }
        document.getElementById('modalTitle').textContent = '✏️ Editar Participante';
        document.getElementById('editId').value = d.id;
        document.getElementById('fNombre').value = d.nombre || '';
        document.getElementById('fApellido').value = d.apellido || '';
        document.getElementById('fSexo').value = d.sexo || '';
        document.getElementById('fEdad').value = d.edad || '';
        document.getElementById('fFechaNac').value = d.fecha_nacimiento || '';
        document.getElementById('fPeso').value = d.peso || '';
        document.getElementById('fEstatura').value = d.estatura || '';
        document.getElementById('fCategoria').value = d.categoria || '';
        matchGrado(d.grado || '');
        setCustomBelt(d.id_cinturon, d.cinturon || '');
        document.getElementById('fCorreo').value = d.correo || '';
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
    data.append('sexo', document.getElementById('fSexo').value);
    data.append('edad', document.getElementById('fEdad').value);
    data.append('fecha_nacimiento', document.getElementById('fFechaNac').value);
    data.append('peso', document.getElementById('fPeso').value);
    data.append('estatura', document.getElementById('fEstatura').value);
    data.append('categoria', document.getElementById('fCategoria').value);
    data.append('grado', document.getElementById('fGrado').value);
    var sel = document.getElementById('fIdCinturon');
    data.append('id_cinturon', sel.value);
    data.append('cinturon', sel.options[sel.selectedIndex] ? sel.options[sel.selectedIndex].text : '');
    data.append('correo', document.getElementById('fCorreo').value);
    data.append('telefono', document.getElementById('fTelefono').value);
    data.append('ciudad', document.getElementById('fCiudad').value);

    var url = id === '0' ? '<?= base_url('/participantes/guardar') ?>' : '<?= base_url('/participantes/actualizar') ?>';
    if (id !== '0') data.append('id', id);

    fetch(url, { method: 'POST', body: data })
    .then(r => r.json())
    .then(d => {
        if (d.success) { modal.hide(); location.reload(); }
        else alert(d.message);
    });
}

function eliminar() {
    if (!confirm('¿Eliminar este participante?')) return;
    var id = document.getElementById('editId').value;
    var data = new URLSearchParams();
    data.append('id', id);
    fetch('<?= base_url('/participantes/eliminar') ?>', { method: 'POST', body: data })
    .then(r => r.json())
    .then(d => {
        if (d.success) { modal.hide(); location.reload(); }
        else alert(d.message);
    });
}

function filtrar() {
    var q = document.getElementById('searchInput').value.toLowerCase();
    document.querySelectorAll('.participant-item').forEach(function(el) {
        el.style.display = el.getAttribute('data-search').includes(q) ? 'flex' : 'none';
    });
}

function resetCustomBelt() {
    document.getElementById('fIdCinturon').value = '';
    document.getElementById('belPreview').innerHTML = '<span class="belt-dot" style="width:20px;height:20px;background:#eee;border:2px solid #ddd;"></span>';
    document.getElementById('belText').textContent = '—';
    document.getElementById('belText').style.color = '#999';
    document.getElementById('belOptions').style.display = 'none';
    _customOpen = false;
}

function setCustomBelt(id, texto) {
    var sel = document.getElementById('fIdCinturon');
    if (id) {
        sel.value = id;
    }
    var idx = sel.selectedIndex;
    if (idx < 1 && texto) {
        var t = texto.replace(/[\/\-]/g, '').toLowerCase();
        for (var i = 1; i < sel.options.length; i++) {
            if (sel.options[i].text.replace(/[\/\-]/g, '').toLowerCase() === t) {
                sel.value = sel.options[i].value;
                idx = i;
                break;
            }
        }
    }
    if (idx >= 1) {
        var opt = sel.options[idx];
        var colors = opt.getAttribute('data-colors');
        var parts = colors ? colors.split('|') : [];
        var html = parts.length === 2
            ? '<span class="belt-dot" style="background:'+parts[0]+';width:20px;height:20px;"></span><span class="belt-dot" style="background:'+parts[1]+';width:20px;height:20px;margin-left:-6px;"></span>'
            : '<span class="belt-dot" style="background:'+parts[0]+';width:20px;height:20px;"></span>';
        document.getElementById('belPreview').innerHTML = html;
        document.getElementById('belText').textContent = opt.text;
        document.getElementById('belText').style.color = '#333';
    } else {
        resetCustomBelt();
    }
}

function customDrop() {
    var o = document.getElementById('belOptions');
    _customOpen = !_customOpen;
    o.style.display = _customOpen ? 'block' : 'none';
}

function selCustom(id) {
    document.getElementById('fIdCinturon').value = id;
    setCustomBelt(id, '');
    document.getElementById('belOptions').style.display = 'none';
    _customOpen = false;
}

function matchGrado(texto) {
    var sel = document.getElementById('fGrado');
    if (!texto) { sel.value = ''; return; }
    for (var i = 0; i < sel.options.length; i++) {
        if (sel.options[i].text.toLowerCase() === texto.toLowerCase()) {
            sel.value = sel.options[i].value;
            return;
        }
    }
    for (var i = 0; i < sel.options.length; i++) {
        if (sel.options[i].text.toLowerCase().includes(texto.toLowerCase()) || texto.toLowerCase().includes(sel.options[i].text.toLowerCase())) {
            sel.value = sel.options[i].value;
            return;
        }
    }
    sel.value = '';
}

function aviso(s) {
    if (s === 'config') { location.href = '<?= base_url('/escuela') ?>'; return; }
    alert('🔧 Módulo de ' + s + ' en construcción. ¡Próximamente!');
}
</script>
</body>
</html>
