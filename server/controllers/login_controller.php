<?php
require_once "../lib/db_config.php";

//  Login
function login_user_by_credentials($username, $password){

  // Chequeamos si las credenciales están registradas en la base de datos
  $dbh = $GLOBALS['dbh'];
  $sql = "SELECT `password`, `tipo` FROM usuarios WHERE username = :username"; // obtenemos contraseña registrada
  $params = [
    ":username" => $username
  ];
  $resultado = pdo_sql_query($dbh, $sql, $params);
  
  // chequeamos que la contraseña recibida coincida con la contraseña correcta
  if($resultado->result !== [] ){ 
    if($resultado->result[0]['password'] == $password){ 
      return [
        'status' => true,
        'message' => 'login successful',
        'token' => create_jwt([
          'type' => $resultado->result[0]['tipo']
        ])
      ];
    } else {
      return [
        'status' => false,
        'message' => 'Incorrect username or password'
      ];
    }
  } else {
    return [
      'status' => false,
      'message' => 'Incorrect username or password'
    ]; 
  }
}

function login_user_by_token(){
  $decoded = verify_jwt();
  $pass = is_array($decoded)?true:$decoded;
  // aca podría implementar un control de acceso basado en el rol
  return [
    "pass" => $pass
  ]; 
}

function test_login_user_by_credentials(){
  var_dump( login_user_by_credentials( 'joelkukin', '1234'));
}

?>