<?php	require_once('../../../lib/inspekt/Inspekt.php');	
		include("../../helper_functions.php");

		$conn = checkSessionStatus_and_connect();
		if(!$conn){
			die("session not connected");
		}



		if ($_SERVER["REQUEST_METHOD"] == "POST"){
				$validated = true;
				
				if(isset($_POST['person_name'])){ $person_name = test_input($_POST['person_name']);}
				if(isset($_POST['join_date'])){ $join_date = test_input($_POST['join_date']);}
				if(isset($_POST['email'])){ $email = test_input($_POST['email']);}
				if(isset($_POST['phone'])){ $phone = test_input($_POST['phone']);}
				if(isset($_POST['assign_office'])){ $assign_office = test_input($_POST['assign_office']);}

				if(!Inspekt::isAlpha($person_name)){ 
					$error_person_name = '<label class="text-danger">Invalid Person Name</label>';
					$validated = false;
				}
				if(!Inspekt::isDate($join_date)){ 
					$error_join_date = '<label class="text-danger">Invalid Join Date</label>';
					$validated = false;
				}
				if(!Inspekt::isEmail($email)){ 
					$error_email = '<label class="text-danger">Invalid Email</label>';
					$validated = false;
				}
				if(!Inspekt::isInt($phone)){ 
					$error_phone = '<label class="text-danger">Invalid Phone</label>';
					$validated = false;
				}
				if(!Inspekt::isInt($assign_office)){ 
					$error_assign_office = '<label class="text-danger">Invalid Assign_office</label>';
					$validated = false;
				}
				

		}

		if(isset($validated) && $validated){
			create_employeeDB($conn,$person_name,$join_date,$email,$phone,$assign_office);
			echo "<h1>submit</h1>";
		}else{

?>

<div class="middle">
	<form class="form-horizontal" id="create_employee_form" method="post" action="http://localhost/pak_china_template/helper/dashboard_create_submit.php">		
		<div class="form-group">
			<label class="col-sm-3 control-label">Person Name:-</label>
			<div class="col-sm-3">
				<input class="form-control" name="person_name"  <?php if(isset($person_name)){ echo 'value="'.$person_name.'"';} ?> placeholder="name" required>
			</div>
			<?php if(isset($error_person_name)){echo $error_person_name;} ?>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">Join Date:-</label>
			<div class="col-sm-3">
				<input class="form-control" type="date" <?php if(isset($join_date)){ echo 'value="'.$join_date.'"';} ?> name="join_date" placeholder="date">
			</div>
			<?php if(isset($error_join_date)){echo $error_join_date;} ?>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">Email:-</label>
			<div class="col-sm-3">
				<input class="form-control" type="email" <?php if(isset($email)){ echo 'value="'.$email.'"';} ?> name="email" placeholder="email">
			</div>
			<?php if(isset($error_email)){echo $error_email;} ?>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">Phone:-</label>
			<div class="col-sm-3">
				<input class="form-control" type="tel" <?php if(isset($phone)){ echo 'value="'.$phone.'"';} ?> name="phone" placeholder="phone">
			</div>
			<?php if(isset($error_phone)){echo $error_phone;} ?>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">Assign Office:-</label>
			<div class="col-sm-3">
				<input class="form-control" type="number" <?php if(isset($assign_office)){ echo 'value="'.$assign_office.'"';} ?> name="assign_office" placeholder="Office ID">
			</div>
			<?php if(isset($error_assign_office)){echo $error_assign_office;} ?>
		</div>
		<div class="form-group">
			<div class="col-sm-2 col-sm-offset-3">
				<button type="submit" id="form_create_btn" class="btn btn-default">Create Employee</button>
			</div>
		</div>
	</form>
</div>

<script>
	
	 $("#form_create_btn").click(function(e){
            e.preventDefault();
            
            var serialize = $("#create_employee_form").serialize();

            $.post(" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> ",serialize).done(function( data ) {
				  $(".main").html(data);				 
				} );
			
		
    });   
	// console.log("after");
</script>

<?php } 

	function create_employeeDB($conn,$person_name,$join_date,$email,$phone,$assign_office){

			$sql = "INSERT INTO employee(person_name,join_date,email,phone,location_id)
					 VALUES('$person_name','$join_date','$email',$phone,$assign_office)";
			echo $sql . "</br>";

			mysql_query($sql,$conn);


	}

?>