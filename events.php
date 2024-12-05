<?php
session_start();

require_once __DIR__ . "/atajos/db.php";

require_once __DIR__ . "/atajos/redirect-login.php";

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <header class="p-3 text-bg-dark mb-5 ">
        <div class="fluid-container">
            <h1>EVENTOS</h1>

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
            //PREGUNTAR POR ARIA-LABEL
            $eventos = $calendarAccess->getEventsByUserId($_SESSION['user']);
            echo '<a href="new-event.php" class="btn btn-primary"><span class="visually-hidden">Nuevo evento</span><i class="fa-solid fa-plus fa-2xl"></i></a>';
            if (sizeof($eventos) > 0):
                echo '<table class="table table-hover">';
                echo "<thead>";
                echo "<tr>";
                echo "<th>Título</th>";
                echo "<th>Descripción</th>";
                echo "<th>Fecha inicio</th>";
                echo "<th>Fecha fin</th>";
                echo "<th></th>";
                echo "</tr>";
                echo "</thead>";

                echo "<tbody>";
                foreach ($eventos as $event) {
                    $id = $event->getId();
                    $title = $event->getTitle();
                    $descripcion = $event->getDescription();
                    $startDate = new DateTime($event->getStartDate());
                    $endDate = new DateTime($event->getEndDate());

                    echo "<tr>";
                    echo "<td>$title</td>";
                    echo "<td>$descripcion</td>";
                    echo "<td>" . $startDate->format('d/m/Y H:i') . "</td>";
                    echo "<td>" . $endDate->format('d/m/Y H:i') . "</td>";
                    echo "<td>";

                    //ENLACES COMO ICONOS, NO TEXTO

                    echo '<a href="#!" class="btn btn-secondary"><span class="visually-hidden">Editar evento</span><i class="fa-solid fa-pen-to-square fa-2xl"></i></a>';
                    // echo '<div><a href="#!">Editar</a></div>';
                    echo "<a href=\"delete-event.php?id=$id\" class=\"btn btn-secondary\"><span class=\"visually-hidden\">Borrar evento</span><i class=\"fa-solid fa-trash fa-2xl\"></i></a>";
                    // echo "<div><a href=\"delete-event.php?id=$id\">Eliminar</a></div>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";

                //ENLACES COMO ICONOS, NO TEXTO
                echo '<a href="new-event.php" class="btn btn-primary"><span class="visually-hidden">Nuevo evento</span><i class="fa-solid fa-plus fa-2xl"></i></a>';
            endif;
            ?>
        </div>
    </main>
</body>

</html>