<?php
require_once "../lib/db_config.php";
//require_once "../lib/login_functions.php";
require_once "../models/Link.php";

define('DATATABLE', 'shortlinks');

function get_http_data(){
  if(check_user_loged()){ // solo si la sesion está iniciada
    
    // test if endpoint is working
    $data = json_decode(file_get_contents('php://input')); // capturar datos del http request : array()
    

    return [
      'status' => true,
      'data' => $data
    ];
    
  }else{
    return [
      'status' => false
    ];
  }
}
  
/* function get_all_links($id_user){ // buscar
  if (get_http_data()['status']) {
    // traigo los links de la BD
    $stmt = $GLOBALS['dbh']->prepare("SELECT * FROM ".DATATABLE." WHERE 1");
    $stmt->execute();

    // instanciamos la clase Link con los datos de cada registro 

    $links = $stmt->fetchAll(PDO::FETCH_CLASS, "Link");

    if(count($links) > 0){
      return [
        "status" => true,
        "data" => $data
      ];
    } else {
      return [
        "status" => true,
        "data" => $data
      ];
    }
  }
} */

function create_link($id_user){
  $http_body = get_http_data();
  if ($http_body['status']) {
    if(!isset($http_body['data'])) return "hubo un problema al obtener el http_body";
    if(
      isset($http_body['data']->link_src) &&
      isset($http_body['data']->link_target)
    ){
        
      // instanciamos la clase Link con los datos del request
      $stmt = $GLOBALS['dbh']->prepare(
        "INSERT INTO ".DATATABLE." (link_src, link_target, owner, qr_img) VALUES (:link_src, :link_target, :owner, :qr_img)"
      );
      $result = $stmt->execute([
        ":link_src" => $http_body['data']->link_src, 
        ":link_target" => $http_body['data']->link_target, 
        ":owner" => isset($id_user)? $id_user : "undefined", 
        ":qr_img" => isset($http_body['data']->qr_img)? $http_body['data']->qr_img : ""
      ]);

      $links = search_links([
        "owner" => $id_user, 
        "link_src" => $http_body['data']->link_src]);

      return $links[0];
    }else{
      return "faltan parametros esenciales para crear el link";
    }
  }
}

function search_links($criterios, $aprox = false){
  if(is_array($criterios) && is_bool($aprox)){
    // unir clave y valor en string
    $sql_parts = [];
    $params = [];
    $comparacion = $aprox? "=": "LIKE";
    foreach($criterios as $campo => $valor){
      if( strtolower($campo) == "id" 
      || strtolower($campo) == "link_src" 
      || strtolower($campo) == "link_target" 
      || strtolower($campo) == "owner"
      || strtolower($campo) == "qr_img") {
  
        $params[":$campo"] = $valor;
        $sql_parts[] = "$campo $comparacion :$campo";
      
      } else {
        return "el campo $campo no existe";
      }
      
    }
    
    // unir strings
    $str_criterios = implode(" AND ", $sql_parts);
  
    // obtener datos ingresados
    $http_body = get_http_data();
    if ($http_body['status']) {
  
      $stmt = $GLOBALS['dbh']->prepare("SELECT * FROM ".DATATABLE." WHERE $str_criterios");
      $result = $stmt->execute($params);
  
      // instanciamos la clase Link con los datos de cada registro 
      $links = $stmt->fetchAll(PDO::FETCH_CLASS, "Link");
      
      return $links;
    }

  }
}

function redirect($id_user, $link_src){
  if (get_http_data()['status']) {
    $link_dest = search_links(['owner'=>$id_user, "link_src"=>$link_src]);
   
    if(isset($link_dest[0])){
      $url = $link_dest[0]->link_target;
      $pattern = '/\b((https?|ftp):\/\/[-\w+&@#\/%?=~_|!:,.;]*[-\w+&@#\/%=~_|])|^$/i';
    } else {
      return "El link al que intenta acceder no existe";
    }
  
    if (preg_match($pattern, $url)) {
      echo "La URL asociada a este link es válida.";
      header("Location: $url");
    } else {
      return "La URL asociada a este link no es válida. link_target: ".$url." expected some like https://webDestino.algo";
    }
  }
}

function update_link($id_user, $link_src){
  if (get_http_data()['status']) {
    $http_body = get_http_data(); 
    $link = search_links([ // retorna un array de las coincidencias
      "link_src" => $link_src,
      "owner" => $id_user 
    ]);

    // transformamos los parámetros en array
    $sets = (array)$http_body['data'];
    // var_dump($link);
    if(isset($link[0])){
      $link = $link[0]->set($sets); // seteamoi
      return $link;
    } else {
      return "el link no existe";
    }
  }
}

function delete_link($id_user, $link_src){
  if (get_http_data()['status']) {
    $link = search_links([ // retorna un array de las coincidencias
      "link_src" => $link_src,
      "owner" => $id_user 
    ]);

    // var_dump($link);
    if(isset($link[0])){
      $removed = $link[0]->remove();
      if($removed){
        return "Link eliminado con éxito";
      }
    } else {
      return "el link no existe";
    }
  }
}

function test_links_controller($data){
  echo "<pre>";
  $links = get_all_links();
   var_dump("respuesta: ",$links);
  /*
  $links['data'][0]->set([
    'link_target' => $links['data'][0]->link_src,
    'link_src' => 'acort.ar.test/yt'
  ]);
  var_dump("post set(): ",$links['data'][0]); */

  
  echo "</pre>";
}

?>