<?php 

	echo '<h1>Delete Employee</h1>';

?>

<div class="middle">
	<form class="form-horizontal" id="delete_employee_form" method="post">		
		
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
				<button type="submit" id="delete_employee_btn" class="btn btn-default">Search</button>
			</div>
		</div>
	</form>
</div>

<script>
	

	 $("#delete_employee_btn").click(function(e){
            e.preventDefault();
            var serialize = $("#delete_employee_form").serialize();
           	    serialize += "&delete=0";
            $.post("/pak_china_template/helper/admin/employee/search_employee.php",serialize).done(function( data ) {
				  $(".main").html(data);				 
				} );
			
			console.log(serialize);
		
    });   
</script>
