<?php
session_start();

require_once __DIR__ . "/atajos/db.php";

require_once __DIR__ . "/atajos/redirect-events.php";

$error = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $users = $calendarAccess->getAllUsers();

    foreach ($users as $user) {
        $email = $user->getEmail();
        $password = $user->getPassword();

        if (
            isset($_POST['email']) && $_POST['email'] == $email
            && isset($_POST['password'])
            && password_verify($_POST['password'], $password)
        ) {
            $_SESSION['user'] = $user->getId();
            $_SESSION['nombre'] = $user->getFirstName();
            $_SESSION['apellidos'] = $user->getLastName();
            session_regenerate_id();
            header("Location: events.php");
            die();
        } else {
            $error = true;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header class="p-3 text-bg-dark mb-5">
        <div class="fluid-container">
            <h1>INGRESO</h1>
        </div>
    </header>

    <main>
        <div class="container">
            <?php
            if ($_SERVER['REQUEST_METHOD'] == "POST" && $error) {
                echo '<p class="errores alert alert-danger">Usuario o contraseña incorrectos</p>';
                $lastEmail = $_POST['email'];
            } else {
                $lastEmail = "";
            }
            ?>
            <form method="post">
                <div class="mb-3 row">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" value="<?= $lastEmail ?>" class="form-control" name="email" id="email" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="password" class="col-sm-2 col-form-label">Contraseña</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Ingresar</button>
            </form>
            <a href="register.php" class="btn btn-link">Crear cuenta</a>

            <?php
            // $users = $calendarAccess->getAllUsers();

            // foreach ($users as $user) {
            //     $email = $user->getEmail();
            //     $password = $user->getPassword();

            //     echo "<p>$email</p>";
            //     echo "<p>$password</p>";
            // }
            ?>
        </div>
    </main>

</body>

</html>