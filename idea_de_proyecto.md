# Idea de proyecto

la idea de este proyecto es implementar un sistema de marketing de afiliados
donde cualquier persona que traiga 5 clientes, se lleva el 10% de lo que
compre cada uno

# ¿como funciona?

link=[ HTTP_GET(codigo de afiliado) ]=> pagina: Pagina_de_producto , btn.onclick :{"agregar al carrito"} =[ carrito.agregar(codigo de producto, cantidad) ]=> vista: Carrito, boton comprar=> link de cobro a mercado pago => distribuir el pago entre afiliado y vendedor



### <u>Que le permite hacer a los usuarios</u>

yo como cliente recomendado entro directamente a la tienda online y puedo comprar lo que yo quiera y (opcional) voy a ver un descuento aplicado a mis compras por haber entrado por un afiliado

yo como afiliado, tengo una cuenta en la aplicacion afiliarte.com.ar y estoy suscripto a varias tiendas online y puedo ver los links a sus tiendas y compartirlos, éstos links siempre terminan con una variable "cod_afiliado" que le indica a la tienda online de parte de quien viene cada referido, tambien puedo suscribirme a más tiendas escaneando su qr o por su link

yo como tienda, tengo una lista de afiliados suscriptos a mi tienda y puedo ver cuantas ventas y cuanto dinero me genera cada uno y cuanta comisión les he pagado, tambien tengo un link y un codigo qr que redirige a cualquiera que lo escanee a crear una cuenta de afiliado en afiliarte.com.ar y al terminar de crearse la cuenta, ya está suscrito a mi negocio

yo como dueño de la plataforma, gano el 3% de todas las transacciones que se hagan por la plataforma



## <u>Proceso de suscripción</u>

una persona cualquiera entra en una tienda y compra un producto, a la hora de pagar, el cajero le dice que 
si recomienda el local a sus amigos,  podrá ganar una comision (porcentaje que decida el dueño de la tienda) del monto total que compre su referido, el cliente al escuchar ésto le dan ganas de suscribirse, el dueño de la tienda
le pide escanear el qr que le abre el sitio web de la tienda donde ve un formulario que le pide el nombre, apellido
nro de telefono y cbu, al darle enter, se crea una nueva cuenta en la base de datos de la tienda 



tengo que hacer un boton para ponerle a los productos que agregue el producto a mi carrito en lugar del que esté por defecto

tengo que hacer un carrito de compras que al comprar, envie al servidor los productos {nombre_producto, cantidad, precio} el total, y el codigo del afiliado

luego en el servidor debo calcular cuanto dinero le corresponde al afiliado, cuanto me corresponde a mi y restarle ese dinero al monto total y ése seria el dinero que se le paga al vendedor



### <u>Lo que ve el cliente</u>

- #### vista de carrito de compras
  - listado de productos agregados
- #### vista de mis referidos
  - la pagina de productos de las tiendas online a las que está suscrito
- #### vista de mis ganancias
  - lista de negocios con la cantidad total de dinero ganado por cada uno de mis referidos

### <u>Lo que ve el dueño de la tienda</u>

### <u>Lo que ve el dueño del sistema</u>

## yo como usuario puedo afiliarme a una tienda online

para hacerlo solo tengo que rellenar un formulario con mi nombre, mi email y mi whatsapp, estos datos son almacenados en la base de datos de la tienda online a la que me estoy suscribiendo y recibo un qr y un link de afiliado que al compartirlo

## la tienda online

si un usuario suscriptor está logueado en una tienda online,
va a poder ver, en cada producto de la tienda online, un botoncito de compartir que le va a dar la opcion de copiar el link y descargar el qr

# componentes

## tienda online:

- login

- Pagina de productos
  
  - tienda de productos (vista):
    - g


