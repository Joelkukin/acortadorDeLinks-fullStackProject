<?php 
require_once "../lib/Route.php";
require_once "../controllers/links_controller.php";
require_once "../controllers/login_controller.php";
require_once "../controllers/jwt_controller.php";

// parámetros buscar
/* {
  campo: str,
  buscar: str,
  } */

 // traer todo
header("Content-type: text/json; charset:utf-8");
Route::get("/links/:id_user/", function($id_user){
  /* $token = $_SERVER["HTTP_AUTHORIZATION"]; */
  $result = verify_jwt();
  //var_dump($result["valid"]);
  if($result["valid"]){
    echo json_encode(search_links(['owner' => $id_user]));
  } else {
    echo json_encode([
      'error' => "access denied"
    ]);
  }
});


 // redirect
Route::get("/:id_user/:link_src", function($id_user, $link_src){
  
  echo json_encode(redirect($id_user, $link_src));

});
 
// crear
Route::post("/links/:id_user", function($id_user){
  echo json_encode( create_link($id_user));
});


// modificar
Route::put("/links/:id_user/:link_src", function($id_user, $link_src){
  echo json_encode( update_link($id_user, $link_src));
});

// borrar
Route::delete("/links/:id_user/:link_src", function($id_user, $link_src){
  echo json_encode( delete_link($id_user, $link_src));
});



// parámetros insertar
/* {
  campo1: valor1,
  campo2: valor2,
  ...
  campoN: valorN
  
} */

/* Route::post("/create", function(){ // insertar
  if(session_id() !== null){
    # <code>  solo ejecuta el controlador
    $data = json_decode(file_get_contents('php://input')); // capturar datos del http request
    echo json_encode(['data' => $data]);

    # </code>
  }else{
    header(501);
    echo json_encode([
      'error' => 'No hay sesión activa'
    ]);
  }
}); */

// parámetros modificar
/* {
  campo1: valor1,
  campo2: valor2,
  ...
  campoN: valorN
  
} */
Route::put("/links", function(){ // modificar
  if(session_id() !== null){
    # <code> solo ejecuta el controlador
    $data = json_decode(file_get_contents('php://input')); // capturar datos del http request
    echo json_encode(['data' => $data]);

    # </code>
  }else{
    header(501);
    echo json_encode([
      'error' => 'No hay sesión activa'
    ]);
  }
});

// parámetros borrar
/* {
  campo1: [id]
} */
Route::delete("/links", function(){ // borrar
  if(session_id() !== null){
    # <code> solo ejecuta el controlador
    $data = json_decode(file_get_contents('php://input')); // capturar datos del http request
    echo json_encode(['data' => $data]);

    # </code>
  }else{
    header(501);
    echo json_encode([
      'error' => 'No hay sesión activa'
    ]);
  }
});

?>