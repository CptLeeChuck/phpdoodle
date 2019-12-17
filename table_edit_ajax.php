<?php
include("db.php");
if($_POST['id'])
{
$id=mysqli_real_escape_string($link, $_POST['id']);
$name=mysqli_real_escape_string($link, $_POST['name']);
$wurst=mysqli_real_escape_string($link, $_POST['wurst']);
$getraenk=mysqli_real_escape_string($link, $_POST['getraenk']);
$sql = "update test set name='$name',getraenk='$getraenk',wurst='$wurst' where id='$id'";
mysqli_query($link, $sql);
}
?>