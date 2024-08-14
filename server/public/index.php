<?php 
// ROUTER

// use routes/Route.php";
require_once "../lib/db_config.php";
require_once "../lib/Route.php";
/* 
require_once "../routes/routes_login.php";
require_once "../routes/routes_register.php";
require_once "../routes/routes_links.php";
 */

include_once "../controller/register.php";
include_once "../controller/links.php";

//$json = file_get_contents('php://input'); // obtener http_body

//var_dump(json_decode($json));

/* Aca definimos las rutas */
$GLOBALS['dbh'] = pdo_start_session(db_config());

Route::post("/test", function(){
  include_once "../lib/db_config.php";
  // esto irá en crud_usuarios.php
  

  var_dump( login_user( 'joelkukin', '1234'));
});

Route::post("/login", function(){
  require_once "../controller/login.php";
  $data = file_get_contents('php://input'); // obtener http_body
  $data = json_decode($data);
  
  // $dbh = pdo_start_session($dbconfig);

  echo login_user($data->username, $data->password);

 
});


if(!isset($_SESSION)){
  
  Route::post("/register", function(){
    if(!isset($_SESSION)){
      echo "sesion no iniciada<br>";
    }else{
      echo "sesion iniciada";
      echo session_id();
    }
  });
  
  // Control de acceso //
  
  Route::post("/links", function(){
  
  });
  
  // cerrar conexion base de datos
  Route::post("/close", function(){
    unset($dbh);
  });
}else{
  echo "no existe sesion";
};


// iniciamos escucha de solicitudes HTTP
Route::dispatch();

?>
