<?php
function limpiarTokensExpirados() {
    $ini_array = parse_ini_file('config.txt', true);
    $current_time = time();

    foreach ($ini_array as $user => $info) {
        if ((time() - strtotime($info['timestamp'])) > 3600) {
            unset($ini_array[$user]);
        }
    }

    $new_content = '';
    foreach ($ini_array as $user => $info) {
        $new_content .= "[$user]\n";
        foreach ($info as $key => $value) {
            $new_content .= "$key = \"$value\"\n";
        }
    }
    file_put_contents('config.txt', $new_content);
}

limpiarTokensExpirados();
?>
