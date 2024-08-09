# Try Catch

```php

// similar al do-while
try { // ejecuta este codigo:

    /* codigo... */

    throw new Exception('exception personalizada'); // opcional

/*                  👇 puede ser cualquier nombre */
} catch (Exeption $exception) { // si te dá error...
// ... aquí lo que quieras hacer en caso de error. 
// aclaracion: pueden haber varios catch

    /* explicacion */

    $exeption.getMessage()         /* Obtiene el mensaje de Excepción. Se usa en el ejemplo anterior*/

    $exeption.getPrevious()        /* Devuelve la excepción anterior.*/

    $exeption.getCode()            /* Obtiene el código de Excepción. Este método es útil para añadir en el log de errores.*/

    $exeption.getFile()            /* Obtiene el fichero en el que ocurrió la excepción. Este método es útil para añadir en el log de errores.*/

    $exeption.getLine()            /* Obtiene la línea en donde ocurrió la excepción. Este método es útil para añadir en el log de errores.*/

    $exeption.getTrace()          /*Obtiene el seguimiento de la pila. Este método es útil para añadir en el log de errores.*/

    $exeption.getTraceAsString()  /*Obtiene el stack trace como cadena.*/

    /* codigo... */

    die("Error: ",$exeption.getMessage()) // die = console.log + break

}finally{ /* Finally:Este bloque siempre se ejecutará 
independientemente de que se haya lanzado una excepción o no, 
y antes de que la ejecución normal continúe. No es obligatorio. */

    /* codigo... */


}

```