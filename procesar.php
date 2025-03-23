<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Protección anti-spam: honeypot
    if (!empty($_POST['telefono'])) {
        exit("Spam detectado.");
    }

    // Sanitizar entradas
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $correo = filter_var(trim($_POST['correo']), FILTER_SANITIZE_EMAIL);
    $mensaje = htmlspecialchars(trim($_POST['mensaje']));

    // Validación básica
    if (empty($nombre) || empty($correo) || empty($mensaje) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        exit("Datos inválidos.");
    }

    // Preparar la línea a guardar
    $linea = "Nombre: $nombre\nCorreo: $correo\nMensaje: $mensaje\n---\n";

    // Guardar en archivo
    $archivo = 'mensajes.txt';
    file_put_contents($archivo, $linea, FILE_APPEND | LOCK_EX);

    // Redirigir o confirmar
    echo "<script>alert('Mensaje enviado correctamente'); window.location.href='index.html';</script>";
} else {
    http_response_code(405);
    echo "Método no permitido.";
}
?>
