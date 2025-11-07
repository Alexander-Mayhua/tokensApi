<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Iniciar sesión</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background:#0f2233; display:flex; align-items:center; justify-content:center; height:100vh; }
    .login-card { width:100%; max-width:380px; background:#fff; border-radius:16px; padding:26px; }
  </style>
</head>
<body>
  <div class="login-card shadow">
    <h3 class="mb-3 text-center">TOKENS</h3>
    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post" action="<?= App\Lib\url_to('login') ?>">
      <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>">
      <div class="mb-3">
        <label class="form-label">Usuario</label>
        <input class="form-control" name="usuario" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Clave</label>
        <input type="password" class="form-control" name="clave" required>
      </div>
      <button class="btn btn-primary w-100" type="submit">Ingresar</button>
    </form>
  </div>
</body>
</html>
