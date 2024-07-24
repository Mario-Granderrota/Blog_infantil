<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_usuario = $_POST['nombre'];
    $timestamp = time();
    $solicitud = "$nombre_usuario - " . date("Y-m-d H:i:s", $timestamp) . "\n";
    file_put_contents('solicitudes.txt', $solicitud, FILE_APPEND);
    echo "Solicitud enviada";
}
?>
