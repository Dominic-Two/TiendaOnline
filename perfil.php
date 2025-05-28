<?php
session_start();
$auth = $_SESSION['login'] ?? false;

if (isset($_POST['guardarDatos'])) {
    require './src/config/connection.php';

    // Obtenemos los datos que quiere actualizar por que el wey se equivoco(Parece chiste pero es anecdota)
    $nombre = !empty($_POST['inputNombre']) ? mysqli_real_escape_string($connection, $_POST['inputNombre']) : null;
    $apellido = !empty($_POST['inputApellido']) ? mysqli_real_escape_string($connection, $_POST['inputApellido']) : null;
    $email = !empty($_POST['inputEmail']) ? mysqli_real_escape_string($connection, filter_var($_POST['inputEmail'], FILTER_VALIDATE_EMAIL)) : null;

    $oldEmail = $_SESSION['email'];

    // Buscamos el id del papu
    $getId = "SELECT id FROM usuarios WHERE email = '$oldEmail'";
    $buscarId = mysqli_query($connection, $getId);
    if ($buscarId && $row = mysqli_fetch_assoc($buscarId)) {
        $id = $row['id'];
    } else {
        echo "No se pudo encontrar el usuario.";
        exit;
    }

    // Verificamos que no exista email(Por que ya vez que la pagina tiene 10000000000 de usuarios) :D
    if ($email !== null && $email !== $oldEmail) {
        $query = "SELECT email FROM usuarios WHERE email = '$email'";
        $resultado = mysqli_query($connection, $query);

        if (!$resultado) {
            echo "Error en la consulta de verificación del correo: " . mysqli_error($connection);
            exit;
        }

        if (mysqli_num_rows($resultado) > 0) {
            echo "El correo ya está en uso";
            exit;
        }
    }
    //Guardamos los datos en un arreglo que nos proporciono el papu en caso de que nos los haya dado:D
    $updates = [];
    if ($nombre !== null) {
        $updates[] = "nombre='$nombre'";
    }
    if ($apellido !== null) {
        $updates[] = "apellido='$apellido'";
    }
    if ($email !== null) {
        $updates[] = "email='$email'";
    }

    if (!empty($updates)) {

        //Hacemos la consulta con los datos que quizo actualizar el muy wey por que no ecribe bien :3
        $updateQuery = "UPDATE usuarios SET " . implode(", ", $updates) . " WHERE id=$id";

        if (mysqli_query($connection, $updateQuery)) {
            // Actualizamos la sesiones pa que se vea mas perron obviamente si se actualizaron :D
            if ($nombre !== null) {
                $_SESSION['usuario'] = $nombre;
            }
            if ($apellido !== null) {
                $_SESSION['apellido'] = $apellido;
            }
            if ($email !== null) {
                $_SESSION['email'] = $email;
            }
            // Redirigimos para recargar la página con los nuevos datos que actualiza desde la raiz los datos :o
            // Pa eso sirve el $_SERVER['PHP_SELF'] (no savia, fue un protip-cini, cini, cini)
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "Error en las actualizaciónes: " . mysqli_error($connection);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($_SESSION['usuario'] . " " . $_SESSION['apellido']); ?></title>
    <link rel="shortcut icon" href="./src/img/Logo.jpg" type="image/x-icon">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="./src/css/normalize.css">
    <link rel="stylesheet" href="./src/css/utilities.css">
    <link rel="stylesheet" href="./src/css/navbar.css">
    <link rel="stylesheet" href="./src/css/card.css">
    <link rel="stylesheet" href="./src/css/carrito.css">
    <link rel="stylesheet" href="./src/css/categorias.css">
    <link rel="stylesheet" href="./src/css/carrucel.css">
    <link rel="stylesheet" href="./src/css/divider.css">
    <link rel="stylesheet" href="./src/css/perfil.css">
    <link rel="stylesheet" href="./src/css/footer.css"> 
</head>
<body>
<?php require './src/template/carrito.php'; ?>
<?php require './src/template/infoSesion.php'; ?>
<?php require './src/template/navbar.php'; ?>

<section id="productsCont"></section>

<main class="main-perfil">
<h1>Mi Perfil</h1>
<div class="div-mainperfil">

            <form action="" method="POST" class="form-inputs">
                <label for="inputNombre" class="label-input">Nombre</label>
                <input type="text" name="inputNombre" class="input-nombre grupo-inputs" placeholder="<?php echo htmlspecialchars($_SESSION['usuario']); ?>" value="<?php echo htmlspecialchars($nombre ?? ''); ?>">
                <label for="inputApellido" class="label-input">Apellido</label>
                <input type="text" name="inputApellido" class="input-apellido grupo-inputs" placeholder="<?php echo htmlspecialchars($_SESSION['apellido']); ?>" value="<?php echo htmlspecialchars($apellido ?? ''); ?>">
                <label for="inputCorreo" class="label-input">Correo</label>
                <input type="text" name="inputEmail" class="input-correo grupo-inputs" placeholder="<?php echo htmlspecialchars($_SESSION['email']); ?>" value="<?php echo htmlspecialchars($email ?? ''); ?>">
                <input type="submit" name="guardarDatos" value="Actualizar datos" class="input-guardar">
            </form>
            <img class="img-usuario" src="src/img/usuario.png" alt="">
    </div>
</main>
<script src="./src/js/perfil.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="./src/js/carrito.js"></script>
<script src="./src/js/carrucel.js"></script>
</body>
</html>
