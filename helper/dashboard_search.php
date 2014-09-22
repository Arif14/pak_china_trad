<?php 
	require_once('../lib/inspekt/Inspekt.php');	

	include("helper_functions.php");
	
		$conn = checkSessionStatus_and_connect();
		if(!$conn){
			die("session not connected");
		}

		if ($_SERVER["REQUEST_METHOD"] == "POST"){
				$validated = true;

				if(isset($_POST['transport_id'])){ $transport_id = test_input($_POST['transport_id']);}
				
				
				if(!Inspekt::isInt($transport_id)){ 
					$error_transport_id = '<label class="text-danger col-sm-4 col-sm-offset-3">Invalid Transport Id</label>';
					$validated = false;
				}


		}


		if(isset($validated) && $validated){

			search_submit($conn,$transport_id);
			//create_transportDB($conn,$customer_name,$from_location,$to_location,$start_date,$size);
			//echo "Validated";
		}else{

?>

<div class="middle">

 <div class="well col-md-8 col-md-offset-2">
	<form class="form-horizontal" id="search_form">		
		<fieldset>
		<legend class="text-center">Search Transport</legend>
		<div class="form-group">
			<label class="col-sm-3 control-label">Transport Id:-</label>
			<div class="col-sm-9">
				<input class="form-control" type="text" name="transport_id" <?php if(isset($transport_id)){ echo 'value="'.$transport_id.'"';} ?> placeholder="id">
			</div>
			<?php if(isset($error_transport_id)){echo $error_transport_id;} ?>
		</div>
		<div class="form-group">
			<div class="col-sm-2 col-sm-offset-6">
				<button type="submit" id="form_search_btn" class="btn btn-primary">Search</button>
			</div>
		</div>
		</fieldset>
	</form>
	</div>
</div>

<script>

	$("#form_search_btn").click(function(e){
            e.preventDefault();
            
            $.post( "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>", $( "#search_form" ).serialize()).done(function( data ) {
				  $(".main").html(data);				 
				} );
		
    });   
 

</script>


<?php


	}


	function search_submit($conn,$id){


 ?>

 <div class="middle">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>Transport Id</th>
				<th>Customer Name</th>
				<th>From Location</th>
				<th>To Location</th>
				<th>Start</th>
				<th>End</th>
				<th>Size</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<?php 
					$sql = "SELECT * 
							FROM transport
							WHERE id = {$id}";

					$result = mysql_query($sql,$conn);


					while($row = mysql_fetch_array($result)){
						echo "  <td>{$row['id']}</td>
								<td>{$row['customer_name']}</td>
								<td>{$row['from_location']}</td>
								<td>{$row['to_location']}</td>
								<td>{$row['start_date']}</td>
								<td>{$row['end_date']}</td>
								<td>{$row['status']}</td>
								<td>{$row['size']}</td>
						";
					}
				?>
			</tr>
		</tbody>
	</table>
	<div class="col-sm-1 col-sm-offset-11">
		<button class="btn btn-primary" id="details_btn">Details</button>
	</div>
</div>


<?php global $conn; db_connect_footer($conn) ?>

<script>
	
	$("#details_btn").click(function(e){
		console.log("clicked");
		$(".main").load("http://localhost/pak_china_template/helper/dashboard_search_details.php?transport_id="+<?php echo $id; ?>);
	});

</script>

 <?php } ?>