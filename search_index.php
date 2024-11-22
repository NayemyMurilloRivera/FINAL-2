<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GFarma</title>
    <link rel="stylesheet" href="style_inicio.css">
    <link rel="icon" type="image/logogfarma" href="images/logogfarma.png">
</head>
<body>
    <?php 
        session_start();
        include 'conexion.php';

        $enlace = new mysqli($host, $user, $password, $dbname);

        try {
            $stmt = $pdo->query('SELECT * FROM productos');
            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Error al obtener productos: ' . $e->getMessage();
        }

        $productos = [];

        if (isset($_GET['enviar']) && !empty($_GET['barra'])) {
            $busqueda = $_GET['barra'];
            
            $consulta = $enlace->prepare("SELECT * FROM productos WHERE Nombre LIKE ?");
            $busqueda_param = "%" . $busqueda . "%";
            $consulta->bind_param("s", $busqueda_param);
            $consulta->execute();
            $resultado = $consulta->get_result();

            while ($producto = $resultado->fetch_assoc()) {
                $productos[] = $producto;
            }
            
            $consulta->close();
        }
    ?>

    <header>
        <div class="top-bar">
            <div class="container">
                <a><img src="images/telefono.png" class="button-icon">Farmafono Arequipa - (123) 314 - 2024</a>
            </div>
        </div>

        <div class="main-header">
            <div class="container">
                <img src="images/logogfarma.png" alt="Logo" class="logo">
                <div class="search-bar">
                    <form action="search_index.php" method="GET" class="search-bar"> 
                        <input type="text" name="barra" placeholder="Busca una marca o producto"><button type="submit" name="enviar" style="display: inline-block;">Buscar</button>
                    </form>
                </div>
                <?php
                 if (isset($_GET['enviar'])){
                    $busqueda=$_GET['barra'];
                    $consulta=$enlace->query("SELECT * FROM productos WHERE Nombre LIKE '%$busqueda'");
                 }

                 if (isset($_SESSION['usuario_login'])) {
                    echo '<div class="user-button-container">
                        <button class="user-button" href="informacion.php"><img src="images/icono_usuario.png" class="button-icon">Bienvenido, ' . $_SESSION['usuario_login'] . '</button>
                        <button class="user-action-button"><img src="images/anadir-al-carrito.png" class="button-icon"></button>
                    </div>';
                } 
                ?>
            </div>
        </div>

        <nav>
        <ul class="nav-list">
        <li class="dropdown">
            <li>
            <form action="#" method="get">
                <select name="categorias" id="categorias" onchange="location = this.value;">
                    <option value="#" disabled selected>Categoría</option>
                    <option value="categoria1.html">Categoría 1</option>
                    <option value="categoria2.html">Categoría 2</option>
                    <option value="categoria3.html">Categoría 3</option>
                </select>
            </form>
             </li>
            <li>
                <form action="#" method="get">
                <select name="producto" id="produc" onchange="location = this.value;">
                    <option value="#" disabled selected>Productos</option>
                    <option value="categoria1.html"> 1</option>
                    <option value="categoria2.html"> 2</option>
                    <option value="categoria3.html">3</option>
                </select>
            </form>
            </li>
            <li>
                <form action="#" method="get">
                <select name="servicios" id="serv" onchange="location = this.value;">
                    <option value="#" disabled selected>Servicios</option>
                    <option value="1.html"> 1</option>
                    <option value="2.html"> 2</option>
                    <option value="3.html">3</option>
                </select>
            </form>
            </li>
        </li>
        </ul>
        </nav>
    </header>

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
                <p>No se encontraron productos que coincidan con tu búsqueda.</p>
            <?php endif; ?>
        </section>
    </main>

    <div id="modal-backdrop" class="modal-backdrop"></div>
    <div id="cart-modal" class="modal">
        <span id="close-modal" class="close-button">&times;</span>
        <h2>Tu carrito</h2>
        <div id="cart-items"></div>
        <p class="total-price">Total: S/ <span id="total-price">0.00</span></p>
    <!-- Nuevo botón para finalizar la compra -->
    <button id="finalizar-compra-button" style="margin-top: 20px;">Finalizar Compra</button>
    </div>

    <footer>
        <!-- Footer aquí -->
    </footer>

    <script>
        const cart = {}; // Carrito como objeto dinámico

        // Referencias a elementos del DOM
        const cartButton = document.querySelector('.user-action-button');
        const cartModal = document.getElementById('cart-modal');
        const closeModalButton = document.getElementById('close-modal');
        const modalBackdrop = document.getElementById('modal-backdrop');
        const addToCartButtons = document.querySelectorAll('.agregar-carrito');
        const cartItemsContainer = document.getElementById('cart-items');
        const totalPriceElement = document.getElementById('total-price');

        // Función para mostrar el modal
        function showModal() {
            cartModal.classList.add('active');
            modalBackdrop.classList.add('active');
            renderCart();
        }

        // Función para cerrar el modal
        function closeModal() {
            cartModal.classList.remove('active');
            modalBackdrop.classList.remove('active');
        }

        function addToCart(event) 
        {
            const productElement = event.target.closest('.producto');
            const productName = productElement.querySelector('h3, h4').textContent; // Toma el título del producto
            const productPrice = parseFloat(
                productElement.querySelector('.precio').textContent.replace('S/', '').trim() // Elimina "S/" y espacios
            );

            if (!cart[productName]) {
                cart[productName] = { price: productPrice, quantity: 1 };
            } else {
                cart[productName].quantity++;
            }
            renderCart();
        }
        // Función para actualizar la vista del carrito
        function renderCart() {
            cartItemsContainer.innerHTML = '';
            let total = 0;

            for (const [productName, productData] of Object.entries(cart)) {
                const itemTotal = productData.price * productData.quantity;
                total += itemTotal;

                const cartItem = document.createElement('div');
                cartItem.className = 'cart-item';

                cartItem.innerHTML = `
                    <span>${productName}</span>
                    <span>S/ ${itemTotal.toFixed(2)}</span>
                    <div class="cart-actions">
                        <button class="decrease">-</button>
                        <span>${productData.quantity}</span>
                        <button class="increase">+</button>
                        <button class="remove">X</button>
                    </div>
                `;

                cartItem.querySelector('.increase').addEventListener('click', () => {
                    cart[productName].quantity++;
                    renderCart();
                });

                cartItem.querySelector('.decrease').addEventListener('click', () => {
                    cart[productName].quantity--;
                    if (cart[productName].quantity <= 0) delete cart[productName];
                    renderCart();
                });

                cartItem.querySelector('.remove').addEventListener('click', () => {
                    delete cart[productName];
                    renderCart();
                });

                cartItemsContainer.appendChild(cartItem);

                const comprarButton = document.getElementById('comprar-button');

                comprarButton.addEventListener('click', async () => {
                const usuario = "<?php echo isset($_SESSION['usuario_login']) ? $_SESSION['usuario_login'] : 'Invitado'; ?>";
                const compraData = {
                    usuario,
                    carrito: cart
                };
                

                // Enviar datos al servidor
                try {
                    const response = await fetch('procesar_compra.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(compraData),
                    });

                    const result = await response.json();
                    if (result.success) {
                        alert('Compra registrada con éxito.');
                        cartItemsContainer.innerHTML = '';
                        totalPriceElement.textContent = '0.00';
                        Object.keys(cart).forEach(key => delete cart[key]); // Vacía el carrito
                        closeModal();
                    } else {
                        alert('Ocurrió un error al procesar la compra.');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('No se pudo completar la compra.');
                }
            });
            }

            totalPriceElement.textContent = total.toFixed(2);
        }

        // Referencia al nuevo botón
    const finalizarCompraButton = document.getElementById('finalizar-compra-button');

    // Evento para el botón
    finalizarCompraButton.addEventListener('click', () => {
        // Crear un formulario dinámico
        const form = document.createElement('form');
        form.action = 'pagina_compra.php'; // Página a la que redirigir
        form.method = 'POST';

        // Agregar los productos del carrito como inputs ocultos
        for (const [productName, productData] of Object.entries(cart)) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = `productos[${productName}]`; // Nombre del producto como clave
            input.value = JSON.stringify(productData); // Detalles del producto
            form.appendChild(input);
        }

        // Agregar el formulario al DOM y enviarlo
        document.body.appendChild(form);
        form.submit();
    });


        // Eventos
        cartButton.addEventListener('click', showModal);
        closeModalButton.addEventListener('click', closeModal);
        modalBackdrop.addEventListener('click', closeModal);
        addToCartButtons.forEach(button => button.addEventListener('click', addToCart));
    </script>
</body>
</html>