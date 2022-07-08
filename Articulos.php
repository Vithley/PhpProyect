<!DOCTYPE html>

<html lang="es">
    <head>
        <title>Artículos</title>
        <meta charset="UTF-8">
        <link href="css/estilos.css" rel="stylesheet"/>
        <?php
            
            include "BaseDatos.php";

            if(isset($_GET['pagina']))
                $pagina = $_GET['pagina'];
            else
                $pagina = 0;
        ?>
    </head>
    <body>


    <h1 class="h2_acceso">Artículos</h1>
    <?php
    //Si el usuario es autorizado o superadmin pueden crear artículos nuevos. Los registrados no tienen acceso.
        if($_SESSION['tipoUsuario'] == "autorizado" || ($_SESSION['tipoUsuario'] == "superadmin")){
            echo"<p><a class= 'boton3' href='formArticulos.php'>Crear un nuevo artículo</a></p>";
        }

    ?>

    

    <table class="inline">  
    <tr>
        <th scope="col">
            <a href="Articulos.php?campos=productid" class="boton3">ID
            </a>
        </th>
        <th scope="col">
            <a href="Articulos.php?campos=categoria" class="boton3" > Categoría
            </a>
            </th>
        <th scope="col">
            <a href="Articulos.php?campos=name" class="boton3"> Nombre
            </a>
        </th>
        <th scope="col">
            <a href="Articulos.php?campos=cost" class="boton3"> Coste
            </a>
        </th>
        <th scope="col">
            <a href="Articulos.php?campos=price" class="boton3"> Precio
            </a>
        </th>

        <!--Si es superadmin que tiene acceso a la columna manejos donde editamos y borramos los artículos  -->
        <?php
        if($_SESSION['tipoUsuario'] == "superadmin")
            echo '<th scope="col"><div class="boton1">Manejo</div></th>';  ?>
        
    </tr>
    
  
    <?php
    //Mostramos los artículos en la tabla llamando a la función listarArticulos.
       
       if(isset($_GET['campos']))
            $_SESSION['campos'] = $_GET['campos'];
       
       listarArticulos();
        
    ?>
  
    </table>
    <div>
        <p>
            <a class= "boton3" href= "Articulos.php<?php 
                //Para que nos muestre los artículos de la tabla de 10 en 10.
                if (isset($pagina))
                    if($pagina - 10 > 0)
                        echo '?pagina=' . ($pagina-10); ?>"> <<< </a>
        
        
            <a class = "boton3" href="Articulos.php?pagina=<?php
                if (!isset($pagina))
                    echo 10;
                else if($pagina + 10 < numRegistros())
                    echo $pagina + 10;
                else echo 50;?>">>>></a> 
            <a class="boton3" href="Acceso.php" >Volver</a>     
        </p>
    </div>

    

    </body>
</html>


