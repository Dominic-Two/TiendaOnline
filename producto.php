<?php
session_start();
$auth = $_SESSION['login'] ?? false;
require './src/config/connection.php';
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

$categoria = htmlspecialchars($_GET['categoria'], ENT_QUOTES, 'UTF-8');

if(!$id || !$categoria){
    header('Location: /Ecommerce');
  }

if($connection){
    $consultaProducto = "SELECT * FROM productos WHERE id = $id";
    $obtenerProducto = mysqli_query($connection, $consultaProducto);

    $consultaCategoria = "SELECT id, nombre, imagen,categoria, precio, descripcion_corta FROM productos WHERE categoria = '$categoria'";
    $obtenerCategoria = mysqli_query($connection, $consultaCategoria);

    $producto = mysqli_fetch_assoc($obtenerProducto);
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $producto['nombre'] ?></title>
    <link rel="shortcut icon" href="./src/img/Logo.jpg" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="./src/css/normalize.css">
    <link rel="stylesheet" href="./src/css/utilities.css">
    <link rel="stylesheet" href="./src/css/navbar.css">
    <link rel="stylesheet" href="./src/css/producto.css">
    <link rel="stylesheet" href="./src/css/carrito.css">
    <link rel="stylesheet" href="./src/css/footer.css"> 

</head>
<body>
    <?php require './src/template/infoSesion.php'; ?>
    <?php require './src/template/navbar.php' ?>
    <?php require './src/template/carrito.php'; ?>

    <section class="productsCont" id="productsCont">
        <div class="product-img">
            <picture>
                <source srcset="./<?php echo $producto['imagen'];?>.webp" type="image/webp">
                <img loading="lazy" src="./<?php echo $producto['imagen'];?>.jpg" alt="Imagen de <?php echo $producto['nombre'];?>">
            </picture>
        </div>
        <div class="info">
                <div class="info-product">
                    <h2 class="name"><?php echo $producto['nombre'];?></h2>
                    <p class="desc-product"><?php echo $producto['descripcion_larga'];?></p>
                    <ul class="ul-datos">
                        <li>Categoria: <span><?php echo $producto['categoria'];?></span></li>
                        <li>Stock/Disponibles: <span><?php echo $producto['stock'];?></span></li>
                        <li>Costo: <span class="precio"><?php echo $producto['precio'];?></span></li>
                    </ul>
                </div>

                <div class="buttons">
                    <a href="#" class="btn btn-addCart" id="addToCart" data-id="<?php echo $producto['id'];?>">Añadir al carrito</a>
                </div>
        </div>
        </section>
        <hr class="hr-divider">
        <section class="more-products">
        <?php while($cat = mysqli_fetch_assoc($obtenerCategoria)):?>
        <?php if($cat['nombre'] === $producto['nombre']):
            continue;
        endif; ?>
                <div class="more-product">
                    <div class="more-product-img">
                        <picture>
                            <source srcset="./<?php echo $cat['imagen'];?>.webp" type="image/webp">
                            <img loading="lazy" src="./<?php echo $cat['imagen'];?>.jpg" alt="Imagen de <?php echo $cat['nombre'];?>">
                        </picture>
                    </div>

                    <div class="more-info">
                        <div class="more-info-product">
                            <h2 class="more-name"><?php echo $cat['nombre'];?></h2>
                            <p class="more-desc-product"><?php echo $cat['descripcion_corta'];?></p>
                            <p class="more-desc-product ">$<span class="precio"><?php echo $cat['precio'];?></span> USD</p>
                        </div>
                        <div class="more-buttons">
                        <a href="?id=<?php echo $cat['id']; ?>&categoria=<?php echo $cat['categoria']; ?>" class="btn btn-more">Ver más</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
     </section>

    
    <?php require './src/template/footer.php'; ?>
    
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="./src/js/carrito.js"></script>
</body>
</html>