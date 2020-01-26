<?php
	if($_POST['id'])
	{
		include("db.php");
		$id=mysqli_real_escape_string($link, $_POST['id']);
		//$name=mysqli_real_escape_string($link, $_POST['name']);
		//$wurst=mysqli_real_escape_string($link, $_POST['wurst']);
		//$getraenk=mysqli_real_escape_string($link, $_POST['getraenk']);
		
		//$sql = "update test set name='$name',getraenk='$getraenk',wurst='$wurst' where id='$id'";
		
		$sql = "UPDATE $mysql_table SET ";
		$firstloop = true;
		foreach ($spalten as $spalte) {
			if (!$firstloop)
				$sql .= " ,";
			$sql .= $spalte["col"] . "='" . mysqli_real_escape_string($link, $_POST[$spalte["col"]]) . "'";
			$firstloop = false;
		}
		$sql .= " WHERE id = '$id';";
		mysqli_query($link, $sql);

	}
?>