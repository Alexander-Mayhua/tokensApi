<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscador de Docentes - API Instituto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f4f7fb; font-family: "Segoe UI", Arial, sans-serif; }
        .card { border-radius: 14px; box-shadow: 0 3px 12px rgba(0,0,0,0.1); }
        .btn-custom { background-color: #004aad; color: white; border-radius: 8px; }
        .btn-custom:hover { background-color: #003d91; }
        .table th { background-color: #004aad; color: white; }
    </style>
</head>
<body class="p-4">

<div class="container mt-5">
    <div class="card p-4">
        <h3 class="text-center mb-4 text-primary">
            <i class="bi bi-search"></i> Buscador de Docentes (API Instituto)
        </h3>

        <form id="formConsumo" method="POST">
            <div class="mb-3">
                <label for="data" class="form-label fw-bold">Nombre o DNI:</label>
                <input type="text" id="data" name="data" class="form-control"
                       placeholder="Ingrese nombre o DNI del docente" required>
            </div>

            <!-- 🔒 Token del cliente autorizado -->
            <input type="hidden" id="token" name="token"
                   value="f9595f6e9dba9ec3d7ea7a0bad02ce5d-251111-2">

            <!-- 🌐 URL del sistema Instituto -->
            <input type="hidden" id="ruta_api" name="ruta_api"
                   value="https://instituto.estudiojuridico.com.pe/">

            <div class="text-center mt-3">
                <button type="submit" class="btn btn-custom px-5">
                    <i class="bi bi-search"></i> Buscar
                </button>
                <a href="?r=consumoapi/form" class="btn btn-outline-secondary px-4 ms-2">
                    <i class="bi bi-key"></i> Ver Token
                </a>
            </div>
        </form>

        <hr>
        <div id="resultado" class="mt-4"></div>
    </div>
</div>

<script>
document.getElementById('formConsumo').addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const cont = document.getElementById('resultado');
    cont.innerHTML = '<div class="alert alert-info">Buscando docente...</div>';

    try {
        const response = await fetch('index.php?r=consumoapi/procesar', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();
        cont.innerHTML = '';

        if (!data.status) {
            cont.innerHTML = `<div class="alert alert-warning">${data.mensaje || data.msg || 'No se encontraron resultados.'}</div>`;
            return;
        }

        const docentes = data.contenido || [];
        if (docentes.length === 0) {
            cont.innerHTML = '<div class="alert alert-info">No se encontraron docentes.</div>';
            return;
        }

        let tabla = `<table class="table table-striped align-middle">
            <thead><tr>
                <th>#</th>
                <th>DNI</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Celular</th>
                <th>Correo</th>
                <th>Especialidad</th>
            </tr></thead><tbody>`;
        docentes.forEach((d, i) => {
            tabla += `<tr>
                <td>${i + 1}</td>
                <td>${d.DNI || ''}</td>
                <td>${d.nombres || ''}</td>
                <td>${d.apellidos || ''}</td>
                <td>${d.celular || ''}</td>
                <td>${d.correo || ''}</td>
                <td>${d.especialidad || ''}</td>
            </tr>`;
        });
        tabla += '</tbody></table>';
        cont.innerHTML = tabla;

    } catch (error) {
        cont.innerHTML = '<div class="alert alert-danger">❌ Error al conectar con el servidor del Instituto.</div>';
    }
});
</script>
</body>
</html>
