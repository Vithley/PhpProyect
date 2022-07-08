<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <link href="css/estilos.css" rel="stylesheet"/>
	<title>Ejemplo 2: Procesar un formulario</title>
    <?php 
        
        include "BaseDatos.php";
    ?>

</head>
<body class= "estiloindex1">   

    <?php
    //Hacemos un  if para que nos de la opción de crear, editar o borrar los artículos, y una vez creados nos muestre el mensaje.
        if (isset($_POST["opcion"])){
            $opcion = $_POST["opcion"];
            
            $productid = $_POST["ProductID"];
            $categoria = $_POST["categoria"];
            $nombre= $_POST["nombre"];
            $coste = $_POST["coste"];
            $precio= $_POST["precio"]; 
                
            if ($opcion == "Añadir"){    
                crearArticulos($categoria, $nombre, $coste, $precio);
                echo "<h1 class = 'cabecero'>Artículo creado</h1>";
                echo "<a href= 'Articulos.php' class= 'boton'>Volver</a>"; 
            }
            else if($opcion == "Editar"){
                editarArticulos($productid, $categoria, $nombre, $coste, $precio);
                echo "<h1 class = 'cabecero'>Artículo editado</h1>";
                echo "<p><a href= 'Articulos.php' class= 'boton'>Volver</a></p>"; 
            }
            else{
                borrarArticulos($productid);
                echo "<h1 class = 'cabecero'>Artículo borrado</h1>";
                echo "<a href= 'Articulos.php' class= 'boton'>Volver</a>"; 
            }
        }
        else if(isset($_POST['accion'])){

            $accion = $_POST['accion'];
            $id = $_POST['id'];
            $fila = infoArticulo($id);
            

            //Si queremos editar o borrar el artículo nos muestra este formulario.
            echo '
            <h2>' . $accion . ' un artículo</h2>
            <form action="formArticulos.php" method="POST" id="formarticulos">
            <p>ID: <input class= "linea"  type="text" name="ProductID" value='. $fila['ProductID'] . '></p>
            <p>Categoría: 
            <select class= "linea1"  name="categoria"> 
            <option ';
            //Depende la categoría que sea el artículo , nos muestra en el desplegable la opción que es.
             if($fila['CategoryID'] == 1) 
                echo 'selected';
             echo '    value="1">PANTALÓN</option>'; 
            echo ' <option ';
             if($fila['CategoryID'] == 2) 
                echo 'selected';
             echo '    value="2">CAMISA</option>'; 
             echo '<option ';
             if($fila['CategoryID'] == 3) 
                echo 'selected';
             echo '    value="3">JERSEY</option>'; 
             echo '<option ';
             if($fila['CategoryID'] == 4) 
                echo 'selected';
             echo '    value="4">CHAQUETA</option>'; 
            
        
            echo '</select>
            </p>        
        
            </p>
            
            <p>Nombre: <input class= "linea" type="text" name="nombre" value="'. $fila['Name'] . '"></p>
            <p>Coste: <input class= "linea" type="text" name="coste" value="'. $fila['Cost'] . '"></p>
            <p>Precio: <input class= "linea" type="text" name="precio" value="'. $fila['Price'] . '"></p>
            
            <input class= "boton" type="submit" name="opcion" value="'. $accion .'">
            
        </form><br>
        <form action="Articulos.php" method=post>
            <input class= "boton" type="submit" name="volver" value="Volver">
        </form>';

           
        }
        else{
            //Si queremos crear el artículo accedemos a este.
          
            echo '
            <h2>Se va añadir un artículo nuevo</h2>

            <form action="formArticulos.php" method="POST" id="formarticulos">
                <p>ID: <input class= "linea" type="text" name="ProductID"></p>
                <p>Categoría: 
                <select class= "linea1" name="categoria"> 
                    <option  value="1">PANTALÓN</option> 
                    <option value="2">CAMISA</option> 
                    <option value="3">JERSEY</option>
                    <option value="4">CHAQUETA</option>            
                </select>
                    
                </p>        
            
                </p>
                <p>Nombre: <input class= "linea" type="text" name="nombre"></p>
                <p>Coste: <input class= "linea" type="text" name="coste"></p>
                <p>Precio: <input class= "linea" type="text" name="precio"></p>
                
                <input class = "boton" type="submit" name="opcion" value="Añadir">
                
            </form><br>
            <form action="Articulos.php" method=post>
                <input class = "boton" type="submit" name="volver" value="Volver">
            </form> ';
        }

    
    
    ?>



        
	

 

</body>
</html>

