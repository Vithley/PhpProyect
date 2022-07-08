<!DOCTYPE html>
<html>
  <head>
  <title>Crear Usuario</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link href="css/estilos.css" rel="stylesheet"/>

  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <?php
        
        include "BaseDatos.php";  
      ?>

  </head>
  <body>
      
      <?php
      
       //Hacemos un  if para que nos de la opción de crear, editar o borrar los usuarios, y una vez creados nos muestre el mensaje.
      if(isset($_POST["submit"])){  
        $fullName = $_POST["FullName"];
        $password = $_POST["Password"];
        $email = $_POST["Email"];
        $lastAccess= $_POST["LastAccess"]; 
        $date= date("Y-m-d", strtotime($lastAccess));
        $checkboxes = $_POST["checkboxes"];
        
        crearUsuarioBD($fullName, $email, $date, $checkboxes, $password);
        echo "<h1>Se ha añadido un nuevo Usuario</h1>";
        echo "<p><a href= 'Usuarios.php' class= 'boton'>Volver</a></p>"; 

      }
      else if(isset($_POST['opcion'])){  
                  
        $opcion = $_POST['opcion'];        
        
        if ($opcion == "Editar"){
            $id = $_POST['UserID'];
            $fullName = $_POST["FullName"];
            $password = $_POST["Password"];
            $email = $_POST["Email"]; 
            $lastAccess = $_POST['LastAccess'];
            $date= date("Y-m-d", strtotime($lastAccess));

            editarUsuarioBD($id, $fullName, $email, $date);
            echo '<h1 class = "cabecero">Usuario editado</h1>';
            echo "<p><a href= 'Usuarios.php' class= 'boton'>Volver</a></p>"; 
          }
          else if($opcion == "Eliminar"){
            $id = $_POST['UserID'];

            borrarUsuariosBD($id);

            echo '<h1>Usuario eliminado</h1>';
            echo "<p class = 'cabecero'><a href= 'Usuarios.php' class= 'boton'>Volver</a></p>"; 
          }                  
      }


       else if(isset($_POST['accion'])){  

          $accion = $_POST['accion'];
          $id = $_POST['id'];

          $fila = infoUsuario($id);

          $enabled = $fila['Enabled'];
          //Si es registrado o autorizado nos marca la opción del usuario que sea.
          if($enabled == 1){
            $checkedYes = "checked";
            $checkedNo = "";
          }
          else{
            $checkedYes = "";
            $checkedNo = "checked";
          }


          //Mostramos el formulario para editar o borrar los usuarios.
          echo '
            <h1 class = "cabecero">' . $_POST['accion'] . ' un Usuario existente</h1>
            <form action="formUsuarios.php" method="POST">
            <!--Nombre ID-->
            <div class="form-group">
              <label class="col-md-4 control-label boton1" for="UserID">ID</label>  
              <div class="col-md-4">
              <input class="form-control input-md" id="UserID" name="UserID" type="number" placeholder="Introduce tu id" value="'. $fila["UserID"] . '">
                
              </div>
            </div>
    
            <!-- Nombre input-->
            <div class="form-group">
              <label class="col-md-4 control-label boton1" for="FullName">Nombre</label>  
              <div class="col-md-4">
              <input class="form-control input-md" id="Fullname" name="FullName"  type="text" placeholder="Introduce tu nombre" value="'. $fila["FullName"] . '">
                
              </div>
            </div>
    
            <!-- Contraseña input-->
            <div class="form-group">
              <label class="col-md-4 control-label boton1" for="Password">Contraseña</label>  
              <div class="col-md-4">
              <input class="form-control input-md" id="Password" name="Password" type="password" placeholder="Introduce tu contraseña" value="'. $fila["Password"] . '">
                
              </div>
            </div>
    
            <!-- Correo input-->
            <div class= "form-group">
              <label class="col-md-4 control-label boton1" for="Email">Correo</label>  
              <div class="col-md-4">
              <input class="form-control input-md" id="Email" name="Email" type="email" placeholder="Introduce tu correo electrónico" value="'. $fila["Email"] . '">
                
              </div>
            </div>
    
            <!-- Último acceso input-->
            <div class="form-group">
              <label class="col-md-4 control-label boton1" for="LastAccess">Último acceso</label>  
              <div class="col-md-4">
              <input class="form-control input-md" id="LastAccess" name="LastAccess" type="date" value="'. $fila["LastAccess"] . '">
                
              </div>
            </div>


            <!-- Multiple Checkboxes -->
            <div class="form-group">
              <label class="col-md-4 control-label" for="checkboxes">Autorizado</label>
              <div class="col-md-4">
              <div class="checkbox">
                <label for="checkboxes-0">
                  <input name="checkboxes" id="checkboxes-0" type="radio" value="1"' . $checkedYes . '>
                  Sí
                </label>
              </div>
              <div class="checkbox">
                <label for="checkboxes-1">
                  <input name="checkboxes" id="checkboxes-1" type="radio" value="0"' . $checkedNo . '>
                  No
                </label>
              </div>
    
              <div class="w3-container">
                <a href="Usuarios.php"  class="w3-button w3-pink">Volver</a>
                <input type="submit" name="opcion" class="w3-button w3-pink" value="' . $_POST['accion'] . '"/>
              </div>
    
            </div>
          </form>';


        }
          //Mostramos el formulario para crear los usuarios.
          else{  
            echo '
            <h1 class = "cabecero"> Crear Usuario nuevo</h1>
            <form action="formUsuarios.php" method="POST">
            <div class="form-group">
              <label class="col-md-4 control-label boton1" for="UserID">ID</label>  
              <div class="col-md-4">
              <input class="form-control input-md " id="UserID" name="UserID" type="number" placeholder="Introduce tu id">
                
              </div>
            </div>
    
            <!-- Nombre input-->
            <div class="form-group">
              <label class="col-md-4 control-label boton1" for="FullName">Nombre</label>  
              <div class="col-md-4">
              <input class="form-control input-md" id="Fullname" name="FullName"  type="text" placeholder="Introduce tu nombre">
                
              </div>
            </div>
    
            <!-- Contraseña input-->
            <div class="form-group">
              <label class="col-md-4 control-label boton1" for="Password">Contraseña</label>  
              <div class="col-md-4">
              <input class="form-control input-md" id="Password" name="Password" type="password" placeholder="Introduce tu contraseña">
                
              </div>
            </div>
    
            <!-- Correo input-->
            <div class= "form-group">
              <label class="col-md-4 control-label boton1" for="Email">Correo</label>  
              <div class="col-md-4">
              <input class="form-control input-md" id="Email" name="Email" type="email" placeholder="Introduce tu correo electrónico">
                
              </div>
            </div>
    
            <!-- Último acceso input-->
            <div class="form-group">
              <label class="col-md-4 control-label boton1" for="LastAccess">Último acceso</label>  
              <div class="col-md-4">
              <input class="form-control input-md" id="LastAccess" name="LastAccess" type="date">
                
              </div>
            </div>
    
            <!-- Multiple Checkboxes -->
            <div class="form-group">
              <label class="col-md-4 control-label boton1" for="checkboxes">Autorizado</label>
              <div class="col-md-4">
              <div class="checkbox">
                <label for="checkboxes-0">
                  <input name="checkboxes" id="checkboxes-0" type="radio" value="1">
                  Sí
                </label>
              </div>
              <div class="checkbox">
                <label for="checkboxes-1">
                  <input name="checkboxes" id="checkboxes-1" type="radio" value="0">
                  No
                </label>
              </div>
    
              <div class="w3-container">
                <a href="Usuarios.php"  class="w3-button w3-pink">Volver</a>
                <input  type="submit" name="submit" class="w3-button w3-pink" value="Añadir"/>
              </div>
    
            </div>
          </form>';
          }
        
          ?> 
  </body>
</html>
          
            


    













        
      
      
      


</body>
</html>

