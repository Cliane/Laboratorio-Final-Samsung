<?php
$servername = "localhost";
$username = "root";
$dbpassword = "";
$dbname = "laboratorio";

// Establecer conexión a la base de datos
$conn = new mysqli($servername, $username, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consultar todos los usuarios registrados
$consulta = "SELECT * FROM usuario";
$resultado = $conn->query($consulta);

if (isset($_POST['volver'])) {
    header("Location: formulario.php");
}

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Consulta de Usuarios</title>
<link href="estiloconsulta.css" rel="stylesheet" type="text/css">
</head>

<body>
    <h2>Lista de Usuarios Registrados</h2>

    <table>
        <tr>
            <th>Nombre</th>
            <th>Primer Apellido</th>
            <th>Segundo Apellido</th>
            <th>Email</th>
            <th>Login</th>
        </tr>
        
        <?php while ($fila = $resultado->fetch_assoc()): ?>
        <tr>
            <td><?php echo $fila['nombre']; ?></td>
            <td><?php echo $fila['primerapellido']; ?></td>
            <td><?php echo $fila['segundoapellido']; ?></td>
            <td><?php echo $fila['email']; ?></td>
            <td><?php echo $fila['login']; ?></td>
        </tr>
        <?php endwhile; ?>

    </table>

    
    <form action="" method="post">
    <input class="form-btn" name="volver" type="submit" value="Volver"/>
    </form>

    <?php $conn->close(); ?>

</body>
</html>
