<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Bufete de Abogados Valbuena - Lista de Usuarios</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.css" rel="stylesheet">
</head>

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
                    <a class="nav-link" href="creaCa.php">
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
                    <a class="nav-link active" aria-current="page" href="ListaUsuarios.php">
                        <i class="bi bi-person-plus"></i> Editar usuarios
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="gesArchi.html">
                        <i class="bi bi-file-earmark-text"></i> Gestión de documentos
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

    <?php include 'php/conexion.php'; ?>

    <div class="container mt-5">
        <h2>Usuarios Registrados</h2>
        <?php
        if (isset($_GET['mensaje'])) {
            echo "<div class='alert alert-info'>" . htmlspecialchars($_GET['mensaje']) . "</div>";
        }
        ?>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>NUIP</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT id, nombre, apellido, NUIP, email, rol FROM Usuarios";
                $stmt = $conexion->prepare($sql);
                $stmt->execute();
                $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($usuarios as $usuario) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($usuario['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($usuario['nombre']) . "</td>";
                    echo "<td>" . htmlspecialchars($usuario['apellido']) . "</td>";
                    echo "<td>" . htmlspecialchars($usuario['NUIP']) . "</td>";
                    echo "<td>" . htmlspecialchars($usuario['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($usuario['rol']) . "</td>";
                    echo "<td>";
                    echo "<a href='EditUsu.php?id=" . htmlspecialchars($usuario['id']) . "' class='btn btn-warning btn-sm'>Editar</a> ";
                    echo "<button onclick='confirmarEliminacion(" . htmlspecialchars($usuario['id']) . ")' class='btn btn-danger btn-sm'>Eliminar</button>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>Valbuena abogados &copy; 2024</p>
    </footer>

    <script>
        // Verifica si la URL contiene el parámetro `mensaje=actualizado`
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('mensaje') === 'actualizado') {
            alert("Usuario actualizado exitosamente");
        }

        function confirmarEliminacion(id) {
            if (confirm("¿Estás seguro de que deseas eliminar este usuario?")) {
                window.location.href = "php/eliminar_usuario.php?id=" + id;
            }
        }
    </script>
</body>

</html>