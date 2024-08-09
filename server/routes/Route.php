<?php

class Route{
  private static $routes = [];

  public static function get($uri, $callback){
    $uri = trim($uri, "/");
    self::$routes['GET'][$uri] = $callback;
  }

  public static function post($uri, $callback){
    $uri = trim($uri, "/");
    self::$routes['POST'][$uri] = $callback;
  }

  public static function put($uri, $callback){
    $uri = trim($uri, "/");
    self::$routes['PUT'][$uri] = $callback;
  }

  public static function delete($uri, $callback){
    $uri = trim($uri, "/");
    self::$routes["DELETE"][$uri] = $callback;
  }
  
  public static function dispatch() {
    
    $method = $_SERVER['REQUEST_METHOD'];
    $uri_actual = $_SERVER['REQUEST_URI'];
    $uri_actual = trim($uri, "/");

    foreach (self::$routes[$method] as $ruta => $callback) {
      if ($ruta == $uri_actual) {
        $callback();
        return;
      }
    }
    echo "404 not found";

  }
}
?>