<?php
include('config.php');

function esEditor() {
    return $_SERVER['REMOTE_ADDR'] === IP_DEL_EDITOR;
}

function respuestaJson($mensaje) {
    echo json_encode($mensaje);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $entrada_id = $_GET['id'];
        $entrada = json_decode(file_get_contents(DIRECTORIO_ENTRADAS . "$entrada_id.json"), true);
        
        // Obtener entradas anteriores y siguientes
        $entradas = glob(DIRECTORIO_ENTRADAS . '*.json');
        $indices = array_flip($entradas);
        $index = $indices[DIRECTORIO_ENTRADAS . "$entrada_id.json"];
        
        $entrada['anterior'] = $index > 0 ? basename($entradas[$index - 1], ".json") : null;
        $entrada['siguiente'] = $index < count($entradas) - 1 ? basename($entradas[$index + 1], ".json") : null;

        respuestaJson($entrada);
    } else {
        $entradas = [];
        foreach (glob(DIRECTORIO_ENTRADAS . '*.json') as $filename) {
            $entrada = json_decode(file_get_contents($filename), true);
            $entrada['id'] = basename($filename, ".json");
            $entradas[] = $entrada;
        }
        respuestaJson($entradas);
    }
}

if (!esEditor()) {
    respuestaJson(['error' => 'Acceso denegado']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'];
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $fecha = $_POST['fecha'];
    $pieArchivo = isset($_POST['pieArchivo']) ? $_POST['pieArchivo'] : '';

    if ($accion === 'crear') {
        $entrada_id = uniqid();
        $entrada = [
            'titulo' => $titulo,
            'contenido' => $contenido,
            'fecha' => $fecha,
            'creado' => date("Y-m-d H:i:s")
        ];

        if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == UPLOAD_ERR_OK) {
            $nombre_archivo = $_FILES['archivo']['name'];
            $archivo_contenido = file_get_contents($_FILES['archivo']['tmp_name']);
            if (file_put_contents(DIRECTORIO_ENTRADAS . "$entrada_id-$nombre_archivo", $archivo_contenido) === false) {
                respuestaJson(['error' => 'Error al guardar el archivo']);
            }
            $entrada['archivo'] = "$entrada_id-$nombre_archivo";
            $entrada['pieArchivo'] = $pieArchivo;
        }

        if (file_put_contents(DIRECTORIO_ENTRADAS . "$entrada_id.json", json_encode($entrada)) === false) {
            respuestaJson(['error' => 'Error al guardar la entrada']);
        }

        respuestaJson(['mensaje' => 'Entrada creada con éxito']);
    } elseif ($accion === 'editar') {
        $entrada_id = $_POST['id'];
        $entrada = [
            'titulo' => $titulo,
            'contenido' => $contenido,
            'fecha' => $fecha,
            'editado' => date("Y-m-d H:i:s")
        ];

        if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == UPLOAD_ERR_OK) {
            $nombre_archivo = $_FILES['archivo']['name'];
            $archivo_contenido = file_get_contents($_FILES['archivo']['tmp_name']);
            if (file_put_contents(DIRECTORIO_ENTRADAS . "$entrada_id-$nombre_archivo", $archivo_contenido) === false) {
                respuestaJson(['error' => 'Error al guardar el archivo']);
            }
            $entrada['archivo'] = "$entrada_id-$nombre_archivo";
            $entrada['pieArchivo'] = $pieArchivo;
        }

        if (file_put_contents(DIRECTORIO_ENTRADAS . "$entrada_id.json", json_encode($entrada)) === false) {
            respuestaJson(['error' => 'Error al guardar la entrada']);
        }

        respuestaJson(['mensaje' => 'Entrada editada con éxito']);
    }
}
?>
