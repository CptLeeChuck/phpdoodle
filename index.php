<?php

	include('db.php');

?><!doctype html>
<html class="no-js" lang="en">

<head>
	<script type="text/javascript" src="./3rdParty/jquery-3.4.1.min.js"></script>
	<link rel="stylesheet" href="./3rdParty/bootstrap-4.4.1/css/bootstrap.min.css">
	<script type="text/javascript" src="./3rdParty/bootstrap-4.4.1/js/bootstrap.min.js"></script>
	<script type="text/javascript">

$(document).ready(function() {
	$(".edit_tr").click(function() {
		
		var ID=$(this).attr('id');
		<?php
			// This loop generates this lines of JS:
			// $("#firstcolumn_"+ID).hide();
			// $("#firstcolumn_input_"+ID).show();
			foreach ($spalten as $spalte) {
				echo '$("#' . $spalte["col"] . '_"+ID).hide();' . "\n";
				echo '$("#' . $spalte["col"] . '_input_"+ID).show();' . "\n";
			}
		?>
	}).change(function() {
		var ID=$(this).attr('id');
		<?php
			// This loop generates this lines of JS:
			// var firstcolumn=$("#firstcolumn_input_"+ID).val();
			// var secndcolumn=$("#secndcolumn_input_"+ID).val();
			foreach ($spalten as $spalte) {
				echo 'var ' . $spalte["col"] . '=$("#' . $spalte["col"] . '_input_"+ID).val();' . "\n";
			}

			// This loop generates this line of JS:
			// var dataString = 'id='+ ID +'&name='+first+'&getraenk='+last+'&wurst='+wurst;
			echo "var dataString = 'id='+ ID +'";
			$firstloop = true;
			foreach ($spalten as $spalte) {
				if (!$firstloop)
					echo "+'";
				echo "&" . $spalte["col"] . "='+" . $spalte["col"];
				$firstloop = false;
			}
			echo ";\n";
		?>
		
		// Todo? Vielleicht hier ein Waiting Wheel weil so lange ist auch noch der alte Wert im Text zu sehen
		// bevor die Success Meldung des Ajax Requests erfolgte bleibt der Text der Alte.
		
		$.ajax( {
			type: "POST",
			url: "update_via_ajax.php",
			data: dataString,
			cache: false,
			success: function(html) {

				<?php
					// This loop generates this lines of JS:
					// $("#firstcolumn_"+ID).html(firstcolumn);
					// $("#secndcolumn_"+ID).html(secndcolumn);
					foreach ($spalten as $spalte) {
						echo '$("#' . $spalte["col"] . '_"+ID).html(' . $spalte["col"] . ');' . "\n";
					}
				?>
			}
		});
	});

	// Edit input box click action
	$(".editbox").mouseup(function() {
		return false
	});

	// Outside click action
	$(document).mouseup(function() {
		$(".editbox").hide();
		$(".text").show();
	});
});
</script>

<style>
	

	:root {
	    color-scheme: light dark;
	    --my-text-color: black;
	    --border-color: black;
	    --my-backgroundcolor: white;
	}

	@media (prefers-color-scheme: dark) {
	    :root {
	        --my-text-color: white;
	        --border-color: white;
		    --my-backgroundcolor: #282922;
	    }
	}

	body {
		color: var(--my-text-color);
		background-color: var(--my-backgroundcolor);
	}


	td {
		padding:5px;
	}
	
	.text {
		background-color:#bbcccc;
		display:inline-block;
	}
	
	.editbox {
		background-color:#ffffcc;
		display:none
	}
	
	.edit_tr:hover {
		background-color:#1ebbb4;
		cursor:pointer;
	}
</style>

</head>
<body>
<br><br><br><br><br>

<?php

	// =================== ======
	// Define Table Header (+SQL)
	// =================== ======
	echo '<div class="container">';
	echo '<div class="row align-items-center">';

	// Define also the SQL query to catch all row/cols while printing each table header.
	// The created SQL query looks very simple like:
	// $query = "SELECT id, firstcolumn, secndcolumn FROM 'test'";
	$query = "SELECT id, ";
	$firstloop = true;
	foreach ($spalten as $spalte) {

		// SQL
		if (!$firstloop)
			$query .= ", ";
		$query .= $spalte["col"];
		$firstloop = false;

		// Table Header
		echo '<div class="col-lg mt-2 mb-2">';
		echo $spalte["col"];
		echo "</div>\n";

	}
	$query .= " FROM $mysql_table";

	echo "</div>";
	echo "</div>";




	// ====================
	// Define Table content
	// ====================

	if ($stmt = mysqli_prepare($link, $query)) {
	    // execute statement
	    mysqli_stmt_execute($stmt);
	    // catch results
	    $result = mysqli_stmt_get_result($stmt);
	    // loop each row from result
        while ($row = mysqli_fetch_assoc($result))
        {

   			// Create the div wrapper for each row of the table
        	echo '<div class="container">' . "\n";
			echo "\t" . '<div id="' . $row["id"] . '" class="edit_tr row align-items-center">' . "\n";

			// Loop thru each column in this row and create the cell with specific CSS tags 			
            foreach ($spalten as $spalte) {
	            echo "\t\t"   . '<div class="col-lg mt-2 mb-2">' . "\n";
	            echo "\t\t\t" . '<span id="' . $spalte["col"] . '_' . $row["id"] . '" class="text form-control form-control-lg">' . $row[$spalte["col"]] . '</span>' . "\n";
	            echo "\t\t\t" . '<input type="text" value="' . $row[$spalte["col"]] . '" class="editbox form-control form-control-lg" id="' . $spalte["col"] . '_input_' . $row["id"] . '" />' . "\n";
	            echo "\t\t"   . "</div>\n";
			}
			
			// Close the div wrapper for each row in the table
			echo "\t" . "</div>\n";
			echo "</div>\n\n\n";	

		}
	}



	// ==============
	// Close the file
	// ==============
?>
</body>
</html>