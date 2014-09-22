<?php

	include("../../helper_functions.php");

		$conn = checkSessionStatus_and_connect();
		if(!$conn){
			die("session not connected");
		}

	if(isset($_POST['my_id'])){
		$id = $_POST['my_id'];

		$sql = "DELETE FROM office 
				WHERE id = {$id}";

		mysql_query($sql,$conn);

		$sql = "DELETE FROM office_map
				WHERE from_location = {$id}
				OR to_location = {$id}";

		mysql_query($sql,$conn);

	}

?>