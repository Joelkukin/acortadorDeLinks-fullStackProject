# Acortador de Links

## Endpoints

### Inicio de sesion
--------------------

#### `POST /Login`

para iniciar sesion y obtener un token de acceso

**Http Body:**
```json
{
    "username": "tu nombre de usuario",
    "password": "tu contraseña"
}
```

para acceder a una seccion protegida

**Http Body:**
```json
{
    "token": "token obtenido mediante login"
}
```


#### `POST /Registro`

**Http Body:**
```json
{
    "username" : "tu username", 
    "password" : "tu password", 
    "nombre" : "tu nombre", 
    "partner" : "tu partner", 
    "mail" : "tu mail", 
    "tipo" : "tu tipo"
}
```

### Links
--------------------

