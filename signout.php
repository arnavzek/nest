<?php


unset($_COOKIE['lluda_token']);

setcookie('lluda_token', '', time() - 3600, '/');

header("location:index.php");


?>