<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verificar Token - Blog</title>
</head>
<body>
    <h1 id="nombre-blog">Cargando...</h1>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'obtener_recursos_blog.php', true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    document.getElementById('nombre-blog').textContent = response.nombre_blog;
                }
            };
            xhr.send();
        });

        var token = new URLSearchParams(window.location.search).get('token');
        if (token) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'verificar_token.php?token=' + token, true);
            xhr.onload = function() {
                if (xhr.status === 200 && xhr.responseText === 'Token válido') {
                    localStorage.setItem('blog_token', token);
                    window.location.href = 'blog.html';
                } else {
                    alert('Token inválido o expirado. Solicite acceso nuevamente.');
                    window.location.href = 'index.html';
                }
            };
            xhr.send();
        } else {
            alert('Token no proporcionado. Solicite acceso nuevamente.');
            window.location.href = 'index.html';
        }
    </script>
</body>
</html>
