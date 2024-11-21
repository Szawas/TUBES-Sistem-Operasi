<?php
session_start();

// Hancurkan sesi untuk logout
session_unset();
session_destroy();

// Redirect ke index.php
header("Location: index.php");
exit();
?>