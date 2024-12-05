<?php
session_start();
session_regenerate_id();

require_once __DIR__ . "/atajos/db.php";

require_once __DIR__ . "/atajos/redirect-events.php";

$error = false;
$errores = [];

$email;
$nombre;
$apellidos;
$fechaNacimiento;
$password;

$usuarioCreado = false;

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (!isset($_POST['email']) || strlen($_POST['email']) == 0) {
        $error = true;
        array_push($errores, "Campo Email incorrecto. Vacío");
    } else if (isset($_POST['email']) && !filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
        $error = true;
        array_push($errores, "Campo Email incorrecto. Formato erróneo");
    } else if (isset($_POST['email'])) {
        $userDB = $calendarAccess->getUserByEmail($_POST['email']);
        if ($userDB != null) {
            $error = true;
            array_push($errores, "Ya existe una cuenta registrada con ese email");
        }
    }

    if (!isset($_POST['nombre']) || strlen($_POST['nombre']) == 0) {
        $error = true;
        array_push($errores, "Campo Nombre incorrecto. Vacío");
    }

    if (!isset($_POST['apellidos']) || strlen($_POST['apellidos']) == 0) {
        $error = true;
        array_push($errores, "Campo Apellidos incorrecto. Vacío");
    }

    if (!isset($_POST['fechaNacimiento']) || strlen($_POST['fechaNacimiento']) == 0) {
        $error = true;
        array_push($errores, "Campo Fecha de Nacimiento incorrecto. Vacío");
    } else {
        if (strtotime($_POST['fechaNacimiento']) == false) {
            $error = true;
            array_push($errores, "Campo Fecha de Nacimiento incorrecto. No tiene el formato correcto");
        } else if (strtotime($_POST['fechaNacimiento']) > time()) {
            $error = true;
            array_push($errores, "Campo Fecha de Nacimiento incorrecto. No puede poner una fecha futura");
        }
    }
    // try {
    //     $fecha = new DateTime($_POST['fechaNacimiento']);
    // } catch (Exception) {
    //     $error = true;
    //     array_push($errores, "Campo Fecha de Nacimiento incorrecto. No tiene el formato correcto");
    // }
}

if (!isset($_POST['password']) || strlen($_POST['password']) == 0) {
    $error = true;
    array_push($errores, "Campo Contraseña incorrecto. Vacío");
} else {
    $password = $_POST['password'];

    if (strlen($password) < 8) {
        $error = true;
        array_push($errores, "Campo Contraseña incorrecto. No tiene 8 caracteres");
    }
    $tieneNumero = false;

    $tieneLetra = false;

    for ($i = 0; $i < strlen($password); $i++) {
        $char = $password[$i];

        if (ctype_digit($char)) {
            $tieneNumero = true;
        } else {
            $tieneLetra = true;
        }
    }

    if (!$tieneLetra || !$tieneNumero) {
        $error = true;
        array_push($errores, "Campo Contraseña incorrecto. Tiene que tener letras Y números");
    }
}

if (!isset($_POST['repassword']) || strlen($_POST['repassword']) == 0) {
    $error = true;
    array_push($errores, "Campo Repetir Contraseña incorrecto. Vacío");
} else if (
    isset($_POST['password']) && isset($_POST['repassword'])
    && $_POST['password'] != $_POST['repassword']
) {
    $error = true;
    array_push($errores, "Campo Repetir Contraseña incorrecto. No es igual al campo Contraseña");
}

if (!$error) {
    $email = $_POST['email'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $fechaNacimiento = $_POST['fechaNacimiento'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $user = new User(
        $email,
        $password,
        $nombre,
        $apellidos,
        $fechaNacimiento,
        ""
    );

    $calendarAccess->createUser($user);

    $usuarioCreado = true;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regsitro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header class="p-3 text-bg-dark mb-5 ">
        <div class="fluid-container">
            <h1>REGISTRO</h1>
        </div>
    </header>

    <main>
        <div class="container">
            <?php
            if (!$usuarioCreado):

                if ($_SERVER['REQUEST_METHOD'] == "POST" && $error) {
                    echo '<ul class="errores alert alert-danger">';
                    echo '<div class="container">';
                    foreach ($errores as $error) {
                        echo "<li>$error</li>";
                    }
                    echo "</div>";
                    echo "</ul>";


                    $lastEmail = $_POST['email'];
                    $lastNombre = $_POST['nombre'];
                    $lastApellidos = $_POST['apellidos'];
                    $lastFechaNacimiento = $_POST['fechaNacimiento'];
                } else {
                    $lastEmail = "";
                    $lastNombre = "";
                    $lastApellidos = "";
                    $lastFechaNacimiento = "";
                }
            ?>

                <form method="post">
                    <div class="mb-3 row ">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" value="<?= $lastEmail ?>" class="form-control" name="email" id="email" required>
                        </div>
                    </div>

                    <div class="mb-3 row ">
                        <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                        <div class="col-sm-10">
                            <input type="text" value="<?= $lastNombre ?>" class="form-control" name="nombre" id="nombre" required>
                        </div>
                    </div>

                    <div class="mb-3 row ">
                        <label for="apellidos" class="col-sm-2 col-form-label">Apellidos</label>
                        <div class="col-sm-10">
                            <input type="text" value="<?= $lastApellidos ?>" class="form-control" name="apellidos" id="apellidos" required>
                        </div>
                    </div>

                    <div class="mb-3 row ">
                        <label for="fechaNacimiento" class="col-sm-2 col-form-label">Fecha de nacimiento</label>
                        <div class="col-sm-10">
                            <input type="date" value="<?= $lastFechaNacimiento ?>" class="form-control" name="fechaNacimiento" id="fechaNacimiento" required>
                        </div>
                    </div>

                    <div class="mb-3 row ">
                        <label for="password" class="col-sm-2 col-form-label">Contraseña</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="password" id="password" required>
                        </div>
                        <div class="form-text">La contraseña tiene que tener mínimo 8 caracteres, y además debe tener letras y números</div>
                    </div>

                    <div class="mb-3 row ">
                        <label for="repassword" class="col-sm-2 col-form-label">Repetir contraseña</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="repassword" id="repassword" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Crear usuario</button>
                </form>
                <a href="index.php" class="btn btn-link">Ya tengo cuenta</a>
            <?php
            else:
            ?>
                <p>Usuario creado</p>
                <a href="index.php">Volver a la página de acceso</a>
            <?php
            endif;
            ?>
        </div>
    </main>
</body>

</html>