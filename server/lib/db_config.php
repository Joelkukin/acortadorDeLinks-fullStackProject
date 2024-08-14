<?php
    
// poner aqui los datos de la base de datos
function db_config(){
    return[
        "host" => "localhost"//"sql108.infinityfree.com",
        ,"user"=> "root"//"if0_35806127",
        ,"pswd"=> ""//"JkOuEkLin", 
        ,"db_name"=> "compartienda" //"if0_35806127_gestor_DB"
    ];
}

function sql_query($sql, $json = false){ // array
    $db_config = db_config();
    
    // Conexión a la base de datos
    $mysqli = new mysqli($db_config["host"], $db_config["user"], $db_config["pswd"], $db_config["db_name"]);
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
   
function pdo_start_session($db_config){
    $db_config;
    //
    try {
        $dbh = new PDO(
            "mysql:host=localhost;
            dbname=".$db_config['db_name']
            ,$db_config['user']
            ,$db_config['pswd']
            ,[PDO::ATTR_PERSISTENT => true]
        );
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION, );
    } catch (PDOException $e){
        echo $e->getMessage();
    }
    //
    return $dbh;
}

function pdo_sql_query($dbh, $sql, $params = null){
    
    $resultado = [];
    
    // Prepare:
    $stmt = $dbh->prepare($sql);

    // Bind y execute:
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    try{
        $stmt->execute($params); 
        //echo "consulta ejecutada correctamente!";
        $i = 0;
    
        while ($row = $stmt->fetch()){ 
            array_push($resultado,$row);
            $i+=1;
        }
        return $resultado;
    }catch (\throwable $e){
        return $e->getMessage();
    }
}

/* class DB_connection{
    private $db_config;
    private $dbh;

    function __construct($db_config){
        $this->db_config = $db_config;
        $this->dbh = pdo_start_session($db_config);
    }
    public function prep_query($sql, $params = null){
        pdo_sql_query($this->dbh, $sql, $params);
    }
}    */

function test_sql_pdo_query(){
    $sql = "SELECT * FROM items WHERE nombre LIKE :nombre";
    $params = [':nombre'=> 'PC %'];
    $dbh = pdo_start_session();
    pdo_sql_query($dbh, $sql, $params);
    
}
//test_sql_pdo_query()
?>