<?php
session_start();

// Si ya hay una sesión activa, redirigir al usuario a la página correspondiente
if (isset($_SESSION['usuario_id'])) {
    switch ($_SESSION['rol']) {
        case "SuperAdmin":
            header("Location: SuperAdmin.html");
            break;
        case "Admin":
            header("Location: Administrador.html");
            break;
        case "Abogado":
            header("Location: Abogado.html");
            break;
        case "Secretario":
            header("Location: Secretario.html");
            break;
        case "Usuario":
            header("Location: Usuario.html");
            break;
        default:
            // En caso de un rol inesperado, redirigir a una página de error o cerrar la sesión
            header("Location: logout.php");
            break;
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Bufete de Abogados - Acceso</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <header class="bg-dark text-white text-center py-3">
        <h1 style="margin-bottom: 2rem;">Accede a la plataforma</h1>
        <nav>
            <ul class="nav nav-pills nav-fill justify-content-center">
                <li class="nav-item">
                    <a class="nav-link" href="index.html">
                        <i class="bi bi-house"></i> Inicio
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="servicios.html">
                        <i class="bi bi-briefcase"></i> Servicios
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contacto.html">
                        <i class="bi bi-envelope"></i> Contacto
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="acceso.php">
                        <i class="bi bi-box-arrow-in-right"></i> Acceso
                    </a>
                </li>
            </ul>
        </nav>
    </header>

    <section class="container my-5">
        <div class="row align-items-center">
            <div class="col-md-6 text-center">
                <img src="Images/logoempresarial.jpg" class="img-fluid" alt="Logo Empresarial">
            </div>

            <div class="col-md-6">
                <h2 class="text-center mb-4">Iniciar Sesión</h2>

                <div class="alert alert-info text-center">
                    <strong>¡Bienvenido!</strong> Accede a tu cuenta para disfrutar de nuestros servicios personalizados
                    y obtener el soporte que necesitas. Inicia sesión para continuar.
                </div>

                <form id="loginForm" class="row g-3" method="post" action="#">
                    <div class="col-md-12">
                        <label for="email" class="form-label">Correo Electrónico:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="col-md-12">
                        <label for="password" class="form-label">Contraseña:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary mt-3">Iniciar Sesión</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-white text-center py-3">
        <p>Valbuena abogados &copy; 2024</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#loginForm").submit(function (event) {
                event.preventDefault();

                var formData = {
                    email: $("#email").val(),
                    password: $("#password").val()
                };

                $.ajax({
                    type: "POST",
                    url: "php/login.php",
                    data: formData,
                    success: function (response) {
                        response = response.trim();
                        console.log("Respuesta del servidor:", response);

                        switch (response) {
                            case "superadmin":
                                window.location.href = "SuperAdmin.html";
                                break;
                            case "admin":
                                window.location.href = "Administrador.html";
                                break;
                            case "abogado":
                                window.location.href = "Abogado.html";
                                break;
                            case "secretario":
                                window.location.href = "Secretario.html";
                                break;
                            case "usuario":
                                window.location.href = "Usuario.html";
                                break;
                            default:
                                alert("Correo o contraseña incorrectos, o usuario inactivo.");
                        }
                    },
                    error: function (xhr, status, error) {
                        alert("Error en la solicitud: " + status + " - " + error);
                    }
                });
            });
        });
    </script>
</body>

</html>
