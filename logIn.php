<?php
session_start();
if($_SESSION['login']){
    header('Location: /Ecommerce');
}
    require './src/config/connection.php';
    $errorres = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $email = mysqli_real_escape_string($connection, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
        $password = mysqli_real_escape_string($connection, $_POST['password']);

        if(!$email){
            $errorres[] = 'El email es obligatorio o no es valido';
        }
        if(!$password){
            $errorres[] = 'La contraseña es obligatoria';
        }
        if(empty($errorres)){
            $query = "SELECT * FROM usuarios WHERE email = '$email'";
            $resultado = mysqli_query($connection, $query);

            if($resultado->num_rows){
                $usuario = mysqli_fetch_assoc($resultado);
                $auth = password_verify($password, $usuario['password']);
                if($auth){
                    session_start();
                    $_SESSION['usuario'] = $usuario['nombre'];
                    $_SESSION['apellido'] = $usuario['apellido'];
                    $_SESSION['email'] = $usuario['email'];
                    $_SESSION['login'] = true;
                    
                    if($_SESSION['login']){
                        header('Location: /Ecommerce');
                    }
                }else {
                    $errorres[] = 'La contraseña es incorrecta jijija';
                }
            }else{
                $errorres[] = 'El usuario no existe';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicia Sesión</title>
    <link rel="stylesheet" href="./src/css/normalize.css">
    <link rel="stylesheet" href="./src/css/utilities.css">
    <link rel="stylesheet" href="./src/css/formularios.css">
</head>
<body>
    <form action="" method="POST" class="form">
        <fieldset>
            <legend>Inicia Sesión</legend>
            <?php foreach($errorres as $error): ?>
                <div class="errores">
                    <?php echo $error ?>
                </div>
            <?php endforeach; ?>

            <label for="email">E-mail:</label>
            <input type="email" placeholder="E-mail" name="email" id="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" placeholder="Contraseña" name="password" id="password" required>
        </fieldset>

        <div class="opc-logIn">
            <div class="noSesion">
                ¿No tienes una cuenta? | <a href="./SingUp.php">Registrate</a>
            </div>
            <button type="submit" class="btn">Iniciar Sesion</button>
        </div>
    </form>
</body>
</html>