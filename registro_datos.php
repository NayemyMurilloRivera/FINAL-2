<?php
$host = 'localhost';
$user = 'root'; 
$password = ''; 
$dbname = 'basedatos'; 

$enlace = new mysqli($host, $user, $password, $dbname);

if (isset($_POST['usuario']) && isset($_POST['nueva_contraseña']) && isset($_POST['confirmar_contraseña']) &&
    isset($_POST['email']) && isset($_POST['nombre']) && isset($_POST['apellido_paterno']) && 
    isset($_POST['apellido_materno']) && isset($_POST['telefono']) && isset($_POST['fecha_nacimiento']) && 
    isset($_POST['documento']) && isset($_POST['numero_documento']) && isset($_POST['genero']) && isset($_POST['terminos']) && isset($_POST['tpersonales'])) {

    if ($_POST['terminos'] != 'on' || $_POST['tpersonales'] != 'on') {
        echo "Debes aceptar los términos y condiciones y la política de privacidad.";
        exit();
    }

    if (isset($enlace)) {
        $usuario = mysqli_real_escape_string($enlace, $_POST['usuario']);
        $nombre = mysqli_real_escape_string($enlace, $_POST['nombre']);
        $apellido_paterno = mysqli_real_escape_string($enlace, $_POST['apellido_paterno']);
        $apellido_materno = mysqli_real_escape_string($enlace, $_POST['apellido_materno']);
        $email = mysqli_real_escape_string($enlace, $_POST['email']);
        $telefono = mysqli_real_escape_string($enlace, $_POST['telefono']);
        $fecha_nacimiento = mysqli_real_escape_string($enlace, $_POST['fecha_nacimiento']);
        $documento = mysqli_real_escape_string($enlace, $_POST['documento']);
        $numero_documento = mysqli_real_escape_string($enlace, $_POST['numero_documento']);
        $genero = mysqli_real_escape_string($enlace, $_POST['genero']);
        $contraseña = mysqli_real_escape_string($enlace, $_POST['nueva_contraseña']);
        $confirmar_contraseña = mysqli_real_escape_string($enlace, $_POST['confirmar_contraseña']);
    } else {
        die("Error: No se pudo establecer la conexión a la base de datos.");
    }

    if (strlen($usuario) < 5 || strlen($usuario) > 8) {
        echo "El nombre de usuario debe tener entre 5 y 8 caracteres.";
        exit();
    }

    if ($contraseña !== $confirmar_contraseña) {
        echo "Las contraseñas no coinciden.";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Ingrese un correo electrónico válido.";
        exit();
    }

    if (!filter_var($telefono, FILTER_VALIDATE_INT)) {
        echo "Ingrese un número de teléfono válido.";
        exit();
    }

    if (!preg_match("/^\d{8}$/", $numero_documento)) {
        echo "El número de documento debe tener 8 dígitos.";
        exit();
    }

    $verificar_usuario = "SELECT 1 FROM usuarios WHERE LOWER(usuario) = LOWER('$usuario')";
    $verificar_email = "SELECT 1 FROM usuarios WHERE LOWER(email) = LOWER('$email')";
    $verificar_documento = "SELECT 1 FROM usuarios WHERE LOWER(documento) = LOWER('$documento') AND numero_documento = '$numero_documento'";

    $result_usuario = mysqli_query($enlace, $verificar_usuario);
    $result_email = mysqli_query($enlace, $verificar_email);
    $result_documento = mysqli_query($enlace, $verificar_documento);

    if (mysqli_num_rows($result_usuario) > 0) {
        echo "El nombre de usuario ya está registrado.";
        exit();
    } elseif (mysqli_num_rows($result_email) > 0) {
        echo "El correo electrónico ya está registrado.";
        exit();
    } elseif (mysqli_num_rows($result_documento) > 0) {
        echo "El número de documento ya está registrado.";
        exit();
    } else {
        $contraseña_hashed = password_hash($contraseña, PASSWORD_DEFAULT);

        $insertar = "INSERT INTO usuarios (usuario, nombre, apellido_paterno, apellido_materno, email, telefono, fecha_nacimiento, documento, numero_documento, genero, contraseña) 
                     VALUES ('$usuario', '$nombre', '$apellido_paterno', '$apellido_materno', '$email', '$telefono', '$fecha_nacimiento', '$documento', '$numero_documento', '$genero', '$contraseña_hashed')";

        if (mysqli_query($enlace, $insertar)) {
            echo "Datos insertados correctamente.";
        } else {
            echo "Error al insertar datos: " . mysqli_error($enlace);
        }
    }

} else {
    echo "Faltan datos. Por favor, complete el formulario.";
    exit();
}
?>
