<?php 
require_once "../lib/Route.php";
require_once "../controllers/register_controller.php";

Route::post("/register", function(){
  header('content-type: text/json; charset = UTF-8');
  
    # <code>
    $data = json_decode(file_get_contents('php://input')); // capturar datos del http request
    
    // Validamos que el body sea de la forma
    /*******************************
     * {
     *   username
     *   password
     *   nombre
     *   partner
     *   mail
     *   tipo
     * }
     ******************************/ 

    // creamos un usuario
    $data = crear_usuario($data);
      if($data['status']){
        header('Content-Type: text/json; charset: UTF-8');
        echo json_encode([
            'status' => $data['status'],
            'message' => isset($data['message'])? $data['message'] : null,
            'data' => isset($data['data'])? $data['data'] : null
        ]);
      }else{
        header('Content-Type: text/json; charset: UTF-8');
        echo json_encode([
          'status' => false,
          'message' => isset($data['message'])? $data['message'] : null,
          'data' => isset($data['data'])? $data['data'] : null
        ]);
      }
    # </code>
  
});

?>