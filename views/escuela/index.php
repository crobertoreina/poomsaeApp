<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrar Dojang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { background: linear-gradient(135deg, #f5f5dc 0%, #e8f5e9 100%); min-height:100vh; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif; padding:20px 0; }
        .form-wrapper { max-width:640px; margin:0 auto; padding:0 20px; }
        .form-card { background:#fff; border-radius:18px; padding:32px 28px; box-shadow:0 8px 30px rgba(0,0,0,0.08); }
        .form-card h1 { color:#2e7d32; font-size:20px; font-weight:700; text-align:center; margin-bottom:4px; }
        .form-card .sub { color:#999; font-size:11px; text-align:center; letter-spacing:2px; text-transform:uppercase; margin-bottom:24px; font-weight:500; }
        .form-card label { display:block; font-size:11px; font-weight:600; color:#888; text-transform:uppercase; letter-spacing:1px; margin-bottom:4px; }
        .form-card .form-control, .form-card input { font-size:14px; border-radius:10px; border:1.5px solid #e0e0e0; background:#fafafa; padding:10px 14px; transition:all 0.15s; }
        .form-card .form-control:focus, .form-card input:focus { border-color:#4caf50; background:#fff; outline:none; box-shadow:0 0 0 3px rgba(76,175,80,0.1); }
        .btn-primary-custom { width:100%; padding:13px; background:linear-gradient(135deg,#2e7d32,#4caf50); color:#fff; border:none; border-radius:12px; font-size:15px; font-weight:700; cursor:pointer; box-shadow:0 4px 12px rgba(76,175,80,0.25); transition:all 0.15s; }
        .btn-primary-custom:hover { transform:translateY(-1px); box-shadow:0 6px 18px rgba(76,175,80,0.3); }
        .error-msg { text-align:center; margin-bottom:16px; padding:10px 14px; background:#ffebee; color:#c62828; border-radius:10px; font-size:13px; }
        .form-card .row { margin-bottom:14px; }
        .back-link { text-align:center; margin-top:16px; }
        .back-link a { color:#4caf50; font-size:13px; font-weight:600; text-decoration:none; }
        .section-title { font-size:13px; font-weight:700; color:#2e7d32; margin:18px 0 12px; padding-bottom:6px; border-bottom:2px solid #e8f5e9; }
    </style>
</head>
<body>
    <div class="form-wrapper">
        <div class="form-card">
            <h1>🏫 Registrar Dojang</h1>
            <div class="sub">Nueva Escuela de Taekwondo</div>

            <?php if (!empty($error)): ?>
                <div class="error-msg"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="<?= base_url('/registro') ?>">
                <div class="section-title">📋 Informaci&oacute;n del Dojang</div>
                <div class="row">
                    <div class="col-md-7 mb-3">
                        <label>🏷️ Nombre del Dojang</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Ej: Sombae Taekwondo" value="<?= htmlspecialchars($data['nombre'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-5 mb-3">
                        <label>🔤 Abreviatura</label>
                        <input type="text" name="siglas" class="form-control" placeholder="Ej: SMB" value="<?= htmlspecialchars($data['siglas'] ?? '') ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>📅 Fecha de Fundaci&oacute;n</label>
                        <input type="date" name="fecha_fundacion" class="form-control" value="<?= htmlspecialchars($data['fecha_fundacion'] ?? '') ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>📞 Tel&eacute;fono</label>
                        <input type="text" name="telefono" class="form-control" placeholder="+505 8888 8888" value="<?= htmlspecialchars($data['telefono'] ?? '') ?>">
                    </div>
                </div>

                <div class="section-title">👤 Sensei / Master</div>
                <div class="row">
                    <div class="col-md-7 mb-3">
                        <label>🥋 Nombre del Instructor</label>
                        <input type="text" name="instructor_nombre" class="form-control" placeholder="Nombre completo" value="<?= htmlspecialchars($data['instructor_nombre'] ?? '') ?>">
                    </div>
                    <div class="col-md-5 mb-3">
                        <label>🎓 Grado</label>
                        <input type="text" name="instructor_grado" class="form-control" placeholder="Ej: 4to Dan" value="<?= htmlspecialchars($data['instructor_grado'] ?? '') ?>">
                    </div>
                </div>

                <div class="section-title">📍 Ubicaci&oacute;n</div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>🌍 Pa&iacute;s</label>
                        <input type="text" name="pais" class="form-control" placeholder="Pa&iacute;s" value="<?= htmlspecialchars($data['pais'] ?? '') ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>🏙️ Ciudad</label>
                        <input type="text" name="ciudad" class="form-control" placeholder="Ciudad" value="<?= htmlspecialchars($data['ciudad'] ?? '') ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>📍 Direcci&oacute;n</label>
                        <input type="text" name="direccion" class="form-control" placeholder="Direcci&oacute;n" value="<?= htmlspecialchars($data['direccion'] ?? '') ?>">
                    </div>
                </div>

                <div class="section-title">🔐 Acceso</div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>📧 Correo Electr&oacute;nico</label>
                        <input type="email" name="correo" class="form-control" placeholder="correo@ejemplo.com" value="<?= htmlspecialchars($data['correo'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>👤 Usuario (opcional)</label>
                        <input type="text" name="user" class="form-control" placeholder="Si se deja vac&iacute;o, se usa el correo" value="<?= htmlspecialchars($data['user'] ?? '') ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>🔑 Contrase&ntilde;a</label>
                        <input type="password" name="pass" class="form-control" placeholder="M&iacute;nimo 6 caracteres" required>
                    </div>
                </div>

                <button type="submit" class="btn-primary-custom mt-2">✅ Crear Dojang</button>
            </form>

            <div class="back-link">
                <a href="<?= base_url('/login') ?>">← ¿Ya tienes cuenta? Inicia sesi&oacute;n</a>
            </div>
        </div>
    </div>
</body>
</html>
