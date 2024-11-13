<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Vista de Material de Capacitación - Bufete de Abogados Valbuena</title>
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
                    <a class="nav-link" href="SuperAdmin.html"><i class="bi bi-house"></i> Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="creaCa.php"><i class="bi bi-folder-plus"></i> Creación y asignación de casos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="seguimiento.php"><i class="bi bi-binoculars"></i> Seguimiento de casos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="regiUser.html"><i class="bi bi-person-plus"></i> Registro de usuarios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ListaUsuarios.php"><i class="bi bi-person-plus"></i> Editar usuarios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="mCap.html"><i class="bi bi-book"></i> Módulo de capacitación</a>
                </li>
                <li class="nav-item">
                    <form action="logout.php" method="post">
                        <button type="submit" class="btn btn-light nav-link"><i class="bi bi-door-closed"></i> Cerrar sesión</button>
                    </form>
                </li>
            </ul>
        </nav>
    </header>

    <div class="container mt-5">
        <h2>Vista de Material de Capacitación</h2>
        <div id="materialContainer" class="mt-4">
            <!-- Aquí se cargará el material de capacitación -->
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>Valbuena abogados &copy; 2024</p>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch("php/obtener_material_capacitacion.php")
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const container = document.getElementById("materialContainer");
                        container.innerHTML = ''; // Limpiar el contenedor para asegurar que se llenará correctamente

                        data.materiales.forEach(material => {
                            const materialDiv = document.createElement("div");
                            materialDiv.classList.add("card", "mb-3");

                            let content = `
                                <div class="card-body">
                                    <h5 class="card-title">${material.titulo}</h5>
                                    <p class="card-text">${material.descripcion}</p>
                                    <p class="card-text"><strong>Tipo:</strong> ${material.tipo}</p>`;

                            if (material.tipo === "archivo") {
                                content += `<a href="${material.url}" target="_blank" class="btn btn-primary">Descargar Archivo</a>`;
                            } else if (material.tipo === "enlace") {
                                content += `<a href="${material.url}" target="_blank" class="btn btn-primary">Ver Enlace</a>`;
                            }

                            content += `</div>`;
                            materialDiv.innerHTML = content;
                            container.appendChild(materialDiv);
                        });
                    } else {
                        alert("Error al cargar los materiales de capacitación.");
                    }
                })
                .catch(error => {
                    console.error("Error al cargar el material:", error);
                    alert("Ocurrió un error al cargar el material de capacitación.");
                });
        });
    </script>
</body>
</html>
