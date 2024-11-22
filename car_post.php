<?php
    include 'conexion.php';

    if (!isset($_SESSION['id'])) {
        die("No se ha iniciado sesión. Por favor, inicie sesión primero.");
    }

    $id_usuario = $_SESSION['id'];

    $data = json_decode(file_get_contents('php://input'), true);

    $nombre = $data['nombre'];
    $precio = $data['precio'];
    $cantidad = $data['cantidad'];
    $descuento = $data['descuento'];

    $stmt = $enlace->prepare("INSERT INTO carrito (id, Nombre, Precio, Cantidad, Descuento) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issdi", $id, $nombre, $precio, $cantidad, $descuento);

    if ($stmt->execute()) {
        echo "Producto añadido al carrito con éxito.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $enlace->close();
?>