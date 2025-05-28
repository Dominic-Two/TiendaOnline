<?php
session_start();
if(!$_SESSION['login']){
    header('Location: ./logIn.php');
}
$auth = $_SESSION['login'] ?? false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago</title>
    <link rel="shortcut icon" href="./src/img/Logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="./src/css/normalize.css">
    <link rel="stylesheet" href="./src/css/utilities.css">
    <link rel="stylesheet" href="./src/css/navbar.css">
    <link rel="stylesheet" href="./src/css/carrito.css">
    <link rel="stylesheet" href="./src/css/footer.css"> 
</head>
<body id="resumen-carrito">
    <?php require './src/template/infoSesion.php'; ?>
    <?php require './src/template/navbar.php' ?>
    <?php require './src/template/carrito.php'; ?>
    <section id="productsCont"></section>

    <section class="contenedor main">
        <div class="productos">
        <h2>Carrito de Compras</h2>
            <div class="producto">
                <img src="./src/img/rtx3080ti.webp" alt="">
                <div class="info">
                    <h2>Rtx</h2>
                    <p>Precio Unitario: <span>1234</span></p>
                    <p>Cantidad: <input type="number" value="2"></p>
                    <p>Total del articulo: <span class="total-articulo">1234</span></p>
                </div>
            </div>

        </div>
        <div class="summary">
            <p>Total del carrito: <span id="total-carrito"></span></p>
            <a href="#" class="pagar" id="a-pagar">Proceder al Pago del producto</a>
        </div>
    </section>
    

    <?php require './src/template/footer.php'; ?>


    <style>
        .main{
            padding: 1rem;
            border-radius: 1rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: grid;
            grid-template-columns: repeat(4, 1fr);
        }
        .productos{
            grid-column: 1/4;
            min-height: 70rem;
        }
        @media (max-width: 720px) {
            .main{
                display: flex;
            }
        }
        @media (max-width: 480px) {
            .main{
                flex-wrap: wrap;
            }
        }
        .producto{
            padding: .5rem;
            border-bottom: 1px solid var(--morado1);
        }
        @media (min-width: 720px) {
            .producto{
                display: flex;
                gap: 1.5rem;
            }
        }
        h2{
            font-size: 2.5rem;
        }
        .info span{
            font-weight: bold;
        }
        .span-cantidad{
            padding: 0 2rem;
            border-radius: .5rem;
            border: 2px solid var(--morado-munfrost);
        }

        .summary{
            span{
                font-weight: bold;
            }

            a{
                background-color: var(--morado-munfrost);
                border-radius: .5rem;
                padding: .5rem;
                color: var(--blanco1);
            }
        }    
    </style>
    <script src="./src/js/carrito.js"></script>
    <script src="./src/js/compraecha.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <script src="./src/js/summaryCart.js"></script> -->
</body>
</html>