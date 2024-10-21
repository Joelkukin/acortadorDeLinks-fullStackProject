<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
require "../vendor/autoload.php";

define('KEY','joel');
define('ALGO','HS256');

function create_jwt($data){
  $payload = [
      'exp' => strtotime("now") + 60*60, // 1 hora
      'data' => $data
  ];
  $jwt = JWT::encode($payload, KEY, ALGO);
  return $jwt;
}

function verify_jwt(){
  // Rescato los headers de la solicitud http
  $headers = apache_request_headers();
  
  $jwt = explode(" ", $headers['Authorization'])[1];
  //var_dump($jwt);
  try {
    $jwt = JWT::decode($jwt, new Key(KEY, ALGO));
    $valid = is_object($jwt);
    
    return [
      'data' => $jwt,
      'valid' => $valid
    ];
  } catch (Exception $e) {
    $error = $e->getMessage();
    return $error;
  }


}

/**
 * IMPORTANT:
 * You must specify supported algorithms for your application. See
 * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
 * for a list of spec-compliant algorithms.
 */
function test_jwt_controller(){
  $jwt = create_jwt([
    'name' => 'John Doe',
    'rol' => 'admin'
  ]);
  var_dump($jwt);
  $decoded = verify_jwt($jwt);
  var_dump($decoded);
}

//test_jwt_controller();

?>