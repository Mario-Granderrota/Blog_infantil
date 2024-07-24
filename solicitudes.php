<?php
header('Content-Type: application/json; charset=utf-8');
$solicitudes = [];

if (file_exists('solicitudes.txt')) {
    $lines = file('solicitudes.txt', FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line) {
        list($nombre, $timestamp) = explode(' - ', $line);
        $solicitudes[] = ['nombre' => $nombre, 'timestamp' => $timestamp];
    }
}

echo json_encode($solicitudes);
?>
