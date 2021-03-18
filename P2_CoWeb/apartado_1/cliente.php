<!-- GET no oculta los valores pasados por parametro -->
<!-- POST si oculta los valores pasador por parametro en la URL -->

<!-- Power Point -->
<!--
GET : pide al servidor una pagina o datos.Si el pedido tiene parámetros, ellos se envían por medio del URL
como un string query

POST : envía los datos a un web server y recupera la respuesta del servidor
Si el pedido tiene parámetros, ellos se incluyen en el paquete
HTTP pedido, y no en el URL
-->
<form action="http://localhost/COW/P2_CoWeb/apartado_1/servidor.php" method=POST>
    <div>
        name: <input type="text" name="var1"/> password: <input type="text" name="var2"/> <input type="submit"/>
    </div>
</form>