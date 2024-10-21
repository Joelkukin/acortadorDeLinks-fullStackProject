<?php
require_once "../lib/db_config.php";
//require_once "../lib/qr_creator.php";

class Link {
  public $id;
  public $link_src;
  public $link_target;
  public $owner;
  public $qr_img;
  private $datatable = 'shortlinks';
 /*  public function __construct($id ,$link_src ,$link_trgt ,$owner){
    $this->id = $id;
    $this->link_src = $link_src;
    $this->link_trgt = $link_trgt;
    $this->owner = $owner;
    $this->qr_img = $this->generate_qr();

  } */

  private function generate_qr(){
    return "< path-qr-image >";
  }

  public function go(){
    return $_SERVER['HTTP_HOST']."/".$this->link_src;
  }
  
  public function get($campo = "*"){
    $sql = "SELECT $campo FROM $this->datatable WHERE id LIKE '$this->id'";
    // var_dump($sql);
    
    $link = pdo_sql_query($GLOBALS['dbh'],$sql);
    
    $registro = $link->result;
    $this->id = isset($registro['id'])? $registro['id'] :$this->id;
    $this->link_src = isset($registro['link_src'])? $registro['link_src'] :$this->link_src;
    $this->link_target = isset($registro['link_target'])? $registro['link_target'] :$this->link_target;
    $this->owner = isset($registro['owner'])? $registro['owner'] :$this->owner;
    $this->qr_img = isset($registro['qr_img'])? $registro['qr_img'] :$this->qr_img;

    return $registro;
  }

  // Hay que resolver por que no impacta este codigo en la base de datos
  public function set($set_propierties){
    var_dump($set_propierties);
    
    $sets = [];
    $original = [];

     foreach ($set_propierties as $campo => $valor) {
      $this->$campo = $valor;
      array_push($sets," `$campo` = '$valor'");
    } 
    $sets = implode(", ", $sets);

    $sql = "UPDATE `$this->datatable` SET ".$sets." WHERE id LIKE $this->id";
    var_dump($sql);
    $resultado = pdo_sql_query($GLOBALS['dbh'], $sql);

    return $this->get(
      implode(", ", array_keys($set_propierties))
    )[0];
    
  }

  public function remove(){
    $sql = "DELETE FROM $this->datatable WHERE id LIKE '$this->id'";
    $resultado = pdo_sql_query($GLOBALS['dbh'],$sql);
    return $resultado->affected_rows;
  }
}


function test_class_link_2(){
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