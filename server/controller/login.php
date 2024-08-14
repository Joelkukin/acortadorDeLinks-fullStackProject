<?php
require_once "../lib/db_config.php";

//  Login
function login_user($username, $password){
  $dbh = $GLOBALS['dbh'];
  $sql = "SELECT `password` FROM usuarios WHERE username LIKE :username";
  $params = [
    ":username" => $username
  ];
  $resultado = pdo_sql_query($dbh, $sql, $params)[0];
  if($resultado["password"] == $password){
    return true;
  } else {
    return false;
  }
}

// capturar usuario y contraseña de la solicitud HTTP

// chequear si el usuario y contraseña coinciden con la base de datos

// true: reenviar a home

// false: reenviar a login
?>