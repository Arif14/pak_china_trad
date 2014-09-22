<?php 

	include("../../helper_functions.php");
	
		$conn = checkSessionStatus_and_connect();

		
		if(!$conn){
			die("session not connected");
		}
		
		function createQuery($person_name,$join_date,$office_id){
			
			$sql = 'SELECT *
					FROM employee e 
					WHERE ';

			$sql .= "TRUE";
			
			if(strcmp($office_id,"")){
				$sql .= " AND location_id =  {$office_id}";
			}
			if(strcmp($join_date,"")){
				$sql .= " AND join_date =  '{$join_date}'";
			}

			if(strcmp($person_name,"")){
				$sql .= " AND person_name =  '{$person_name}'";
			}

			//$sql .= $where;
			echo $sql."</br>";
			return $sql;

		}

		if($_SERVER["REQUEST_METHOD"] == "POST"){
			searchResult($conn);
		}else{

	echo '<h1>Search Employee</h1>';



?>

<div class="middle">
	<form class="form-horizontal" id="search_employee_form" method="post" >		
		<div class="form-group">
			<label class="col-sm-3 control-label">Person Name:-</label>
			<div class="col-sm-3">
				<input class="form-control" name="person_name" type="text" placeholder="name" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">Join Date:-</label>
			<div class="col-sm-3">
				<input class="form-control" type="date" name="join_date" placeholder="date">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">Office ID:-</label>
			<div class="col-sm-3">
				<input class="form-control" name="office_id" type="number" placeholder="name" required>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-2 col-sm-offset-3">
				<button type="submit" id="search_employee_btn" class="btn btn-default">Search</button>
			</div>
		</div>
	</form>
</div>

<script>
	

	 $("#search_employee_btn").click(function(e){
            e.preventDefault();
            var serialize = $("#search_employee_form").serialize();
           
            $.post("<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>",serialize).done(function( data ) {
				  $(".main").html(data);				 
				} );
			
			console.log(serialize);
		
    });   
</script>



<?php

		}
	function searchResult($conn){

	

 ?>


<div class="middle">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>Employee Id</th>
				<th>Person Name</th>
				<th>Join Date</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Location Id</th>
				<?php if(isset($_POST['delete'])){
					echo "<th>Delete</th>";
				}						
				 ?>
				
			</tr>
		</thead>
		<tbody>
			
				<?php 
					
					$sql = createQuery(test_input($_POST['person_name']),test_input($_POST['join_date']),test_input($_POST['office_id']));

					$result = mysql_query($sql,$conn);


					while($row = mysql_fetch_array($result)){
						$html =  " <tr> 
										<td>{$row['id']}</td>
										<td>{$row['person_name']}</td>
										<td>{$row['join_date']}</td>
										<td>{$row['email']}</td>
										<td>{$row['phone']}</td>
										<td>{$row['location_id']}</td>

										";
						if(isset($_POST['delete'])){

						$html .= '<td><button type="button" my_id = '.$row['id'].' class="btn btn-danger del_btn">Delete</button></td>';

						}
						$html .= "</tr>";

						echo $html;
						
					}
				?>
			
		</tbody>
	</table>

	
</div>

<script>
	$(".del_btn").on("click",function(e){
		e.preventDefault();
		var id =  $(this).attr('my_id');
		
		console.log($(this).parent().parent().remove());

		//$.post( "http://localhost/pak_china_template/helper/admin/office/delete_office_submit.php", {my_id: id} );
	});

</script>


<?php } ?>
