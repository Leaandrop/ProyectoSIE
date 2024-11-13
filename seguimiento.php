<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Bufete de Abogados Valbuena - Administrador</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <?php include 'php/obtener_casos.php'; ?>
    <header class="bg-dark text-white text-center py-3">
        <h1 style="margin-bottom: 2rem;">Bienvenido</h1>
        <nav>
            <ul class="nav nav-pills nav-fill justify-content-center">
                <li class="nav-item">
                    <a class="nav-link" href="SuperAdmin.html">
                        <i class="bi bi-house"></i> Inicio
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="creaCa.php">
                        <i class="bi bi-folder-plus"></i> Creación y asignación de casos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="seguimiento.php">
                        <i class="bi bi-binoculars"></i> Seguimiento de casos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="regiUser.html">
                        <i class="bi bi-person-plus"></i> Registro de usuarios
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ListaUsuarios.php">
                        <i class="bi bi-person-plus"></i> Editar usuarios
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="mCap.html">
                        <i class="bi bi-book"></i> Módulo de capacitación
                    </a>
                </li>
                <li class="nav-item">
                    <form action="logout.php" method="post">
                        <button type="submit" class="btn btn-light nav-link">
                            <i class="bi bi-door-closed"></i> Cerrar sesión
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </header>

    <!-- Aquí agregamos una clase de margen superior -->
    <div class="container table-section mt-4">
        <h3>Casos Activos</h3>
        <p>Aquí puedes ver el seguimiento de todos los casos registrados en el sistema.</p>

        <div class="row mb-3">
            <div class="col-md-6">
                <input type="text" id="buscarInput" class="form-control"
                    placeholder="Buscar por número de caso, descripción o estado" onkeyup="filtrarCasos()">
            </div>
            <div class="col-md-6">
                <select id="filtroEstado" class="form-control" onchange="filtrarCasos()">
                    <option value="">Todos los estados</option>
                    <option value="abierto">Abierto</option>
                    <option value="cerrado">Cerrado</option>
                    <option value="en progreso">En progreso</option>
                </select>
            </div>
        </div>

        <?php if (!empty($casos)): ?>
            <table class="table table-hover" id="tablaCasos">
                <thead>
                    <tr>
                        <th>Número de Caso</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Fecha de Creación</th>
                        <th>Fecha de Cierre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($casos as $caso): ?>
                        <tr id="caso-<?php echo htmlspecialchars($caso['id'] ?? ''); ?>">
                            <td><?php echo htmlspecialchars($caso['numero_caso'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($caso['descripcion'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($caso['estado'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($caso['fecha_creacion'] ?? ''); ?></td>
                            <td>
                                <?php echo $caso['fecha_cierre'] ? htmlspecialchars($caso['fecha_cierre']) : '<span class="text-muted">N/A</span>'; ?>
                            </td>
                            <td>
                                <button class="btn btn-info btn-sm"
                                    onclick="mostrarDetalles('<?php echo addslashes($caso['numero_caso'] ?? ''); ?>')">
                                    <i class="bi bi-info-circle"></i> Detalles
                                </button>

                                <button class="btn btn-danger btn-sm"
                                    onclick="cerrarCaso('<?php echo addslashes($caso['id'] ?? ''); ?>')">
                                    <i class="bi bi-x-circle"></i> Cerrar Caso
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-muted">No hay casos registrados.</p>
        <?php endif; ?>
    </div>

    <!-- Modal para Detalles del Caso -->
    <div class="modal fade" id="detalleModal" tabindex="-1" aria-labelledby="detalleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detalleModalLabel">Detalles del Caso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Documento</th>
                                <th>Nombre</th>
                                <th>Número de Licencia</th>
                            </tr>
                        </thead>
                        <tbody id="detalleTablaBody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

    <script>
        function filtrarCasos() {
            const buscarInput = document.getElementById("buscarInput").value.toLowerCase();
            const filtroEstado = document.getElementById("filtroEstado").value.toLowerCase();
            const filas = document.querySelectorAll("#tablaCasos tbody tr");

            filas.forEach(fila => {
                const textoFila = fila.textContent.toLowerCase();
                const estadoFila = fila.querySelector("td:nth-child(3)").textContent.toLowerCase();

                if ((textoFila.includes(buscarInput)) &&
                    (filtroEstado === "" || estadoFila === filtroEstado)) {
                    fila.style.display = "";
                } else {
                    fila.style.display = "none";
                }
            });
        }

        function mostrarDetalles(numeroCaso) {
            fetch(`php/detalles_caso.php?numero_caso=${numeroCaso}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        let contenido = `
                        <tr>
                            <td>Abogado</td>
                            <td>${data.abogado_documento || 'N/A'}</td>
                            <td>${data.abogado_nombre || 'N/A'}</td>
                            <td>${data.abogado_licencia || 'N/A'}</td>
                        </tr>
                        <tr>
                            <td>Cliente</td>
                            <td>${data.cliente_documento || 'N/A'}</td>
                            <td>${data.cliente_nombre || 'N/A'}</td>
                            <td>${data.cliente_licencia || 'N/A'}</td>
                        </tr>
                    `;
                        document.getElementById('detalleTablaBody').innerHTML = contenido;
                        new bootstrap.Modal(document.getElementById('detalleModal')).show();
                    }
                })
                .catch(error => {
                    console.error('Error al obtener los detalles:', error);
                    alert('Ocurrió un error al obtener los detalles del caso.');
                });
        }

        function cerrarCaso(caso_id) {
            if (confirm("¿Estás seguro de que deseas cerrar este caso?")) {
                fetch(`php/cerrar_caso.php`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `caso_id=${caso_id}`
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("El caso ha sido cerrado.");
                            document.querySelector(`#caso-${caso_id} td:nth-child(3)`).innerText = "cerrado";
                            document.querySelector(`#caso-${caso_id} td:nth-child(5)`).innerText = data.fecha_cierre;
                        } else {
                            alert("Error al cerrar el caso: " + data.error);
                        }
                    })
                    .catch(error => {
                        console.error('Error al cerrar el caso:', error);
                        alert('Ocurrió un error al cerrar el caso.');
                    });
            }
        }
    </script>
</body>

<footer class="bg-dark text-white text-center py-3">
    <p>Valbuena abogados &copy; 2024</p>
</footer>

</html>
