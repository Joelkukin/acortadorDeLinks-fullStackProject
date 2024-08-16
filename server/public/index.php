<?php 
// ROUTER

// use routes/Route.php";
require_once "../lib/db_config.php";
require_once "../lib/Route.php";
 
$GLOBALS['dbh'] = pdo_start_session(db_config());

// Control de acceso //
require_once "../routes/routes_login.php";
require_once "../routes/routes_register.php";


/* Aca definimos las rutas del sitio */
require_once "../routes/routes_links.php";

// cerrar conexion base de datos
Route::post("/exit", function(){
  unset($GLOBALS['dbh']);
  header("location: /login");
  session_destroy();
});


Route::post("/test", function(){
  $data = json_decode(file_get_contents('php://input')); // capturar datos del http request
  require_once "../models/Usuario.php";
  test_class_usuario($data);
});
// iniciamos escucha de solicitudes HTTP
Route::dispatch();

?>
