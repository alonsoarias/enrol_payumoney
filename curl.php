<?php
/**
 * Ejemplo de cómo usar PHP, JSON y cURL para enviar
 * datos codificados a otro servidor
 * 
 * @author parzibyte
 */

# Definimos los datos que vamos a enviar, estos pueden venir de cualquier lugar
# Los hacemos complejos y largos para demostrar cómo se pueden anidar

defined('MOODLE_INTERNAL') || die();
$persona = [
    "test" => "false",
    "language" => "en",
    "command" => "GET_PAYMENT_METHODS",
    "merchant" => ["apiLogin", "LhGP7t5PkkkK2eH", "apiKey", "cB9styZXvjSM09yBngy7I63d47"],
];

// Los codificamos
// recomendado: https://parzibyte.me/blog/2018/12/26/codificar-decodificar-json-php/
$datosCodificados = json_encode($persona);

// Comenzar a crear el objeto de curl
# A dónde se hace la petición...
$url = "https://api.payulatam.com/reports-api/4.0/service.cgi";
$ch = curl_init($url);

# Ahora le ponemos todas las opciones
# Nota: podríamos usar la versión corta de arreglos: https://parzibyte.me/blog/2018/10/11/sintaxis-corta-array-php/
curl_setopt_array($ch, array(
    // Indicar que vamos a hacer una petición POST
    CURLOPT_CUSTOMREQUEST => "POST",
    // Justo aquí ponemos los datos dentro del cuerpo
    CURLOPT_POSTFIELDS => $datosCodificados,
    // Encabezados
    //CURLOPT_HEADER => true,
    CURLOPT_HTTPHEADER => array(
	'POST /payments-api/4.0/service.cgi HTTP/1.1',
        'Host: api.payulatam.com',
	'Content-Type: application/json; charset=utf-8',
	'Accept: application/json'
        'Content-Length: ' . strlen($datosCodificados), // Abajo podríamos agregar más encabezados
    ),
    # indicar que regrese los datos, no que los imprima directamente
    CURLOPT_RETURNTRANSFER => true,
));
# Hora de hacer la petición
$resultado = curl_exec($ch);
# Vemos si el código es 200, es decir, HTTP_OK
$codigoRespuesta = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if($codigoRespuesta === 200){
    # Decodificar JSON porque esa es la respuesta
    $respuestaDecodificada = json_decode($resultado);
    # Simplemente los imprimimos
    echo "<strong>El servidor dice que la hora de petición fue: </strong>" . $respuestaDecodificada->fechaYHora;
    echo "<br><strong>El servidor dice que el primer lenguaje es: </strong>" . $respuestaDecodificada->primerLenguaje;
    echo "<br><strong>Los encabezados que el servidor recibió fueron: </strong><pre>" . var_export($respuestaDecodificada->encabezados, true) . "</pre>";
    echo "<br><strong>Los gustos musicales que el servidor recibió fueron: </strong><pre>" . var_export($respuestaDecodificada->gustosMusicales, true) . "</pre>";
    echo "<br><strong>Los libros que el servidor recibió fueron: </strong><pre>" . var_export($respuestaDecodificada->libros, true) . "</pre>";
    echo "<br><strong>Mensaje del servidor: </strong>" . $respuestaDecodificada->mensaje;
}else{
    # Error
    echo "Error consultando. Código de respuesta: $codigoRespuesta";
}
curl_close($ch);
?>
