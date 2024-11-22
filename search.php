<?php
    $host = 'localhost';
    $user = 'root'; 
    $password = ''; 
    $dbname = 'basedatos'; 

    $enlace = new mysqli($host, $user, $password, $dbname);

    if ($enlace->connect_error) {
        die("Error de conexión: " . $enlace->connect_error);
    } else {
        $sql = "SELECT * FROM productos";
        $result = $enlace->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $nombre = $row["Nombre"];
            $precio = $row["Precio"];
            $stock = $row["Stock"];
            $desc = $row["Descuento"];
        } else {
            echo "No se encontraron productos.";
        }

        $enlace->close();
    }
?>
