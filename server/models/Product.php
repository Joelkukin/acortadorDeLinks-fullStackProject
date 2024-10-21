<?php
require_once "../lib/db_config.php";

class Product {
  public $id;
  public $name;
  public $description;
  public $price;
  public $stock;
  public $category;
  private $datatable = 'products';

  private function validate_price($price) {
    return is_numeric($price) && $price >= 0;
  }

  public function get($field = "*") {
    $sql = "SELECT $field FROM $this->datatable WHERE id LIKE '$this->id'";
    
    $product = pdo_sql_query($GLOBALS['dbh'], $sql);
    
    $record = $product->result;
    $this->id = isset($record['id']) ? $record['id'] : $this->id;
    $this->name = isset($record['name']) ? $record['name'] : $this->name;
    $this->description = isset($record['description']) ? $record['description'] : $this->description;
    $this->price = isset($record['price']) ? $record['price'] : $this->price;
    $this->stock = isset($record['stock']) ? $record['stock'] : $this->stock;
    $this->category = isset($record['category']) ? $record['category'] : $this->category;

    return $record;
  }

  public function set($set_properties) {
    $sets = [];

    foreach ($set_properties as $field => $value) {
      if ($field === 'price' && !$this->validate_price($value)) {
        throw new Exception("Invalid price value");
      }
      $this->$field = $value;
      array_push($sets, " `$field` = '$value'");
    }
    $sets = implode(", ", $sets);

    $sql = "UPDATE `$this->datatable` SET ".$sets." WHERE id = '$this->id'";
    $result = pdo_sql_query($GLOBALS['dbh'], $sql);

    return $this->get(
      implode(", ", array_keys($set_properties))
    )[0];
  }

  public function remove() {
    $sql = "DELETE FROM $this->datatable WHERE id LIKE '$this->id'";
    $result = pdo_sql_query($GLOBALS['dbh'], $sql);
    return $result->affected_rows;
  }
}