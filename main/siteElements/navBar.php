<?php
if(!isset($_SESSION["id"]) || !isset($_SESSION["user_status"]) || !isset($_SESSION["display_name"]) || !isset($_SESSION["user_type"])){
	header("Location: ../index.php");
}
else{
	switch($_SESSION["user_type"]){
		case 1:{?>
			<div id="nav">
				<ul>
					<li><a title="Home Page" href="./home.php"><span class="home">Home</span></a></li>
					<li><a title="Add a user" href="./User.php?mode=add"><span class="addUser">Add User</span></a></li>
					<li><a title="Add users in bulk from a CSV sheet" href="./User.php?mode=bulk"><span class="addBulkUsers">Add Users from CSV</span></a></li>
					<li><a title="View all the existing users" href="./User.php?mode=view"><span class="book">View Users</span></a></li>
					<li><a title="View the archived users" href="./archives.php?mode=view"><span class="book">View Archives</span></a></li>
					<li><a title="Download Center - Add Download" href="./CDC.php?mode=add"><span class="payslip">Add Download</span></a></li>
					<li><a title="Download Center - Manage Download" href="./CDC.php?mode=manage"><span class="payslip">Manage Downloads</span></a></li>
				</ul>
			</div>
		<?php break;
		}
		case 2:{?>
			<div id="nav">
				<ul>
					<li><a href="./home.php"><span class="home">Home</span></a></li>
					<li><a title="View the contacts" href="./contacts.php?mode=view"><span class="contacts">View Contacts</span></a></li>
					<li><a title="View the archived users" href="./archives.php?mode=view"><span class="book">View Archives</span></a></li>
					<li><a title="Download Center - Add Download" href="./CDC.php?mode=add"><span class="payslip">Add Download</span></a></li>
					<li><a title="Download Center - Manage Download" href="./CDC.php?mode=manage"><span class="payslip">Manage Downloads</span></a></li>
				</ul>
			</div>
		<?php break;
		}
		case 3:{?>
			<div id="nav">
				<ul>
					<li><a href="./home.php"><span class="home">Home</span></a></li>
					<li><a title="View the contacts" href="./contacts.php?mode=view"><span class="contacts">View Contacts</span></a></li>
					<li><a title="Download Center - Add Download" href="./CDC.php?mode=add"><span class="payslip">Add Download</span></a></li>
					<li><a title="Download Center - Manage Download" href="./CDC.php?mode=manage"><span class="payslip">Manage Downloads</span></a></li>
				</ul>
			</div>
		<?php break;
		}
		case 4:{?>
			<div id="nav">
				<ul>
					<li><a title="Home" href="./home.php"><span class="home">Home</span></a></li>
					<li><a title="View the contacts" href="./contacts.php?mode=view"><span class="contacts">View Contacts</span></a></li>
					<li><a title="Download Center - Add Download" href="./CDC.php?mode=add"><span class="payslip">Add Download</span></a></li>
					<li><a title="Download Center - Manage Download" href="./CDC.php?mode=manage"><span class="payslip">Manage Downloads</span></a></li>
				</ul>
			</div>
		<?php break;
		}
		default:{?>
			undefined user type.
		<?php break;
		}
	}
}?>