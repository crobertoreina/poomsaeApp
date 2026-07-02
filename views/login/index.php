<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover,user-scalable=no">
    <meta name="theme-color" content="#1b5e20">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>Taekwondo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="manifest" href="<?= base_url('/manifest.php') ?>">
    <style>
        body { background: linear-gradient(135deg, #f5f5dc 0%, #e8f5e9 100%); min-height:100vh; min-height:100dvh; display:flex; align-items:center; justify-content:center; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif; padding:16px; }
        .card-login { max-width:400px; width:100%; border:none; border-radius:20px; box-shadow:0 8px 30px rgba(0,0,0,0.06); animation:fadeUp .5s ease-out; }
        @keyframes fadeUp { 0%{opacity:0;transform:translateY(20px)} 100%{opacity:1;transform:translateY(0)} }
        .card-login .card-body { padding:32px 28px; }
        .card-login .form-control { border-radius:12px; padding:12px 16px; border:2px solid #f0f0f0; background:#fafafa; font-size:14px; transition:all .15s; }
        .card-login .form-control:focus { border-color:#4caf50; background:#fff; box-shadow:0 0 0 4px rgba(76,175,80,0.08); }
        .card-login .form-label { font-size:11px; font-weight:600; color:#999; text-transform:uppercase; letter-spacing:1px; margin-bottom:6px; }
        .btn-dojang { background:linear-gradient(135deg,#2e7d32,#4caf50); border:none; border-radius:12px; padding:13px; font-weight:700; color:#fff; transition:all .15s; }
        .btn-dojang:hover { transform:translateY(-1px); box-shadow:0 4px 16px rgba(76,175,80,0.3); }
        .btn-dojang:active { transform:scale(0.97); }
        .btn-outline-dojang { border:2px solid #e8f5e9; border-radius:12px; padding:12px; font-weight:600; color:#4caf50; transition:all .15s; }
        .btn-outline-dojang:hover { background:#f1f8e9; }
        .divider-custom { display:flex; align-items:center; gap:12px; margin:18px 0; }
        .divider-custom::before,.divider-custom::after { content:''; flex:1; height:1px; background:#f0f0f0; }
        .divider-custom span { color:#ccc; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:1px; }
        .error-msg { background:#fff0f0; color:#d32f2f; border:1px solid #ffcdd2; border-radius:12px; padding:12px 16px; font-size:13px; font-weight:500; text-align:center; margin-bottom:16px; }
    </style>
</head>
<body>
    <div class="card card-login">
        <div class="card-body">
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center" style="width:64px;height:64px;background:linear-gradient(135deg,#2e7d32,#4caf50);border-radius:18px;box-shadow:0 6px 20px rgba(76,175,80,0.25);font-size:32px;">🥋</div>
                <h2 class="mt-3 mb-1 fw-bold" style="color:#1b5e20;">Taekwondo</h2>
            </div>

            <?php if (!empty($error)): ?>
                <div class="error-msg"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="<?= base_url('/login') ?>">
                <div class="mb-3">
                    <label class="form-label">Correo o Usuario</label>
                    <input type="text" name="username" class="form-control" placeholder="correo@ejemplo.com" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Contrase&ntilde;a</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn btn-dojang w-100">Ingresar</button>
            </form>

            <div class="divider-custom"><span>o</span></div>

            <a href="<?= base_url('/registro') ?>" class="btn btn-outline-dojang w-100 text-decoration-none">📝 Sign In — Registrar Dojang</a>
        </div>
    </div>
    <script>
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('<?= base_url('/sw.js') ?>');
    }
    </script>
</body>
</html>
