<?php	
	

	require_once('../lib/inspekt/Inspekt.php');	

	include("helper_functions.php");
	
		$conn = checkSessionStatus_and_connect();
		if(!$conn){
			die("session not connected");
		}

	function createToLocationOptions(&$conn){
		

		$ofc_id = $_SESSION["office_id"];
		$sql = "SELECT location FROM office WHERE id <> {$ofc_id} ";

		$result = mysql_query($sql,$conn);

		while($row = mysql_fetch_array($result)){
			echo "<option>" . $row['location'] . "</option>";
		}

	}


	function getLocation($location_id,&$conn){

		$sql = "SELECT location
				FROM office
				WHERE id = {$location_id}";

		$result =  mysql_query($sql,$conn);

		while($row  =  mysql_fetch_array($result)){
			return $row['location'];
		}

	}

		if ($_SERVER["REQUEST_METHOD"] == "POST"){
				$validated = true;

				if(isset($_POST['customer_name'])){ $customer_name = test_input($_POST['customer_name']);}
				if(isset($_POST['from_location'])){ $from_location = test_input($_POST['from_location']);}
				if(isset($_POST['start_date'])){ $start_date = test_input($_POST['start_date']);}
				if(isset($_POST['size'])){ $size = test_input($_POST['size']);}

				if(!Inspekt::isAlpha($customer_name)){ 
					$error_customer_name = '<label class="text-danger col-sm-4 col-sm-offset-3">Invalid Customer Name</label>';
					$validated = false;
				}

				if(!Inspekt::isRegex($from_location,'/^[a-zA-Z]$/')){ 
					$error_from_location = '<label class="text-danger col-sm-4 col-sm-offset-3">Invalid From Location</label>';
					$validated = false;
				}

				if(!Inspekt::isDate($start_date)){ 
					$error_start_date = '<label class="text-danger col-sm-4 col-sm-offset-3">Invalid Start Date</label>';
					$validated = false;
				}

				if(!Inspekt::isInt($size)){ 
					$error_size = '<label class="text-danger col-sm-4 col-sm-offset-3">Invalid Size</label>';
					$validated = false;
				}

		}

		if(isset($validated) && $validated){

			$to_location = $_POST["to_location"];

			create_transportDB($conn,$customer_name,$from_location,$to_location,$start_date,$size);
		}else{
?>

<div class="middle">

	<div class="well col-md-8 col-md-offset-2">

	<form class="form-horizontal" id="create_form" method="post" >		
		<fieldset>
			<legend class="text-center">Create New Transport Package</legend>
				<div class="form-group">
					<label class="col-sm-3 control-label">Customer Name:-</label>
					<div class="col-sm-9">
						<input class="form-control" name="customer_name" type="text" <?php if(isset($customer_name)){ echo 'value="'.$customer_name.'"';} ?> placeholder="name" required>
					</div>
					<?php if(isset($error_customer_name)){echo $error_customer_name;} ?>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">From Location:-</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="from_location" value = "<?php echo getLocation($_SESSION["office_id"],$conn); ?>" placeholder="location">
					</div>
					<?php if(isset($error_from_location)){echo $error_from_location;} ?>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">To Location:-</label>
					<div class="col-sm-9">
						<select class="form-control" name="to_location">
						<?php
							createToLocationOptions($conn);
						 ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Start Date:-</label>
					<div class="col-sm-9">
						<input class="form-control" type="date" name="start_date" <?php if(isset($start_date)){ echo 'value="'.$start_date.'"';} ?> placeholder="date">
					</div>
					<?php if(isset($error_start_date)){echo $error_start_date;} ?>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Size:-</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" name="size" <?php if(isset($size)){ echo 'value="'.$size.'"';} ?> placeholder="size">
					</div>
					<?php if(isset($error_size)){echo $error_size;} ?>
				</div>
				<div class="form-group">
					<div class="col-sm-1 col-sm-offset-10">
						<button type="submit" id="form_create_btn" class="btn btn-primary">Create</button>
					</div>
				</div>
		</fieldset>
	</form>
	</div>
</div>

<script>

	$("#form_create_btn").click(function(e){
            e.preventDefault();
            
            $.post( "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>", $( "#create_form" ).serialize()).done(function( data ) {
				  $(".main").html(data);				 
				} );
		
    });   
 

</script>

<?php }



	function create_transportDB($conn,$customer_name,$from_location,$to_location,$start_date,$size){

		$map =& createMap();

	//	echo "after createMap()";

		

		$sql = 'SELECT a.id "from_location_id", b.id "to_location_id"
				FROM office a, office b 
				WHERE a.location ='. "'{$from_location}'" .
				" AND b.location = '{$to_location}'"
				;

		$result = mysql_query($sql,$conn);

		$to_location_id = "";
		$from_location_id = "";

		while($row = mysql_fetch_array($result)){
			$to_location_id = $row['to_location_id'];
			$from_location_id = $row['from_location_id'];
		}

		
	//	echo "from_location " . $from_location_id . "<br/>";
	//	echo "to_location " . $to_location_id . "<br/>";

	//	echo "before createPath <br>";
		$path =& createPath($map,$from_location_id,$to_location_id); 
		
		
		$stringPath = implode($path,"#");;
		/*
		
		foreach ($path as $key => $value) {
			global $stringPath;
			$stringPath .= $value . "#";
		}

		$stringPath .= $to_location_id;
		*/

	//	echo "String Path : " . $stringPath . "<br/>";

	$sql = "INSERT INTO transport(customer_name,from_location,to_location,start_date,size,path)
			values('$customer_name','$from_location','$to_location','$start_date',$size,'$stringPath')
			";

	$status =  mysql_query($sql,$conn);

	$id = mysql_insert_id();

	insertToTruck($id,$_SESSION["office_id"],$conn);

	if($status){
		transport_submit($id,$customer_name,$from_location,$to_location,$start_date,$size);
	}else{
		echo '
				<div class="middle">
					<h1>Error</h1>
				</div> ';
	}
	}


	function transport_submit($id,$customer_name,$from_location,$to_location,$start_date,$size){

 ?>

 	<div class="middle">

			<div class="well col-md-8 col-md-offset-1">
					<div class="row">
							<h3 class="text-center"><u>Transport ID # <?php echo $id; ?></u></h3>
					</div>
					<hr>
					<div class="row">
						<div class="col-sm-5">
							<h4 class="text-right">Customer Name:-</h4>
						</div>
						<div class="col-sm-6">
							<h4 ><?php echo $customer_name; ?></h4>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-5">
							<h4 class="text-right">From Location:-</h4>
						</div>
						<div class="col-sm-6">
							<h4 ><?php echo $from_location; ?></h4>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-5">
							<h4 class="text-right">To Location:-</h4>
						</div>
						<div class="col-sm-6">
							<h4 ><?php echo $to_location; ?></h4>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-5">
							<h4 class="text-right">Start Date:-</h4>
						</div>
						<div class="col-sm-6">
							<h4 ><?php echo $start_date; ?></h4>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-5">
							<h4 class="text-right">Size:-</h4>
						</div>
						<div class="col-sm-6">
							<h4 ><?php echo $size; ?></h4>
						</div>
					</div>
					
			</div>
	</div>

 <?php
 	}
  ?>