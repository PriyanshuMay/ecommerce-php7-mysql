<?php
session_start();
include('../essentials/config.php');

if (!isset($_SESSION['admin'])) {
    header('location:logout.php');
}

$id = $_POST['id'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];

$sql = "UPDATE supplier SET supplier_name='$name',email='$email',phone='$phone',address='$address',
    modified_date=now() WHERE supplier_id=$id";
mysqli_query($connect, $sql);
header("location:manageSupplier.php");
