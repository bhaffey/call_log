<?php

if (!$_SESSION['user_login_status']) {
  header('URL=index.php');
}

//variables needed for log
$today = date("Y-m-d H:i:s");

//get the mysql db connection
$db = DB::getInstance();

//pass the userID from SESSION to query for calulating number of total calls
$user_id = $_SESSION['user_fullname'];

$sql = "SELECT count(*) FROM `calls` WHERE `user_id` = ? AND date(timestamp) = date(now())";

if ($query = $db->prepare($sql)) {
  
  if ($query->execute(array($user_id))) {

    $result = $query->fetch(PDO::FETCH_NUM);

    $numbersubmits = $result[0];
  }
}

echo "<script language='javascript' type='text/javascript'>arrayTranslate();</script>";

//DO NOT CLEAR FORM IF SUBMIT FAILED
if (!isset($_POST['outcome']) || !isset($_POST['type'])) {
    //echo "<button onClick='arrayTranslate()';>Array Translate</button>";
    //echo "<script>arrayTranslate();</script>";

    if (isset($_POST['studentUID'])) {
         $storeOutcome = $_POST['studentUID'];
            $value2 = json_encode($storeOutcome);
            //echo "<button onClick='reloadStudentUID($value2)';>Reload StudentUID</button>";
    }

    if (isset($_POST['outcome'])) {
         $storeOutcome = $_POST['outcome'];
            $value2 = json_encode($storeOutcome);  //Make variable readable to JavaScript
            //echo "<button onClick='reCheckBoxes($value2)';>Reload Values</button>";
            //echo "<script>window.onload='reCheckBoxes($value2)';</script>";
            //echo "<script>reCheckBoxes($value2);</script>";
            //echo "<script>alert($value2);</script>";
    }
    //print_r($storeOutcome);
    if (isset($_POST['type'])) {
         $storeType = $_POST['type'];
         $value2 = json_encode($storeType);
         echo "<button onClick='reCheckBoxes($value2)';>Reload Values</button>";
         //print_r($storeType);
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

<!-- FIELDS CHECK -->
<script type="text/javascript" language="JavaScript">
<!-- Function to Test Whether Fields Checked in Both Columns-->
function fieldscheck()
{
        <!-- If No Checkboxes Checked -->
        if(document.getElementById("411_OSA").checked == false && document.getElementById("411_Other").checked == false &&
           document.getElementById("Academic_Advising").checked == false && document.getElementById("Academic_Scheduling").checked == false &&
           document.getElementById("Admissions").checked == false && document.getElementById("Auxillary_Services").checked == false &&
           document.getElementById("CPE").checked == false && document.getElementById("Confirm_Receipt").checked == false &&
           document.getElementById("Degree_Audit").checked == false && document.getElementById("Financial_Aid").checked == false &&
           document.getElementById("Immunization").checked == false && document.getElementById("IT").checked == false &&
           document.getElementById("Other_Call_Type").checked == false &&
           document.getElementById("OSA_Appeals").checked == false && document.getElementById("Registration").checked == false &&
           document.getElementById("Residential_Life").checked == false && document.getElementById("Student_Accounts").checked == false &&
           document.getElementById("Student_Activities").checked == false && document.getElementById("TAP").checked == false &&
           document.getElementById("Transfer_Credit").checked == false && document.getElementById("Transcripts").checked == false &&
           document.getElementById("Verification").checked == false && document.getElementById("Veteran_Affairs").checked == false &&
           document.getElementById("Dead_Call_Type").checked == false && document.getElementById("Resolved").checked == false &&
           document.getElementById("Call_Back_Required").checked == false && document.getElementById("Ticket_Created").checked == false &&
           document.getElementById("TransferOSA").checked == false && document.getElementById("Transfer_NonOSA").checked == false &&
           document.getElementById("Other_Outcome").checked == false && document.getElementById("Dead_Call_Outcome").checked == false) {
                 alert("You have not checked any boxes.");

                 return false;

           } else {
        <!-- If No Call Type Checked -->
              if(document.getElementById("411_OSA").checked == false && document.getElementById("411_Other").checked == false &&
                document.getElementById("Academic_Advising").checked == false && document.getElementById("Academic_Scheduling").checked == false &&
                document.getElementById("Admissions").checked == false && document.getElementById("Auxillary_Services").checked == false &&
                document.getElementById("CPE").checked == false && document.getElementById("Confirm_Receipt").checked == false &&
                document.getElementById("Degree_Audit").checked == false && document.getElementById("Financial_Aid").checked == false &&
                document.getElementById("Immunization").checked == false && document.getElementById("IT").checked == false &&
                document.getElementById("Other_Call_Type").checked == false &&
                document.getElementById("OSA_Appeals").checked == false && document.getElementById("Registration").checked == false &&
                document.getElementById("Residential_Life").checked == false && document.getElementById("Student_Accounts").checked == false &&
                document.getElementById("Student_Activities").checked == false && document.getElementById("TAP").checked == false &&
                document.getElementById("Transfer_Credit").checked == false && document.getElementById("Transcripts").checked == false &&
                document.getElementById("Verification").checked == false && document.getElementById("Veteran_Affairs").checked == false &&
                document.getElementById("Dead_Call_Type").checked == false) {
                    alert("You have not chosen a Call Type.");
                    arrayTranslate();

                    return false;
                    }
        <!-- If No Call Outcome Checked -->
              if(document.getElementById("Resolved").checked == false && document.getElementById("Call_Back_Required").checked == false &&
                 document.getElementById("Ticket_Created").checked == false && document.getElementById("TransferOSA").checked == false &&
                 document.getElementById("Transfer_NonOSA").checked == false && document.getElementById("Other_Outcome").checked == false &&
                 document.getElementById("Dead_Call_Outcome").checked == false) {
                    alert("You have not chosen an Outcome Type.");
                    arrayTranslate();

                    return false;
               } else {
                return confirm('Confirm Call Log Submission');
        return true;
              }
         }
}

<!-- Function to Hide/Display Specific Elements or Remainder of Form -->
function displayResult(x)
{
document.getElementById(x).style.display="block";
}

function hideResult(y)
{
    document.getElementById(y).style.display="none";
}

<!--Display Other Text Box if Checked-->
function otherChecked()
{
        document.getElementById("hiddenTextBoxOther").style.display = 'block';
}
</script>

<script language='javascript' type='text/javascript'>
function reCheckBoxes(y)
{
  for (var i = 0; i < y.length; i++) {
     //alert(postArrayTypeCopy.toString());
     //alert(y[i]);
     document.getElementById(y[i]).checked="true";
    }
}

function reloadStudentUID(y)
{
     //alert(y);
     //document.getElementById(y).value = y;
}
</script>

<script language='javascript' type='text/javascript'>
function arrayTranslate()
{
    var postArrayTypeCopy = new Array();
  <?php foreach ($_POST['type'] as $key => $val) { ?>
      postArrayTypeCopy.push('<?php echo $val; ?>');
  <?php } ?>
  var postArrayOutcomeCopy = new Array();
  <?php foreach ($_POST['outcome'] as $key => $val) { ?>
      postArrayOutcomeCopy.push('<?php echo $val; ?>');
  <?php } ?>
  //reCheckBoxes(postArrayOutcomeCopy[]);
  //reCheckBoxes(postArrayTypeCopy[]);

  //alert(postArrayCopy.toString());
    //for (var i = 0; i < postArrayOutcomeCopy.length; i++) {
     //alert(postArrayOutcomeCopy.toString());
     //reCheckBoxes(postArrayOutcomeCopy[i]);
}
</script>
<title>OSA Call Log</title>
</head>
<body id="public">
<div id="container">

<!-- LOGO + TITLE -->
<div id="pacelogo"><h1><img src="images/pacelogosmaller.jpg" ></h1></div>
<div id="title"><h1>OSA Solution Center<br>Call Log</h1></div>

<!-- ADMIN USER + CALLS LOGGED -->
<div id="user">
  <h2 style="margin-right: 30px; color: navy"><?php echo $_SESSION['user_fullname']; ?></h2>
  <h3 style="margin-right: 30px; color: navy">Calls logged today: <?php echo $numbersubmits; ?></h3>
  <h3><ul>
    <li><a href="changepass.php">Change Password</a></li>
<?php

$group = $_SESSION['user_permission'];

if ($group == 2) {
  echo '<li><a href="controlpanel.php">Control Panel</a></li>';
} else {
  echo '<li>&nbsp;</li>';
}
?>
    <li><a href="index.php?logout">Logout</a></li>
    <li>
</div>

<!-- SEARCH UID AND RETURN FIRST, LAST NAME -->
<div id="studentinfo">
  <div class="info">&nbsp; </div>
    <form method="post" id="calllog" action="">
      <div style="text-align:center">
	      <p><em>Student's User ID: &nbsp;</em>
				<input type="text" id="studentUID" name="studentUID" value="U">
				&nbsp;&nbsp;<input type="submit" name="submit1" value="Search">
          </p>
		  <p>
			<input type="radio" id="noStudentUID" name="noStudentUID" value="N/A">
			<em>No Student User ID/Not Applicable</em>
          </p>
	  </div>
<?php


//Local Machine testing
$ociconn = oci_connect('osa_reports', 'o5a_r3port5', 'PROD') or
die ('Invalid UID. Error: <pre>' . print_r(oci_error(), 1) . '</pre>');

//OSA Dev
//putenv("TNS_ADMIN=/etc");
//$ociconn = @oci_connect('/', '', 'PROD_OSA_REPORTS', null, OCI_CRED_EXT);

if (!$ociconn) {
	die("Invalid Banner Connection.\n");
}


if (isset($_POST['submit1'])) {

  $studentUID=$_POST['studentUID'];
  $alreadyInvalid = 0;
  //verify input is valid
  //grab first character of studentID to ensure it is a capital U
  if (substr($studentUID, 0, 1) != 'U') {
    echo "<div style='text-align:center'>";
    echo "<p style='color:red'><b>The UID that you enter must start with the capital letter 'U'.</b></p>";
    echo "</div>";
    $alreadyInvalid++;
  }
//must be 9 digits (including the U)
  if (strlen($studentUID) != 9) {
    echo "<div style='text-align:center'>";
    echo "<p style='color:red'><b>The UID that you entered has the incorrect number of digits.</b></p>";
    echo "</div>";
    $alreadyInvalid++;
  }
//if input is 9 digits, print entered UID
  if (strlen($studentUID) == 9) {
    echo "<div style='text-align:center'>";
    echo("<h3 style='color:navy'><b>The UID that you entered was: </b>");
    print($studentUID);
    echo("</h3>");
    echo "</div>";
  } //closes else statement
//Fomulate Query Based on User UID Input
  $query = oci_parse($ociconn, "SELECT spriden_first_name, spriden_last_name FROM spriden WHERE spriden_change_ind is null AND spriden_id=:studentUID");
  oci_bind_by_name($query, ':studentUID', $studentUID);
  oci_execute($query);
  oci_fetch_all($query, $result,null,null,OCI_FETCHSTATEMENT_BY_ROW);

  if ((count($result) == 0) && ($alreadyInvalid == 0)) {
    echo "<div style='text-align:center'>";
    echo("<span style='color:red'><b>You have entered an invalid UID.  Please try again.</b></span>");
    echo "</div>";
  }
  //Print Out First Name, Last Name
  echo "<div style='text-align:center'>";
  for ($row = 0; ($row < count($result)); $row++) {
    echo("<h3><em>Student First Name: </em>");
    echo $result[$row]['SPRIDEN_FIRST_NAME'];
    echo("</h3>");
    echo("<h3><em>Student Last Name: </em>");
    echo $result[$row]['SPRIDEN_LAST_NAME'];
    echo("</h3>");
  }
  echo "</div>";
}
?>
          </p>
        </form>
      </div>
      
<!-- CALL LOG CHECKBOXES: CALL TYPE + CALL OUTCOME -->
<form name="logCheckboxes" class="calllog" action="includes/addcall.php" method="post" onSubmit="fieldscheck();">
<?php


//PASS STUDENTUID VALUE TO SECOND FORM
if (isset($_POST['submit1']) && ($alreadyInvalid == 0)) {
  echo ("<input type='hidden' name='studentUID'");
  echo ("value='$studentUID'");
  echo("/>");
}
?>
<div class="info">&nbsp; </div>
  <table width="100%">
        <tr>
            <td colspan="3" class="section first" align="center" style="padding-top:5px; padding-bottom:10px; color: red"><em>You must select at least one item from each column.</em></td>
        </tr>
        <tr>
            <td class="section first desc" align="center" colspan="2" style="padding-left: 50px"><h3> Call Type </h3><em>Choose All Applicable</em></td>
            <td class="section first" align="center" style="padding-bottom: 10px"><h3>Call Outcome</h3><em>Choose All Applicable</em></td>
        </tr>
  </table>
  <table>
        <tr>
            <td class="calltype">
               <ul>
            <li class="list">
            <span><input class="field checkbox" type="checkbox" id="411_OSA" name="type[]" value="411_OSA"/>
            <label class="choice">411 - OSA </label></span>
            <span><input class="field checkbox" type="checkbox" id="411_Other" name="type[]" value="411_Other" />
            <label class="choice">411 - Other</label></span>
            <span><input class="field checkbox" type="checkbox" id="Academic_Advising" value="Academic_Advising" />
            <label class="choice">Academic Advisement/Concerns</label></span>
            <span><input class="field checkbox" type="checkbox" id="Academic_Scheduling" value="Academic_Scheduling"/>
            <label class="choice">Academic Scheduling</label></span>
            <span><input class="field checkbox" type="checkbox" name="type[]" id="Admissions" value="Admissions"/>
            <label class="choice">Admissions</label></span>
            <span><input class="field checkbox" type="checkbox" name="type[]" id="Auxillary_Services" value="Auxillary_Services"/>
            <label class="choice">Auxillary Services</label></span>
            <span><input class="field checkbox" type="checkbox" name="type[]" id="CPE" value="CPE"/>
            <label class="choice">CPE</label></span>
            <span><input class="field checkbox" type="checkbox" name="type[]" id="Confirm_Receipt" value="Confirm_Receipt"/>
            <label class="choice">Confirm Receipt</label></span>
            <span><input class="field checkbox" type="checkbox" name="type[]" id="Degree_Audit" value="Degree_Audit"/>
            <label class="choice">Degree Audit</label></span>
            <span><input class="field checkbox" type="checkbox" name="type[]" id="Financial_Aid" value="Financial_Aid"/>
            <label class="choice">Financial Aid</label></span>
            <span><input class="field checkbox" type="checkbox" name="type[]" id="Immunization" value="Immunization"/>
            <label class="choice">Immunization</label></span>
            </li>
              </ul>
            </td>

    <td class="calltypecolumntwo">
              <ul>
                  <li class="list">
                  <div>
                  <span><input class="field checkbox" type="checkbox" name="type[]" id="IT" value="IT"/>
                  <label class="choice">IT</label></span>
                  <span><input class="field checkbox" type="checkbox" name="type[]" id="Other_Call_Type" value="Other_Call_Type" onClick="displayResult('hiddenTextBoxOther')"/>
                  <label class="choice">Other Call Type</label></span>
                  <span><input class="field checkbox" type="checkbox" name="type[]" id="OSA_Appeals" value="OSA_Appeals" onClick="help()" />
                  <label class="choice">OSA Appeals</label></span>
                  <span><input class="field checkbox" type="checkbox" name="type[]" id="Registration" value="Registration"/>
                  <label class="choice">Registration</label></span>
                  <span><input class="field checkbox" type="checkbox" name="type[]" id="Residential_Life" value="Residential_Life"/>
                  <label class="choice">Residential Life</label></span>
                  <span><input class="field checkbox" type="checkbox" name="type[]" id="Student_Accounts" value="Student_Accounts"/>
                  <label class="choice">Student Accounts</label></span>
                  <span><input class="field checkbox" type="checkbox" name="type[]" id="Student_Activities" value="Student_Activities"/>
                  <label class="choice">Student Activities</label></span>
                  <span><input class="field checkbox" type="checkbox" name="type[]" id="TAP" value="TAP"/>
                  <label class="choice">TAP</label></span>
                  <span><input class="field checkbox" type="checkbox" name="type[]" id="Transfer_Credit" value="Transfer_Credit"/>
                  <label class="choice">Transfer Credit</label></span>
                  <span><input class="field checkbox" type="checkbox" name="type[]" id="Transcripts" value="Transcripts"/>
                  <label class="choice">Transcripts</label></span>
                  <span><input class="field checkbox" type="checkbox" name="type[]" id="Verification" value="Verification"/>
                  <label class="choice">Verification</label></span>
                  <span><input class="field checkbox" type="checkbox" name="type[]" id="Veteran_Affairs" value="Veteran_Affairs"/>
                  <label class="choice">Veteran Affairs</label></span>
                  <span><input class="field checkbox" type="checkbox" name="type[]" id="Dead_Call_Type" value="Dead_Call_Type"/>
                  <label class="choice">Dead Call</label></span>
                  </div>
                  </li>
               </ul>
    </td>
    <td class="calloutcome">
             <ul>
              <li class="list">
              <div>
              <span><input class="field checkbox" type="checkbox" name="outcome[]" id="Resolved" value="Resolved"  />
              <label class="choice">Resolved</label></span>
              <span><input class="field checkbox" type="checkbox" name="outcome[]" id="Call_Back_Required" value="Call_Back_Required"/>
              <label class="choice">Call Back Required</label></span>
              <span><input class="field checkbox" type="checkbox" name="outcome[]" id="Ticket_Created" value="Ticket_Created"/>
              <label class="choice">Ticket Created</label></span>
              <span><input class="field checkbox" type="checkbox" name="outcome[]" id="TransferOSA" value="TransferOSA"/>
              <label class="choice">Transfer to OSA</label></span>
              <span><input class="field checkbox" type="checkbox" name="outcome[]" id="Transfer_NonOSA" value="Transfer_NonOSA"/>
              <label class="choice">Transfer to non-OSA</label></span>
              <span><input class="field checkbox" type="checkbox" name="outcome[]" id="Other_Outcome" value="Other_Outcome" onClick="displayResult('hiddenTextBoxOther')"/>
              <label class="choice">Other Outcome</label></span>
              <span><input class="field checkbox" type="checkbox" name="outcome[]" id="Dead_Call_Outcome" value="Dead_Call_Outcome"/>
              <label class="choice">Dead Call</label></span>
              </div></li>
             </ul>
    </td>
  </tr>
</table>

<!-- ENTER CALL DATA BUTTON -->
<div class="hiddenTextBoxOther" id="hiddenTextBoxOther" style="display:none">
     <p>Other (please briefly describe):</p>

     <input class="textBoxOther" type="text" name="other" id="Other_Comment" value=""/>
</div>

<div class="submitButton">
     <input type = "hidden" name="datetime" value="<?php echo $today; ?>">
     <input class="submitbutton" type="submit" name="submit" value="Submit to Call Log"  /></td>
</div>
</form>
</div><!--container-->
</body>
</html>
