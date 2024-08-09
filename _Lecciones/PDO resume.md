# PDO 
fuente: https://diego.com.es/tutorial-de-pdo

## Conectarse a BD

El sistema PDO se fundamenta en 3 clases: PDO, PDOStatement y PDOException. La clase PDO se encarga de mantener la conexión a la base de datos y otro tipo de conexiones específicas como transacciones, además de crear instancias de la clase PDOStatement. Es ésta clase, PDOStatement, la que maneja las sentencias SQL y devuelve los resultados. La clase PDOException se utiliza para manejar los errores.


<image src="./funcionamiento-pdo.png" alt="Descripción de la imagen">

### Ejemplo:
```php

try {
    $dsn = "mysql:host=localhost;dbname=$dbname";
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    echo $e->getMessage();
}
```

Existen [más opciones](http://php.net/manual/es/pdo.setattribute.php) aparte de el modo de error ATTR_ERRMODE, algunas de ellas son:

ATTR_CASE. Fuerza a los nombres de las columnas a mayúsculas o minúsculas (CASE_LOWER, CASE_UPPER).
ATTR_TIMEOUT. Especifica el tiempo de espera en segundos.
ATTR_STRINGIFY_FETCHES. Convierte los valores numéricos en cadenas.

## Registrar datos con PDO

Pasando los valores mediante un array (siempre array, aunque sólo haya un valor) al método execute():

```php
// Prepare:
$stmt = $dbh->prepare("INSERT INTO Clientes (nombre, ciudad) VALUES (:nombre, :ciudad)");
$nombre = "Luis";
$ciudad = "Barcelona";
// Bind y execute:
if($stmt->execute(array(':nombre'=>$nombre, ':ciudad'=>$ciudad))) {
    echo "Se ha creado el nuevo registro!";
}
```

## Consultar datos con PDO

La consulta de datos se realiza mediante PDOStatement::fetch, que obtiene la siguiente fila de un conjunto de resultados. Antes de llamar a fetch (o durante) hay que especificar como se quieren devolver los datos:

#### Más usados:
PDO::FETCH_ASSOC: devuelve un array indexado cuyos keys son el nombre de las columnas.

PDO::FETCH_OBJ: devuelve un objeto anónimo con nombres de propiedades que corresponden a las columnas.

PDO::FETCH_BOUND: asigna los valores de las columnas a las variables establecidas con el método PDOStatement::bindColumn.

PDO::FETCH_CLASS: asigna los valores de las columnas a propiedades de una clase. Creará las propiedades si éstas no existen.

```php
/* FETCH_ASSOC: Retorna array asociativo $array['columna']*/

$stmt = $dbh->prepare("SELECT * FROM Clientes");
// Especificamos el fetch mode antes de llamar a fetch()

$stmt->setFetchMode(PDO::FETCH_ASSOC); 
// Ejecutamos
$stmt->execute();
// Mostramos los resultados

// esta forma de hacer el while es como un foreach que recorre las filas de la tabla de la BD
while ($row = $stmt->fetch()){ 
    echo "Nombre: {$row["nombre"]} <br>";
    echo "Ciudad: {$row["ciudad"]} <br><br>";
}

/* FETCH_OBJ: Retorna un objeto cuyas propiedades son 
el campo de cada fila */

$stmt = $dbh->prepare("SELECT * FROM Clientes");
// Ejecutamos
$stmt->execute();
// Ahora vamos a indicar el fetch mode cuando llamamos a fetch:
//
while($row = $stmt->fetch(PDO::FETCH_OBJ)){
    echo "Nombre: " . $row->nombre . "<br>";
    echo "Ciudad: " . $row->ciudad . "<br>";
}

/* PDO::FETCH_BOUND */

// Preparamos
$stmt = $dbh->prepare("SELECT nombre, ciudad FROM Clientes");
// Ejecutamos
$stmt->execute();

// bindColumn (nombre_de_campo/indice_de_campo, variable_contenedora)

// en $nombre se guardará el valor del primer campo
$stmt->bindColumn(1, $nombre); 
// en $ciudad se guardará el valor del campo "ciudad"
$stmt->bindColumn('ciudad', $ciudad); 

while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
    $cliente = $nombre . ": " . $ciudad;
    echo $cliente . "<br>";
}
```

#### Menos usados:

PDO::FETCH_NUM: devuelve un array indexado cuyos keys son números.
PDO::FETCH_BOTH: valor por defecto. Devuelve un array indexado cuyos keys son tanto el nombre de las columnas como números.
PDO::FETCH_INTO: actualiza una instancia existente de una clase.
PDO::FETCH_LAZY: combina PDO::FETCH_BOTH y PDO::FETCH_OBJ, creando los nombres de las propiedades del objeto tal como se accedieron.
Los más utilizados son FETCH_ASSOC, FETCH_OBJ, FETCH_BOUND y FETCH_CLASS. Vamos a poner un ejemplo de los dos primeros:

## Diferencia entre query() y prepare()/execute()

```query``` ejecuta la sentencia sql directamente

`prepare()` y `execute()` evitan ataques sql
