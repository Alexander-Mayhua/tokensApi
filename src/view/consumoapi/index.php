<?php
// Vista: buscar DOCENTES con token oculto (validación en backend)
if (session_status() === PHP_SESSION_NONE) session_start();
$tokenValue = $_SESSION['api_token'] ?? ($_GET['token'] ?? '');
?>

<!-- 🔹 Estilos personalizados -->
<style>
body {
  background: #f3f6fb;
  font-family: 'Poppins', sans-serif;
  color: #333;
}

.header-bar {
  background: linear-gradient(90deg, #004e92, #000428);
  color: #fff;
  padding: 25px 40px;
  border-radius: 15px;
  box-shadow: 0 3px 10px rgba(0,0,0,0.2);
  margin-bottom: 30px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.header-bar h2 {
  font-weight: 600;
  margin: 0;
  font-size: 1.6rem;
}

.header-bar small {
  display: block;
  font-size: 0.9rem;
  color: rgba(255,255,255,0.8);
}

.btn-custom {
  background: linear-gradient(90deg, #007bff, #0056d2);
  border: none;
  color: white;
  font-weight: 500;
  transition: all 0.3s ease;
  box-shadow: 0 3px 6px rgba(0,0,0,0.1);
}

.btn-custom:hover {
  transform: scale(1.03);
  background: linear-gradient(90deg, #0056d2, #003b99);
}

.card {
  border: none;
  border-radius: 15px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.08);
}

.card h5 {
  font-weight: 600;
  color: #2c3e50;
}

.table thead {
  background: #004e92;
  color: #fff;
}

.table th, .table td {
  vertical-align: middle;
  text-align: center;
}

.badge {
  padding: 6px 12px;
  border-radius: 12px;
  font-size: 0.85rem;
}

.spinner-border {
  width: 2.5rem;
  height: 2.5rem;
}

.fadeIn {
  animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
  from {opacity: 0; transform: translateY(10px);}
  to {opacity: 1; transform: translateY(0);}
}
</style>

<!-- 🔹 Encabezado institucional -->
<div class="header-bar">
  <div>
    <h2>📡 Módulo de Consumo API</h2>
    <small>Consulta de docentes registrados en el sistema institucional</small>
  </div>
  <a href="?" class="btn btn-outline-light px-4 py-2 fw-semibold rounded-pill shadow-sm">
    <i class="bi bi-arrow-left"></i> Volver
  </a>
</div>

<!-- 🔹 Formulario de búsqueda -->
<div class="card p-4 mb-4 fadeIn">
  <form id="formBuscarDocente">
    <input type="hidden" name="token" value="<?= htmlspecialchars($tokenValue, ENT_QUOTES, 'UTF-8') ?>">
    <input type="hidden" name="tipo" value="verdocenteapibynombreodni">

    <div class="row g-3 align-items-end">
      <div class="col-md-8">
        <label class="form-label fw-semibold text-secondary">🔍 Nombre / Apellido / DNI</label>
        <input type="text" name="data" id="data" class="form-control form-control-lg shadow-sm"
               placeholder="Ejemplo: Ana, Pérez o 12345678" required>
      </div>
      <div class="col-md-4 d-flex gap-2">
        <button type="submit" class="btn btn-custom flex-fill btn-lg">
          <i class="bi bi-search"></i> Buscar
        </button>
        <button type="button" class="btn btn-outline-secondary flex-fill btn-lg" id="btnLimpiar">
          <i class="bi bi-eraser"></i> Limpiar
        </button>
      </div>
    </div>
  </form>
</div>

<!-- 🔹 Resultados -->
<div class="card p-4 fadeIn">
  <h5 class="mb-3"><i class="bi bi-list-ul"></i> Resultados de la búsqueda</h5>
  <div id="resultado" class="text-center text-muted">
    <div>Ingrese un nombre, apellido o DNI para realizar la búsqueda.</div>
  </div>
</div>

<!-- 🔹 Script funcional -->
<script>
document.getElementById('formBuscarDocente').addEventListener('submit', async function(e) {
  e.preventDefault();
  const formData = new FormData(this);

  document.getElementById('resultado').innerHTML =
    `<div class="p-4 text-center text-muted">
       <div class="spinner-border text-primary" role="status"></div><br>
       <small class="d-block mt-2">Consultando API...</small>
     </div>`;

  try {
    const res = await fetch('?c=consumoapi&a=verDocenteApiByNombreODni', {
      method: 'POST',
      body: formData
    });
    const data = await res.json();

    if (!data || data.status === false) {
      document.getElementById('resultado').innerHTML =
        `<div class="alert alert-danger fadeIn"><i class="bi bi-x-circle"></i> ${data.msg || 'Error en la consulta.'}</div>`;
      return;
    }

    const docentes = data.contenido || [];
    if (docentes.length === 0) {
      document.getElementById('resultado').innerHTML =
        `<div class="alert alert-warning fadeIn"><i class="bi bi-exclamation-triangle"></i> No se encontraron resultados.</div>`;
      return;
    }

    let html = `
      <div class="table-responsive fadeIn">
        <table class="table table-bordered table-striped align-middle">
          <thead>
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
    document.getElementById('resultado').innerHTML = html;

  } catch (err) {
    console.error(err);
    document.getElementById('resultado').innerHTML =
      `<div class="alert alert-danger fadeIn"><i class="bi bi-wifi-off"></i> Error al conectar con el servidor.</div>`;
  }
});

document.getElementById('btnLimpiar').addEventListener('click', function() {
  document.getElementById('data').value = '';
  document.getElementById('resultado').innerHTML =
    `<div class="text-muted">Ingrese un nombre, apellido o DNI para realizar la búsqueda.</div>`;
});

function esc(v) {
  if (v === null || v === undefined) return '';
  return String(v).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}
</script>
