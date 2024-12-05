<?php
if (isset($_SESSION['user'])) {
    header("Location: events.php");
    die();
}
