<?php 
// ROUTER
header('text/json; charset=UTF-8');
// use routes/Route.php";
require_once "../lib/db_config.php";
require_once "../lib/Route.php";
require_once "../lib/login_functions.php";
 
$GLOBALS['dbh'] = pdo_start_session(db_config());

// Control de acceso //
require_once "../routes/routes_login.php";
require_once "../routes/routes_register.php";


/* Aca definimos las rutas del sitio */
require_once "../routes/routes_links.php";


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
// iniciamos escucha de solicitudes HTTP
Route::dispatch();

?>
