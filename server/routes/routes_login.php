<?php 
require_once "../lib/Route.php";
require_once "../controllers/login_controller.php";

Route::post("/login", function (){
  $data = json_decode(file_get_contents('php://input')); // capturar datos del http request
  
  // chequear si el usuario y contraseña coinciden con la base de datos
  if(login_user($data->username, $data->password)){
    // si coinciden, iniciar sesion
    session_start();
    //echo login_user($data->username, $data->password);

    // lo ideal seria implementar JWT pero por ahora nos manejaremos con el ID de la sesion
    header('content-type: text/json');
    echo json_encode([
      'status' => true,
      'message' => 'Login exitoso',
      'session_id' => session_id()
    ]);
  }else{
    header('content-type: text/json');
    echo json_encode([
      'status' => false,
      'message' => 'usuario o contraseña incorrectos'
    ]);
  };
});

?>