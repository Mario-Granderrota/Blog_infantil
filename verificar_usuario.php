<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = $_POST['nombre'];
    $ini_array = parse_ini_file('config.txt', true);

    if (isset($ini_array[$nombre_usuario])) {
        $token = $ini_array[$nombre_usuario]['token'];
        $timestamp = $ini_array[$nombre_usuario]['timestamp'];

        if ((time() - strtotime($timestamp)) <= 3600) {
            respuestaJson(['status' => 'success', 'token' => $token]);
        } else {
            respuestaJson(['status' => 'expired']);
        }
    } else {
        respuestaJson(['status' => 'not_found']);
    }
}

function respuestaJson($mensaje) {
    echo json_encode($mensaje);
    exit;
}
?>
