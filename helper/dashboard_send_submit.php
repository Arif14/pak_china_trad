<?php

	include("helper_functions.php");
	
		$conn = checkSessionStatus_and_connect();
		if(!$conn){
			die("session not connected");
		}

	function updateDateForTruck($truck_id,&$conn){
		$date = date("y-m-d");
		
		$sql = "UPDATE truck SET date_send = '{$date}' WHERE id = {$truck_id} ";

		mysql_query($sql,$conn);

	}
?>

<div class="middle">
	<h1>Transport Id = <b><?php echo $_GET['truck_id']; global $conn; updateDateForTruck($_GET['truck_id'],$conn); ?></b></h1>
</div>