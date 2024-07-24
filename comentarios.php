<?php
include('config.php');

function respuestaJson($mensaje) {
    echo json_encode($mensaje);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $entrada_id = $_GET['id'];
    $comentarios = [];
    foreach (glob(DIRECTORIO_COMENTARIOS . "$entrada_id-*.json") as $filename) {
        $comentario = json_decode(file_get_contents($filename), true);
        $comentarios[] = $comentario;
    }
    respuestaJson($comentarios);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'];
    $entrada_id = $_POST['entrada_id'];
    $comentario_texto = $_POST['comentario'];
    $nombre_usuario = $_POST['usuario'];

    if ($accion === 'agregar') {
        $comentario_id = uniqid();
        $comentario = [
            'usuario' => $nombre_usuario,
            'texto' => $comentario_texto,
            'fecha' => date("Y-m-d H:i:s")
        ];

        if (file_put_contents(DIRECTORIO_COMENTARIOS . "$entrada_id-$comentario_id.json", json_encode($comentario)) === false) {
            respuestaJson(['error' => 'Error al guardar el comentario']);
        }

        respuestaJson(['mensaje' => 'Comentario agregado con éxito']);
    }
}
?>
