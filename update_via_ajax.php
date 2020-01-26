<?php
	if($_POST['id'])
	{
		include("db.php");
		$id = mysqli_real_escape_string($link, $_POST['id']);

		// Loop all columns and create the UPDATE sql staement like this example:
		// UPDATE TABLE SET firstcolumn='$firstcolumn', secndcolumn='$secndcolumn' WHERE id='$id'";
		
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