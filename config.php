<?php
define('CLAVE_SECRETA', 'MiContraseña123');
define('DIRECTORIO_ENTRADAS', 'entradas/');
define('DIRECTORIO_COMENTARIOS', 'comentarios/');
define('IP_DEL_EDITOR', 'xxx.xxx.xxx.xxx'); 
define('NOMBRE_BLOG', 'El Blog de tu hijo o hija');
// Crear directorios si no existen
if (!file_exists(DIRECTORIO_ENTRADAS)) {
    mkdir(DIRECTORIO_ENTRADAS, 0777, true);
}
if (!file_exists(DIRECTORIO_COMENTARIOS)) {
    mkdir(DIRECTORIO_COMENTARIOS, 0777, true);
}
// Limpiar tokens y peticiones obsoletas
include('limpiar_tokens_expirados.php');
include('limpiar_peticiones_obsoletas.php');
?>
