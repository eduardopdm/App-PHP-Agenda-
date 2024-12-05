<?php
require_once __DIR__ . "/../data-access/CalendarDataAccess.php";
require_once __DIR__ . "/../entities/User.php";
require_once __DIR__ . "/../entities/Event.php";

$dbFile = __DIR__ . "/../data-access/calendario.db";

// if (file_exists($dbFile)) {
//     unlink($dbFile);
// }

$calendarAccess = new CalendarDataAccess($dbFile);
