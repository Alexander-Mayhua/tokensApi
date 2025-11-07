<div class="card p-4">
  <h3>⚙️ Configuración de Consumo API</h3>
  <p class="text-muted">Aquí podrás ajustar parámetros del consumo de la API (por ejemplo, token o URL del servidor principal).</p>

  <form method="post" action="?c=consumoapi&a=guardarConfiguracion">
    <div class="mb-3">
      <label class="form-label">URL del servidor principal</label>
      <input type="text" name="api_url" class="form-control" value="https://instituto.estudiojuridico.com.pe/?c=consumoapi&a=verDocenteApiByNombreODni">
    </div>
    <div class="mb-3">
      <label class="form-label">Token de acceso</label>
      <input type="text" name="api_token" class="form-control" value="TOKEN_FIJO_12345">
    </div>
    <button type="submit" class="btn btn-primary">Guardar Configuración</button>
  </form>
</div>
