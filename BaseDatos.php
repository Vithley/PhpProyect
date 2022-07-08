<?php
    session_start();
    /**Creamos una función para guardar la conexión a la base de datos**/
    function crearConexion() {
        return mysqli_connect('localhost','root', '', 'pac3_daw');
    }

    
/*****************************COMPROBAMOS LOS USUARIOS********************************* */
    function comprobarUsuario(){
        //Nos conectamos a la base de datos y creamos las variables
        $conexion = crearConexion();
        $nombre = $_POST['nombre'];
        $correo= $_POST['correo'];
        //Hacemos la consulta a la base de datos para que nos muestre todos los usuarios.
        $resultado = mysqli_query($conexion, "SELECT * FROM user WHERE Email = '$correo' AND FullName = '$nombre'");
        $registro = mysqli_fetch_assoc($resultado);

        //Hacemos un  if para comprobar si el usuario está registrado y que nos muestre el mensaje.
        if(isset($registro)){

            echo "<p>Bienvenido $nombre, pulsa <a href= 'Acceso.php'> AQUÍ </a> para continuar</p>";

            $id = $registro['UserID'];
            $fecha = date('Y-m-d');

            mysqli_query($conexion, "UPDATE user SET LastAccess= '$fecha' WHERE UserID= '$id'");

            //Utilizo la consulta para guardar en la sesión el tipo de usuario que es.
            if($registro['Enabled']==1){
                $_SESSION ['tipoUsuario'] = "autorizado";
            }
            else if ($registro['Enabled']==0){
                $_SESSION ['tipoUsuario'] = "registrado";
            }

            //A continuación compruebo si es Super Admin o no. En caso de serlo sobreescribo el tipoUsario
            $resultado = mysqli_query($conexion, "SELECT * FROM setup WHERE SuperAdmin = '$id'");
            $registro = mysqli_fetch_assoc($resultado);

            if(isset($registro)){
                $_SESSION['tipoUsuario'] = "superadmin";
            }    
           
        }
        else
                echo "<p>El usuario o el correo introducido no es correcto</p>";
        
         //Cerramos la conexión.
        mysqli_close($conexion);
                    

    }

    /**********FUNCIÓN PARA ORDENAR LOS ARTÍCULOS***********/

    function listarArticulos(){
        //Hacemos la conexion a la base de datos
        $conexion = crearConexion();
        $resultados_por_pagina = 10;
        
        
        if(isset($_GET['pagina'])){
            $pagina = $_GET['pagina'];
        }else{
            $pagina= 0;
        }

        //Hacemos las consultas a la base de datos 
        if (isset($_SESSION['campos'])){
            $campo = $_SESSION['campos'];

            // si hay un campo seleccionado para ordenar, se ejecuta esta consulta
            $consulta = "SELECT ProductID, category.Name AS categoria, product.Name, Cost, Price FROM product INNER JOIN category 
            ON product.CategoryID = category.CategoryID ORDER BY $campo LIMIT $pagina, $resultados_por_pagina";
        }
        else{
            // Si no lo hay, se ejecuta esta otra
            $consulta= "SELECT ProductID, category.Name AS categoria, product.Name, Cost, Price FROM product INNER JOIN category 
            ON product.CategoryID = category.CategoryID LIMIT $pagina, $resultados_por_pagina "; 
        }  


        $resultado = mysqli_query($conexion, $consulta);
            
            /* Insertamos tantos elementos como artículos existan */
            while ($registro = mysqli_fetch_assoc($resultado)) {
                
                echo "<tr>
                    <td> " . $registro['ProductID'] . "</td>
                    <td> " . $registro['categoria'] . "</td>
                    <td> " . $registro['Name'] . "</td>
                    <td> " . $registro['Cost'] . "</td>
                    <td> " . $registro['Price'] . "</td>";
                    
                    if($_SESSION ['tipoUsuario'] == "superadmin"){
                        echo "<td>
                        <form action='formArticulos.php' method='post'>
                            <input type='hidden' name='id' value='" .  $registro['ProductID'] . "'>
                            <input type='submit' name='accion' value= 'Editar' class='boton' > 
                        </form>   
                        <form action='formArticulos.php' method='post'>
                            <input type='hidden' name='id' value='" .  $registro['ProductID'] . "'>
                            <input type='submit' name='accion' value= 'Eliminar' class='boton'> 
                        </form>                                                             
                        
                        
                        </td></tr>";
                    }
                    else{
                        echo "</tr>";
                    }
            }   

         //Cerramos la conexión.
         mysqli_close($conexion);                      
    }         
    
/***********************Crear, editar, eliminar Artículos************************** */

//Creamos la funcion de Crear Artículos.
function crearArticulos($categoria, $nombre, $coste, $precio){
    //Creamos la conexión con la base de datos.
    $conexion = crearConexion();
    //Hacemos la consulta para insertar artículos nuevos.
    $consulta = "INSERT INTO product (Name, Cost, Price, CategoryID)
    VALUES ('" . $nombre . "', '" . $coste . "', '" . $precio . "', '" .$categoria."')";
    $resultado = mysqli_query($conexion, $consulta);
    //Aquí nos devuelve el resultado.
    if($resultado){
        return $resultado;
        
    } else{
        echo "Error en funcion crearArticulos";
    }
    //Cerramos la conexión.
    mysqli_close($conexion);

}
//Creamos la función para editar los artículos.
function editarArticulos($productid, $categoria, $nombre, $coste, $precio){
    //Hacemos la conexión con la base de datos.
    $conexion = crearConexion();
    //Hacemos la consulta
    $consulta = "UPDATE product SET CategoryID = $categoria, Name='$nombre', Cost = $coste, Price=$precio WHERE ProductID= $productid";
    $resultado = mysqli_query($conexion, $consulta);
    //Nos muestra el resultado.
    if($resultado){
        return $resultado;

    }else{
        echo "Error en funcion borrarArticulos";
    }
    //Cerramos la conexión.
    mysqli_close($conexion);

}

