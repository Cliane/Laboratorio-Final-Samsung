<?php
$message = ""; // Variable para almacenar los mensajes
$operationSuccessful = false; // Variable para verificar si la operación fue exitosa
$validaciones = false;

if (isset($_POST['submit'])) {
    $nombre = $_POST['nombre'];
    $apellidoprimero = $_POST['primerapellido'];
    $apellidosegundo = $_POST['segundoapellido'];
    $email = $_POST['email'];
    $login = $_POST['login'];
    $userPassword = $_POST['password'];


    //_____________________________________________
    //Validamos la longitud de la contraseña
    $minLength = 4; // Longitud mínima permitida
    $maxLength = 8; // Longitud máxima permitida
    
    if (strlen($userPassword) < $minLength) {
        $validaciones = false;
        $message = "El la contraseña no cumpli con el numero mínimo de caracteres el cual es 4.";
    } elseif (strlen($userPassword) > $maxLength) {
        $validaciones = false;
        $message = "El la contraseña excede el número máximo de caracteres el cual es 8.";
    } else {
        // La longitud de la contraseña es válida
        $validaciones = true;
    }

    //_____________________________________________
    //Validamos el formato del email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // El correo electrónico es válido
        $validaciones = true;
    } else {
        // El correo electrónico no es válido
        $message = "El email no tiene un formato válido. Por favor, utiliza otro.";
        $validaciones = false;
    }

    //_____________________________________________
    //Si las validaciones son correctas procedemos a introducir el registro en la bbdd
    if ($validaciones):
    $servername = "localhost";
    $username = "root";
    $dbpassword = "";
    $dbname = "laboratorio";

    // Establecer conexión a la base de datos
    $conn = new mysqli($servername, $username, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Verificar si el email ya existe en la base de datos
    $checkEmailQuery = "SELECT * FROM usuario WHERE email = '$email'";
    $result = $conn->query($checkEmailQuery);

    if ($result->num_rows > 0) {
        // El email ya está registrado, mostrar mensaje de error y volver al formulario
        $message = "El email ya está registrado. Por favor, utiliza otro.";
    } else {
        // Insertar los datos en la base de datos
        $sql = "INSERT INTO usuario (nombre, primerapellido, segundoapellido, email, login, password)
        VALUES ('$nombre', '$apellidoprimero', '$apellidosegundo', '$email', '$login', '$userPassword')";

        if ($conn->query($sql) === TRUE) {
            $message = "Registro completado con éxito.";
        } else {
            $message = "Error al registrar. Por favor, inténtalo nuevamente.";
        }

    }

    $conn->close();
    endif;
}

    if (isset($_POST['consulta'])) {
    $email = $_POST['email'];

    $servername = "localhost";
    $username = "root";
    $dbpassword = "";
    $dbname = "laboratorio";

    // Establecer conexión a la base de datos
    $connconsulta = new mysqli($servername, $username, $dbpassword, $dbname);

        $checkEmailConsulta = "SELECT * FROM usuario WHERE email = '$email'";
        $resultConsulta = $connconsulta->query($checkEmailConsulta);

    if ($resultConsulta->num_rows > 0) {
        header("Location: consulta.php");
    }else{
        $validaciones = true;
        $message = "El usuario con el que intenta realizar la consulta no existe en la base de datos.";
        //header("Location: formulario.php");
    }
    $connconsulta->close();
    }

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formulario de registro</title>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div class="group">

        <form method="POST" action="">
        <h2>Registro de Usuario</h2>
        <form action="procesar_registro.php" method="POST">

        <label for="nombre">Nombre<span><em>(requerido)</em></span></label>
        <input type="text" id="nombre" name="nombre" class="form-input" required/>

        <label for="apellido1">Primer Apellido<span><em>(requerido)</em></span></label>
        <input type="text" id="primero" name="primerapellido" class="form-input" required/>

        <label for="apellido2">Segundo Apellido<span><em>(requerido)</em></span></label>
        <input type="text" id="segundo" name="segundoapellido" class="form-input" required/>

        <label for="email">Email<span><em>(requerido)</em></span></label>
        <input type="email" id="email" name="email" class="form-input" required/>      

        <label for="login">Login<span><em>(requerido)</em></span></label>
        <input type="text" id="login" name="login" class="form-input" required/>

        <label for="password">Contraseña<span><em>(requerido)</em></span></label>
        <input type="password" id="password" name="password" class="form-input" required minlength="4" maxlength="8"/><br>

        <input class="form-btn" name="submit" type="submit" value="Registrarse"/>
        <input class="form-btn" name="consulta" type="submit" value="Consulta"/>

    </form>

</div>

</div>

<?php if ($validaciones): ?>
<script>
        function confirmar() {
            var resultado = "<?php echo $message; ?>";
            alert(resultado);
        }
        confirmar(); 
</script>
<?php endif; ?>


</body>
</html>