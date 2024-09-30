<?php
session_start();
session_unset();
session_destroy();
// header("Location: LoginPHP/index.php");
header('Location: http://web-server/menu.php');

?>