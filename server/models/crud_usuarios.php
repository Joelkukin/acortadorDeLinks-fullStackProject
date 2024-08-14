<?php
require_once "../lib/db_config.php";
require_once "../lib/qr_creator.php";

// sql_query_pdo($dbh, $sql, $params)
class Usuarios{
  public static function get($campo, $valor){
    $dbh;
    $sql = "SELECT :campo FROM usuarios WHERE :campo LIKE :valor%";
    $params;
    sql_query_pdo($dbh, $sql, $params);
  }
}


?>