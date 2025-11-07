<?php
// Vista: consumoapi/index.php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">🔍 Consumo de API - Buscar Docentes</h3>
  <a class="btn btn-outline-secondary" href="?">Volver</a>
</div>

<div class="card p-4 mb-4">
  <form id="formBuscarDocente" method="post">
    <input type="hidden" name="tipo" value="verdocenteapibynombreodni">
    <div class="row g-3 align-items-end">
      <div class="col-md-8">
        <label class="form-label">Nombre / Apellido / DNI</label>
        <input type="text" name="data" id="data" class="form-control" placeholder="Ej.: Ana, Pérez o 12345678">
      </div>
      <div class="col-md-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary flex-fill">Buscar</button>
        <button type="button" class="btn btn-outline-secondary flex-fill" id="btnLimpiar">Limpiar</button>
      </div>
    </div>
  </form>
</div>

<div class="card p-3">
  <h5 class="mb-3">Resultados</h5>
  <div id="resultado">
    <div class="text-muted">Escriba un nombre/apellido o un DNI para buscar.</div>
  </div>
</div>

<script>
document.getElementById('formBuscarDocente').addEventListener('submit', async (e) => {
  e.preventDefault();
  const form = e.target;
  const resDiv = document.getElementById('resultado');
  resDiv.innerHTML = '<div class="text-center text-muted p-3">Consultando API...</div>';

  try {
    const res = await fetch('?c=consumoapi&a=verDocenteApiByNombreODni', {
      method: 'POST',
      body: new FormData(form)
    });
    const data = await res.json();

    if (!data || data.status === false) {
      resDiv.innerHTML = `<div class="alert alert-danger">${data.msg || 'Error en la consulta.'}</div>`;
      return;
    }

    const docentes = data.contenido || [];
    if (docentes.length === 0) {
      resDiv.innerHTML = '<div class="alert alert-warning">No se encontraron resultados.</div>';
      return;
    }

    let html = `
      <div class="table-responsive">
        <table class="table table-sm table-bordered align-middle">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>DNI</th>
              <th>Nombres</th>
              <th>Apellidos</th>
              <th>Especialidad</th>
              <th>Grado Académico</th>
              <th>Estado</th>
            </tr>
          </thead>
          <tbody>
    `;

    docentes.forEach((d, i) => {
      const activo = (d.estado === 'Activo');
      html += `
        <tr>
          <td>${i + 1}</td>
          <td>${esc(d.dni)}</td>
          <td>${esc(d.nombres)}</td>
          <td>${esc(d.apellidos)}</td>
          <td>${esc(d.especialidad || '-')}</td>
          <td>${esc(d.grado_academico || '')}</td>
          <td><span class="badge bg-${activo ? 'success' : 'secondary'}">${esc(d.estado || '')}</span></td>
        </tr>`;
    });

    html += '</tbody></table></div>';
    resDiv.innerHTML = html;

  } catch (err) {
    console.error(err);
    resDiv.innerHTML = '<div class="alert alert-danger">Error al conectar con el servidor.</div>';
  }
});

document.getElementById('btnLimpiar').addEventListener('click', () => {
  document.getElementById('data').value = '';
  document.getElementById('resultado').innerHTML =
    '<div class="text-muted">Escriba un nombre/apellido o un DNI para buscar.</div>';
});

function esc(v) {
  if (v === null || v === undefined) return '';
  return String(v).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
}
</script>
