<!DOCTYPE html>

<html>
    <head>
        <title>Artículos</title>
        <meta charset="UTF-8">
        <link href="css/estilos.css" rel="stylesheet"/>
        <?php

            /*Creamos un if para que no nos deje escribir en la url otra página y acceder a ella siendo 
            un usario resgitrado o autorizado. Al intentarlo nos saltara esta página y nos redigirá a la 
            página de Acceso.*/
            include "BaseDatos.php";
            if($_SESSION['tipoUsuario'] != "superadmin"){
                header("Refresh: 5; url = Acceso.php");
                echo "<h3 class='h1_acceso'>Acceso denegado</h3>";
                echo "<h4 class='h1_acceso'>Serás redirigido en unos instantes</h4>";

                exit;

            }
             
        ?>
    </head>
    <body>

    <h1 class="h2_acceso">Usuarios</h1>
    <p><a class= "boton3" href="formUsuarios.php">Crear un nuevo Usuario</a></p>

    

    <table class='inline'>
        
  
    <tr>
        <th scope="col">
        <a class="boton3" href="Usuarios.php?campo=UserID" >ID</a>
        </th>
        <th scope="col"><span>
            <a class="boton3" href="Usuarios.php?campo=FullName">Nombre</a>
        </span></th>
        <th>
            <a class="boton3" href="Usuarios.php?campo=Email ">Email</a>
        </th>
        <th scope="col">
            <a class="boton3" href="Usuarios.php?campo=LastAccess">Último Acceso</a>
        </th>
        <th scope="col">
            <a class="boton3" href="Usuarios.php?campo=Enabled">Enabled</a>
        </th>
        <th scope="col">
            <div class="boton1">Manejo</div>
        </th>
        
    </tr>
  
    <?php
        //Mostramos los usuarios en la tabla llamando a la función listarUsuarios.
        if(isset($_GET['campo']))
        $_SESSION['campo'] = $_GET['campo'];
        listarUsuarios();
        
        
    ?>
  
    </table>

    <p><a class="boton3" href="Acceso.php">Volver</a><p>

    </body>
</html>

      

