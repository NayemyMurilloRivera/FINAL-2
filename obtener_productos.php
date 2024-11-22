<?php
include 'conexion.php';

try {
    $stmt = $pdo->query('SELECT * FROM productos');
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Error al obtener productos: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Productos</title>
    <link rel="stylesheet" href="styles.css"> <!-- Archivo CSS opcional -->
</head>
<body>
    <main class="container">
        <section class="productos">
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $producto): ?>
                    <div class="producto">
                        <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                        <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                        <p class="marca"><?php echo htmlspecialchars($producto['marca']); ?></p>
                        <p class="precio">S/ <?php echo number_format($producto['precio'], 2); ?></p>
                        <button class="agregar-carrito">Agregar al carrito</button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay productos disponibles.</p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>