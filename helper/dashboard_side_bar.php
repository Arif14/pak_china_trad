<?php

function sidebar_subOffice(){

	echo '<li class="inactive"><a href="http://localhost/pak_china_template/helper/dashboard_profile.php">Profile</a></li>
  <li class="inactive"><a href="http://localhost/pak_china_template/helper/dashboard_update_status.php">Update Status</a></li>
	<li class="inactive"><a href="http://localhost/pak_china_template/helper/dashboard_delivery_status.php">Delivery Status</a></li>
	<li class="inactive"><a href="http://localhost/pak_china_template/helper/dashboard_send.php">Send</a></li>';	
}

function sidebar_headOffice(){

	echo '<li class="inactive"><a href="http://localhost/pak_china_template/helper/dashboard_profile.php">Profile</a></li>
	<li class="inactive"><a href="http://localhost/pak_china_template/helper/dashboard_create.php">Create New</a></li>
	<li class="inactive"><a href="http://localhost/pak_china_template/helper/dashboard_search.php">Search Transport</a></li>
	<li class="inactive"><a href="http://localhost/pak_china_template/helper/dashboard_search_truck.php">Search Truck</a></li>
	<li class="inactive"><a href="http://localhost/pak_china_template/helper/dashboard_send.php">Send</a></li>';

}


function sidebar_adminPanel(){
	echo '<li class="unexpand">
           <a>Office</a>
            <ul class="hidden">
                <li class="sub"><a href="http://localhost/pak_china_template/helper/admin/office/create_office.php">Create Office</a></li>
                <li class="sub"><a href="http://localhost/pak_china_template/helper/admin/office/delete_office.php">Delete Office</a></li>
                <li class="sub"><a href="http://localhost/pak_china_template/helper/admin/office/search_office.php">Search Office</a></li>
             </ul>    
        </li>
         <li class="unexpand">
         	<a>Employee</a>
             <ul class="hidden">
                <li class="sub"><a href="http://localhost/pak_china_template/helper/admin/employee/create_employee.php">Create Employee</a></li>
                <li class="sub"><a href="http://localhost/pak_china_template/helper/admin/employee/delete_employee.php">Delete Employee</a></li>
                <li class="sub"><a href="http://localhost/pak_china_template/helper/admin/employee/search_employee.php">Search Employee</a></li>
             </ul>      
          </li>
          <li class="unexpand">
           <a>User Accounts</a>
            <ul class="hidden">
                <li class="sub"><a href="http://localhost/pak_china_template/helper/admin/user_account/create_account.php">Create Account</a></li>
                <li class="sub"><a href="http://localhost/pak_china_template/helper/admin/user_account/search_user_account.php">Search/Edit Account</a></li>
             </ul>    
            </li>
          ';

}


?>