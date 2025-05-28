<div class="sesion">
    <div class="contenedor infoSesion">
        <?php if(!$auth){ ?>
            <a href="./logIn.php">Iniciar Sesión</a>
            <span>|</span>
            <a href="./singUp.php">Registrate</a>
        <?php } else{?>

            <a href="./perfil.php"><img class="img-perfil-icon" src="./src/img/iconPerfil.png" alt="Perfil"><?php echo $_SESSION['usuario'], " ", $_SESSION['apellido'];?> </a>
            <span>|</span>
            <a href="./cerrarSesion.php">Cerrar Sesión<img class="img-perfil-icon" src="./src/img/cerrarsesion.png" alt="Perfil"></a>
            <?php } ?>
    </div>
</div>

<style>
    .sesion{
        background-color: var(--negro);
    }
    .img-perfil-icon{
        filter: brightness(0) invert(1);
        width: 2rem;
        height: 2rem;
        margin-right: .3rem;
        margin-left: .3rem;
    }
    .infoSesion{
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 1rem;
        color: var(--blanco1);


        a{
            color: var(--blanco1);
            display: flex;
            justify-content:center;
            aling-content:center;
        }
        a:hover {
            text-decoration:underline;
        }
    }
</style>