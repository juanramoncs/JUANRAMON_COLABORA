<?php
// Obtener datos del formulario
$login = $_POST['login'];
$clave = md5($_POST['clave']); // Cifrar la contraseña con MD5
$nombre = $_POST['nombre'];

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "Sepecam2020-21";
$dbname = "ejemplo";

// Crear conexión
$conexion = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Preparar la consulta SQL
$sql = "INSERT INTO acceso (login, clave, nombre) VALUES (?, ?, ?)";
$stmt = $conexion->prepare($sql);

// Verificar si la preparación de la consulta fue exitosa
if ($stmt === false) {
    die("Error al preparar la consulta: " . $conexion->error);
}

// Enlazar parámetros a la consulta preparada
$stmt->bind_param("sss", $login, $clave, $nombre);

// Ejecutar la consulta
if ($stmt->execute()) {
    echo "Usuario registrado correctamente.";
} else {
    echo "Error al registrar usuario: " . $conexion->error;
}

// Cerrar conexión y liberar recursos
$stmt->close();
$conexion->close();
?>
