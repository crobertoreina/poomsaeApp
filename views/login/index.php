<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover,user-scalable=no">
    <meta name="theme-color" content="#1b5e20">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>Poomsae</title>
    <link rel="manifest" href="<?= base_url('/manifest.php') ?>">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; -webkit-tap-highlight-color:transparent; }
        body { background:#f5f5dc; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif; min-height:100vh; min-height:100dvh; display:flex; align-items:center; justify-content:center; padding:16px; }
        .app-container { width:100%; max-width:400px; animation:fadeUp .5s ease-out; }
        @keyframes fadeUp { 0%{opacity:0;transform:translateY(20px)} 100%{opacity:1;transform:translateY(0)} }
        .logo-area { text-align:center; margin-bottom:32px; }
        .logo-icon { width:72px; height:72px; background:linear-gradient(135deg,#2e7d32,#4caf50); border-radius:20px; display:inline-flex; align-items:center; justify-content:center; box-shadow:0 8px 24px rgba(76,175,80,0.3); margin-bottom:12px; }
        .logo-icon span { font-size:36px; }
        .logo-area h1 { font-size:24px; font-weight:800; color:#1b5e20; letter-spacing:-0.5px; }
        .logo-area p { font-size:12px; color:#999; font-weight:500; letter-spacing:2px; text-transform:uppercase; margin-top:2px; }
        .card { background:#fff; border-radius:20px; padding:28px 24px; box-shadow:0 4px 24px rgba(0,0,0,0.06); }
        .card h2 { font-size:17px; font-weight:700; color:#333; margin-bottom:20px; text-align:center; }
        .field { margin-bottom:16px; }
        .field label { display:block; font-size:11px; font-weight:600; color:#999; text-transform:uppercase; letter-spacing:1px; margin-bottom:6px; }
        .field .input-wrap { position:relative; }
        .field .input-wrap .icon { position:absolute; left:14px; top:50%; transform:translateY(-50%); font-size:16px; opacity:0.5; }
        .field input { width:100%; padding:14px 14px 14px 44px; border:2px solid #f0f0f0; border-radius:14px; font-size:15px; background:#fafafa; transition:all .2s; }
        .field input:focus { border-color:#4caf50; background:#fff; outline:none; box-shadow:0 0 0 4px rgba(76,175,80,0.08); }
        .btn-primary { width:100%; padding:15px; background:linear-gradient(135deg,#2e7d32,#4caf50); color:#fff; border:none; border-radius:14px; font-size:15px; font-weight:700; cursor:pointer; transition:all .2s; box-shadow:0 4px 16px rgba(76,175,80,0.3); }
        .btn-primary:active { transform:scale(0.97); }
        .btn-outline { width:100%; padding:14px; background:transparent; color:#4caf50; border:2px solid #e8f5e9; border-radius:14px; font-size:14px; font-weight:600; cursor:pointer; transition:all .2s; }
        .btn-outline:active { background:#f1f8e9; }
        .divider { display:flex; align-items:center; gap:12px; margin:20px 0; }
        .divider::before,.divider::after { content:''; flex:1; height:1px; background:#f0f0f0; }
        .divider span { color:#ccc; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:1px; }
        .error-msg { text-align:center; margin-bottom:16px; padding:12px 16px; background:#fff0f0; color:#d32f2f; border-radius:12px; font-size:13px; font-weight:500; border:1px solid #ffcdd2; }
        .bottom-safe { height:env(safe-area-inset-bottom,0px); }
        @media (prefers-color-scheme:dark) {
            body { background:#1a1a2e; }
            .card { background:#16213e; box-shadow:0 4px 24px rgba(0,0,0,0.2); }
            .card h2 { color:#e0e0e0; }
            .field input { background:#1a1a2e; border-color:#2a2a4e; color:#e0e0e0; }
            .field input:focus { border-color:#4caf50; background:#1a1a2e; }
            .field label { color:#888; }
            .logo-area h1 { color:#4caf50; }
            .btn-outline { border-color:#2a2a4e; color:#66bb6a; }
            .divider::before,.divider::after { background:#2a2a4e; }
            .divider span { color:#555; }
        }
    </style>
</head>
<body>
    <div class="app-container">
        <div class="card" style="margin-top:20px;">
            <h2>Taekwondo</h2>

            <?php if (!empty($error)): ?>
                <div class="error-msg"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="<?= base_url('/login') ?>">
                <div class="field">
                    <label>Correo o Usuario</label>
                    <div class="input-wrap">
                        <span class="icon">📧</span>
                        <input type="text" name="username" placeholder="correo@ejemplo.com" required>
                    </div>
                </div>
                <div class="field">
                    <label>Contrase&ntilde;a</label>
                    <div class="input-wrap">
                        <span class="icon">🔒</span>
                        <input type="password" name="password" placeholder="••••••••" required>
                    </div>
                </div>
                <button type="submit" class="btn-primary">Ingresar</button>
            </form>

            <div class="divider"><span>o</span></div>

            <a href="<?= base_url('/registro') ?>" style="text-decoration:none;display:block;">
                <button class="btn-outline">📝 Sign In — Registrar Dojang</button>
            </a>
        </div>
        <div class="bottom-safe"></div>
    </div>
    <script>
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('<?= base_url('/sw.js') ?>');
    }
    </script>
</body>
</html>
