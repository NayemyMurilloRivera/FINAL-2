<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro G Fharma</title>
    <link rel="stylesheet" href="style_registro.css"> 
</head>
<body>
    <header>
        <div class="top-bar">
            <div class="container">
                <a>Registrandote...</a>
            </div>
        </div>

        <div class="main-header">
            <div class="container">
                <img src="images/logogfarma.png" alt="Logo" class="logo">
                <div class="search-bar">
                    <input type="text" placeholder="Busca una marca o producto"><button>Buscar</button>
                </div>
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
    <div class="form-container">
        <h1>¡Ya casi terminamos!</h1>
        <p>Completa estos datos para crear tu cuenta</p>
        <form action="registro_datos.php" method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label for="documento">Tipo de documento</label>
                    <select name="documento" id="documento" required>
                        <option value="DNI">DNI</option>
                        <option value="Pasaporte">Pasaporte</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="numero_documento">Número de documento</label>
                    <input type="text" name="numero_documento" id="numero_documento" required placeholder="Ingresa tu DNI">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="nombre">Nombres</label>
                    <input type="text" name="nombre" id="nombre" required placeholder="Ingresa tus nombres">
                </div>
                <div class="form-group">
                    <label for="apellido_paterno">Apellido paterno</label>
                    <input type="text" name="apellido_paterno" id="apellido_paterno" required placeholder="Ingresa tu apellido paterno">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="apellido_materno">Apellido materno</label>
                    <input type="text" name="apellido_materno" id="apellido_materno" required placeholder="Ingresa tu apellido materno">
                </div>
                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" name="email" id="email" required placeholder="Ingresa tu correo electrónico">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="usuario">Usuario</label>
                    <input type="text" name="usuario" id="usuario" required placeholder="Crea tu nombre de usuario">
                </div>
                <div class="form-group">
                    <label for="telefono">Celular</label>
                    <input type="text" name="telefono" id="telefono" required placeholder="Ingresa tu celular">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="nueva_contraseña">Nueva contraseña</label>
                    <input type="password" name="nueva_contraseña" id="nueva_contraseña" required placeholder="Crea una contraseña">
                </div>
                <div class="form-group">
                    <label for="confirmar_contraseña">Confirmar contraseña</label>
                    <input type="password" name="confirmar_contraseña" id="confirmar_contraseña" required placeholder="Confirma tu contraseña">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="fecha_nacimiento">Fecha de nacimiento <span class="optional">- Opcional</span></label>
                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento">
                </div>
                <div class="form-group">
                    <label for="genero">Género <span class="optional">- Opcional</span></label>
                    <select name="genero" id="genero">
                        <option value="">Selecciona tu género</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <input type="checkbox" name="terminos" id="terminos" required>
                    <label class="letra" for="terminos">He leído y acepto los <a href="#">términos y condiciones</a> y las <a href="#">políticas de privacidad</a></label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <input type="checkbox" name="tpersonales" id="tpersonales" required>
                    <label  class="letra" for="tpersonales">He leído y acepto el <a href="#">tratamiento de mis datos personales</a> para finalidades adicionales</label>
                </div>
            </div>

            <button type="submit">Registrarse</button>
        </form>
    </div>
</body>
</html>
