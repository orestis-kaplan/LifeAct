<?php
session_start();
unset($_SESSION['usname']);
session_destroy();
header("Location: home.php");
exit;
 ?>
