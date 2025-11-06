<h1 class="mb-3">Editar token</h1>
<div class="card p-4" style="max-width:560px">
  <form method="post" action="<?= App\Lib\url_to('tokens/update') ?>">
    <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>">
    <input type="hidden" name="old" value="<?= htmlspecialchars($token['tokens']) ?>">
    <div class="mb-3">
      <label class="form-label">Nuevo token</label>
      <input class="form-control" name="new" value="<?= htmlspecialchars($token['tokens']) ?>" required>
    </div>
    <div class="d-flex gap-2">
      <button class="btn btn-success" type="submit">Guardar cambios</button>
      <a class="btn btn-secondary" href="<?= App\Lib\url_to('tokens') ?>">Cancelar</a>
    </div>
  </form>
</div>
