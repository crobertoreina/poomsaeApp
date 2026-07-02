<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover,user-scalable=no">
    <meta name="theme-color" content="#1b237e">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>Evaluaci&oacute;n - <?= htmlspecialchars($_SESSION['juez_nombre'] ?? 'Juez') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * { -webkit-tap-highlight-color: transparent; user-select: none; }
        body { background: #0a0a23; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; min-height: 100vh; min-height: 100dvh; color: #fff; }
        .topbar { background: linear-gradient(135deg, #1a237e, #283593); padding: 12px 16px; padding-top: max(12px, env(safe-area-inset-top, 12px)); display: flex; align-items: center; justify-content: space-between; }
        .topbar .title { font-size: 16px; font-weight: 700; }
        .topbar .sub { font-size: 11px; opacity: 0.6; }
        .content { max-width: 500px; margin: 0 auto; padding: 16px; }
        .item-card { background: #1a1a3e; border-radius: 16px; padding: 14px 16px; margin-bottom: 8px; display: flex; align-items: center; gap: 12px; cursor: pointer; }
        .item-card:active { transform: scale(0.98); background: #2a2a5e; }
        .item-avatar { width: 44px; height: 44px; border-radius: 14px; background: rgba(255,255,255,0.08); display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
        .item-info { flex: 1; min-width: 0; }
        .item-name { font-size: 15px; font-weight: 700; }
        .item-meta { font-size: 11px; opacity: 0.5; margin-top: 2px; display: flex; gap: 8px; flex-wrap: wrap; }
        .item-state { font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 20px; }
        .state-borrador { background: #37474f; color: #90a4ae; }
        .state-curso { background: #1b5e20; color: #81c784; }
        .state-finalizado { background: #4a148c; color: #ce93d8; }
        .empty-state { text-align: center; padding: 60px 20px; opacity: 0.4; }
        .empty-state .ei { font-size: 56px; margin-bottom: 12px; }
        .empty-state p { font-size: 14px; }
        .btn-logout { background: rgba(255,255,255,0.08); border: none; border-radius: 10px; color: #fff; font-size: 13px; padding: 6px 12px; }
        .btn-back { background: rgba(255,255,255,0.08); border: none; border-radius: 10px; color: #fff; font-size: 16px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; }
        .btn-puntaje { flex: 1; padding: 20px; border: none; border-radius: 16px; font-size: 24px; font-weight: 800; cursor: pointer; transition: transform 0.1s; }
        .btn-puntaje:active { transform: scale(0.95); }
        .btn-puntaje.positivo { background: #1b5e20; color: #81c784; }
        .btn-puntaje.negativo { background: #b71c1c; color: #ef9a9a; }
        .slider-row { margin-bottom:14px; }
        .slider-label { font-size:11px;font-weight:600;opacity:0.6;margin-bottom:2px; }
        .slider-val { font-size:16px;font-weight:800;text-align:right;margin-bottom:2px;color:#4caf50; }
        .slider-input { width:100%;height:6px;-webkit-appearance:none;appearance:none;background:#2a2a4e;border-radius:3px;outline:none; }
        .slider-input::-webkit-slider-thumb { -webkit-appearance:none;appearance:none;width:20px;height:20px;border-radius:50%;background:#4caf50;cursor:pointer;border:2px solid #1a1a2e; }
        .slider-input::-moz-range-thumb { width:20px;height:20px;border-radius:50%;background:#4caf50;cursor:pointer;border:2px solid #1a1a2e; }
        .btn-guardar { width: 100%; padding: 16px; border: none; border-radius: 16px; background: linear-gradient(135deg, #1a237e, #283593); color: #fff; font-size: 18px; font-weight: 700; cursor: pointer; }
        .btn-guardar:active { transform: scale(0.97); }
        @media (prefers-color-scheme: light) {
            body { background: #f5f5f5; color: #333; }
            .topbar { background: linear-gradient(135deg, #1a237e, #283593); }
            .topbar .title { color: #fff; }
            .item-card { background: #fff; color: #333; }
            .item-card:active { background: #f0f0f0; }
            .item-meta { opacity: 0.6; }
            .btn-puntaje.positivo { background: #e8f5e9; color: #2e7d32; }
            .btn-puntaje.negativo { background: #ffebee; color: #c62828; }
            .slider-input { background:#ddd; }
            .slider-input::-webkit-slider-thumb { border-color:#fff; }
            .btn-guardar { background: linear-gradient(135deg, #283593, #3949ab); }
        }
    </style>
</head>
<body>

<div class="topbar">
    <div>
        <div class="title">⚖️ Evaluaci&oacute;n</div>
        <div class="sub"><?= htmlspecialchars($_SESSION['juez_nombre'] ?? '') ?></div>
    </div>
    <a href="<?= base_url('/logout') ?>" class="btn-logout" style="text-decoration:none;">🚪 Salir</a>
</div>

<div class="content">
    <div id="listaTorneos">
        <?php if (empty($torneos)): ?>
            <div class="empty-state">
                <div class="ei">🏆</div>
                <p>No tienes torneos asignados.</p>
            </div>
        <?php else: ?>
            <?php foreach ($torneos as $t):
                $habilitado = $t['estado'] == 1;
            ?>
                <div class="item-card" onclick="<?= $habilitado ? "abrirTorneo({$t['idTorneo']})" : '' ?>" style="<?= !$habilitado ? 'opacity:0.5;cursor:default;' : '' ?>">
                    <div class="item-avatar"><?= $t['estado'] == 2 ? '🏁' : ($habilitado ? '🏆' : '🔒') ?></div>
                    <div class="item-info">
                        <div class="item-name"><?= htmlspecialchars($t['nombre']) ?></div>
                        <div class="item-meta">
                            <span>📅 <?= htmlspecialchars($t['fecha']) ?></span>
                            <?php if ($t['ciudad']): ?><span>📍 <?= htmlspecialchars($t['ciudad']) ?></span><?php endif; ?>
                            <span>Por <?= htmlspecialchars($t['creador_siglas'] ?: $t['creador_nombre']) ?></span>
                        </div>
                        <div style="margin-top:4px;">
                            <?php $estados = ['🔒 Borrador', '▶ En curso', '🏁 Finalizado']; ?>
                            <?php $cls = ['state-borrador', 'state-curso', 'state-finalizado']; ?>
                            <span class="item-state <?= $cls[$t['estado']] ?? $cls[0] ?>"><?= $estados[$t['estado']] ?? 'Desconocido' ?></span>
                        </div>
                    </div>
                    <div style="opacity:0.3;font-size:14px;">›</div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div id="listaParticipantes" style="display:none;">
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px;">
            <button class="btn-back" onclick="volverLista()">‹</button>
            <div>
                <div style="font-size:16px;font-weight:700;" id="torneoNombre"></div>
                <div style="font-size:11px;opacity:0.5;" id="torneoMeta"></div>
            </div>
        </div>
        <div id="participantesContainer"></div>
    </div>

    <div id="evaluacionScreen" style="display:none;">
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px;">
            <button class="btn-back" onclick="volverParticipantes()">‹</button>
            <div>
                <div style="font-size:16px;font-weight:700;" id="evalParticipanteNombre"></div>
                <div style="font-size:11px;opacity:0.5;" id="evalParticipanteInfo"></div>
            </div>
        </div>
        <div style="text-align:center;padding:20px 0;">
            <div id="puntosDisplay" style="font-size:96px;font-weight:900;color:#4caf50;line-height:1;font-variant-numeric:tabular-nums;">4.0</div>
            <div style="font-size:13px;opacity:0.4;margin-top:4px;">Presentación</div>
        </div>
        <div style="display:flex;gap:12px;margin-bottom:12px;">
            <button class="btn-puntaje positivo" onclick="ajustarPuntaje(0.1)">+0.1</button>
            <button class="btn-puntaje positivo" onclick="ajustarPuntaje(0.3)">+0.3</button>
        </div>
        <div style="display:flex;gap:12px;margin-bottom:20px;">
            <button class="btn-puntaje negativo" onclick="ajustarPuntaje(-0.1)">-0.1</button>
            <button class="btn-puntaje negativo" onclick="ajustarPuntaje(-0.3)">-0.3</button>
        </div>

        <div style="border-top:1px solid rgba(255,255,255,0.1);padding-top:16px;margin-bottom:16px;">
            <div class="slider-row">
                <div class="slider-label">Fuerza / Velocidad</div>
                <div class="slider-val" id="fvDisplay">0.0</div>
                <input type="range" min="0" max="2" step="0.1" value="0" class="slider-input" id="fvSlider" oninput="actualizarSlider('fv')">
                <div style="display:flex;justify-content:space-between;font-size:9px;opacity:0.3;padding:0 2px;"><span>0</span><span>2</span></div>
            </div>
            <div class="slider-row">
                <div class="slider-label">Ritmo / Tiempo</div>
                <div class="slider-val" id="rtDisplay">0.0</div>
                <input type="range" min="0" max="2" step="0.1" value="0" class="slider-input" id="rtSlider" oninput="actualizarSlider('rt')">
                <div style="display:flex;justify-content:space-between;font-size:9px;opacity:0.3;padding:0 2px;"><span>0</span><span>2</span></div>
            </div>
            <div class="slider-row">
                <div class="slider-label">Expresión de la Energía</div>
                <div class="slider-val" id="eeDisplay">0.0</div>
                <input type="range" min="0" max="2" step="0.1" value="0" class="slider-input" id="eeSlider" oninput="actualizarSlider('ee')">
                <div style="display:flex;justify-content:space-between;font-size:9px;opacity:0.3;padding:0 2px;"><span>0</span><span>2</span></div>
            </div>
        </div>

        <div style="text-align:center;font-size:18px;font-weight:800;margin-bottom:16px;color:#fff;" id="totalDisplay">Total: 4.0 / 10</div>

        <button class="btn-guardar" onclick="guardarPuntaje()">💾 Guardar Resultado</button>
        <div id="evalFeedback" style="text-align:center;font-size:13px;margin-top:10px;min-height:20px;"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
var currentTorneoId = 0;
var currentParticipanteId = 0;
var currentCategoriaId = 0;
var puntajeActual = 4.0;
var fvActual = 0;
var rtActual = 0;
var eeActual = 0;
var participantesData = [];
var puntajesGuardados = {};

function abrirTorneo(id) {
    currentTorneoId = id;
    document.getElementById('listaTorneos').style.display = 'none';
    document.getElementById('listaParticipantes').style.display = 'block';
    document.getElementById('participantesContainer').innerHTML = '<div style="text-align:center;padding:40px;opacity:0.4;">Cargando...</div>';
    fetch('<?= base_url('/evaluacion/torneo') ?>?id=' + id)
    .then(r => r.json())
    .then(d => {
        if (!d.success) { alert(d.message); volverLista(); return; }
        var t = d.torneo;
        document.getElementById('torneoNombre').textContent = '🏆 ' + t.nombre;
        document.getElementById('torneoMeta').textContent = (t.ciudad || '') + ' · ' + (t.fecha || '');
        participantesData = d.participantes || [];
        puntajesGuardados = d.puntajes || {};
        renderParticipantes();
    });
}

function renderParticipantes() {
    var container = document.getElementById('participantesContainer');
    if (participantesData.length === 0) {
        container.innerHTML = '<div style="text-align:center;padding:40px;opacity:0.4;">Sin participantes.</div>';
        return;
    }
    var html = '';
    var lastCat = '';
    participantesData.forEach(function(p) {
        var catNombre = p.categoria_nombre || 'Sin categor\u00eda';
        if (catNombre !== lastCat) {
            if (lastCat !== '') html += '</div>';
            var catSexo = p.categoria_sexo === 'M' ? '♂' : p.categoria_sexo === 'F' ? '♀' : '⚥';
            html += '<div style="font-size:12px;font-weight:700;opacity:0.5;margin:12px 0 6px;text-transform:uppercase;letter-spacing:1px;">' + htmlspecialchars(catNombre) + ' ' + catSexo + '</div>';
            lastCat = catNombre;
            html += '<div style="display:flex;flex-wrap:wrap;gap:6px;margin-bottom:8px;">';
        }
        var puntaje = puntajesGuardados[p.id];
        var puntajeStr = puntaje ? puntaje.puntaje.toFixed(1) : '—';
        var sexoIcon = p.sexo === 'M' ? '♂' : p.sexo === 'F' ? '♀' : '⚥';
        var beltColor = getBeltColor(p.cinturon || p.grado || '');
        var evaluado = puntaje !== null && puntaje !== undefined;
        html += '<div class="item-card" style="flex:1;min-width:120px;padding:10px 12px;gap:8px;' + (evaluado ? 'opacity:0.7;cursor:default;' : '') + '" onclick="' + (evaluado ? '' : 'abrirEvaluacion(' + p.id + ',' + (p.id_categoria || 0) + ')') + '">'
            + '<span style="width:8px;height:8px;border-radius:50%;background:' + beltColor + ';display:inline-block;flex-shrink:0;"></span>'
            + '<div style="flex:1;min-width:0;">'
            + '<div style="font-size:13px;font-weight:600;">' + htmlspecialchars(p.nombre + ' ' + p.apellido) + '</div>'
            + '<div style="font-size:10px;opacity:0.5;">' + sexoIcon + ' ' + (p.edad ? p.edad + 'a' : '') + ' ' + renderBeltDots(p.cinturon || p.grado || '') + '</div>'
            + '</div>'
            + '<div style="font-size:14px;font-weight:800;color:' + (evaluado ? '#4caf50' : '#666') + ';">' + (evaluado ? '✅ ' + puntajeStr : '—') + '</div>'
            + '</div>';
    });
    if (lastCat !== '') html += '</div>';
    container.innerHTML = html;
}

function abrirEvaluacion(participanteId, categoriaId) {
    currentParticipanteId = participanteId;
    currentCategoriaId = categoriaId;
    var p = participantesData.find(function(x) { return x.id == participanteId; });
    if (!p) return;
    document.getElementById('listaParticipantes').style.display = 'none';
    document.getElementById('evaluacionScreen').style.display = 'block';
    document.getElementById('evalParticipanteNombre').textContent = htmlspecialchars(p.nombre + ' ' + p.apellido);
    document.getElementById('evalParticipanteInfo').innerHTML = renderBeltDots(p.cinturon || p.grado || '') + ' · ' + (p.edad ? p.edad + ' a\u00f1os' : '') + ' · ' + (p.sexo === 'M' ? '♂' : p.sexo === 'F' ? '♀' : '⚥');
    // Load saved puntaje or default
    var guardado = puntajesGuardados[p.id];
    if (guardado) {
        puntajeActual = guardado.puntaje !== undefined ? guardado.puntaje : 4.0;
        fvActual = guardado.fuerza_velocidad || 0;
        rtActual = guardado.ritmo_tiempo || 0;
        eeActual = guardado.expresion_energia || 0;
    } else {
        puntajeActual = 4.0;
        fvActual = 0;
        rtActual = 0;
        eeActual = 0;
    }
    document.getElementById('fvSlider').value = fvActual;
    document.getElementById('rtSlider').value = rtActual;
    document.getElementById('eeSlider').value = eeActual;
    actualizarDisplay();
    document.getElementById('evalFeedback').textContent = '';
}

function ajustarPuntaje(delta) {
    var nuevo = puntajeActual + delta;
    nuevo = Math.round(nuevo * 10) / 10;
    if (nuevo > 4.0) nuevo = 4.0;
    if (nuevo < 0) nuevo = 0;
    puntajeActual = nuevo;
    actualizarDisplay();
}

function actualizarSlider(tipo) {
    if (tipo === 'fv') { fvActual = parseFloat(document.getElementById('fvSlider').value); document.getElementById('fvDisplay').textContent = fvActual.toFixed(1); }
    else if (tipo === 'rt') { rtActual = parseFloat(document.getElementById('rtSlider').value); document.getElementById('rtDisplay').textContent = rtActual.toFixed(1); }
    else if (tipo === 'ee') { eeActual = parseFloat(document.getElementById('eeSlider').value); document.getElementById('eeDisplay').textContent = eeActual.toFixed(1); }
    actualizarDisplay();
}

function actualizarDisplay() {
    document.getElementById('puntosDisplay').textContent = puntajeActual.toFixed(1);
    var color = puntajeActual >= 3.0 ? '#4caf50' : puntajeActual >= 2.0 ? '#ff9800' : '#f44336';
    document.getElementById('puntosDisplay').style.color = color;
    var total = puntajeActual + fvActual + rtActual + eeActual;
    var totalEl = document.getElementById('totalDisplay');
    totalEl.textContent = 'Total: ' + total.toFixed(1) + ' / 10';
    totalEl.style.color = total >= 7.0 ? '#4caf50' : total >= 4.0 ? '#ff9800' : '#f44336';
}

function guardarPuntaje() {
    var data = new URLSearchParams();
    data.append('id_torneo', currentTorneoId);
    data.append('id_participante', currentParticipanteId);
    data.append('id_categoria', currentCategoriaId);
    data.append('puntaje', puntajeActual.toFixed(1));
    data.append('fuerza_velocidad', fvActual.toFixed(1));
    data.append('ritmo_tiempo', rtActual.toFixed(1));
    data.append('expresion_energia', eeActual.toFixed(1));
    fetch('<?= base_url('/evaluacion/guardar') ?>', { method: 'POST', body: data })
    .then(r => r.json())
    .then(d => {
        if (d.success) {
            puntajesGuardados[currentParticipanteId] = {
                puntaje: puntajeActual,
                fuerza_velocidad: fvActual,
                ritmo_tiempo: rtActual,
                expresion_energia: eeActual
            };
            volverParticipantes();
        } else {
            var fb = document.getElementById('evalFeedback');
            fb.textContent = '❌ ' + d.message;
            fb.style.color = '#f44336';
        }
    });
}

function volverLista() {
    document.getElementById('listaParticipantes').style.display = 'none';
    document.getElementById('evaluacionScreen').style.display = 'none';
    document.getElementById('listaTorneos').style.display = 'block';
}

function volverParticipantes() {
    document.getElementById('evaluacionScreen').style.display = 'none';
    document.getElementById('listaParticipantes').style.display = 'block';
    // Re-render to show updated scores
    renderParticipantes();
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
        html += '<span style="width:8px;height:8px;border-radius:50%;background:' + c + ';display:inline-block;border:1px solid rgba(0,0,0,0.1);margin-right:2px;vertical-align:middle;"></span>';
    });
    return html || '<span style="width:8px;height:8px;border-radius:50%;background:#ccc;display:inline-block;border:1px solid rgba(0,0,0,0.1);"></span>';
}
</script>
</body>
</html>
