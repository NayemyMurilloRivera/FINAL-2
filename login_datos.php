<?php
$host = 'localhost';
$user = 'root'; 
$password = ''; 
$dbname = 'basedatos'; 

$enlace = new mysqli($host, $user, $password, $dbname);

if ($enlace->connect_error) {
    die("Error de conexión: " . $enlace->connect_error);
}

if (isset($_POST['usuario1']) && isset($_POST['contraseña']) && isset($_POST['email'])) {
    $usuario_login = $_POST['usuario1'];
    $contraseña = $_POST['contraseña'];
    $email = $_POST['email'];

    $usuario_login = mysqli_real_escape_string($enlace, $usuario_login);
    $email = mysqli_real_escape_string($enlace, $email);

    if (!preg_match("/^[a-zA-Z0-9]{1,15}$/", $usuario_login)) {
        echo "El usuario debe contener solo letras y números, y ser menor o igual a 15 caracteres.";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Ingrese un correo electrónico válido.";
        exit();
    }

    $consulta = "SELECT contraseña FROM usuarios WHERE usuario = '$usuario_login' AND email = '$email'";

    $resultado = mysqli_query($enlace, $consulta);

    session_start();
    if ($resultado && mysqli_num_rows($resultado) == 1) {
        $row = mysqli_fetch_assoc($resultado);
        var_dump($_SESSION);
        if (password_verify($contraseña, $row['contraseña'])) {
            $_SESSION['usuario_login'] = $usuario_login;
            echo "<script>
            alert('Login exitoso, bienvenido.');
            window.location.href = 'index_inicio.php'; 
          </script>";
        } else {
            echo "<script>alert('Contraseña incorrecta.');</script>";
        }
    }else {
            echo "Usuario o correo electrónico no encontrado.";
        }
} else {
    echo "Faltan datos. Por favor, complete el formulario.";
    exit();
}
?>