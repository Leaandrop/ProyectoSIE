<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Bufete de Abogados Valbuena - Editar Usuario</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <?php
    include 'php/conexion.php';

    // Verifica si se envió el ID del usuario a editar
    if (isset($_GET['id'])) {
        $usuario_id = $_GET['id'];

        // Consulta para obtener los datos del usuario
        $sql = "SELECT * FROM Usuarios WHERE id = :usuario_id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            echo "<p>Usuario no encontrado.</p>";
            exit();
        }
    } else {
        echo "<p>ID de usuario no especificado.</p>";
        exit();
    }
    ?>

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
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2>Editar Información del Usuario</h2>
                <form action="php/actualizar_usuario.php" method="POST">
                    <!-- Campo oculto para el ID del usuario -->
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($usuario['id']); ?>">

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre"
                            value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido"
                            value="<?php echo htmlspecialchars($usuario['apellido']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="NUIP" class="form-label">NUIP</label>
                        <input type="text" class="form-control" id="NUIP" name="NUIP"
                            value="<?php echo htmlspecialchars($usuario['NUIP']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono"
                            value="<?php echo htmlspecialchars($usuario['telefono']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion"
                            value="<?php echo htmlspecialchars($usuario['direccion']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="contrasena" class="form-label">Contraseña (Dejar en blanco si no desea
                            cambiarla)</label>
                        <input type="password" class="form-control" id="contrasena" name="contrasena">
                    </div>
                    <div class="mb-3">
                        <label for="rol" class="form-label">Rol</label>
                        <select class="form-control" id="rol" name="rol" required>
                            <option value="SuperAdmin" <?php if ($usuario['rol'] == 'SuperAdmin')
                                echo 'selected'; ?>>
                                SuperAdmin</option>
                            <option value="Admin" <?php if ($usuario['rol'] == 'Admin')
                                echo 'selected'; ?>>Admin</option>
                            <option value="Abogado" <?php if ($usuario['rol'] == 'Abogado')
                                echo 'selected'; ?>>Abogado
                            </option>
                            <option value="Secretario" <?php if ($usuario['rol'] == 'Secretario')
                                echo 'selected'; ?>>
                                Secretario</option>
                            <option value="Usuario" <?php if ($usuario['rol'] == 'Usuario')
                                echo 'selected'; ?>>Usuario
                            </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="numero_licencia" class="form-label">Número de Licencia</label>
                        <input type="text" class="form-control" id="numero_licencia" name="numero_licencia"
                            value="<?php echo htmlspecialchars($usuario['numero_licencia']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="especialidad" class="form-label">Especialidad</label>
                        <input type="text" class="form-control" id="especialidad" name="especialidad"
                            value="<?php echo htmlspecialchars($usuario['especialidad']); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>Valbuena abogados &copy; 2024</p>
    </footer>
</body>

</html>