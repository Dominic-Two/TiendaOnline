<?php
    $connection = mysqli_connect('localhost', 'root', 'mysql123', 'ecommerce');

    if (!$connection) {
        die("Conexión fallida: " . mysqli_connect_error());
    }
?>