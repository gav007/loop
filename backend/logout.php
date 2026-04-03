<?php
session_start();
session_unset();
session_destroy();

header("Location: ../templates/login_page.php");
exit();
?>
