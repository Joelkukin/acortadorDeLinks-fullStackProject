<?php 
require_once "../lib/Route.php";
require_once "../controllers/login_controller.php";
require_once "../controllers/jwt_controller.php";


Route::post("/login", function (){
  $body = json_decode(file_get_contents('php://input')); // capturar datos del http request
  
  // chequear si el usuario y contraseña coinciden con la base de datos
  
  //code...
  $login_result; 
  
  header('Content-Type: text/json; charset = UTF-8');

  if(isset($body->username) && isset($body->password)){
    echo json_encode(login_user_by_credentials($body->username, $body->password));
  } else if(isset($body->token)){
    echo json_encode(login_user_by_token($body->token));
  }
  
    /* 
    if($login_result['status']){
        
      
      header('Content-Type: text/json; charset = UTF-8');
      echo json_encode([
        'status' => true,
        'message' => 'Login successful',
        'token' => crear_jwt([

        ])
      ]);
    }else{
      header('Content-Type: text/json; charset = UTF-8');
      echo json_encode([
        'status' => $login_result['status'],
        'message' => $login_result['message']
      ]);
    };
   */
});

?>