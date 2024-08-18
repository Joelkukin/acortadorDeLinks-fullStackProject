<?php
require_once "../lib/db_config.php";
//require_once "../lib/qr_creator.php";

class Link {
  private $dbh;
  public $id;
  public $link_src;
  public $link_target;
  public $owner;
  public $qr_img;
  private $datatable;
  public function __construct(
    /* ------------ interface ------------ */
    /* {
      id : str
      link_src : str
      link_trgt : str
      owner : str // dueño
      qr_img : str(url)
    } */


    $datos_link = [ // todo: consultar en la BD
      'link_src' => null, 
      'link_target' => "", 
      'owner' => "", 
      'qr_img' => "", 
    ]
  ){
    // ------------ Constructor ------------ //
    // - uso de conexion a base de datos
    $this->dbh = $GLOBALS['dbh']; 
    $this->datatable = 'shortlinks';
    
    // validacion de parametros ingresados
    foreach ($datos_link as $prop => $value) {
      
    }

    // verificacion de existencia del link en la base de datos //';
    $consulta = pdo_sql_query($this->dbh,
      // consulta de la cantidad de veces que aparece el $link_src
      "SELECT COUNT(*) as coincidencias FROM $this->datatable WHERE link_src LIKE :link_src", [
        ':link_src' => $datos_link['link_src']
      ]
    );

    // si existe el link en la base de datos, asignamos a éste objeto los valores existentes en la BD
    // si no existe el link en la base de datos, creamos un nuevo registro en la BD
    $coincidencias = $consulta->result[0]['coincidencias'];
    
    // chequeamos si existe el link en la base de datos
    if($coincidencias == 1){

      // - consulta de la cantidad de veces que aparece el $link_src
      $link = pdo_sql_query($this->dbh,
        "SELECT * FROM $this->datatable WHERE link_src LIKE :link_src", [
          ':link_src' => $datos_link['link_src']
        ]
      );

      // - asignamos a éste objeto los valores existentes en la BD
      $link = $link->result[0];
      $this->id = $link['id'];

      $this->link_src = $link['link_src'];
      $this->link_target = $link['link_target'];
      $this->owner = $link['owner'];
      $this->qr_img = $link['qr_img'];
    } elseif ($coincidencias == 0){
      
      // si no existe el link en la base de datos, creamos un nuevo registro en la BD //

      // - consulta de creacion de nuevo link en base de datos
      $this->link_src = $datos_link['link_src'];
      $this->link_target = $datos_link['link_target'];
      $this->owner = $datos_link['owner'];
      $this->qr_img = $datos_link['qr_img'];

      $sql_insert = 
        "INSERT 
          INTO `$this->datatable` ( `link_src`, `link_target`, `owner`, `qr_img`) 
          VALUES       ( :link_src , :link_target , :owner , :qr_img )";
  
      $stmt_insert = pdo_sql_query($this->dbh,$sql_insert, [
        ':link_src' => $datos_link['link_src'],
        ':link_target' => $datos_link['link_target'],
        ':owner' => $datos_link['owner'],
        ':qr_img' => $datos_link['qr_img']
      ]);

    } 
  }
  
  public function get($campo = "*"){
    $sql = "SELECT $campo FROM $this->datatable WHERE id LIKE '$this->id'";
    
    $link = pdo_sql_query($this->dbh,$sql);
    
    $registro = $link->result[0];
    $this->id = isset($registro['id'])? $registro['id'] :$this->id;
    $this->link_src = isset($registro['link_src'])? $registro['link_src'] :$this->link_src;
    $this->link_target = isset($registro['link_target'])? $registro['link_target'] :$this->link_target;
    $this->owner = isset($registro['owner'])? $registro['owner'] :$this->owner;
    $this->qr_img = isset($registro['qr_img'])? $registro['qr_img'] :$this->qr_img;

    return $registro;
  }

  // Hay que resolver por que no impacta este codigo en la base de datos
  public function set($set_propierties){
    
    
    $sets = [];
     foreach ($set_propierties as $campo => $valor) {
      array_push($sets," `$campo` = '$valor'");
    } 
    $sets = implode(", ", $sets);

    $sql = "UPDATE `$this->datatable` SET ".$sets." WHERE id = '$this->id'";
    $resultado = pdo_sql_query($this->dbh, $sql);

    return $resultado->affected_rows;
  }

  public function remove(){
    $sql = "DELETE FROM $this->datatable WHERE id LIKE '$this->id'";
    $resultado = pdo_sql_query($this->dbh,$sql);
    return $resultado->affected_rows;
  }
}


function test_class_link(){
  $dbh= $GLOBALS['dbh'];
  echo "<pre>";
  
  var_dump('<h1>$link</h1> <br>');
  $link= new Link(
    [
      'link_src' => "test_link_src1", 
      'link_target' => "test_link_target", 
      'owner' => "test_owner", 
      'qr_img' => "test_qr_img", 
    ]
  );
    var_dump($link);
    var_dump('<h1>$link->get("*")</h1> <br>');
    var_dump($link->get('*')); // params => "`id`, `link_src`, `link_target`, ..."
    var_dump('<h1>$link->get("link_src") #1</h1> <br>');
    var_dump($link->get('link_src')); // params => "`id`, `link_src`, `link_target`, ..."
    var_dump('<h1>$link->set()</h1> <br>'); 
    var_dump("result: ",$link->set(["link_src" => 'holaa']));
    var_dump('<h1>$link->get() #2</h1> <br>');
    var_dump("result: ",$link->get('link_src'));
    var_dump('<h1>$link->delete() #2</h1> <br>');
    var_dump("result: ",$link->remove('link_src'));

  echo "</pre>";
}

?>