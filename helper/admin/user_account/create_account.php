<?php 
	require_once('../../../lib/inspekt/Inspekt.php');	
		include("../../helper_functions.php");

		$conn = checkSessionStatus_and_connect();
		if(!$conn){
			die("session not connected");
		}


		if(isset($_GET["user_id"])){
			$id = $_GET["user_id"];
			$sql = "SELECT * FROM user_account
					WHERE id = {$id}";
			$result = mysql_query($sql);

			while($row = mysql_fetch_array($result)){
				$username = $row['username'];
				$password = $row['password'];
				$employee_id = $row['employee_id'];
			}


		}




		if ($_SERVER["REQUEST_METHOD"] == "POST"){
				$validated = true;

				if(isset($_POST['username'])){ $username = test_input($_POST['username']);}
				if(isset($_POST['password'])){ $password = test_input($_POST['password']);}
				if(isset($_POST['employee_id'])){ $employee_id = test_input($_POST['employee_id']);}
				
				if(!Inspekt::isAlnum($username)){ 
					$error_username = '<label class="text-danger">Invalid Username</label>';
					$validated = false;
				}
				if(!Inspekt::isAlnum($password)){ 
					$error_password = '<label class="text-danger">Invalid Password</label>';
					$validated = false;
				}
				if(!Inspekt::isInt($employee_id)){ 
					$error_employee_id = '<label class="text-danger">Invalid Employee Id</label>';
					$validated = false;
				}


		}

		if(isset($_POST['user_id'])){
			echo "inside isset post userid<br>";
			update_accountDB($conn,$username,$password,$employee_id);
		}else if(isset($validated) && $validated && !isset($_POST['user_id'])){
			create_accountDB($conn,$username,$password,$employee_id);
			echo "inside isset post validated <br>";
			//echo "<h1>submit</h1>";
		}else{

?>

<h1>Create User account </h1>

<div class="middle">
	<form class="form-horizontal" id="create_account_form">		
		<div class="form-group ">
			<label class="col-sm-3 control-label">UserName:-</label>
			<div class="col-sm-3">
				<input class="form-control" name="username" placeholder="username" <?php if(isset($username)){ echo 'value="'.$username.'"';}  ?> required>
			</div>	
			<?php if(isset($error_username)){echo $error_username;} ?>		
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">password:-</label>
			<div class="col-sm-3">
				<input class="form-control" name="password" type="password" placeholder="password" <?php if(isset($password)){ echo 'value="'.$password.'"';} ?> required>
			</div>
			<?php if(isset($error_password)){echo $error_password;} ?>
		</div>
		<div class="form-group ">
			<label class="col-sm-3 control-label">Employee Id:-</label>
			<div class="col-sm-3">
				<input class="form-control" name="employee_id" placeholder="Employee Id" <?php if(isset($employee_id)){ echo 'value="'.$employee_id.'"';} ?> required>
			</div>		
			<?php if(isset($error_employee_id)){echo $error_employee_id;} ?>	
		</div>
		<div class="form-group">
			<div class="col-sm-2 col-sm-offset-3">
			<?php 

				if(isset($_GET["user_id"])){
				echo '<button type="submit" id="form_edit_account_btn" user_id = "'.$_GET["user_id"].'" class="btn btn-default">Save</button>';

				}else{
				echo '<button type="submit" id="form_create_account_btn" class="btn btn-default">Create Account</button>';
				}
			?>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">

	$("#form_create_account_btn").click(function(e){
		e.preventDefault();

		var serialize = $("#create_account_form").serialize();

            $.post(" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> ",serialize).done(function( data ) {
				  $(".main").html(data);				 
				} );

	});

	$("#form_edit_account_btn").click(function(e){
		e.preventDefault();
		console.log("delete clicked");

		var url = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>";
		

		var serialize = $("#create_account_form").serialize();
		serialize += "&user_id="+$(this).attr("user_id");
		console.log(serialize);
		$.post(url,serialize,function(data){
			 $(".main").html(data);
		});



	});
	
	

</script>
<?php } 

	function update_accountDB($conn,$username,$password,$employee_id){
		$sql = "UPDATE user_account
				SET username = '{$username}',password = '{$password}'
				WHERE employee_id = {$employee_id}";
		$result =  mysql_query($sql,$conn);

		if($result){
			$id = $_POST['user_id'];
			createdAccountTable($id,$username,$password,$employee_id);
		}else{
			echo "<h1>Error In Submition</h1>";
		}
	}

	function create_accountDB($conn,$username,$password,$employee_id){

		$sql = "INSERT INTO user_account(username,password,employee_id)
				VALUES('$username','$password',$employee_id)";

		$result = mysql_query($sql,$conn);

		if($result){
			$id = mysql_insert_id();
			createdAccountTable($id,$username,$password,$employee_id);
		}else{
			echo "<h1>Error In Submition</h1>";
		}
	}

	function createdAccountTable($id,$username,$password,$employee_id){

?>
	
	<div class="middle">
		
		<table class="table table-bordered">
			<tr>
				<th>Id</th>
				<th>UserName</th>
				<th>Password</th>
				<th>Employee Id</th>
			</tr>
			<tr>
			<?php	echo "<td>{$id}</td>
						<td>{$username}</td>
						<td>{$password}</td>
						<td>{$employee_id}</td>
					  ";

			?>
			</tr>

		</table>

	</div>

	


<?php } 

	
?>

