<?php
/*
# Shane Kirk - OSA - Call Log ^2
# @changepass.php - View for facilitating user to change their password
*/
if (!$_SESSION['user_login_status']) {
  header("Location: ../index.php");
}

if (isset($changepass->messages)) {
    if (in_array('Your password has been changed, You must Login again.', $changepass->messages)) {
        header('Refresh: 1; URL=index.php?logout');
    }
}
?>
<!doctype html>
<!-- CSS -->
<link rel="stylesheet" href="css/structure.css" type="text/css" />
<link rel="stylesheet" href="css/form.css" type="text/css" />
<link rel="stylesheet" href="css/theme.css" type="text/css" />
<head>
<style>
</style>
<title>OSA Password Change</title>
</head>
<body id="public">
<div id="container">

<!-- LOGO + TITLE -->
<div id="pacelogo"><h1><img src="images/pacelogosmaller.jpg" ></h1></div>
<div id="title"><h1>OSA Solution Center<br>Call Log</h1></div>

<!-- password change form -->
<form method="post" action="changepass.php" name="changepassform" id="changepass">
<div>
<table width="510" border="0" align="center">
  <tr><td colspan="2" align="center"><p><h1><strong>Change <?php echo $_SESSION['user_fullname']; ?>'s password</strong></h1></p></td></tr>
  <tr><td colspan="2" align="center" id="errors">
  
<?php
// show potential errors / feedback (from PasswordChange object)
if (isset($changepass)) {
  if ($changepass->errors) {
    foreach ($changepass->errors as $error) {
      echo $error;
    }
  }
  
  if ($changepass->messages) {
    foreach ($changepass->messages as $message) {
      echo $message;
    }
  }
}
?>
  </td></tr>
  <tr>
    <td align="right">CURRENT PASSWORD:</td>
    <td align="left"><input id="login_input_password_old" class="login_input" type="password" name="user_password_old" pattern=".{6,}" required autocomplete="off" /></td>
  </tr>
  <tr>
    <td align="right">NEW PASSWORD:</td>
    <td align="left"><input id="login_input_password_new" class="login_input" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" /></td>
  </tr>
  <tr>
    <td align="right">CONFRIM NEW PASSWORD:</td>
    <td align="left"><input id="login_input_password_repeat" class="login_input" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" /></td>
  </tr>
  <tr><td>&nbsp;</td></tr>
  <tr>
    <td align="center" colspan="2" class="submitbutton"><input type="submit"  name="changepass" value="Submit" onClick="return confirm('Confirm Password Change');"/>
    &nbsp;&nbsp;<input type="button" name="button" id="button" value="Cancel" onClick="window.location.href='index.php'" /></td>
  </tr>
</table>
</div>
</form>
</div>
</body>
</html>
