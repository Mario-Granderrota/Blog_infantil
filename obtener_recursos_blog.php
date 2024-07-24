<?php
header('Content-Type: application/json; charset=utf-8');
include('config.php');

echo json_encode([
    'nombre_blog' => NOMBRE_BLOG,
    'clave_secreta' => CLAVE_SECRETA,
    'ip_del_editor' => IP_DEL_EDITOR
]);
?>
