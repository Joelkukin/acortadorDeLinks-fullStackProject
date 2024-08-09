<?php 
// ROUTER

// use routes/Route.php";
require_once "./routes/Route.php";

echo $_SERVER['REQUEST_URI'];

// aca definimos las rutas
Route::get("/", function(){
  header("location: ../client/dist/index.html");
});

// iniciamos escucha de solicitudes HTTP
Route::dispatch();

?>
