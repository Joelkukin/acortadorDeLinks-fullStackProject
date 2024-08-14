<?php 
// ROUTER

// use routes/Route.php";
require_once "../lib/Route.php";

/* 
require_once "../routes/routes_login.php";
require_once "../routes/routes_register.php";
require_once "../routes/routes_links.php";
 */
include_once "../controller/login.php";
include_once "../controller/register.php";
include_once "../controller/links.php";

//echo $_SERVER['REQUEST_URI'];
//echo $_SESSION[''];

//$json = file_get_contents('php://input');

//var_dump(json_decode($json));

/* Aca definimos las rutas */
//  Home

Route::get("/", function(){
  echo 'home';
  echo '<br><br>';
  
  echo file_get_contents("./index.html");
  
});



// iniciamos escucha de solicitudes HTTP
Route::dispatch();

?>
