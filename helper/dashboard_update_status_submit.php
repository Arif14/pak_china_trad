<?php

	include("helper_functions.php");
	
		$conn = checkSessionStatus_and_connect();
		if(!$conn){
			die("session not connected");
		}

	function updateStatus($truck_id,$office_id,&$conn){
		$date = date("y-m-d");
		
		$sql = "UPDATE truck 
				SET date_recieved = '{$date}' 
				WHERE id = {$truck_id} ";

		mysql_query($sql,$conn);

		$sql = "SELECT transport_id 
				FROM truck_transport_rel 
				WHERE truck_id = {$truck_id}";

		$result =  mysql_query($sql,$conn);

		while($row = mysql_fetch_array($result)){
			echo "run " . "<br/>";

			$transport_id = $row['transport_id'];
			$sql = "SELECT id
					FROM office
					WHERE location = (SELECT to_location 
									  FROM transport
									  WHERE id = $transport_id)";  //''";

			$result2 = mysql_query($sql,$conn);

			$flag = false;

			while($row = mysql_fetch_array($result2)){
				if($row['id'] == $office_id){
					$flag = true;
				}
			}


			if($flag){
				$sql = "UPDATE transport
						SET end_date = '{$date}'
						WHERE id = {$transport_id}";
				mysql_query($sql,$conn);
			}else{
				insertToTruck($transport_id,$_SESSION["office_id"],$conn);
			}
		}
	}
?>

<div class="middle">
	<?php 	global $conn;
			$truck_id = $_POST['truck_id'];
			updateStatus($truck_id,$_SESSION["office_id"],$conn);
	 ?>
	<h1>Working</h1>	
</div>