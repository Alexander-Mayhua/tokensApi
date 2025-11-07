<h1 class="mb-3">Tokens API</h1>
<div class="card p-3">
  <div class="table-responsive">
    <table class="table align-middle">
      <thead><tr><th>Token</th><th style="width:200px"></th></tr></thead>
      <tbody>
        <?php foreach($tokens as $t): ?>
          <tr>
            <td><code><?= htmlspecialchars($t['tokens']) ?></code></td>
            <td class="d-flex gap-2">
          
              <a class="btn btn-sm btn-primary" href="<?= App\Lib\url_to('tokens/edit') . '&value=' . urlencode($t['tokens']) ?>">Editar</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
