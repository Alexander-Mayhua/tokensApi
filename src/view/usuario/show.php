<h1 class="mb-3">Usuario</h1>
<div class="card p-4" style="max-width:640px">
  <div class="row g-3">
    <div class="col-sm-6">
      <label class="form-label">ID</label>
      <input class="form-control" value="<?= (int)$usr['id_usuario'] ?>" readonly>
    </div>
    <div class="col-sm-6">
      <label class="form-label">Usuario</label>
      <input class="form-control" value="<?= htmlspecialchars($usr['usuario']) ?>" readonly>
    </div>
    <div class="col-sm-6">
      <label class="form-label">Rol</label>
      <input class="form-control" value="<?= htmlspecialchars($usr['rol']) ?>" readonly>
    </div>
    <div class="col-sm-6">
      <label class="form-label">Estado</label>
      <input class="form-control" value="<?= htmlspecialchars($usr['estado']) ?>" readonly>
    </div>
    <div class="col-12">
      <label class="form-label">Fecha de registro</label>
      <input class="form-control" value="<?= htmlspecialchars($usr['fecha_registro'] ?? '') ?>" readonly>
    </div>
  </div>
  <div class="mt-3">
    <a class="btn btn-secondary" href="<?= App\Lib\url_to('dashboard') ?>">Volver</a>
  </div>
</div>
