<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_usuario = $_POST['nombre'];
    $token = $_POST['token'];
    $timestamp = $_POST['timestamp'];

    // Leer el archivo config.txt
    $ini_array = parse_ini_file('config.txt', true);
    $ini_array[$nombre_usuario] = [
        'token' => $token,
        'timestamp' => $timestamp
    ];

    // Escribir de nuevo en config.txt
    $new_content = '';
    foreach ($ini_array as $user => $info) {
        $new_content .= "[$user]\n";
        foreach ($info as $key => $value) {
            $new_content .= "$key = \"$value\"\n"; // Asegurarse de que los valores se guardan correctamente
        }
    }
    file_put_contents('config.txt', $new_content);
    echo "Acceso concedido y config.txt actualizado.";
}
?>
