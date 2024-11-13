<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Bufete de Abogados Valbuena - Administrador</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<style>
    .spacer {
        margin-bottom: 50px; /* Ajusta el valor según el espacio que necesites */
    }
</style>

<body>
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
                    <a class="nav-link active" aria-current="page" href="creaCa.php">
                        <i class="bi bi-folder-plus"></i> Creación y asignación de casos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="seguimiento.php">
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


    <div class="container mt-5">
        <h2>Crear Nuevo Caso</h2>
        <form id="crearCasoForm" class="spacer">
            <div class="mb-3">
                <label for="numero_caso" class="form-label">Número de Caso</label>
                <input type="text" class="form-control" id="numero_caso" name="numero_caso" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="usuario_id" class="form-label">Usuario</label>
                <select class="form-control" id="usuario_id" name="usuario_id" required>
                    <?php
                    include 'php/conexion.php';
                    $usuarios = $conexion->query("SELECT id, nombre, apellido FROM Usuarios WHERE rol = 'Usuario'");
                    while ($usuario = $usuarios->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$usuario['id']}'>{$usuario['nombre']} {$usuario['apellido']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="abogado_id" class="form-label">Abogado</label>
                <select class="form-control" id="abogado_id" name="abogado_id" required>
                    <?php
                    $abogados = $conexion->query("SELECT id, nombre, apellido FROM Usuarios WHERE rol = 'Abogado'");
                    while ($abogado = $abogados->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$abogado['id']}'>{$abogado['nombre']} {$abogado['apellido']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="secretario_id" class="form-label">Secretario (opcional)</label>
                <select class="form-control" id="secretario_id" name="secretario_id">
                    <option value="">Ninguno</option>
                    <?php
                    $secretarios = $conexion->query("SELECT id, nombre, apellido FROM Usuarios WHERE rol = 'Secretario'");
                    while ($secretario = $secretarios->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$secretario['id']}'>{$secretario['nombre']} {$secretario['apellido']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Crear Caso</button>
        </form>
    </div>

    <footer class="bg-dark text-white text-center py-3">
        <p>Valbuena abogados &copy; 2024</p>
    </footer>

    <script>
        document.getElementById('crearCasoForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Evitar el envío del formulario
            const formData = new FormData(this);

            fetch('php/crear_caso.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Caso creado exitosamente");
                        document.getElementById('crearCasoForm').reset(); // Limpiar el formulario
                    } else {
                        alert("Error al crear el caso: " + data.error);
                    }
                })
                .catch(error => {
                    console.error("Error al crear el caso:", error);
                    alert("Ocurrió un error al crear el caso.");
                });
        });
    </script>
</body>

</html>