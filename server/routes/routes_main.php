<?php 
require_once "../lib/Route.php";
require_once "../controllers/login_controller.php";
require_once "../controllers/jwt_controller.php";


// cerrar conexion base de datos
Route::post("/exit", function(){
  header("location: /login",true,200);
  close_user_session();
  unset($GLOBALS['dbh']);
});


Route::post("/test", function(){
  $data = json_decode(file_get_contents('php://input')); // capturar datos del http request
  require_once "../controllers/links_controller.php";
  test_links_controller($data);
});

?>