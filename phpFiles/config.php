<?php
define('DB_SERVER', 'localhost:80');
define('DB_USERNAME', 'dbConnectionUser');
define('DB_PASSWORD', 'dbConnectionPass');
define('DB_DATABASE', 'ipfw-capstone');
$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
?>
