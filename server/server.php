<?php
require_once "./modelsBD/db_config.php"; // new Database(url)
/**************************
    // leer datos de una tabla:
    ```
    $db = new Database();

    $data = $db->read('posts', '*', 'id = 1');

    print_r($data);
    ```

    Insertar datos en una tabla:

    ```
    $db = new Database();

    $data = [
        'title' => 'Título de ejemplo',
        'content' => 'Contenido de ejemplo'
    ];

    $result = $db->write('posts', $data);

    if ($result) {
        echo "Datos insertados correctamente";
    } else {
        echo "Error al insertar datos";
    }
    ```

    Actualizar datos en una tabla:
    ```
    $db = new Database();

    $data = [
        'title' => 'Título actualizado'
    ];

    $where = 'id = 1';

    $result = $db->update('posts', $data, $where);

    if ($result) {
        echo "Datos actualizados correctamente";
    } else {
        echo "Error al actualizar datos";
    }
    ```

    Eliminar datos de una tabla:
    ```
    $db = new Database();

    $where = 'id = 1';

    $result = $db->delete('posts', $where);

    if ($result) {
        echo "Datos eliminados correctamente";
    } else {
        echo "Error al eliminar datos";
    }
    ```

    **************************/
echo $_SERVER('REQUEST_METHOD')==="POST";
switch ($_SERVER['REQUEST_']) {
    case 'GET':
        $json = file_get_contents('php://input');
        
        return json_decode($json, true);;
        break;
    case 'POST':
        // process POST request
        // Obtenemos los datos JSON de la solicitud
        $json = file_get_contents('php://input');

        return $json;
        //$obj = json_decode($json, true); // le ponemos true para que devuelva un array asociativo (el equivalente a un objeto en js)
        
        /* procesamos la solicitud */
        
        
        //echo $obj;
        break;
    default:
        // handle other requests
        header('HTTP/1.1 405 Method Not Allowed');
        break;
}
/* 
function process_get($param1, $param2) {
    // process GET parameters
    echo "You sent GET parameters: $param1 and $param2";
}

function process_post($param1, $param2) {
    // process POST parameters
    echo "You sent POST parameters: $param1 and $param2";
}
?> */