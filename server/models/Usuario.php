<?php
require_once "../lib/db_config.php";
//require_once "../lib/qr_creator.php";

class Usuario {
  private $dbh;
  private $id;
  private $nombre;
  private $partner;
  private $username;
  private $password;
  private $mail;
  private $tipo;
  public function __construct($dbh, $clave, $valor){
    if($clave == "id" || $clave == "username"){ // validacion de parametros
      $sql = "SELECT * FROM usuarios WHERE $clave LIKE '$valor%'";
      
      $resultado = pdo_sql_query($dbh,$sql);
    }else{
      return "los parametros ingresados son incorrectos";
    };

    // validacion de existencia del registro solicitado en la base de datos
    var_dump($resultado);
    if($resultado){
      $registro = $resultado[0];
      $this->dbh = $dbh;
      $this->id = $registro['id'];
      $this->nombre = $registro['nombre'];
      $this->partner = $registro['partner'];
      $this->username = $registro['username'];
      $this->password = $registro['password'];
      $this->mail = $registro['mail'];
      $this->tipo = $registro['tipo'];
    }else{echo "la consulta no ha obtenido resultados";}
  }
  
  public function get($campo = "*"){
    $sql = "SELECT $campo FROM usuarios WHERE id LIKE '$this->id'";
    
    $registro = pdo_sql_query($this->dbh,$sql);
    var_dump($resultado);
    $registro = $registro[0];
    $this->id = isset($registro['id'])? $registro['id'] :$this->id;
    $this->nombre = isset($registro['nombre'])? $registro['nombre'] :$this->nombre;
    $this->partner = isset($registro['partner'])? $registro['partner'] :$this->partner;
    $this->username = isset($registro['username'])? $registro['username'] :$this->username;
    $this->password = isset($registro['password'])? $registro['password'] :$this->password;
    $this->mail = isset($registro['mail'])? $registro['mail'] :$this->mail;
    $this->tipo = isset($registro['tipo'])? $registro['tipo'] :$this->tipo;

    return $registro;
  }

  // Hay que resolver por que no impacta este codigo en la base de datos
  public function set($set_propierties){
    echo($set_propierties."<br>");
    
    $sql = "UPDATE `usuarios` SET".
      $set_propierties.
      " WHERE id = '$this->id'";
      $resultado = pdo_sql_query($this->dbh,$sql);
      $sql = "SELECT username FROM usuarios WHERE id LIKE '$this->id'";
  
    $registro = pdo_sql_query($this->dbh,$sql);

    return $registro;
  }

  public function remove(){
    $sql = "DELETE FROM usuarios WHERE id LIKE '$this->id'";
    $resultado = pdo_sql_query($this->dbh,$sql);
    return $resultado;
  }
}
function test_class_usuario(){
  $dbh=pdo_start_session();
  echo "<pre>";
  $usuario= new Usuario($dbh, "id", "203");
  
    print_r($usuario);
    print_r("<h1>get</h1> <br>");
    print_r($usuario->get('username')); // params => "`id`, `nombre`, `partner`, ..."
    print_r("<h1>set</h1> <br>");
    print_r($usuario->set("`username` = 'joelkukin'"));
    print_r("<h1>get actualizado</h1> <br>");
    print_r($usuario->get('username'));
  echo "</pre>";
}
test_class_usuario();

?>