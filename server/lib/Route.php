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

/*   public static function post_middleware($uri, $callback){
    $uri = trim($uri, "/");
    
    self::$routes['POST'][$uri] = $callback;
  } */

  public static function put($uri, $callback){
    $uri = trim($uri, "/");
    self::$routes['PUT'][$uri] = $callback;
  }

  public static function delete($uri, $callback){
    $uri = trim($uri, "/");
    self::$routes["DELETE"][$uri] = $callback;
  }

  public static function pattern_to_regex($pattern) {
      // Remover los caracteres iniciales '/' de ambos strings
      $pattern = ltrim($pattern, '/');

      // Dividir los strings en partes
      $patternParts = explode('/', $pattern);

      // Definir el patrón para reemplazar ":palabra" con la expresión regular deseada
      $pattern = '/:\w+/';
      $replacement = '([a-zA-Z0-9_-]+)';

      // Recorrer las partes del patrón y del URL
      foreach ($patternParts as $index => $part) {
        
        // Si la parte del patrón empieza con ':', es un parámetro
        if (strpos($part, ':') === 0) {
          // Reemplazar todas las ocurrencias en el string de entrada
          $patternParts[$index] = preg_replace($pattern, $replacement, $part);
        }
      }

      //var_dump("patternParts: ", $patternParts);

      $regex = '/^' . implode("\/",$patternParts) . '$/';
      return $regex;
  }

  public static function test_pattern_to_regex(){// Ejemplo de uso
    // Ejemplo de uso
    $pattern = "/:username/:action";
    //$pattern = "/tomi_shelby/create";
    $url = "/tomi_shelby/create";
    $result = self::pattern_to_regex($pattern);
    
    //var_dump($result); // Debería imprimir Array ( [:username] => tomi_shelby [:action] => create )
  }
  
  
  public static function dispatch() {
    $method = $_SERVER['REQUEST_METHOD'];
    $uri_actual = $_SERVER['REQUEST_URI'];
    $uri_actual = trim($uri_actual, "/");
       
    // buscar en el array de rutas, la que coincida con la uri_actual, luego, ejecutar su callback asociado
    foreach (self::$routes[$method] as $ruta => $callback) {
      

      $regex = self::pattern_to_regex($ruta);
      //var_dump("<pre>");
      //var_dump("regex: ", $regex);
      //var_dump("uri_actual: ", $uri_actual);
      $uri_has_params = preg_match_all($regex, $uri_actual, $matches);
      //var_dump("uri_has_params",$uri_has_params);
      //var_dump("matches: ", isset($matches)?$matches:null);
      
      if($uri_has_params){
        //var_dump("matches: ", $matches);
        $patron = $matches[0][0];
        //var_dump("patron: ", $patron);
        if($matches[0][0] === $uri_actual){
        array_shift($matches);
        // pasar parámetros de array doble a array simple
        $parametros;
        foreach ($matches as $key => $value) {
          $parametros[]=$value[0];
        }
        //var_dump("parametros: ", $parametros);
          $callback(...$parametros);
          return;
        };
      }else if ($ruta == $uri_actual) {
        $callback();
        return;
      }
    }
    echo "404 not found";
  }
}
?>