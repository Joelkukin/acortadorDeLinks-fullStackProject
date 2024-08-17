<?php
require_once "../lib/db_config.php";

//  Login
function login_user($username, $password){
  $dbh = $GLOBALS['dbh'];
  $sql = "SELECT `password` FROM usuarios WHERE username = :username"; // obtenemos contraseña correcta
  $params = [
    ":username" => $username
  ];
  
    //code...
    $resultado = pdo_sql_query($dbh, $sql, $params);
  
  
  if($resultado->result !== [] ){ // chequeamos que el usuario exista en la base de datos
    if($resultado->result[0]['password'] == $password){ // chequeamos que la contraseña sea la correcta
      return [
        'status' => true,
        'message' => 'login successful'
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

function test_login_user(){
  var_dump( login_user( 'joelkukin', '1234'));
}

?>