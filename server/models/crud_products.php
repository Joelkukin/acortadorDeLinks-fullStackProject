<?php
require_once "../lib/db_config";
require_once "../models/Product.php";
require_once "../controllers/products_controller.php";

// This file can be used as a reference for the Product CRUD structure
// and for testing purposes

function test_product_crud() {
  echo "<pre>";
  
  // Test creating a product
  $test_product = create_product(1, [
    'name' => 'Test Product',
    'description' => 'This is a test product',
    'price' => 19.99,
    'stock' => 100,
    'category' => 'Test Category'
  ]);
  var_dump("Created product:", $test_product);
  
  // Test searching products
  $found_products = search_products(['category' => 'Test Category']);
  var_dump("Found products:", $found_products);
  
  // Test updating a product
  if (isset($test_product->id)) {
    $updated_product = update_product(1, $test_product->id, [
      'price' => 24.99,
      'stock' => 90
    ]);
    var_dump("Updated product:", $updated_product);
  }
  
  // Test deleting a product
  if (isset($test_product->id)) {
    $delete_result = delete_product(1, $test_product->id);
    var_dump("Delete result:", $delete_result);
  }
  
  echo "</pre>";
}

// Uncomment to run tests
// test_product_crud();