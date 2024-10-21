<?php
require_once "../lib/db_config.php";
require_once "../models/Product.php";

define('DATATABLE', 'products');

function get_http_data() {
  if(check_user_loged()) {
    $data = json_decode(file_get_contents('php://input'));
    return [
      'status' => true,
      'data' => $data
    ];
  } else {
    return [
      'status' => false
    ];
  }
}

function create_product($user_id) {
  $http_body = get_http_data();
  if ($http_body['status']) {
    if(!isset($http_body['data'])) return "Problem obtaining http_body";
    if(
      isset($http_body['data']->name) &&
      isset($http_body['data']->price)
    ) {
      $stmt = $GLOBALS['dbh']->prepare(
        "INSERT INTO ".DATATABLE." (name, description, price, stock, category, created_by) 
         VALUES (:name, :description, :price, :stock, :category, :created_by)"
      );
      $result = $stmt->execute([
        ":name" => $http_body['data']->name,
        ":description" => $http_body['data']->description ?? "",
        ":price" => $http_body['data']->price,
        ":stock" => $http_body['data']->stock ?? 0,
        ":category" => $http_body['data']->category ?? "uncategorized",
        ":created_by" => $user_id
      ]);

      $products = search_products([
        "created_by" => $user_id,
        "name" => $http_body['data']->name
      ]);

      return $products[0];
    } else {
      return "Missing essential parameters to create the product";
    }
  }
}

function search_products($criteria, $approximate = false) {
  if(is_array($criteria) && is_bool($approximate)) {
    $sql_parts = [];
    $params = [];
    $comparison = $approximate ? "LIKE" : "=";
    
    foreach($criteria as $field => $value) {
      if(in_array(strtolower($field), ['id', 'name', 'price', 'category', 'created_by'])) {
        $params[":$field"] = $approximate ? "%$value%" : $value;
        $sql_parts[] = "$field $comparison :$field";
      } else {
        return "The field $field doesn't exist";
      }
    }
    
    $str_criteria = implode(" AND ", $sql_parts);
  
    $http_body = get_http_data();
    if ($http_body['status']) {
      $stmt = $GLOBALS['dbh']->prepare("SELECT * FROM ".DATATABLE." WHERE $str_criteria");
      $result = $stmt->execute($params);
  
      $products = $stmt->fetchAll(PDO::FETCH_CLASS, "Product");
      
      return $products;
    }
  }
}

function update_product($user_id, $product_id) {
  if (get_http_data()['status']) {
    $http_body = get_http_data();
    $product = search_products([
      "id" => $product_id,
      "created_by" => $user_id
    ]);

    $sets = (array)$http_body['data'];
    if(isset($product[0])) {
      $product = $product[0]->set($sets);
      return $product;
    } else {
      return "Product doesn't exist";
    }
  }
}

function delete_product($user_id, $product_id) {
  if (get_http_data()['status']) {
    $product = search_products([
      "id" => $product_id,
      "created_by" => $user_id
    ]);

    if(isset($product[0])) {
      $removed = $product[0]->remove();
      if($removed) {
        return "Product successfully deleted";
      }
    } else {
      return "Product doesn't exist";
    }
  }
}