//Creamos una función para que nos muestre la información de los artículos que queremos editar o borrar.
function infoArticulo($id){
    $conexion= crearConexion();

    $consulta= "SELECT * FROM product WHERE ProductID = $id";

    $resultado = mysqli_query($conexion, $consulta); 
    
    return mysqli_fetch_array($resultado);

}


//Creamos la función para borrar los artículos.
function borrarArticulos($id){
    $conexion = crearConexion();
    //Hacemos la consulta a la base de datos para que nos borre los artículos.
    $consulta = "DELETE FROM product WHERE ProductID= '".$id. "'";
    $resultado = mysqli_query($conexion, $consulta);
    //Mostramos el resultado.
    if($resultado){
        return $resultado;

    }else{
        echo "Error en funcion borrarArticulos";
    }

    mysqli_close($conexion);
}

//Creamos una función para que nos muestre el número de registros de los artículos.
function numRegistros(){
    $conexion = crearConexion();

    $consulta= "SELECT * FROM product";
    $resultado= mysqli_query($conexion, $consulta);
    
    //devuelve el total de registros
    return mysqli_num_rows($resultado);
}

/*******************CREAMOS LA LISTA DE LA TABLA USUARIOS*************** */

function listarUsuarios(){
    //Creamos la conexión a la base de datos
    $conexion = crearConexion();
    //Hacemos las consultas a la base de datos para que se muestre ordenada por campos o si no que se muestre la tabla.
    if (isset($_SESSION['campo'])){
        $campo = $_SESSION['campo'];
        $consulta= "SELECT UserID, FullName, Email, LastAccess, Enabled  FROM user ORDER BY $campo";

    }else{
        $consulta= "SELECT UserID, FullName, Email,  LastAccess, Enabled FROM user";

    }   
    $resul = mysqli_query($conexion, $consulta);
    
    while ($filas = mysqli_fetch_array($resul)) {

        $lastAccess = strtotime($filas['LastAccess']);

        if ($filas['UserID'] == 3) {/* Si es superAdmin aplicaremos estos estilos */
            $superadminEstilo = 'background-color:pink; color:white; border: 2px solid black;';
            $disabled = 'disabled';
        } else {/* Si no es superAdmin no se aplican estilos */
            $superadminEstilo = null;
            $disabled = null;
        }
        /* Insertamos tantos elementos usuarios como existan */
        echo    "<tr style='$superadminEstilo'>
                    <td>" . $filas['UserID'] . "</td>
                    <td>" . $filas['FullName'] . "</td>
                    <td>" . $filas['Email'] . "</td>
                    <td>" . date('d/m/Y', $lastAccess) . "</td>
                    <td>" . $filas['Enabled'] . "</td>
                    <td>
                        <form action='formUsuarios.php' method='post'>
                            <input  type='hidden' name='id' value='" .  $filas['UserID'] . "'>
                            <input type='submit' name='accion' value= 'Editar' class='boton' $disabled> 
                        </form>                                
                        
                        <form action='formUsuarios.php' method='post'>
                            <input  type='hidden' name='id' value='" .  $filas['UserID'] . "'>
                            <input type='submit' name='accion' value= 'Eliminar' class='boton' $disabled> 
                        </form>
                    </td>                    
                </tr>";
    }
}




/***********************Crear, editar, eliminar Usuarios************************** */
//Creamos la función de Crear Usuarios
function crearUsuarioBD($fullName, $email, $date, $checkboxes, $password){
	$conexion= crearConexion();

    //Hacemos la consulta de la base de datos para añadir nuevos usuarios.
    $consulta= "INSERT INTO user(Email, Fullname, LastAccess, Enabled, Password)
     VALUES ('$email', '$fullName', '$date', $checkboxes, '$password')";

    mysqli_query($conexion, $consulta);  
    
    mysqli_close($conexion);
   
    
}

//Creamos una función para que nos de la información del usuario.
function infoUsuario($id){
    $conexion= crearConexion();

    $consulta= "SELECT * FROM user WHERE UserID = $id";

    $resultado = mysqli_query($conexion, $consulta); 
    
    return mysqli_fetch_array($resultado);
    
}

//Cremaos la función para editar los usuarios que ya existen.
function editarUsuarioBD($id, $fullName, $email, $date){
     $conexion= crearConexion();

     $consulta = "UPDATE user SET FullName= '$fullName',
                    Email= '$email' , LastAccess='$date' WHERE UserID=$id";
    mysqli_query($conexion, $consulta);     
    mysqli_close($conexion);  
    
}
//Creamos la función para borrar los usuarios que ya existen
function borrarUsuariosBD($id){
    $conexion= crearConexion();

        $consulta = "DELETE FROM user WHERE UserID=$id";
        mysqli_query($conexion, $consulta);  
        
        mysqli_close($conexion);
}


?>