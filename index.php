<?php
session_start();

if (isset($_SESSION['usuario_login'])) {
    header('Location: index_inicio.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFarma</title>
    <link rel="stylesheet" href="gfarma.css">
    <link rel="icon" type="image/logogfarma" href="images/logogfarma.png">
</head>
<body>
    <?php 
        include 'conexion.php';
        $enlace = new mysqli($host, $user, $password, $dbname);

        try {
            $stmt = $pdo->query('SELECT * FROM productos');
            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Error al obtener productos: ' . $e->getMessage();
        }
    ?>
    <header>
        <div class="top-bar">
            <div class="user-actions">
                <button id="btn-abrir-modal" class="login" type="button">Iniciar sesión</button>
                <div id="modal" class="modal">
                    <div class="modal-content">
                    <div class="modal-close">
                        <button class="modal-close" id="btn-cerrar-modal">&times;</button>
                    </div>

                        <form action="login_datos.php" method="POST">
                            <label for="usuario1">Usuario:</label>
                            <input type="text" id="usuario1" name="usuario1" required>

                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required>

                            <label for="contraseña">Contraseña:</label>
                            <input type="password" id="contraseña" name="contraseña" required>

                            <button type="submit">Iniciar sesión</button>
                        </form>
                    </div>
                </div>
                <a href="registro.php" class="register">Registrarte</a>
            </div>
        </div>
            </div>
        </div>
        <div class="main-header">
            <div class="container">
                <img src="images/logogfarma.png" alt="Logo" class="logo">
                <div class="search-bar">
                    <form action="search_index.php" method="GET"> 
                        <input type="text" name="barra" placeholder="Busca una marca o producto"><button type="submit" name="enviar">Buscar</button>
                    </form>
                </div>
                <?php
                 if (isset($_SESSION['usuario_login'])) {
                    echo '<div class="user-button-container">
                        <button class="user-button" href="informacion.php"><img src="images/icono_usuario.png" class="button-icon">Bienvenido, ' . $_SESSION['usuario_login'] . '</button>
                        <button class="user-action-button"><img src="images/anadir-al-carrito.png" class="button-icon"></button>
                    </div>';
                } 
                ?>
            </div>
        </div>
        <nav class="main-nav">
            <div class="container">
                <a href="#">Categorías</a>
                <a href="#">Dermocosmética</a>
                <a href="#">Belleza</a>
                <a href="#">Bienestar</a>
                <a href="#">Catálogo</a>
            </div>
        </nav>
    </header>
    <script>
        const abrirModalBtn = document.getElementById("btn-abrir-modal");
        const cerrarModalBtn = document.getElementById("btn-cerrar-modal");
        const modal = document.getElementById("modal");

        abrirModalBtn.addEventListener("click", () => {
            modal.style.display = "flex"; 
        });

        cerrarModalBtn.addEventListener("click", () => {
            modal.style.display = "none";  
        });

        window.addEventListener("click", (event) => {
            if (event.target === modal) {
                modal.style.display = "none";  
            }
        });
    </script>

    <main class="container">
        <section class="productos">
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $producto): ?>
                    <div class="producto">
                        <img src="<?php echo htmlspecialchars($producto['Imagen']); ?>" alt="<?php echo htmlspecialchars($producto['Nombre']); ?>">
                        <?php if (strlen($producto['Nombre']) > 20): ?>
                            <h4><?php echo htmlspecialchars($producto['Nombre']); ?></h4>
                        <?php else: ?>
                            <h3><?php echo htmlspecialchars($producto['Nombre']); ?></h3>
                        <?php endif; ?>

                        <p class="Marca"><?php echo htmlspecialchars($producto['Marca']); ?></p>

                        <?php if (($producto['Descuento'] > 0) && ($producto['Descuento'] < $producto['Precio'])): ?>
                            <?php 
                                $precio_original = $producto['Precio'];
                                $precio_descuento = $precio_original - $producto['Descuento'];
                            ?>
                            <p class="Precio">
                                <span class="precio-original" style="text-decoration: line-through;">S/ <?php echo number_format($precio_original, 2); ?></span>
                                <span class="precio-descuento" style="color: red; font-weight: bold;">S/ <?php echo number_format($precio_descuento, 2); ?></span>
                            </p>
                        <?php else: ?>
                            <p class="Precio">S/ <?php echo number_format($producto['Precio'], 2); ?></p>
                        <?php endif; ?>

                        <button class="agregar-carrito">Agregar al carrito</button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay productos disponibles.</p>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        
    </footer>
</body>
</html>