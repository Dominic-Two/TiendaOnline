<?php
session_start();
if($_SESSION['login']){
    header('Location: /Ecommerce');
}

    require './src/config/connection.php';
    $errorres = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $nombre = mysqli_real_escape_string($connection, $_POST['nombre']);
        $apellido = mysqli_real_escape_string($connection, $_POST['apellido']);
        $email = mysqli_real_escape_string($connection, filter_var($_POST['email'],FILTER_VALIDATE_EMAIL));
        $password = mysqli_real_escape_string($connection, $_POST['password']);
        $password2 = mysqli_real_escape_string($connection, $_POST['password2']);

        if(!$nombre){
            $errorres[] = 'El nombre el obligatorio';
        }
        if(!$apellido){
            $errorres[] = 'El apellido es obligatorio';
        }
        if(!$password){
            $errorres[] = 'La contraseña es obligatoria';
        }
        if($password != $password2){
            $errorres[] = 'Las contraseñas no coinciden';
        }

        if(empty($errorres)){
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $query = "SELECT email FROM usuarios WHERE email = '$email'";
            $resultado = mysqli_query($connection, $query);

            if(!$resultado->num_rows){
                $insert = "INSERT INTO usuarios (nombre, apellido, email, password) VALUES ('$nombre', '$apellido', '$email', '$passwordHash')";
                $res = mysqli_query($connection, $insert);

                if($res){
                    session_start();
                    $_SESSION['usuario'] = $nombre;
                    $_SESSION['apellido'] = $apellido;
                    $_SESSION['email'] = $email;
                    $_SESSION['login'] = true;
                    
                    if($_SESSION['login']){
                        header('Location: /Ecommerce');
                    }
                }
            }else {
                $errorres[] = "El usuario ya exsiste, <a href='./logIn.php'>Iniciar Sesión</a>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrate</title>
    <link rel="stylesheet" href="./src/css/normalize.css">
    <link rel="stylesheet" href="./src/css/utilities.css">
    <link rel="stylesheet" href="./src/css/formularios.css">
</head>
<body>
    <form action="" method="POST" class="form">
        <fieldset>
            <legend>Registrate</legend>
            <?php foreach($errorres as $error): ?>
                <div class="errores">
                    <?php echo $error ?>
                </div>
            <?php endforeach; ?>

            <div class="nombre">
                <label for="nombre">Nombre:</label>
                <input type="nombre" placeholder="Nombre" name="nombre" id="nombre" required>

                <label for="apellido">Apellido:</label>
                <input type="apellido" placeholder="Apellido" name="apellido" id="apellido" required>
            </div>

            <label for="email">E-mail:</label>
            <input type="email" placeholder="E-mail" name="email" id="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" placeholder="Contraseña" name="password" id="password" required>
            <label for="password2">Repite tu Contraseña:</label>
            <input type="password" placeholder="Repite tu Contraseña" name="password2" id="password2" required>
        </fieldset>

        <div class="opc-logIn">
            <div class="noSesion">
                ¿Ya tienes una cuenta? | <a href="./logIn.php">Inicia sesión</a>
            </div>
            <button type="submit" class="btn">Inicia Sesion</button>
        </div>
    </form>
    
</body>
</html>