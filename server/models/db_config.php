<?php
    
    // poner aqui los datos de la base de datos
    function login_db(){
        return[
            "host" => "localhost"//"sql108.infinityfree.com",
            ,"user"=> "root"//"if0_35806127",
            ,"pswd"=> ""//"JkOuEkLin", 
            ,"db_name"=> "simple_php_api" //"if0_35806127_gestor_DB"
        ];
    }
    
    function sql_query($sql, $json = false){ // array
        $login_db = login_db();
        
        // Conexión a la base de datos
        $mysqli = new mysqli($login_db["host"], $login_db["user"], $login_db["pswd"], $login_db["db_name"]);
        // Verificar la conexión
        if ($mysqli->connect_error) {
            die("La conexión falló: " . $mysqli->connect_error);
        }
        /* ejecutar consulta */
    
        $respuesta = $mysqli->query($sql);
        
        $num_rows = $respuesta->num_rows; // encuentro el nro de filas afectadas por la query
        //var_dump($num_rows);
        $resultado = array(); // armamos lo que devolveremos
        if ($num_rows > 0){ // si la consulta me dió resultados
            while($row = $respuesta->fetch_assoc()){ // creo un array asociativo con los resultados
                $resultado[] = $row;
            }
        } else {
            return "La consulta no ha obtenido resultados";
        }

        
        return $json?json_encode($resultado):$resultado;
    } 

    function test_sql_query(){
        $sql = "SELECT * FROM items WHERE nombre = ?";
        $valor = "2";
        $tipo = "s";
        //var_dump(sql_query($sql, $tipo, $valor),"<br>");
        $sql = "SELECT * FROM items WHERE nombre LIKE '%PC%'";
        var_dump(sql_query($sql,1),"<br>");
    }
    //test_sql_query();
    
    //$mysqli); // ejecutar cuando el usuario cierre la pestaña
    /* EJEMPLO sql_pdo_query
    $sql = "INSERT INTO Clientes (nombre, ciudad) VALUES (:nombre, :ciudad)";
    $stmt = $dbh->prepare();
    $nombre = "Luis %"; // trae todo lo que empiece con "luis"
    $nombre = "% Luis %"; // trae todo lo que tenga "luis"
    $ciudad = "Barcelona"; // trae todo lo que tenga solamente "Barcelona"
    // Bind y execute:
    if($stmt->execute(array(':nombre'=>$nombre, ':ciudad'=>$ciudad))) {
        echo "Se ha creado el nuevo registro!";
    } */
   
function create_PDO(){
    $login_db = login_db();
    //
    try {
        $dbh = new PDO(
            "mysql:host=localhost;
            dbname=".$login_db['db_name']
            ,$login_db['user']
            ,$login_db['pswd']
            ,[PDO::ATTR_PERSISTENT => true]
        );
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION, );
    } catch (PDOException $e){
        echo $e->getMessage();
    }
    //
    return $dbh;
}
        
function sql_query_pdo($dbh, $sql, $params){
    
    // Prepare:
    $stmt = $dbh->prepare($sql);

    var_dump("params: ", $params,"<br>.");
    // Bind y execute:
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if($stmt->execute($params)) {
        echo "consulta ejecutada correctamente!";
    }
    $i = 0;
    while ($row = $stmt->fetch()){ 
        var_dump("<br> row $i");
        var_dump(json_encode($row));
        $i+=1;
    }


}
function test_sql_pdo_query(){
    $sql = "SELECT * FROM items WHERE nombre LIKE :nombre";
    $params = [':nombre'=> 'PC %'];
    $dbh = create_PDO();
    sql_query_pdo($dbh,$sql,$params);
    
}
//test_sql_pdo_query()
?>