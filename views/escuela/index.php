<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover,user-scalable=no">
    <meta name="theme-color" content="#1b5e20">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>Registrar Dojang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="manifest" href="<?= base_url('/manifest.php') ?>">
    <style>
        body { background: linear-gradient(135deg, #f5f5dc 0%, #e8f5e9 100%); min-height:100vh; min-height:100dvh; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif; padding:16px; }
        .card-registro { max-width:540px; width:100%; margin:20px auto; border:none; border-radius:20px; box-shadow:0 8px 30px rgba(0,0,0,0.06); animation:fadeUp .5s ease-out; }
        @keyframes fadeUp { 0%{opacity:0;transform:translateY(20px)} 100%{opacity:1;transform:translateY(0)} }
        .card-registro .card-body { padding:28px 24px; }
        .card-registro .form-control, .card-registro .form-select { border-radius:12px; padding:11px 14px; border:2px solid #f0f0f0; background:#fafafa; font-size:14px; transition:all .15s; }
        .card-registro .form-control:focus, .card-registro .form-select:focus { border-color:#4caf50; background:#fff; box-shadow:0 0 0 4px rgba(76,175,80,0.08); }
        .card-registro .form-label { font-size:10px; font-weight:600; color:#999; text-transform:uppercase; letter-spacing:1px; margin-bottom:4px; }
        .section-title { font-size:12px; font-weight:700; color:#2e7d32; text-transform:uppercase; letter-spacing:1px; margin:18px 0 10px; padding-bottom:6px; border-bottom:2px solid #e8f5e9; }
        .section-title:first-of-type { margin-top:0; }
        .btn-dojang { background:linear-gradient(135deg,#2e7d32,#4caf50); border:none; border-radius:12px; padding:13px; font-weight:700; color:#fff; transition:all .15s; }
        .btn-dojang:hover { transform:translateY(-1px); box-shadow:0 4px 16px rgba(76,175,80,0.3); }
        .btn-dojang:active { transform:scale(0.97); }
        .error-msg { background:#fff0f0; color:#d32f2f; border:1px solid #ffcdd2; border-radius:12px; padding:12px 16px; font-size:13px; font-weight:500; text-align:center; margin-bottom:16px; }
    </style>
</head>
<body>
    <div class="card card-registro">
        <div class="card-body">
            <div class="d-flex align-items-center gap-3 mb-3">
                <a href="<?= base_url('/login') ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3" style="border-color:#ddd;font-size:13px;">←</a>
                <h4 class="fw-bold mb-0" style="color:#1b5e20;">🏫 Registrar Dojang</h4>
            </div>

            <?php if (!empty($error)): ?>
                <div class="error-msg"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="<?= base_url('/registro') ?>">
                <div class="section-title">Informaci&oacute;n del Dojang</div>
                <div class="mb-3">
                    <label class="form-label">🏷️ Nombre del Dojang</label>
                    <input type="text" name="nombre" class="form-control" placeholder="Ej: Sombae Taekwondo" value="<?= htmlspecialchars($data['nombre'] ?? '') ?>" required>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <label class="form-label">🔤 Abreviatura</label>
                        <input type="text" name="siglas" class="form-control" placeholder="Ej: SMB" value="<?= htmlspecialchars($data['siglas'] ?? '') ?>">
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label">📅 Fundaci&oacute;n</label>
                        <input type="date" name="fecha_fundacion" class="form-control" value="<?= htmlspecialchars($data['fecha_fundacion'] ?? '') ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">📞 Tel&eacute;fono</label>
                    <input type="text" name="telefono" class="form-control" placeholder="+505 8888 8888" value="<?= htmlspecialchars($data['telefono'] ?? '') ?>">
                </div>

                <div class="section-title">Sensei / Master</div>
                <div class="row g-3 mb-3">
                    <div class="col-sm-7">
                        <label class="form-label">🥋 Nombre</label>
                        <input type="text" name="instructor_nombre" class="form-control" placeholder="Nombre completo" value="<?= htmlspecialchars($data['instructor_nombre'] ?? '') ?>">
                    </div>
                    <div class="col-sm-5">
                        <label class="form-label">🎓 Grado</label>
                        <input type="text" name="instructor_grado" class="form-control" placeholder="Ej: 4to Dan" value="<?= htmlspecialchars($data['instructor_grado'] ?? '') ?>">
                    </div>
                </div>

                <div class="section-title">Ubicaci&oacute;n</div>
                <div class="row g-3 mb-3">
                    <div class="col-sm-4">
                        <label class="form-label">🌍 Pa&iacute;s</label>
                        <input type="text" name="pais" class="form-control" placeholder="Pa&iacute;s" value="<?= htmlspecialchars($data['pais'] ?? '') ?>">
                    </div>
                    <div class="col-sm-4">
                        <label class="form-label">🏙️ Ciudad</label>
                        <input type="text" name="ciudad" class="form-control" placeholder="Ciudad" value="<?= htmlspecialchars($data['ciudad'] ?? '') ?>">
                    </div>
                    <div class="col-sm-4">
                        <label class="form-label">📍 Direcci&oacute;n</label>
                        <input type="text" name="direccion" class="form-control" placeholder="Direcci&oacute;n" value="<?= htmlspecialchars($data['direccion'] ?? '') ?>">
                    </div>
                </div>

                <div class="section-title">Acceso</div>
                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <label class="form-label">📧 Correo</label>
                        <input type="email" name="correo" class="form-control" placeholder="correo@ejemplo.com" value="<?= htmlspecialchars($data['correo'] ?? '') ?>" required>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label">👤 Usuario</label>
                        <input type="text" name="user" class="form-control" placeholder="Opcional" value="<?= htmlspecialchars($data['user'] ?? '') ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">🔑 Contrase&ntilde;a</label>
                    <input type="password" name="pass" class="form-control" placeholder="M&iacute;nimo 6 caracteres" required>
                </div>

                <button type="submit" class="btn btn-dojang w-100">✅ Crear Dojang</button>
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
