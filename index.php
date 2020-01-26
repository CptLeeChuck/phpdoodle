<?php

	include('db.php');

?><!doctype html>
<html class="no-js" lang="en">

<head>
	<script type="text/javascript" src="jq15.js"></script> <!-- JQuery 1.5 :-o -->
	<link rel="stylesheet" href="./bootstrap-4.4.1/css/bootstrap.min.css">
	<script type="text/javascript" src="./bootstrap-4.4.1/js/bootstrap.min.js"></script>
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
		
		// Vielleicht hier doch ein Waiting Wheel weil so lange ist auch noch der alte Wert im Text zu sehen
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
		/*width:380px;
		height: 20px;*/
		background-color:#bbcccc;
		/*border:solid 1px #000;
		padding:4px;*/
		display:inline-block;
	}
	
	.editbox {
		/*height: 20px;
		width:380px;*/
		background-color:#ffffcc;
		/*border:solid 1px #000;
		padding:4px;*/	
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

	// Create SQL query like:
	// $query = "SELECT firstcolumn, secndcolumn FROM 'test'";
	$query = "SELECT id, ";
	$firstloop = true;
	foreach ($spalten as $spalte) {
				if (!$firstloop)
					$query .= ", ";
				$query .= $spalte["col"];
				$firstloop = false;
			}
	$query .= " FROM $mysql_table";

	// mysqli with statement
	if ($stmt = mysqli_prepare($link, $query)) {
	    // execute statement
	    mysqli_stmt_execute($stmt);
	    // catch results
	    $result = mysqli_stmt_get_result($stmt);
	    // loop each row
        while ($row = mysqli_fetch_assoc($result))
        {
            ///////echo $row["name"];

   			// Create rows like
			// <div class="col-lg mt-2 mb-2">
			// 	<span id="first_ID-HERE" class="text form-control form-control-lg">VALUE_HERE</span>
			// 	<input type="text" value="VALUE_HERE" class="editbox form-control form-control-lg" id="first_input_ID-HERE" />
			// </div>


        	//<div class="container">
				//<div id="ID-HERE" class="edit_tr row align-items-center">

        	echo '<div class="container">';
			echo '<div id="' . $row["id"] . '" class="edit_tr row align-items-center">';

 			
            foreach ($spalten as $spalte) {
	//			echo '$("#' . $spalte["col"] . '_"+ID).hide();' . "\n";
	//			echo '$("#' . $spalte["col"] . '_input_"+ID).show();' . "\n";

	            echo '<div class="col-lg mt-2 mb-2">' . "\n";
	            echo '	<span id="' . $spalte["col"] . '_' . $row["id"] . '" class="text form-control form-control-lg">' . $row[$spalte["col"]] . '</span>' . "\n";
	            echo '	<input type="text" value="' . $row[$spalte["col"]] . '" class="editbox form-control form-control-lg" id="' . $spalte["col"] . '_input_' . $row["id"] . '" />' . "\n";
	            echo "</div>\n";

			}
			
			echo "		</div>";
			echo "</div>";	
/*
			
			

			<div class="col-lg mt-2 mb-2">
				<span id="first_<?php echo $id; ?>" class="text form-control form-control-lg"><?php echo $name; ?></span>
				<input type="text" value="<?php echo $name; ?>" class="editbox form-control form-control-lg" id="first_input_<?php echo $id; ?>" />
			</div>
			<div class="col-lg mt-2 mb-2">
				<span id="wurst_<?php echo $id; ?>" class="text form-control form-control-lg"><?php echo $wurst; ?></span> 
				<input type="text" value="<?php echo $wurst; ?>" class="editbox form-control form-control-lg" id="wurst_input_<?php echo $id; ?>"/>
			</div>
			<div class="col-lg mt-2 mb-2">
				<span id="last_<?php echo $id; ?>" class="text form-control form-control-lg"><?php echo $getraenk; ?></span> 
				<input type="text" value="<?php echo $getraenk; ?>" class="editbox form-control form-control-lg" id="last_input_<?php echo $id; ?>"/>
			</div>

*/

		}
	}
?>



</body>
</html>