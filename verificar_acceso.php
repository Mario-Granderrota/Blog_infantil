<?php
$config = include('config.php');
$nombre_usuario = $_GET['nombre'];
$clave = $_GET['clave'];

if ($clave !== $config['clave_secreta']) {
    die("Acceso denegado");
}

$token = bin2hex(random_bytes(16));
$timestamp = time();
$acceso = "$nombre_usuario - $token - " . date("Y-m-d H:i:s", $timestamp) . "\n";
file_put_contents('accesos.txt', $acceso, FILE_APPEND);

$config['lectores_autorizados'][] = $nombre_usuario;
$config['tokens_autorizados'][] = $token;

file_put_contents('config.php', "<?php\nreturn " . var_export($config, true) . ";\n?>");
echo "Acceso concedido. Token: $token";
?>
