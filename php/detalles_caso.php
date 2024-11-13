<?php
include 'conexion.php';

if (isset($_GET['numero_caso'])) {
    $numero_caso = $_GET['numero_caso'];

    // Consulta para obtener detalles del abogado y cliente del caso usando la tabla Asignaciones
    $sql = "SELECT 
                c.descripcion AS descripcion_caso,
                a.fecha_asignacion,
                ab.NUIP AS abogado_documento,
                CONCAT(ab.nombre, ' ', ab.apellido) AS abogado_nombre,
                ab.numero_licencia AS abogado_licencia,
                cl.NUIP AS cliente_documento,
                CONCAT(cl.nombre, ' ', cl.apellido) AS cliente_nombre,
                cl.numero_licencia AS cliente_licencia
            FROM Casos c
            LEFT JOIN Asignaciones a ON c.id = a.caso_id
            LEFT JOIN Usuarios ab ON a.abogado_id = ab.id
            LEFT JOIN Usuarios cl ON a.cliente_id = cl.id
            WHERE c.numero_caso = :numero_caso";
    
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':numero_caso', $numero_caso);
    $stmt->execute();
    $detalle = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($detalle) {
        echo json_encode($detalle);
    } else {
        echo json_encode(["error" => "No se encontraron detalles para este caso."]);
    }
} else {
    echo json_encode(["error" => "Número de caso no especificado."]);
}
?>
