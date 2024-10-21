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

function protected_function($funcion,$jwt){
  // Verificamos si el usuario está logueado
  $valid = $jwt['valid'] || null;
  
  // verificamos si el jwt es válido
  if (is_string($jwt)){
    http_response_code(401); // Unauthorized
    echo $jwt;
  } elseif(is_array($jwt) && $jwt["valid"]){
    return json_encode($funcion); // ejecuta la funcion pasada por parámetro
  } else {
    http_response_code(403); // error server side
    echo json_encode([
      'error' => "access denied",
      'message' => var_dump( $jwt , $jwt["valid"])
    ]);
  }
}


Route::get("/links", function(){
  $jwt = verify_jwt();
  if(is_string($jwt)){
      echo $jwt;
    }else{
      $id_user = $jwt['data']->data->user;
      echo protected_function(search_links(['owner' => $id_user]), $jwt);
    }

});

// crear
Route::post("/links/create", function(){
  $jwt = verify_jwt();
    if(is_string($jwt)){
      echo $jwt;
    }else{
      $id_user = $jwt['data']->data->user;
      echo protected_function( create_link($id_user), $jwt);

    }
  });


// modificar
Route::put("/links/modify/:link_src", function($link_src){
  $jwt = verify_jwt();
    if(is_string($jwt)){
      echo $jwt;
    }else{
      $id_user = $jwt['data']->data->user;
      echo protected_function(update_link($id_user, $link_src), $jwt);
    }
});

// borrar
Route::delete("/links/delete/:link_src", function($link_src){
  $jwt = verify_jwt();  
    if(is_string($jwt)){
      echo $jwt;
    }else{
      $id_user = $jwt['data']->data->user;
      echo protected_function(delete_link($id_user, $link_src), $jwt);
    }
});

 // redirect
 Route::get("/:id_user/:link_src", function($id_user, $link_src){
 
  echo json_encode(search_links(['owner' => $id_user, 'link_src' => $link_src]));

});
?>