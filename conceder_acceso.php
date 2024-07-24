<?php
$config = include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_usuario = $_POST['nombre'];

    if ($_SERVER['REMOTE_ADDR'] !== $config['IP_DEL_EDITOR']) {
        die("Acceso denegado");
    }

    $token = bin2hex(random_bytes(16));
    $timestamp = date("Y-m-d H:i:s");
    $ini_array = parse_ini_file('config.txt', true);
    $ini_array[$nombre_usuario] = ['token' => $token, 'timestamp' => $timestamp];

    $new_content = '';
    foreach ($ini_array as $user => $info) {
        $new_content .= "[$user]\n";
        foreach ($info as $key => $value) {
            $new_content .= "$key = \"$value\"\n";
        }
    }
    file_put_contents('config.txt', $new_content);
    echo $token; // Devuelve el token generado
}
?>
