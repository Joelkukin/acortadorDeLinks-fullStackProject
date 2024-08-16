<?php 
require_once "../lib/Route.php";

Route::post("/links", function(){
  if(isset($_SESSION)){
    # <code>
    $data = json_decode(file_get_contents('php://input')); // capturar datos del http request
    

    # </code>
  }else{
    echo "sesion no iniciada ";
  };
});

?>