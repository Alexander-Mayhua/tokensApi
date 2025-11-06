<?php if (!isset($title)) $title='Panel'; ?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($title) ?> - INSTITUTO</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background:#f2f6fb; }
    .sidebar{width:260px;position:fixed;top:0;bottom:0;left:0;background:#0f2233;color:#fff;padding:20px;}
    .sidebar a{color:#d9e6f2;text-decoration:none;display:block;padding:10px 12px;border-radius:10px;margin-bottom:6px;}
    .sidebar a.active,.sidebar a:hover{background:#1d3550;color:#fff;}
    .content{margin-left:280px;padding:28px;}
    .kpi{border-radius:16px;}
  </style>
</head>
<body>
  <aside class="sidebar">
    <div class="d-flex align-items-center mb-3">
      <div class="rounded-circle bg-light me-2" style="width:40px;height:40px;"></div>
      <div>
        <div style="font-weight:600;"><?= htmlspecialchars($_SESSION['user']['usuario'] ?? 'Usuario') ?></div>
        <div class="text-success"><?= htmlspecialchars($_SESSION['user']['rol'] ?? '') ?></div>
      </div>
    </div>
    <a href="<?= App\Lib\url_to('dashboard') ?>" class="<?= ($title==='Dashboard')?'active':'' ?>">🏠 Dashboard</a>
    <a href="<?= App\Lib\url_to('tokens') ?>" class="<?= ($title==='Tokens API')?'active':'' ?>">🔑 Tokens API</a>
    <a href="<?= App\Lib\url_to('usuario') ?>" class="<?= ($title==='Usuario')?'active':'' ?>">👤 Usuario</a>
    <hr>
    <a href="<?= App\Lib\url_to('logout') ?>">⏻ Salir</a>
  </aside>

  <main class="content">
    <div class="container-fluid">
      <?php include $viewPath; ?>
    </div>
  </main>
</body>
</html>
