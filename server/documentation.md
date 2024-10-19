Documentación de Endpoints - API de Enlaces
===========================================

Base URL
--------

`https://api.ejemplo.com`
Autenticación

-------------

Todos los endpoints, excepto la redirección, requieren autenticación mediante JWT (JSON Web Token). El token debe ser incluido en el encabezado de la solicitud:

``` Authorization: Bearer <tu_token_jwt>``` 

---------
### Login de Usuario
Endpoint: POST /login

Descripción: Autentica a un usuario utilizando sus credenciales o un token JWT existente.

Cuerpo de la solicitud (login con credenciales): 
```json
{
  "username": "nombre_de_usuario",  
  "password": "contraseña_del_usuario" 
} 
```

Cuerpo de la solicitud (login con token): No se requiere cuerpo. El token JWT debe ser enviado en el encabezado de la solicitud.

Respuesta exitosa (login con credenciales): 
```json 
{ 
  "status": true, 
  "message": "login successful", 
  "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..." 
} 
```

Respuesta fallida (login con credenciales): 
```json 
{ 
  "status": false,
  "message": "Incorrect username or password"
}
```

Respuesta (login con token): 
```json 
{ "pass": true }
``` 
o 

```json 
{ "pass": false }
```

#### Notas:

Si se proporcionan credenciales (username y password), el sistema intentará autenticar al usuario con esas credenciales.

Si no se proporcionan credenciales, el sistema buscará un token JWT en el encabezado de la solicitud y lo validará.

El token JWT generado contiene información sobre el usuario y su tipo (rol).

#### Códigos de Estado:
* `200 OK` : La solicitud se ha procesado correctamente.
* `401 Unauthorized`: La solicitud no incluye un token de autenticación válido.
* `404 Not Found`: El enlace solicitado no existe.
* `500 Internal Server Error`: Error interno del servidor.


Autenticación
Para las solicitudes que requieren autenticación, incluya el token JWT en el encabezado de la solicitud:

``` Authorization: Bearer <tu_token_jwt> ``` 

----------

###  Obtener Enlaces del Usuario

**Endpoint:** `GET /links`

**Descripción:** Recupera todos los enlaces asociados al usuario autenticado.

**Respuesta exitosa:**

```json
[
  {
    "id": 1,
    "link_src": "ejemplo1",
    "link_target": "https://www.ejemplo1.com",
    "owner": "usuario123",
    "qr_img": "path/to/qr1.png"
  },
  {
    "id": 2,
    "link_src": "ejemplo2",
    "link_target": "https://www.ejemplo2.com",
    "owner": "usuario123",
    "qr_img": "path/to/qr2.png"
  }
]
```
### Crear un Nuevo Enlace

**Endpoint:** `POST /links/create`

**Descripción:** Crea un nuevo enlace para el usuario autenticado.

**Cuerpo de la solicitud:**

```json
{ 
	"link_src": "mi-nuevo-enlace", 
    "link_target": "https://www.mi-sitio-web.com", 
    "qr_img": "path/to/qr.png" // Opcional 
}
```
**Respuesta exitosa:**

```json
{
  "id": 3,
  "link_src": "mi-nuevo-enlace",
  "link_target": "https://www.mi-sitio-web.com",
  "owner": "usuario123",
  "qr_img": "path/to/qr.png"
}
```
### Modificar un Enlace Existente

**Endpoint:** `PUT /links/modify/:link_src`

**Descripción:** Modifica un enlace existente del usuario autenticado.

**Parámetros de ruta:**

* `link_src`: El identificador del enlace a modificar

**Cuerpo de la solicitud:**

```json
{
  "link_target": "https://www.nueva-url.com",
  "qr_img": "path/to/new_qr.png" // Opcional
}
```

**Respuesta exitosa:**

```json
{
  "id": 3,
  "link_src": "mi-nuevo-enlace",
  "link_target": "https://www.nueva-url.com",
  "owner": "usuario123",
  "qr_img": "path/to/new_qr.png"
}
```
### Eliminar un Enlace

**Endpoint:** `DELETE /links/delete/:link_src`

**Descripción:** Elimina un enlace existente del usuario autenticado.

**Parámetros de ruta:**

* `link_src`: El identificador del enlace a eliminar

**Respuesta exitosa:**

```json
{
  "message": "Link eliminado con éxito"
}
```
### Redireccionar a un Enlace

**Endpoint:** `GET /:id_user/:link_src`

**Descripción:** Redirige a la URL asociada al enlace especificado.

**Parámetros de ruta:**

* `id_user`: El ID del usuario propietario del enlace
* `link_src`: El identificador del enlace

**Comportamiento:** Este endpoint redirige directamente a la URL asociada al enlace. No requiere autenticación.
Códigos de Estado

-----------------

* `200 OK` : La solicitud se ha procesado correctamente.
* `401 Unauthorized`: La solicitud no incluye un token de autenticación válido.
* `404 Not Found`: El enlace solicitado no existe.
* `500 Internal Server Error`: Error interno del servidor.
