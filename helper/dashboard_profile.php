<?php

	include("helper_functions.php");
	
		$conn = checkSessionStatus_and_connect();
		if(!$conn){
			die("session not connected");
		}



?>

<div class="middle">

	<div class="well col-md-8 col-md-offset-2">
		<div class="row">
				<h3 class="text-center"><u>Employee Profile</u></h3>
		</div>
		<hr>
		<div class="row">
			<div class="col-sm-5">
				<h4 class="text-right">Person Name :-</h4>
			</div>
			<div class="col-sm-6">
				<h4> <?php echo $_SESSION["person_name"] ?> </h4>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-5">
				<h4 class="text-right">Location :-</h4>
			</div>
			<div class="col-sm-6">
				<h4 > <?php echo $_SESSION["location"] ?></h4>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-5">
				<h4 class="text-right">Email :-</h4>
			</div>
			<div class="col-sm-6">
				<h4 > <?php echo $_SESSION["email"] ?></h4>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-5">
				<h4 class="text-right">Phone :-</h4>
			</div>
			<div class="col-sm-6">
				<h4 > <?php echo $_SESSION["phone"] ?></h4>
			</div>
		</div>
	</div>
</div>