<?php
session_start();
include('../essentials/config.php');
$id = $_POST['id'];
if (!isset($_SESSION['admin'])) {
    header('location:logout.php');
}

$query = "DELETE FROM carousel WHERE carousel_id=" . $id;
mysqli_query($connect, $query);

echo 1;
