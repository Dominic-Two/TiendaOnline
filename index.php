<?php
    session_start();
    $auth = $_SESSION['login'] ?? false;
    require './src/config/connection.php';

    if($connection){
        $cat = htmlspecialchars($_GET['cat'], ENT_QUOTES, 'UTF-8');
        $prod = htmlspecialchars($_GET['prod'], ENT_QUOTES, 'UTF-8');

        $consultaCategoria = "SELECT categoria FROM productos";
        $obtenerCategoria = mysqli_query($connection, $consultaCategoria);

        if($prod){
            $consultaProductos = "SELECT id, nombre, imagen, precio, descripcion_corta  FROM productos WHERE nombre LIKE '%$prod%'  OR categoria LIKE '%$prod%'";

        }else if($cat){
            $consultaProductos = "SELECT id, nombre, imagen, precio, descripcion_corta FROM productos WHERE categoria = '$cat'";
        }else{
            $consultaProductos = "SELECT id, nombre, imagen, categoria, precio, descripcion_corta FROM productos LIMIT 6;";
        }
        $obtenerProductos = mysqli_query($connection, $consultaProductos);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio | Compus</title>
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
    <link rel="stylesheet" href="./src/css/footer.css"> 
</head>
<body>
<?php require './src/template/infoSesion.php'; ?>
<?php require './src/template/navbar.php'; ?>
<?php require './src/template/carrito.php'; ?>


<div class="contenedor main">
    <section class="categories">
    <a class="a-categoria cat-enlace" href="/Ecommerce">
        <div class="div-categoria">
            <p class="a-categoria">Ver Todo :D</p>    
        </div>
    </a>
        
    <?php 
    $categorias_mostradas = array();
    while ($categoria = mysqli_fetch_assoc($obtenerCategoria)):
        if (in_array($categoria['categoria'], $categorias_mostradas)) {
            continue;
        }
        $categorias_mostradas[] = $categoria['categoria'];
    ?>
        <a class="a-categoria cat-enlace" href="/Ecommerce?cat=<?php echo $categoria['categoria']; ?>#productsCont">
        <div class="div-categoria">
            <p class="a-categoria"><?php echo $categoria['categoria']; ?></p>    
        </div>
        </a>
    <?php endwhile; ?>
    </section>
        <Div>
            <div class="carousel div-main-carrucel-pc">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img clas="img-carrucel" src="src/img/img-monitor-white-neon-purple.jpeg" alt="Imagen 1">
                    </div>
                    <div class="carousel-item active">
                        <img clas="img-carrucel" src="src/img/ASUS-RTX-40-Banner.jpg" alt="Imagen 1">
                    </div>
                    <div class="carousel-item">
                        <img clas="img-carrucel" src="src/img/img-graphic-card-rtx.jpeg" alt="Imagen 2">
                    </div>
                    <div class="carousel-item">
                        <img clas="img-carrucel" src="src/img/img-pc-withe-neon-purple.jpeg" alt="Imagen 3">
                    </div>
                </div>
                <button class="prev" onclick="moveCarousel(-1)">&#10094;</button>
                <button class="next" onclick="moveCarousel(1)">&#10095;</button>
            </div>
    <hr class="divider">
    <section class="productsCont" id="productsCont">

        <?php if (mysqli_num_rows($obtenerProductos) > 0): ?>
            <?php while($producto = mysqli_fetch_assoc($obtenerProductos)):?>
                <div class="product">
                    <div class="product-img">
                        <picture>
                            <source srcset="./<?php echo $producto['imagen'];?>.webp" type="image/webp">
                            <img loading="lazy" src="./<?php echo $producto['imagen'];?>.jpg" alt="Imagen de <?php echo $producto['nombre'];?>">
                        </picture>
                    </div>

                    <div class="info">
                        <div class="info-product">
                            <h2 class="name"><?php echo $producto['nombre'];?></h2>
                            <p class="desc-product"><?php echo $producto['descripcion_corta'];?></p>
                            <p class="desc-product ">$<span class="precio"><?php echo $producto['precio'];?></span> USD</p>
                        </div>
                        <div class="buttons">
                            <a href="./producto.php?id=<?php echo $producto['id'];?>&categoria=<?php echo $producto['categoria'];?>" class="btn btn-more">Ver mas</a>
                            <a href="#" data-id="<?php echo $producto['id'];?>" class="btn btn-addCart" id="addToCart">Añadir al carrito</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-products">
                <p>No se encontraron ningun producto.</p>
            </div>
        <?php endif; ?>
        
    </section>


        </Div>
</div>

<?php require './src/template/footer.php'; ?>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="./src/js/carrito.js"></script>
<script src="./src/js/carrucel.js"></script>
</body>
</html>