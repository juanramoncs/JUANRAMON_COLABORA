<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

</head>
<body>
<?php

// Recibir los datos del formulario
$usuario = $_POST["usu"];
$clave = $_POST["clave"];

// Conectarse al servidor de la base de datos
$conexion = mysqli_connect("localhost", "root", "");
if (!$conexion){
    echo "ERROR: Imposible establecer conexión con la base de datos.<br>";
} else {
    echo "Conexión con la base de datos establecida correctamente...<br><br>";
}

// Seleccionar la base de datos
$db = mysqli_select_db($conexion, "ejemplo");
if (!$db){
    echo "ERROR: Imposible seleccionar la base de datos.<br>";
} else {
    echo "Base de datos seleccionada satisfactoriamente...<br><br>";
}

// Preparar la consulta utilizando consultas preparadas
$query = "SELECT * FROM acceso WHERE login = ? AND clave = md5(?)";

// Inicializar la sentencia preparada
$stmt = mysqli_prepare($conexion, $query);

// Vincular parámetros a la sentencia preparada
mysqli_stmt_bind_param($stmt, "ss", $usuario, $clave);

// Ejecutar la sentencia preparada
mysqli_stmt_execute($stmt);

// Obtener el resultado de la consulta
$resultado = mysqli_stmt_get_result($stmt);

// Mostrar resultados
if (!$resultado) {
    echo "ERROR: Imposible realizar consulta.<br>";
} else {
    echo "Consulta realizada satisfactoriamente!<br>";
    echo "Se encontraron " . mysqli_num_rows($resultado) . " registros.<br>";

    if (mysqli_num_rows($resultado) == 0) {
        echo "<br><b>Usuario y/o clave incorrectos!</b><br>";
    } else {
        echo "<br>REGISTROS ENCONTRADOS:<br>";

        while ($fila = mysqli_fetch_row($resultado)) {
            echo "<b>USUARIO:</b> $fila[0] <b>CLAVE:</b> $fila[1] <b>NOMBRE:</b> $fila[2] <b>HAS CONSEGUIDO ENTRAR EN LA PAGINA WEB!</b><br>";
        }

        echo '<form action="ALTA.html" method="post">';
        echo '<input type="submit" value="Ir a ALTA.php">';
        echo '</form>';
    }
}

// Cerrar la conexión
mysqli_stmt_close($stmt);
mysqli_close($conexion);

?>
</body>
</html>
