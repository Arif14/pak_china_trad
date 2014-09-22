<?php
		require_once('../../../lib/inspekt/Inspekt.php');
		include("../../helper_functions.php");
	
		$conn = checkSessionStatus_and_connect();

		
		if(!$conn){
			die("session not connected");
		}
		

		function officesList(&$conn){

			$sql = "SELECT location 
					FROM office ";

			$result = mysql_query($sql,$conn);

			while($row = mysql_fetch_array($result)){
				$location = $row['location'];
				echo '<option value="'.$location.'">'.$location.'</option>';
			}

		}


		
			if ($_SERVER["REQUEST_METHOD"] == "POST"){
				$validated = true;
				
				if(isset($_POST['location_name'])){ $location_name = test_input($_POST['location_name']);}
				if(isset($_POST['map_cord'])){ $map_cord = test_input($_POST['map_cord']);}

				if(!Inspekt::isAlpha($location_name)){ 
					$error_location_name = '<label class="text-danger">Invalid Location Name</label>';
					$validated = false;
				}
				if(!Inspekt::isRegex($map_cord,"/^(\-?\d+(\.\d+)?),\s*(\-?\d+(\.\d+)?)$/")){ 
					$error_map_cord = '<label class="text-danger">Invalid Map Coordinate</label>'; 
					$validated = false;
				}

			}

		/* validation area end */

		if(isset($validated) && $validated){
			submitFormToDB($conn);
		}else{
?>



<h1>Create Office</h1>
<div class="middle">
	<form class="form-horizontal" id="create_office_form">		
		<div class="form-group ">
			<label class="col-sm-3 control-label">Location Name:-</label>
			<div class="col-sm-3">
				<input class="form-control" id="inputError2" name="location_name" <?php if(isset($location_name)){ echo 'value="'.$location_name.'"';} ?> type="text" placeholder="name" required>
			</div>
			<?php if(isset($error_location_name)){echo $error_location_name;} ?>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">Office Type:-</label>
			<div class="col-sm-3">
				<select class="form-control" name="office_type">
					<option>head_office</option>
					<option>sub_office</option>
				</select>
			</div>
		</div>
		<div class="form-group ">
			<label class="col-sm-3 control-label">Map Coordinates:-</label>
			<div class="col-sm-3">
				<input class="form-control" name="map_cord" type="text" pattern = "^(\-?\d+(\.\d+)?),\s*(\-?\d+(\.\d+)?)$" <?php if(isset($map_cord)){ echo 'value="'.$map_cord.'"';} ?> placeholder="Lat,Lng" required>
			</div>
			<?php if(isset($error_map_cord)){ echo $error_map_cord;} ?>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">Connecting Office:-</label>
			<div class="col-sm-3">
				<select name="connecting_office" id="connecting_office" class="multiselect" multiple="multiple">
				  <?php officesList($conn); ?>
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<div class="col-sm-2 col-sm-offset-3">
				<button type="submit" id="form_create_btn" class="btn btn-default">Create Office</button>
			</div>
		</div>
	</form>
</div>

<script>
	//console.log("before");
	 $('.multiselect').multiselect();

	 $("#form_create_btn").click(function(e){
            e.preventDefault();
            
            console.log($("#create_office_form").serialize());

            var serialize = $("#create_office_form").serialize();

            var JSONconnecting_office = JSON.stringify($("#connecting_office").val());

            serialize += '&connecting_office=' + JSONconnecting_office;
            console.log("serialize : "+ serialize);
            
            $.post(" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> ",serialize).done(function( data ) {
				  $(".main").html(data);				 
				} );
			
		
    });   
	// console.log("after");
</script>

<?php  }

	function submitFormToDB($conn){

		echo "<h1>Create Office Submit</h1>";

		$location_name = $_POST['location_name'];
		$office_type = $_POST['office_type'];
		$map_cord = $_POST['map_cord'];
		$connecting_office = json_decode($_POST['connecting_office']);;

		echo "location_name : $location_name </br>";
		echo "office_type : $office_type </br>";
		echo "map_cord : $map_cord </br>";
		echo "connecting_office :".  print_r($connecting_office) ." </br>";


		$sql = "INSERT INTO office(location,type,map_cord)
				VALUES('{$location_name}','{$office_type}','{$map_cord}')";

		echo "sql : $sql </br>";

		$result =  mysql_query($sql,$conn);

		if($result){
			$last_id = mysql_insert_id();

			echo "size of " . sizeof($connecting_office);
			if(sizeof($connecting_office)>0){
					foreach ($connecting_office as $value) {

						echo " connecting_office : " . $value . "</br>";
						
						$sql = "SELECT id 
								FROM office 
								WHERE location = '{$value}'";
						$result = mysql_query($sql,$conn);

						$to_id = -1;

						while($row = mysql_fetch_array($result)){
							$to_id = $row['id'];
						}

						$sql = "INSERT INTO office_map(from_location,to_location)
								VALUES({$last_id},{$to_id})";



				echo $sql . "</br>";
						mysql_query($sql,$conn);
						
						$sql = "INSERT INTO office_map(from_location,to_location)
								SELECT {$to_id},{$last_id} FROM office_map
								WHERE NOT EXISTS (SELECT * 
												  FROM office_map 
												  WHERE from_location = {$to_id} 
												  AND to_location = {$last_id})
								LIMIT 0,1";
						
						echo $sql . "</br>";
						mysql_query($sql,$conn);

					}

			}

			echo "Submitted </br>";
		}else{

			echo "error in submition </br>";
		}



	}


?>


