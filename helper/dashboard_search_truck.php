<?php

	include("helper_functions.php");
	
		$conn = checkSessionStatus_and_connect();
		if(!$conn){
			die("session not connected");
		}

	$locations = getLocations($conn);


	

?>


<div class="middle">

<div class="well col-md-8 col-md-offset-2">
	<form class="form-horizontal" id="search_truck_form" method="post" action="http://localhost/pak_china_template/helper/dashboard_create_submit.php">		
		<fieldset>
		<legend class="text-center">Search Truck</legend>
		<div class="form-group">
			<label class="col-sm-3 control-label">From Location:-</label>
			<div class="col-sm-9">
				<select class="form-control" name="from_location">
				<?php
					echo "<option>none</option>";
					foreach ($locations as $key => $value) {
						echo "<option>" . $value . "</option>";
					}					
				 ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">To Location:-</label>
			<div class="col-sm-9">
				<select class="form-control" name="to_location">
				<?php
						echo "<option>none</option>";
					foreach ($locations as $key => $value) {
						echo "<option>" . $value . "</option>";
					}
				 ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">Date Send:-</label>
			<div class="col-sm-9">
				<input class="form-control" type="date" name="send_date" placeholder="date">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">Date Recieved:-</label>
			<div class="col-sm-9">
				<input class="form-control" type="date" name="recieve_date" placeholder="date">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-2 col-sm-offset-6">
				<button type="submit" id="form_search_truck_btn" class="btn btn-primary">Search</button>
			</div>
		</div>
		</fieldset>
	</form>
	</div>
</div>

<script>

	$("#form_search_truck_btn").click(function(e){
            e.preventDefault();
            
            $.post( "http://localhost/pak_china_template/helper/dashboard_search_truck_submit.php", $( "#search_truck_form" ).serialize()).done(function( data ) {
				  $(".main").html(data);				 
				} );
		
    });   
 

</script>