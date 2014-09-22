
<?php

	require_once('../../../lib/inspekt/Inspekt.php');	
		include("../../helper_functions.php");

		$conn = checkSessionStatus_and_connect();
		if(!$conn){
			die("session not connected");
		}


		function createQuery($username,$employee_id){

			$sql = 'SELECT *
					FROM user_account o 
					WHERE ';
			$where = "TRUE";
			
			if(strcmp($username,"")){
				$where .= " AND username =  '{$username}'";
			}
			if(strcmp($employee_id,"")){
				$where .= " AND employee_id =  '{$employee_id}'";
			}

			$sql .= $where;
			//echo $sql."</br>";
			return $sql;

		}

		
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$username = $_POST['username'];
			$employee_id = $_POST['employee_id'];
			account_result_table($conn,$username,$employee_id);
		}else if(isset($_GET['user_id'])){
			$id = $_GET['user_id'];
			$sql = "Delete FROM user_account
					WHERE id = {$id}";

			mysql_query($sql,$conn);
		}else{
	

?>

<h1>Search User Account</h1>
<div class="middle">
	<form class="form-horizontal" id="search_account_form">
		<div class="form-group">
			<label class="col-sm-3 control-label">UserName:-</label>
			<div class="col-sm-3">
				<input class="form-control" name="username" placeholder="username">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">Employee Id:-</label>
			<div class="col-sm-3">
				<input class="form-control" name="employee_id" placeholder = "employee id">
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-2 col-sm-offset-3">
				<button class="btn btn-default" id="search_account_btn">Search Account</button>
			</div>
		</div>
	</form>
</div>

<script>
	
	$("#search_account_btn").click(function(e){
		e.preventDefault();

		var serialize =  $("#search_account_form").serialize();
		$.post("<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>",serialize).done(function(data){
			$(".main").html(data);
		});

	});


</script>


<?php

	}

	function account_result_table($conn,$username,$employee_id){

?>

	<div class="middle">
		<table class="table table-bordered">
			<tr>
				<th>Id</th>
				<th>UserName</th>
				<th>Password</th>
				<th>Employee Id</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
			
			<?php

				$sql = createQuery($username,$employee_id);

				//echo $sql."<br>";

				$result = mysql_query($sql,$conn);

				while($row = mysql_fetch_array($result)){

					echo " <tr>
								<td>{$row['id']}</td>
								<td>{$row['username']}</td>
								<td>{$row['password']}</td>
								<td>{$row['employee_id']}</td>".
								'<th><button class="btn btn-primary edit_btn" user_id = "'.$row["id"].'">Edit</button></td>
								<th><button class = "btn btn-danger delete_btn" user_id = "'.$row["id"].'">Delete</button></td>'.
						  "</tr>
					  ";
				}

				

			?>
			

		</table>
	</div>

	<script>

	$(".edit_btn").click(function(e){

		var url  = "./helper/admin/user_account/create_account.php?user_id=";
			url += $(this).attr("user_id");

		console.log(url);

		$.get(url,function(data){
			$(".main").html(data);
		});
	});

	$(".delete_btn").click(function(e){

		console.log("delete clicked");
		var url = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>";
		console.log(url);
		url += "?user_id=" + $(this).attr("user_id");
		console.log(url);
		$(this).parent().parent().remove();
		$.get(url,function(data){
			
		});

	});

	</script>

<?php
		}
 ?>

