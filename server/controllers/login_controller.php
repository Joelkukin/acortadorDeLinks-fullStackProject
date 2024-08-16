<?php
require_once "../lib/db_config.php";

//  Login
function login_user($username, $password){
  $dbh = $GLOBALS['dbh'];
  $sql = "SELECT `password` FROM usuarios WHERE username LIKE :username";
  $params = [
    ":username" => $username
  ];
  $resultado = pdo_sql_query($dbh, $sql, $params);
  if($resultado->result[0]['password'] == $password){
    return true;
  } else {
    return false;
  }
}

function test_login_user(){
  var_dump( login_user( 'joelkukin', '1234'));
}

?>