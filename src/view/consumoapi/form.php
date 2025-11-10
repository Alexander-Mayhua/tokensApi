<form id="formBuscarDocente" method="post">
  <input type="hidden" name="tipo" value="verdocenteapibynombreodni">
  <div class="row g-3 align-items-end">
    <div class="col-md-8">
      <label class="form-label">Nombre / Apellido / DNI</label>
      <input type="text" name="data" id="data" class="form-control" placeholder="Ej.: Ana, Pérez o 12345678">
    </div>
    <div class="col-md-4">
      <button type="submit" class="btn btn-primary w-100">Consultar</button>
    </div>
  </div>
</form>
<script>
document.getElementById('formBuscarDocente').addEventListener('submit', async (e)=>{
  e.preventDefault();
  const res  = await fetch('?c=consumoapi&a=verDocenteApiByNombreODni', { method:'POST', body:new FormData(e.target) });
  const json = await res.json();
  // ...renderiza json.contenido como ya lo haces
});
</script>
