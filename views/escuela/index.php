<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover,user-scalable=no">
    <meta name="theme-color" content="#1b5e20">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>Registrar Dojang</title>
    <link rel="manifest" href="<?= base_url('/manifest.php') ?>">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; -webkit-tap-highlight-color:transparent; }
        body { background:#f5f5dc; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif; min-height:100vh; min-height:100dvh; padding:16px; }
        .app-container { max-width:500px; margin:0 auto; animation:fadeUp .5s ease-out; }
        @keyframes fadeUp { 0%{opacity:0;transform:translateY(20px)} 100%{opacity:1;transform:translateY(0)} }
        .top-bar { display:flex; align-items:center; gap:12px; margin-bottom:20px; }
        .top-bar a { text-decoration:none; color:#4caf50; font-size:14px; font-weight:600; }
        .top-bar h1 { font-size:20px; font-weight:800; color:#1b5e20; flex:1; }
        .card { background:#fff; border-radius:20px; padding:24px; box-shadow:0 4px 24px rgba(0,0,0,0.06); }
        .section-title { font-size:12px; font-weight:700; color:#4caf50; text-transform:uppercase; letter-spacing:1px; margin:18px 0 12px; }
        .section-title:first-child { margin-top:0; }
        .field { margin-bottom:14px; }
        .field label { display:block; font-size:10px; font-weight:600; color:#999; text-transform:uppercase; letter-spacing:1px; margin-bottom:5px; }
        .field input { width:100%; padding:12px 14px; border:2px solid #f0f0f0; border-radius:12px; font-size:14px; background:#fafafa; transition:all .2s; }
        .field input:focus { border-color:#4caf50; background:#fff; outline:none; box-shadow:0 0 0 4px rgba(76,175,80,0.08); }
        .row { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
        .row-3 { display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px; }
        .btn-primary { width:100%; padding:15px; background:linear-gradient(135deg,#2e7d32,#4caf50); color:#fff; border:none; border-radius:14px; font-size:15px; font-weight:700; cursor:pointer; transition:all .2s; margin-top:8px; box-shadow:0 4px 16px rgba(76,175,80,0.3); }
        .btn-primary:active { transform:scale(0.97); }
        .error-msg { text-align:center; margin-bottom:16px; padding:12px 16px; background:#fff0f0; color:#d32f2f; border-radius:12px; font-size:13px; font-weight:500; border:1px solid #ffcdd2; }
        @media (prefers-color-scheme:dark) {
            body { background:#1a1a2e; }
            .card { background:#16213e; }
            .top-bar h1 { color:#4caf50; }
            .field input { background:#1a1a2e; border-color:#2a2a4e; color:#e0e0e0; }
            .field input:focus { border-color:#4caf50; background:#1a1a2e; }
        }
    </style>
</head>
<body>
    <div class="app-container">
        <div class="top-bar">
            <a href="<?= base_url('/login') ?>">←</a>
            <h1>🏫 Registrar Dojang</h1>
        </div>

        <div class="card">
            <?php if (!empty($error)): ?>
                <div class="error-msg"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="<?= base_url('/registro') ?>">
                <div class="section-title">Informaci&oacute;n del Dojang</div>
                <div class="field">
                    <label>🏷️ Nombre del Dojang</label>
                    <input type="text" name="nombre" placeholder="Ej: Sombae Taekwondo" value="<?= htmlspecialchars($data['nombre'] ?? '') ?>" required>
                </div>
                <div class="row">
                    <div class="field">
                        <label>🔤 Abreviatura</label>
                        <input type="text" name="siglas" placeholder="Ej: SMB" value="<?= htmlspecialchars($data['siglas'] ?? '') ?>">
                    </div>
                    <div class="field">
                        <label>📅 Fundaci&oacute;n</label>
                        <input type="date" name="fecha_fundacion" value="<?= htmlspecialchars($data['fecha_fundacion'] ?? '') ?>">
                    </div>
                </div>
                <div class="field">
                    <label>📞 Tel&eacute;fono</label>
                    <input type="text" name="telefono" placeholder="+505 8888 8888" value="<?= htmlspecialchars($data['telefono'] ?? '') ?>">
                </div>

                <div class="section-title">Sensei / Master</div>
                <div class="row">
                    <div class="field">
                        <label>🥋 Nombre</label>
                        <input type="text" name="instructor_nombre" placeholder="Nombre completo" value="<?= htmlspecialchars($data['instructor_nombre'] ?? '') ?>">
                    </div>
                    <div class="field">
                        <label>🎓 Grado</label>
                        <input type="text" name="instructor_grado" placeholder="Ej: 4to Dan" value="<?= htmlspecialchars($data['instructor_grado'] ?? '') ?>">
                    </div>
                </div>

                <div class="section-title">Ubicaci&oacute;n</div>
                <div class="row-3">
                    <div class="field">
                        <label>🌍 Pa&iacute;s</label>
                        <input type="text" name="pais" placeholder="Pa&iacute;s" value="<?= htmlspecialchars($data['pais'] ?? '') ?>">
                    </div>
                    <div class="field">
                        <label>🏙️ Ciudad</label>
                        <input type="text" name="ciudad" placeholder="Ciudad" value="<?= htmlspecialchars($data['ciudad'] ?? '') ?>">
                    </div>
                    <div class="field">
                        <label>📍 Direcci&oacute;n</label>
                        <input type="text" name="direccion" placeholder="Direcci&oacute;n" value="<?= htmlspecialchars($data['direccion'] ?? '') ?>">
                    </div>
                </div>

                <div class="section-title">Acceso</div>
                <div class="row">
                    <div class="field">
                        <label>📧 Correo</label>
                        <input type="email" name="correo" placeholder="correo@ejemplo.com" value="<?= htmlspecialchars($data['correo'] ?? '') ?>" required>
                    </div>
                    <div class="field">
                        <label>👤 Usuario</label>
                        <input type="text" name="user" placeholder="Opcional" value="<?= htmlspecialchars($data['user'] ?? '') ?>">
                    </div>
                </div>
                <div class="field">
                    <label>🔑 Contrase&ntilde;a</label>
                    <input type="password" name="pass" placeholder="M&iacute;nimo 6 caracteres" required>
                </div>

                <button type="submit" class="btn-primary">✅ Crear Dojang</button>
            </form>
        </div>
    </div>
    <script>
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('<?= base_url('/sw.js') ?>');
    }
    </script>
</body>
</html>
