<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Asegurarse de que la variable 'productos' no esté vacía
    if (isset($_POST['productos']) && !empty($_POST['productos'])) {
        // Decodificar el JSON
        $productos = json_decode($_POST['productos'], true);

        // Verificar si los productos fueron correctamente decodificados
        if ($productos && is_array($productos)) {
            $contenido = "------ RECIBO DE COMPRA ------\n";
            $contenido .= "Productos:\n";

            $total = 0;
            // Recorremos los productos
            foreach ($productos as $producto => $detalleJson) {
                // Decodificar cada detalle del producto
                $detalle = json_decode($detalleJson, true);

                if ($detalle && isset($detalle['quantity']) && isset($detalle['price'])) {
                    $subtotal = $detalle['quantity'] * $detalle['price'];
                    $total += $subtotal;

                    // Agregar los detalles del producto al contenido del recibo
                    $contenido .= "- Producto: $producto\n";
                    $contenido .= "  Cantidad: {$detalle['quantity']}\n";
                    $contenido .= "  Precio Unitario: S/ {$detalle['price']}\n";
                    $contenido .= "  Subtotal: S/ " . number_format($subtotal, 2) . "\n";
                }
            }

            // Agregar el total al recibo
            $contenido .= "------------------------------\n";
            $contenido .= "TOTAL A PAGAR: S/ " . number_format($total, 2) . "\n";

            // Nombre del archivo
            $nombreArchivo = "recibo_" . date("Ymd_His") . ".txt";

            // Enviar el archivo para descarga
            header('Content-Type: text/plain');
            header("Content-Disposition: attachment; filename=$nombreArchivo");
            echo $contenido;
            exit;
        } else {
            echo "No se encontraron productos en el carrito o los datos están mal formateados.";
        }
    } else {
        echo "No se han recibido datos del carrito.";
    }
}
?>
