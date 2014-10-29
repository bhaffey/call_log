<?php
/*
# 
# @cpanel.php - View for facilitating Admin controls
*/

$db = DB::getInstance();

if (isset($registration->messages)) {
    if (in_array('User has been added successfully', $registration->messages)) {
        header('Refresh: 1; URL=controlpanel.php');
    }
}
?>
<!doctype html>
<html>
<head>
<!-- CSS -->
<link rel="stylesheet" href="css/structure.css" type="text/css" />
<link rel="stylesheet" href="css/form.css" type="text/css" />
<link rel="stylesheet" href="css/theme.css" type="text/css" />
<head>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script>
	$(document).ready(function() {
	$("#datepicker").datepicker();});
	$(document).ready(function() {
	$("#datepicker2").datepicker();});
</script>
<title>Admin Control Panel</title>
</head>
<body id="public">
<div id="container">
<div id="pacelogo"><h1><img src="images/pacelogosmaller.jpg" ></h1></div>
<div id="title"><h1>OSA Solution Center<br>Call Log Control Panel</h1></div>
<!-- ADMIN USER + CALLS LOGGED -->
<div id="user">
  <h2 style="margin-right: 30px; color: navy"><?php echo $_SESSION['user_fullname']; ?></h2>
  <h3 style="margin-right: 30px; color: navy">&nbsp;</h3>
  <h3><ul>
    <li><a href="index.php">Go Back....</a></li>
    <li><a href="index.php?logout">Logout</a></li>
    </ul></h3>
</div>
<form class="calllog" action="includes/results.php" method="post">
	<div align="center">
	<table>
		<tr><td align="center" colspan="4"><h1>Review Logs</h1></td></tr>
		</tr>
		<tr>
			<td align="right">From Date:</td><td><input id="datepicker" name="fromdate" value="All Dates"/></td>
		</tr>
		<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
		<tr>
			<td align="right">To Date:</td><td><input id="datepicker2" name="todate" value="All Dates"/></td>
		</tr>
		<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
		<tr>
    		<td align="center" colspan="4" class="submitbutton"><input type="submit"  name="changepass" value="Download"/>
    		<!-- &nbsp;&nbsp;<input type="button" name="button" id="button" value="Erase Logs" onClick="window.location.href='includes/cleardb.php'" /> -->
    		</td>
  		</tr>
	</table>
	</div>
</form>
<form method="post" action="controlpanel.php" name="registerform">
	<div align="center">
	<table>
		<tr><td align="center" colspan="4"><h1>Add New User</h1></td></tr>
		</tr>
		<tr><td align="center" colspan="4" id="errors">
<?php
// show potential errors / feedback (from PasswordChange object)
if (isset($registration)) {
	if ($registration->errors) {
    	foreach ($registration->errors as $error) {
        	echo $error;
        }
    }

    if ($registration->messages) {
        foreach ($registration->messages as $message) {
            echo $message;
        }
    }
} else {
	echo "&nbsp;";
}
?>
		</td></tr>
		<tr>
			<td align="right">Username:</td><td><input id="login_input_username" class="login_input" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" required /></td>
		</tr>
		<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
		<tr>
			<td align="right">User Email:</td><td><input id="login_input_email" class="login_input" type="email" name="user_email" required /></td>
		</tr>
		<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
		<tr>
			<td align="right">Password:</td><td><input id="login_input_password_new" class="login_input" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" /></td>
		</tr>
		<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
		<tr>
			<td align="right">Repeat Password:</td><td><input id="login_input_password_repeat" class="login_input" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" /></td>
		</tr>
		<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
  		<tr>
			<td align="center" colspan="2" class="submitbutton"><input type="submit" name="register" id="button" value="Register" onClick="return confirm('Confirm Registration Information');" /></td>
		</tr>
	</table>
	</div>
</form>
</div>
</body>
</html>