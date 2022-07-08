<!DOCTYPE html>

<html>
    <head>
        <title>Acceso</title>
        <meta charset="UTF-8">
        <link href="css/estilos.css" rel="stylesheet"/>
    </head>
    <body>

        <?php
        //Incluimos la conexión con BaseDatos.php
            
            include 'BaseDatos.php'; 
        
        ?>
        
        <h1 class="h1_acceso">Acesso.php</h1>
        <div class="tabla_acceso">
            
            <div>    
                <a class="a_acceso" href="Articulos.php">Artículos&nbsp&nbsp</a>
                <?php
                    //Si el usuario es superadmin tiene acceso a la página de Usuarios
                    $tipoUsuario = $_SESSION['tipoUsuario'];

                    if($tipoUsuario == "superadmin")
                        echo "<a class='a_acceso' href='Usuarios.php'>Usuarios</a>";
                ?>
                   
                

                <p>
                    <a class="volver_acceso" href="Index.php">Volver</a>
                </p>
            </div>

            
              
           
        </div>   
        
        
    </body>
</html>
