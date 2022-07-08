
<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <link href="css/estilos.css" rel="stylesheet"/>
    <?php
    //Incluimos la conexión con BaseDatos.php
     
     include 'BaseDatos.php';             
    ?> 
            
    </head>
    <body class= "estiloindex">
        <h1>Web Store</h1>

        <form  action="index.php" method="POST">
        <input type="hidden" id="authUser" name="authUser" value="1">
            <label class = "input_index_text" for="nombre">Nombre: </label>
            <input class="caja" type="text" id="nombre" name="nombre"/><br/><br>
            <label class = "input_index_text" for="correo">Email: </label>
            <input class= "caja" type="email" id="correo" name="correo"><br><br>
            <input class = "boton2" type="submit" value="Enviar"><br><br> 
        </form>

        <?php
        //Comprobamos el tipo de usuario que es llamando a la funcion comprobarUsuario
            if(isset($_POST['nombre'])){
                comprobarUsuario();
            }
            
            ?>

    </body>
</html>
