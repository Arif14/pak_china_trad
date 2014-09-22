<?php
	
	require_once('../lib/inspekt/Inspekt.php');	

	include("helper_functions.php");
	
		$conn = checkSessionStatus_and_connect();
		if(!$conn){
			die("session not connected");
		}

		if ($_SERVER["REQUEST_METHOD"] == "POST"){
				$validated = true;

				if(isset($_POST['truck_id'])){ 
					$truck_id = test_input($_POST['truck_id']);
				}
				
				
				if(!Inspekt::isInt($truck_id)){ 
					$error_truck_id = '<label class="text-danger col-sm-4 col-sm-offset-3">Invalid Truck Id</label>';
					$validated = false;
				}


		}


		if(isset($validated) && $validated){
					
			updateStatus($truck_id,$_SESSION["office_id"],$conn);

		}else{

?>
<div class="middle">
	<form class="form-horizontal" id="form_update" method="post">
		<div class="form-group">
			<label class="col-sm-3 control-label">Enter Truck Id :</label>
			<div class="col-sm-3">
				<input class="form-control" type="text" name="truck_id" <?php if(isset($truck_id)){ echo 'value="'.$truck_id.'"';} ?> placeholder="Id" />
			</div>
			<?php if(isset($error_truck_id)){echo $error_truck_id;} ?>
		</div>
		<div class="form-group">
			<div class="col-sm-2 col-sm-offset-3">
				<button type="submit" id="update_status_btn" class="btn btn-default">Submit</button>
			</div>
		</div>
		
	</form>
	
</div>

<script>
	
	$("#update_status_btn").click(function(e){
		e.preventDefault();

	
		$.post("<?php  echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>",$("#form_update")
			.serialize()).done(function(data){
					$(".main").html(data);
			})

	});


</script>


<?php
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