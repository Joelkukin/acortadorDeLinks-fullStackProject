<?php 
require_once "../lib/Route.php";

Route::post("/register", function(){
  if(!isset($_SESSION)){
    # <code>
    $data = json_decode(file_get_contents('php://input')); // capturar datos del http request
    
    // creamos un usuario

    # </code>
  }else{
    echo "cierre la cuenta actual para registrar una nueva cuenta";
  };
});

?>