<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesi&oacute;n</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { background: linear-gradient(135deg, #f5f5dc 0%, #e8f5e9 100%); min-height:100vh; display:flex; align-items:center; justify-content:center; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif; }
        .login-wrapper { width:100%; max-width:400px; padding:20px; }
        .login-card { background:#fff; border-radius:18px; padding:32px 28px; box-shadow:0 8px 30px rgba(0,0,0,0.08); }
        .login-card h1 { color:#2e7d32; font-size:22px; font-weight:700; text-align:center; margin-bottom:4px; }
        .login-card .sub { color:#999; font-size:12px; text-align:center; letter-spacing:2px; text-transform:uppercase; margin-bottom:24px; font-weight:500; }
        .login-card .field { margin-bottom:16px; }
        .login-card label { display:block; font-size:11px; font-weight:600; color:#888; text-transform:uppercase; letter-spacing:1px; margin-bottom:5px; }
        .login-card input { width:100%; padding:12px 14px; border:1.5px solid #e0e0e0; border-radius:10px; font-size:14px; background:#fafafa; transition:all 0.15s; }
        .login-card input:focus { border-color:#4caf50; background:#fff; outline:none; box-shadow:0 0 0 3px rgba(76,175,80,0.1); }
        .btn-primary-custom { width:100%; padding:13px; background:linear-gradient(135deg,#2e7d32,#4caf50); color:#fff; border:none; border-radius:12px; font-size:15px; font-weight:700; cursor:pointer; box-shadow:0 4px 12px rgba(76,175,80,0.25); transition:all 0.15s; }
        .btn-primary-custom:hover { transform:translateY(-1px); box-shadow:0 6px 18px rgba(76,175,80,0.3); }
        .btn-signin { width:100%; padding:12px; background:transparent; color:#4caf50; border:1.5px solid #4caf50; border-radius:12px; font-size:14px; font-weight:600; cursor:pointer; transition:all 0.15s; }
        .btn-signin:hover { background:#f1f8e9; }
        .error-msg { text-align:center; margin-bottom:16px; padding:10px 14px; background:#ffebee; color:#c62828; border-radius:10px; font-size:13px; }
        .divider { display:flex; align-items:center; gap:12px; margin:18px 0; }
        .divider::before, .divider::after { content:''; flex:1; height:1px; background:#e0e0e0; }
        .divider span { color:#bbb; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:1px; }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <h1>Poomsae</h1>
            <div class="sub">Sistema de Evaluaci&oacute;n</div>

            <?php if (!empty($error)): ?>
                <div class="error-msg"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="<?= base_url('/login') ?>">
                <div class="field">
                    <label for="username">📧 Correo o Usuario</label>
                    <input type="text" name="username" id="username" placeholder="correo@ejemplo.com" required>
                </div>
                <div class="field">
                    <label for="password">🔒 Contrase&ntilde;a</label>
                    <input type="password" name="password" id="password" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn-primary-custom">Ingresar</button>
            </form>

            <div class="divider"><span>o</span></div>

            <a href="<?= base_url('/registro') ?>" style="text-decoration:none;">
                <button class="btn-signin">📝 Sign In &mdash; Registrar Dojang</button>
            </a>
        </div>
    </div>
</body>
</html>
