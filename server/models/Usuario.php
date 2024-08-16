<?php
require_once "../lib/db_config.php";
//require_once "../lib/qr_creator.php";

class Usuario {
  private $dbh;
  public $id;
  public $nombre;
  public $partner;
  public $username;
  public $password;
  public $mail;
  public $tipo;
  public function __construct(
    $datos_usuario = [
      'username' => null, 
      'password' => null, 
      'nombre' => "", 
      'partner' => "", 
      'mail' => "", 
      'tipo' => ""
    ]
  ){
    // uso de conexion a base de datos
    $this->dbh = $GLOBALS['dbh']; 
    
    // validacion de parametros ingresados
    if (empty($datos_usuario['username']) || empty($datos_usuario['password'])){
      echo(
        '$datos_usuario["username"] y 
        $datos_usuario["password"] no deben estar vacios'
      );
    }


    // verificacion de existencia del usuario en la base de datos //';
    $consulta = pdo_sql_query($this->dbh,
      // consulta de la cantidad de veces que aparece el $username
      "SELECT COUNT(*) as coincidencias FROM usuarios WHERE username LIKE :username", [
        ':username' => $datos_usuario['username']
      ]
    );

    print_r($consulta->result[0]);
    $coincidencias = $consulta->result[0]['coincidencias'];
    
    if($coincidencias == 1){
      $usuario = pdo_sql_query($this->dbh,
        // consulta de la cantidad de veces que aparece el $username
        "SELECT * FROM usuarios WHERE username LIKE :username", [
          ':username' => $datos_usuario['username']
        ]
      );
      $usuario = $usuario->result[0];
      $this->id = $usuario['id'];
      $this->nombre = $usuario['nombre'];
      $this->partner = $usuario['partner'];
      $this->username = $usuario['username'];
      $this->password = $usuario['password'];
      $this->mail = $usuario['mail'];
      $this->tipo = $usuario['tipo'];
    } elseif ($coincidencias == 0){
      // si no existe el usuario, se procede a crear el usuario
      // consulta de creacion de nuevo usuario en base de datos //
      
      $sql_insert = "INSERT INTO `usuarios`(
        
        `nombre`, 
        `partner`, 
        `username`, 
        `password`, 
        `mail`, 
        `tipo`
      ) 
      VALUES (
        :nombre,
        :partner,
        :username,
        :password,
        :mail,
        :tipo
      )";
  
      echo pdo_sql_query($this->dbh,$sql_insert, [
        ':nombre' => $datos_usuario['nombre'],
        ':partner' => $datos_usuario['partner'],
        ':username' => $datos_usuario['username'],
        ':password' => $datos_usuario['password'],
        ':mail' => $datos_usuario['mail'],
        ':tipo' => $datos_usuario['tipo']
      ])->affected_rows;
    }
        
        
  }

  private function sql_query($sql, $params = null){
    return pdo_sql_query($this->dbh, $sql, $params);
  }
  
  public function get($campo = "*"){
    $sql = "SELECT $campo FROM usuarios WHERE id LIKE '$this->id'";
    
    $usuario = pdo_sql_query($this->dbh,$sql);
    
    $registro = $usuario->result;
    $this->id = isset($registro['id'])? $registro['id'] :$this->id;
    $this->nombre = isset($registro['nombre'])? $registro['nombre'] :$this->nombre;
    $this->partner = isset($registro['partner'])? $registro['partner'] :$this->partner;
    $this->username = isset($registro['username'])? $registro['username'] :$this->username;
    $this->password = isset($registro['password'])? $registro['password'] :$this->password;
    $this->mail = isset($registro['mail'])? $registro['mail'] :$this->mail;
    $this->tipo = isset($registro['tipo'])? $registro['tipo'] :$this->tipo;

    return $registro[0][$campo];
  }

  // Hay que resolver por que no impacta este codigo en la base de datos
  public function set($set_propierties){
    
    
    $sets = [];
     foreach ($set_propierties as $campo => $valor) {
      array_push($sets," `$campo` = '$valor'");
    } 
    $sets = implode(", ", $sets);
    
    $sql = "UPDATE `usuarios` SET ".$sets." WHERE id = '$this->id'";
    $resultado = pdo_sql_query($this->dbh,$sql);

    return $resultado->affected_rows;
  }

  public function remove(){
    $sql = "DELETE FROM usuarios WHERE id LIKE '$this->id'";
    $resultado = pdo_sql_query($this->dbh,$sql);
    return $resultado->result[0];
  }
}


function test_class_usuario(){
  $dbh= $GLOBALS['dbh'];
  echo "<pre>";
  
  var_dump('<h1>$usuario</h1> <br>');
  $usuario= new Usuario(
    [
      'username' => "test_username", 
      'password' => "test_password", 
      'nombre' => "test_nombre", 
      'partner' => "test_partner", 
      'mail' => "test_mail", 
      'tipo' => "test_tipo"
    ]
  );
    /* var_dump($usuario);
    var_dump('<h1>$usuario->get() #1</h1> <br>');
    var_dump($usuario->get('username')); // params => "`id`, `nombre`, `partner`, ..."*/
    var_dump('<h1>$usuario->set()</h1> <br>'); 
    var_dump($usuario->set(["tipo" => 'hey']));
    var_dump('<h1>$usuario->get() #2</h1> <br>');
    var_dump($usuario->get('username'));
  echo "</pre>";
}

?>