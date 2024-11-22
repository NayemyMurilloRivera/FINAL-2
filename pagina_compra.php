<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen de tu compra</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        header {
            background-color: #ffc107;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }
        header img {
            height: 50px; /* Ajusta la altura del logo */
        }
        header a {
            text-decoration: none;
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
        }
        .container {
            flex: 1;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .product-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .product-list li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
        }
        .product-list li div {
            margin-right: 10px;
        }
        .product-name {
            font-weight: bold;
            font-size: 16px;
            color: #555;
            flex: 2;
        }
        .product-details {
            text-align: right;
            flex: 1;
        }
        .total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
            color: #333;
        }
        footer {
            text-align: center;
            padding: 10px 20px;
            background-color: #ffc107;
            color: #333;
            margin-top: auto;
        }
        .generate-button {
            text-align: center;
            margin-top: 20px;
        }
        .generate-button button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        .generate-button button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <header>
    <img src="images/logogfarma.png" alt="Logo" class="logo">
        <a href="index.php">Volver a la tienda</a>
    </header>
    <div class="container">
        <h2>Resumen de tu compra</h2>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productos = $_POST['productos'] ?? [];
            if (!empty($productos)) {
                echo "<ul class='product-list'>";
                $total = 0;
                foreach ($productos as $producto => $detalle) {
                    $detalleDecoded = json_decode($detalle, true);
                    $subtotal = $detalleDecoded['quantity'] * $detalleDecoded['price'];
                    $total += $subtotal;
                    echo "<li>
                            <div class='product-name'>{$producto}</div>
                            <div class='product-details'>
                                <div>Cantidad: {$detalleDecoded['quantity']}</div>
                                <div>Subtotal: S/ " . number_format($subtotal, 2) . "</div>
                            </div>
                          </li>";
                }
                echo "</ul>";
                echo "<p class='total'>Total a pagar: S/ " . number_format($total, 2) . "</p>";
                echo "<div class='generate-button'>
                        <form method='POST' action='generar_recibo.php'>
                            <input type='hidden' name='productos' value='" . json_encode($productos) . "'>
                            <button type='submit'>Generar recibo</button>
                        </form>
                      </div>";
            } else {
                echo "<p>No hay productos en el carrito.</p>";
            }
        } else {
            echo "<p>No se han recibido datos del carrito.</p>";
        }
        ?>
    </div>
    <footer>
        &copy; 2024 GN Farma - Todos los derechos reservados
    </footer>
</body>
</html>