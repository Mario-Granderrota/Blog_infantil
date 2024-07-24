<?php
function limpiarPeticionesObsoletas() {
    $file_path = 'solicitudes.txt';
    $lines = file($file_path, FILE_IGNORE_NEW_LINES);
    $current_time = time();
    $new_lines = [];

    foreach ($lines as $line) {
        list($nombre, $timestamp) = explode(' - ', $line);
        if (($current_time - strtotime($timestamp)) <= 3600) { // 1 hora de validez
            $new_lines[] = $line;
        }
    }

    file_put_contents($file_path, implode(PHP_EOL, $new_lines));
}

limpiarPeticionesObsoletas();
?>
