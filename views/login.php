<?php
/*
# 
#
# @login.php - View for facilitating user login
*/
if ($login->isUserLoggedIn()) {
    // the user is logged in
    include 'calllog.php';
}
?>
<!doctype html>
<!-- CSS -->
<link rel="stylesheet" href="css/structure.css" type="text/css" />
<link rel="stylesheet" href="css/form.css" type="text/css" />
<link rel="stylesheet" href="css/theme.css" type="text/css" />
<head>
<title>OSA Login Form</title>
</head>
<body id="public">
<div id="container">
<!-- LOGO + TITLE -->
<div id="pacelogo"><h1><img src="images/pacelogosmaller.jpg" ></h1></div>
<div id="title"><h1>OSA Solution Center<br>Call Log</h1></div>
<form name="loginform" action="index.php" method="post">
<table width="310" border="0" align="center">
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>

        <tr><td colspan="2" align="center" id="errors"><?php
            if (isset($login)) {

                if ($login->errors) {

                    foreach ($login->errors as $error) {

                        echo $error;
                    }
                }

                if ($login->messages) {

                    foreach ($login->messages as $message) {

                        echo $message;
                    }
                }
            } else {
                echo'&nbsp;';
                }
            ?></td></tr>
            <td align="right">USERNAME:</td>
            <td align="left"><input type="text" class="login_input" id="login_input_user_name" name="user_name" autocomplete="off" required></td>
        </tr>
        <tr>
            <td align="right">PASSWORD:</td>
            <td align="left"><input type="password" class="login_input" id="login_input_password" name="user_password" autocomplete="off" required></td>
            <td></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td align="center" colspan="2" class="submitbutton"><input type="submit" name="login" id="button" value="LOG IN" /></td>
        </tr>
    </table>
</form>
</div>
</body>
</html>