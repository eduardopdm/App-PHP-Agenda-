<?php
session_start();

require_once __DIR__ . "/atajos/db.php";

require_once __DIR__ . "/atajos/redirect-login.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['opcion']) && $_POST['opcion'] == "si") {
        session_destroy();
        session_regenerate_id();
        header("Location: index.php");
        die();
    } else if (isset($_POST['opcion']) && $_POST['opcion'] == "no") {
        header("Location: events.php");
        die();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header class="p-3 text-bg-dark mb-5 ">
        <div class="fluid-container">
            <h1>DESCONECTAR</h1>

            <h2><?= $_SESSION['nombre'], " ", $_SESSION['apellidos'] ?></h2>

            <div class="botones">
                <a href="#!" class="btn btn-light">Editar perfil</a>
                <a href="#!" class="btn btn-light">Cambiar contraseña</a>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <p>¿Seguro que quieres desconectar?</p>
            <form method="post">
                <button type="submit" class="btn btn-secondary" name="opcion" value="si">Sí</button>
                <button type="submit" class="btn btn-secondary" name="opcion" value="no">No</button>
            </form>
        </div>
    </main>
</body>

</html>