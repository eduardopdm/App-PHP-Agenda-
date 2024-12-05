<?php
session_start();

require_once __DIR__ . "/atajos/db.php";

require_once __DIR__ . "/atajos/redirect-login.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (
        isset($_POST['opcion']) && $_POST['opcion'] == "si"
        && isset($_GET['id'])
    ) {
        $calendarAccess->deleteEvent($_GET['id']);
    }

    header("Location: events.php");
    die();
}

// $_REQUEST
// if ($_SERVER['REQUEST_METHOD'] == 'GET')

$error = false;

$titulo;

if (isset($_GET['id']) && filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)) {
    $id = $_GET['id'];

    $thisEvento = $calendarAccess->getEventById($id);

    if ($thisEvento != null) {

        if ($thisEvento->getUserId() == $_SESSION['user']) {
            $titulo = $thisEvento->getTitle();
        } else {
            $error = true;
        }
    } else {
        $error = true;
    }
} else {
    $error = true;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Evento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header class="p-3 text-bg-dark mb-5 ">
        <div class="fluid-container">
            <h1>ELIMINAR EVENTO</h1>

            <h2><?= $_SESSION['nombre'], " ", $_SESSION['apellidos'] ?></h2>

            <div class="botones">
                <a href="#!" class="btn btn-light">Editar perfil</a>
                <a href="#!" class="btn btn-light">Cambiar contraseña</a>
                <a href="logout.php" class="btn btn-light">Desconectar</a>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <?php

            if ($error):
                echo "<p alert alert-danger>No se puede acceder al evento porque no existe o porque no tiene permisos para verlo</p>";
                echo '<a href="events.php">Volver al listado de eventos</a>';
            else:
            ?>
                <p>¿Seguro que desea eliminar el evento <?= $titulo ?>?</p>
                <form method="post">
                    <button type="submit" class="btn btn-secondary" name="opcion" value="si">Sí</button>
                    <button type="submit" class="btn btn-secondary" name="opcion" value="no">No</button>
                </form>
            <?php
            endif;
            ?>
        </div>
    </main>
</body>

</html>