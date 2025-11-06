<h1 class="mb-3">Ver token</h1>
<div class="card p-4" style="max-width:560px">
  <div class="mb-3">
    <label class="form-label">Token</label>
    <input class="form-control" value="<?= htmlspecialchars($token['tokens']) ?>" readonly>
  </div>
  <a class="btn btn-secondary" href="<?= App\Lib\url_to('tokens') ?>">Volver</a>
</div>
