<?php
$link = mysqli_init();
$connection = mysqli_real_connect($link, 'localhost', 'root', 'root', 'aitpr', '8889');
if (!$connection){
    die("Database Connection Failed" . mysqli_error($connection));
}
?>