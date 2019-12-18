
<script type="text/javascript" src="jq15.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$(".edit_tr").click(function() {
		
		var ID=$(this).attr('id');
		$("#first_"+ID).hide();
		$("#last_"+ID).hide();
		$("#wurst_"+ID).hide();
		$("#first_input_"+ID).show();
		$("#last_input_"+ID).show();
		$("#wurst_input_"+ID).show();
	}).change(function() {
		var ID=$(this).attr('id');
		var first=$("#first_input_"+ID).val();
		var last=$("#last_input_"+ID).val();
		var wurst=$("#wurst_input_"+ID).val();
		var dataString = 'id='+ ID +'&name='+first+'&getraenk='+last+'&wurst='+wurst;
		
		// Vielleicht hier doch ein Waiting Wheel weil so lange ist auch noch der alte Wert im Text zu sehen
		// bevor die Success Meldung des Ajax Requests erfolgte bleibt der Text der Alte.
		
		if(first.length>0) {
		
			$.ajax( {
				type: "POST",
				url: "table_edit_ajax.php",
				data: dataString,
				cache: false,
				success: function(html) {
					$("#first_"+ID).html(first);
					$("#last_"+ID).html(last);
					$("#wurst_"+ID).html(wurst);
				}
			});
		} else {
			//alert('Enter something.');
		}
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
	
	* {
		font-family:Arial, Helvetica, sans-serif;
		font-size:14px;
		border:solid 1px #000;
		padding:4px;	
	}

	td {
		padding:5px;
	}
	
	.text {
		width:380px;
		height: 20px;
		background-color:#bbcccc;
		display:inline-block;
	}
	
	.editbox {
		height: 20px;
		width:380px;
		background-color:#ffffcc;
		display:none
	}
	
	.edit_tr:hover {
		background-color:#998855;
		cursor:pointer;
	}
</style>


<table>
	<tr>
		<th>Name</th>
		<th>Welche Wurst und wie viele davon?</th>
		<th>Welches Getränk</th>
	</tr>
<?php

	include('db.php');

	$query = "select * from test";

	// mysqli with statement
	if ($stmt = mysqli_prepare($link, $query)) {
	    // execute statement
	    mysqli_stmt_execute($stmt);
	    // bind result variables
	    mysqli_stmt_bind_result($stmt, $id, $name, $wurst, $getraenk);
	
		// fetch values
		while (mysqli_stmt_fetch($stmt)) {

?>
			<tr id="<?php echo $id; ?>" class="edit_tr">
			
			<td class="edit_td">
			<span id="first_<?php echo $id; ?>" class="text"><?php echo $name; ?></span>
			<input type="text" value="<?php echo $name; ?>" class="editbox" id="first_input_<?php echo $id; ?>" />
			</td>
			
			<td class="edit_td">
			<span id="wurst_<?php echo $id; ?>" class="text"><?php echo $wurst; ?></span> 
			<input type="text" value="<?php echo $wurst; ?>" class="editbox" id="wurst_input_<?php echo $id; ?>"/>
			</td>
			
			<td class="edit_td">
			<span id="last_<?php echo $id; ?>" class="text"><?php echo $getraenk; ?></span> 
			<input type="text" value="<?php echo $getraenk; ?>" class="editbox" id="last_input_<?php echo $id; ?>"/>
			</td>
			
			</tr>
<?php
		}
	}
?>

</table>
