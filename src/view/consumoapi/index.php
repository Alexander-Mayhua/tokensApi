<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consumo de API - Instituto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f3f6fa;
            font-family: "Segoe UI", Arial, sans-serif;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        .btn-custom {
            background-color: #004aad;
            color: white;
            border-radius: 8px;
        }
        .btn-custom:hover {
            background-color: #003d91;
        }
    </style>
</head>
<body class="p-4">
<div class="container mt-5">
    <div class="card p-4">
        <h3 class="text-center mb-4 text-primary">🔍 Buscador de Docentes (API Instituto)</h3>

        <form id="formConsumo" method="POST">
            <div class="mb-3">
                <label for="data" class="form-label fw-bold">Nombre o DNI:</label>
                <input type="text" id="data" name="data" class="form-control" placeholder="Ingrese nombre o DNI del docente" required>
            </div>

            <!-- Token fijo -->
            <input type="hidden" id="token" name="token" value="16b75f62760d5cd712a1a4885e73aae6-251111-3">

            <!-- Ruta del API principal -->
            <input type="hidden" id="ruta_api" name="ruta_api" 
                   value="https://instituto.estudiojuridico.com.pe/?c=consumoapi&a=verDocenteApiByNombreODni">

            <input type="hidden" name="tipo" value="verdocenteapibynombreodni">

            <div class="text-center">
                <button type="submit" class="btn btn-custom px-5">Buscar</button>
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
    const response = await fetch('index.php?r=consumoapi/procesar', {
        method: 'POST',
        body: formData
    });

    const data = await response.json().catch(() => null);
    const cont = document.getElementById('resultado');
    cont.innerHTML = '';

    if (!data) {
        cont.innerHTML = '<div class="alert alert-danger">Error al procesar la respuesta.</div>';
        return;
    }

    if (!data.status) {
        cont.innerHTML = `<div class="alert alert-warning">${data.mensaje || 'Error desconocido'}</div>`;
        return;
    }

    // Mostrar los docentes en una tabla
    const docentes = data.contenido || [];
    if (docentes.length === 0) {
        cont.innerHTML = '<div class="alert alert-info">No se encontraron docentes.</div>';
        return;
    }

    let tabla = `<table class="table table-striped">
        <thead><tr><th>#</th><th>DNI</th><th>Nombre</th><th>Apellido</th></tr></thead><tbody>`;
    docentes.forEach((d, i) => {
        tabla += `<tr><td>${i + 1}</td><td>${d.DNI || ''}</td><td>${d.nombres || ''}</td><td>${d.apellidos || ''}</td></tr>`;
    });
    tabla += '</tbody></table>';
    cont.innerHTML = tabla;
});
</script>
</body>
</html>
