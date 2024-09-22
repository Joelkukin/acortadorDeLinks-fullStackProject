**Documentación de la API**
======================

## **Puntos de Acceso** 


### Autenticación:
______

### Generar token de acceso
`POST /login`

* **Descripción:** Autenticar un usuario y obtener un token JWT
* **Parámetros:**
	+ `username`: El nombre de usuario para autenticar
	+ `password`: La contraseña del usuario para autenticar
* **Ejemplo:**
```curl
curl --location 'acort.ar.test/login' \
--data '{
    "username": "joelkukn",
    "password": "1234"
}'
```
* **Respuesta:**
```json
{
    "status": true,
    "message": "Login successful",
    "session_id": {
      "status": true,
      "message": 'login successful',
      "token": 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE3MjcwNDcxMzEsImRhdGEiOnsidHlwZSI6IkNFTyJ9fQ.RZ6ONaNfT5o4p4TX5PUo7wxylRqoVhsqPRr6OXJ-3L4'
    }
}
```

## Registro de Usuarios

### POST /register

* **Descripción:** Crear un nuevo usuario en el sistema
* **Parámetros:**
	+ `username`: El nombre de usuario del nuevo usuario
	+ `password`: La contraseña del nuevo usuario
	+ `nombre`: El nombre del nuevo usuario
	+ `partner`: El partner del nuevo usuario
	+ `mail`: El correo electrónico del nuevo usuario
	+ `tipo`: El tipo de usuario (admin, usuario, etc.)
* **Respuesta:**
	+ Objeto JSON con estado de la operación y mensaje de éxito o error
	+ Datos del usuario creado si la operación es exitosa

* **Ejemplo:**
```curl
curl --location 'acort.ar.test/register' \
--data '{
    "username" : "test_username", 
    "password" : "test_password", 
    "nombre" : "test_nombre", 
    "partner" : "test_partner", 
    "mail" : "test_mail", 
    "tipo" : "test_tipo"
}
```
* **Respuesta:**
```json
{
    "status": true,
    "message": "El usuario fué Registrado con éxito",
    "data": {
      "username" : "test_username", 
      "password" : "test_password", 
      "nombre" : "test_nombre", 
      "partner" : "test_partner", 
      "mail" : "test_mail", 
      "tipo" : "test_tipo"
    }
}
```

==================

## Links
### Buscar Links
`GET /links/:id_usuario/`

* **Descripción:** Recuperar todos los enlaces para un usuario específico
* **Parámetros:**
	+ `id_usuario`: El ID del usuario para recuperar enlaces
* **Autorización:** `bearer TU_TOKEN_DE_SESION`

* **Ejemplo:**
```cUrl
curl --location 'acort.ar.test/links/test_owner' \
--data ''
```

* **Respuesta:**


```json
[
  {
      "id": 1,
      "link_src": "Alias",
      "link_target": "https://www.web_destino.com",
      "owner": "tu_username",
      "qr_img": "path_image"
  },
  (...)
]
```
### Usar Link Corto
`GET /:id_usuario/:link_src`

* **Descripción:** Redirigir al enlace de destino
* **Parámetros:**
	+ `id_user`: El ID del usuario que generó el enlace
	+ `link_src`: Alias del link
* **Respuesta:**
	+ Redirigir al enlace especificado

 **Ejemplo:**
```cUrl
curl --location 'acort.ar.test/test_owner/link_alias' \
--data ''
```

 **Respuesta:**
  + Redirección automática


### Crear Link
`POST /links/:id_usuario`

* **Descripción:** Crear un nuevo enlace para un usuario específico

* **Autorización:** `bearer TU_TOKEN_DE_SESION`


* **Parámetros:**
	+ `id_usuario`: El ID del usuario para crear el enlace
	+ `link_data`: Objeto JSON con datos del enlace (por ejemplo, {"title": "Ejemplo", "url": "http://example.com"})

* **Ejemplo:**
```json
curl --location 'acort.ar.test/links/test_owner' \
--data '{
  "link_src": "test",
    "link_target": "test_link_target",
    "owner": "test_owner",
    "qr_img": "test_path"
}
```
* **Respuesta:**
```json
{
    "id": 1,
    "link_src": "test_alias",
    "link_target": "test_link_target",
    "owner": "test_owner",
    "qr_img": "test_path_qr"
}
```
#### PUT /links/:id_usuario/:link_alias

* **Descripción:** Actualizar un enlace específico para un usuario
* **Parámetros:**
	+ `id_usuario`: El ID del usuario que posee el enlace
	+ `link_alias`: La fuente del enlace para actualizar
	+ Cuerpo de la solicitud: Objeto JSON con datos del enlace actualizados
* **Ejemplo:**
```json
curl --location 'acort.ar.test/links/test_owner' \
--data '{
	"link_src": "test_alias"
}
```
* **Respuesta:**
```json
{
    "id": 1,
    "link_src": "test_alias",
    "link_target": "test_link_target",
    "owner": "test_owner",
    "qr_img": "test_path_qr"
}
```

#### DELETE /links/:id_usuario/:link_alias

* **Descripción:** Eliminar un enlace específico para un usuario
* **Parámetros:**
	+ `id_usuario`: El ID del usuario que posee el enlace
	+ `link_alias`: el alias del enlace a eliminar
* **Ejemplo:**
```json
curl --location --request DELETE 'acort.ar.test/links/test_owner/test_alias' \
--data ''
```
* **Respuesta:**
```json
"Link eliminado con éxito"
```

### Notas

* Casi odos los puntos de acceso requieren un token JWT válido pasado en el encabezado `Authorization` el cual se genera en el endpoint `Login`.
* La función `search_links` no está documentada, pero parece ser utilizada en el punto de acceso `GET /links/:id_usuario/`.
* La función `verify_jwt` no está documentada, pero parece ser utilizada para validar el token JWT.
* La función `redirect` no está documentada, pero parece ser utilizada en el punto de acceso `GET /:id_usuario/:enlace_fuente`.
* Las funciones `create_link`, `update_link` y `delete_link` no están documentadas, pero parece ser utilizadas en los respectivos puntos de acceso.

