<?php
session_start();

require_once __DIR__ . "/atajos/db.php";

require_once __DIR__ . "/atajos/redirect-login.php";

$error = false;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (!isset($_POST['titulo']) || strlen($_POST['titulo']) == 0) {
        $error = true;
    }

    if (!isset($_POST['descripcion'])) {
        $error = true;
    }

    //COMPROBAR DATETIME
    if (!isset($_POST['fechaInicio']) || strlen($_POST['fechaInicio']) == 0) {
        $error = true;
    }

    //COMPROBAR DATETIME
    if (!isset($_POST['fechaFin']) || strlen($_POST['fechaFin']) == 0) {
        $error = true;
    }

    if (
        strtotime($_POST['fechaInicio']) == false
        || strtotime($_POST['fechaFin']) == false
        || (strtotime($_POST['fechaInicio']) > strtotime($_POST['fechaFin']))
    ) {
        $error = true;
    }

    if (!$error) {
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $fechaInicio = $_POST['fechaInicio'];
        $fechaFin = $_POST['fechaFin'];

        $event = new Event($_SESSION['user'], $titulo, $descripcion, $fechaInicio, $fechaFin);

        $calendarAccess->createEvent($event);

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
    <title>Crear evento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header class="p-3 text-bg-dark mb-5 ">
        <div class="fluid-container">
            <h1>NUEVO EVENTO</h1>

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
            if ($_SERVER['REQUEST_METHOD'] == "POST" && $error) {
                echo '<p class="errores alert alert-danger">Ha habido algún error</p>';
                $lastTitulo = $_POST['titulo'];
                $lastDescripcion = $_POST['descripcion'];
                $lastFechaInicio = $_POST['fechaInicio'];
                $lastFechaFin = $_POST['fechaFin'];
            } else {
                $lastTitulo = "";
                $lastDescripcion = "";
                $lastFechaInicio = "";
                $lastFechaFin = "";
            }
            ?>

            <form method="post">
                <div class="mb-3 row ">
                    <label for="titulo" class="col-sm-2 col-form-label">Título</label>
                    <div class="col-sm-10">
                        <input type="text" value="<?= $lastTitulo ?>" class="form-control" name="titulo" id="titulo" required>
                    </div>
                </div>

                <div class="mb-3 row ">
                    <label for="descripcion" class="col-sm-2 col-form-label">Descripción</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="descripcion" id="descripcion"><?= $lastDescripcion ?></textarea>
                    </div>
                </div>

                <div class="mb-3 row ">
                    <label for="fechaInicio" class="col-sm-2 col-form-label">Fecha y hora de inicio</label>
                    <div class="col-sm-10">
                        <input type="datetime-local" value="<?= $lastFechaInicio ?>" class="form-control" name="fechaInicio" id="fechaInicio" required>
                    </div>
                </div>

                <div class="mb-3 row ">
                    <label for="fechaFin" class="col-sm-2 col-form-label">Fecha y hora de fin</label>
                    <div class="col-sm-10">
                        <input type="datetime-local" value="<?= $lastFechaFin ?>" class="form-control" name="fechaFin" id="fechaFin" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Crear</button>
            </form>
        </div>
    </main>
</body>

</html>