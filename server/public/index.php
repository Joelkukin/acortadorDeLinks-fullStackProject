<?php 
// ROUTER
  // MANEJAR SOLICITUDES PREFLIGHT
  if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("Access-Control-Allow-Origin: http://localhost:5173");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    exit(0);
  }


  // PREPARAR LOS HEADERS DE LA RESPUESTA PARA EL CLIENTE
  header('charset = UTF-8');
  header('text/json; charset=UTF-8');
  header("Access-Control-Allow-Origin: http://localhost:5173");
  header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
  header("Access-Control-Allow-Headers: Content-Type, Authorization");
// use routes/Route.php";
require_once "../lib/db_config.php";
require_once "../lib/Route.php";
require_once "../lib/login_functions.php";
 
$GLOBALS['dbh'] = pdo_start_session(db_config());

require_once "../routes/routes_login.php";

// Control de acceso //
require_once "../routes/routes_main.php";
require_once "../routes/routes_register.php";


/* Aca definimos las rutas del sitio */
require_once "../routes/routes_links.php";



// iniciamos escucha de solicitudes HTTP
Route::dispatch();

?>
