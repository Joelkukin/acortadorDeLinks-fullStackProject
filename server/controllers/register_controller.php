<?php
require_once "../lib/db_config.php";
require_once "../models/Usuario.php";

//  Register
function crear_usuario($datos_nuevo_usuario){
  
  // validar si los parametros se pueden asignar a un usuario
  if(
    isset($datos_nuevo_usuario->username) &&
    isset($datos_nuevo_usuario->password) &&
    isset($datos_nuevo_usuario->nombre) &&
    isset($datos_nuevo_usuario->partner) &&
    isset($datos_nuevo_usuario->mail) &&
    isset($datos_nuevo_usuario->tipo)
  ){
      
    // chequear si está registrado
    $consulta = pdo_sql_query(
      $GLOBALS['dbh'], 
      'SELECT * FROM usuarios WHERE username LIKE :username', 
      [':username' => $datos_nuevo_usuario->username]
    );

    if($consulta->affected_rows == 1){
      $nuevo_usuario = new Usuario((array)$datos_nuevo_usuario);
      $nuevo_usuario = $nuevo_usuario->get('id');
      
      return array(
        'status' => false,
        'message' => 'El usuario ya esta registrado',
        // 'data'=>$nuevo_usuario // si no está registrado, el usuario no puede ver los datos
      );
    } else {
      //var_dump("<pre><h1>\$datos_nuevo_usuario</h1><br>",(array)$datos_nuevo_usuario,"</pre>");
      $nuevo_usuario = new Usuario((array)$datos_nuevo_usuario);

      $nuevo_usuario = $nuevo_usuario->get('id');
      var_dump("<pre><h1>\$nuevo_usuario</h1><br>",$nuevo_usuario->username,"</pre>");
      return array(
        'status' => true,
        'message' => 'usuario '.$nuevo_usuario->username.' creado correctamente',
        'data' => $nuevo_usuario // si se acaba de registrar, no hay problema en que el usuario vea los datos
      );
    }


  }else{
    return (object)array(
      'status' => false,
      'message' => 'faltan datos mal ingresados'
    );
  }

  if($consulta->affected_rows == 0){
    
    return new Usuario(
      [
        'username' => $username, 
        'password' => $password, 
        'nombre' => $nombre, 
        'partner' => $partner, 
        'mail' => $mail, 
        'tipo' => $tipo
      ]
    );
  }
}


// capturar el body de la solicitud http

// 
?>