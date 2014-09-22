<h1>Search Office</h1>
<div class="middle">
	<form class="form-horizontal" id="search_office_form" method="post">		
		<div class="form-group">
			<label class="col-sm-3 control-label">Location Name:-</label>
			<div class="col-sm-3">
				<input class="form-control" name="location_name" type="text" placeholder="name" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label">Office Type:-</label>
			<div class="col-sm-3">
				<select name="office_type" class="form-control" >
				  	<option>head_office</option>
					<option>sub_office</option>
				</select>
			</div>
		</div>	
		<div class="form-group">
			<div class="col-sm-2 col-sm-offset-3">
				<button type="submit" id="form_search_btn" class="btn btn-default">Search Office</button>
			</div>
		</div>
	</form>
</div>

<script>
	

	 $("#form_search_btn").click(function(e){
            e.preventDefault();
            var serialize = $("#search_office_form").serialize()+"&search=0";
           
            $.post("http://localhost/pak_china_template/helper/admin/office/search_office_submit.php",serialize).done(function( data ) {
				  $(".main").html(data);				 
				} );
			
			console.log(serialize);
		
    });   
</script>