<?php 
require_once "../lib/Route.php";
require_once "../controllers/login_controller.php";

Route::post("/login", function (){
  $data = json_decode(file_get_contents('php://input')); // capturar datos del http request
  
  // chequear si el usuario y contraseña coinciden con la base de datos
  
    //code...
    $login_result = login_user($data->username, $data->password);
    
    if($login_result['status']){
      // si coinciden, iniciar sesion
      session_start();
      session_create_id('user');
      //echo login_user($data->username, $data->password);
  
      // lo ideal seria implementar JWT pero por ahora nos manejaremos con el ID de la sesion
      header('Content-Type: text/json; charset = UTF-8');
      echo json_encode([
        'status' => true,
        'message' => 'Login successful',
        'session_id' => session_id()
      ]);
    }else{
      header('Content-Type: text/json; charset = UTF-8');
      echo json_encode([
        'status' => $login_result['status'],
        'message' => $login_result['message']
      ]);
    };
  
});

?>