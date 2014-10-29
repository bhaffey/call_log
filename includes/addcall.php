<?php

if (!isset($_SESSION)) {
     session_start();
 }

if (!defined('ROOT')) {
    define('ROOT', "..");
}

require_once ("../config/config.php");

$db = DB::getInstance();

//check and make sure the user is logged in
if (!$_SESSION['user_login_status']) {
  header("Location: ../index.php");
}

if (isset($_POST['submit']) && isset($_POST['type']) && isset($_POST['outcome'])) {
  $insert = array(
    'user_id' => $_SESSION['user_fullname'],
    'timestamp' => $_POST['datetime']
    );
  //Store studentUID in Banner
  if (isset($_POST['studentUID'])) {
    $uid = @strip_tags($_POST['studentUID']);
    $uid = @stripslashes($uid);
    //$uid = mysql_real_escape_string($uid);
    $insert['studentUID'] = $uid;
  }
  //Store Other_Comment in Banner
  if (isset($_POST['other'])) {
    $comment = @strip_tags($_POST['other']);
    $comment = @stripslashes($comment);
  //$comment = mysql_real_escape_string($comment);
    $insert['Other_Comment'] = $comment;
  }

  foreach ($_POST['type'] as $key => $value) {
    $insert[$value] = 1;
  }

  foreach ($_POST['outcome'] as $key => $value) {
    $insert[$value] = 1;
  }

  $columns = array_keys($insert);
  $columns = implode(",", $columns);

  $values = array_values($insert);

  $binds = implode(',', array_fill(0, count($insert), '?'));

  $sql = "INSERT INTO `calls` ($columns) VALUES ($binds) ";

  if ($query = $db->prepare($sql)) {
    if ($query->execute($values)) {
      header("Location: ../index.php");
    } else {
    	echo $sql;
    	 
        echo "<br>There Was an Error submitting Your Call Data, Please Contact an Administrator";
    }
  }
} else {
	header("Location: ../index.php");
}