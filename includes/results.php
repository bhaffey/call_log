<?php

if (!isset($_SESSION)) {
     session_start();
 }

if (!defined('ROOT')) {
    define('ROOT', "..");
}

require_once ("../config/config.php");

$db = DB::getInstance();

//check and make sure the user is an ADMIN
if (!$_SESSION['user_login_status'] && !$_SESSION['user_permission'] == 2) {
	header("Location: ../index.php");
}

/** Include path **/
ini_set('include_path', ini_get('include_path').'; ../Classes/');
set_include_path('../Classes');

/** PHPExcel */
include 'PHPExcel.php';
include 'PHPExcel/Writer/Excel2007.php';
include 'PHPExcel/Reader/Excel2007.php';
include 'PHPExcel/IOFactory.php';

function fillWorksheet($result, $wksht,$shtno) {

		global $objPHPExcel;

		$objWorksheet = $objPHPExcel->setActiveSheetIndex($wksht);

		//	Put into Excel
		// 	First Line
		$column_names = getL2Keys($result);

		$col_count = count($column_names);  // How many columns are there?

		$row = 1;
		$col = 0;  // only a to z
		foreach ($column_names as $key => $value) {
			// TRY TO ADD DATA
			$objWorksheet->setCellValueByColumnAndRow($col, $row, $value);

			$col++;
		} //foreach

		// Check if anything in A1, if no--empty and delete worksheet
		$a1 = $objPHPExcel->getActiveSheet()->getCell('A1')->getValue();

		if (!isset($a1) ) {

			echo 'NO DATA between those dates !!!</br>';
			echo $result;
			return;
		}

		// Add data
		$row = 2;

		foreach ($result as $key) {
			$col = 0;

			foreach ($key as $value) {
				// TRY TO ADD DATA
				$objWorksheet->setCellValueByColumnAndRow($col, $row, $value);
				$col++;
			}

			$row++;
		} //

		$thiscol='A';
		// TURN 1st ROW 90 degrees
		for ($i=0 ; $i < $col_count; $i++) {
			$objPHPExcel->getActiveSheet()->getStyle($thiscol.'1')->getAlignment()->setTextRotation(90);

			$objPHPExcel->getActiveSheet()->getStyle($thiscol.'1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			$objPHPExcel->getActiveSheet()->getStyle($thiscol.'1')->getFill()->getStartColor()->setRGB('E4EAF4');

			//	and AUTOSIZE THE COLUMNS
			$objPHPExcel->getActiveSheet()->getStyle($thiscol.'1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			//$objPHPExcel->getActiveSheet()->getColumnDimension($thiscol)->setAutoSize(true);
			if ($thiscol == 'A' || $thiscol == 'AH') {
				$objPHPExcel->getActiveSheet()->getColumnDimension($thiscol)->setWidth(20); }
			else {
					$objPHPExcel->getActiveSheet()->getColumnDimension($thiscol)->setWidth(3);
				}
				//increment the column
				$thiscol++;
		}

	} // FUNCTION

	function getL2Keys($array) {

		$mergedResult = array();
		foreach($array as $sub) {

			$mergedResult = array_merge((array)$mergedResult, (array)$sub);
		}

		return array_keys($mergedResult);
	}


	$today = date("Y-m-d H:i:s");

	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getDefaultStyle()->getFont()
	->setName('Calibri')
	->setSize(10);

	$fromdate = escape($_POST['fromdate']);
	$todate = escape($_POST['todate']);

	if ($fromdate == 'All Dates' || $todate == 'All Dates') {

		$sql = "	select 	user_id,

						sum(411_osa) as 411_OSA,
						sum(411_other) as 411_Other,
						sum(academic_advising) as Academic_Advisement,
						sum(academic_scheduling) as Academic_Scheduling,
						sum(admissions) as Admissions,
						sum(auxillary_services) as Auxillary_Services,
						sum(CPE) as CPE,
						sum(Confirm_Receipt) as Confirm_Receipt,
						sum(degree_audit) as Degree_Audit,
						sum(financial_aid) as Financial_Aid,
						sum(immunization) as Immunization,
						sum(IT) as IT,
						sum(Other_Outcome) as Other_Outcome,
						sum(OSA_appeals) as OSA_Appeals,
						sum(registration) as Registration,
						sum(residential_life) as Residential_Life,
						sum(student_accounts) as Student_Accounts,
						sum(student_activities) as Student_Activities,
						sum(TAP) as TAP,
						sum(transfer_credit) as Transfer_Credit,
						sum(transcripts) as Transcripts,
						sum(verification) as Verification,
						sum(veteran_affairs) as Veteran_Affairs,
						sum(Other_Call_Type) as Other_Call_Type,
						sum(Dead_Call_type)  as Dead_Call_Type,
						sum(resolved) as Resolved,
						sum(call_back_required) as Call_Back_Required,
						sum(ticket_created) as Ticket_Created,
						sum(transferOSA) as Transfer_OSA,
						sum(transfer_nonOSA) as Transfer_NON_OSA,
						sum(Dead_Call_Outcome) as Dead_Call_Outcome
				from calls group by user_id

				 union

					select 	'' as user_id,
						'' as 411_OSA,
						'' as 411_Other,
						'' as Academic_Advisement,
						'' as Academic_Scheduling,
						'' as Admissions,
						'' as Auxillary_Services,
						'' as CPE,
						'' as Confirm_Receipt,
						'' as Degree_Audit,
						'' as Financial_Aid,
						'' as Immunization,
						'' as IT,
						'' as Other_Call_Type,
						'' as OSA_Appeals,
						'' as Registration,
					    '' as Residential_Life,
						'' as Student_accounts,
						'' as Student_Activities,
						'' as TAP,
						'' as Transfer_Credit,
						'' as Transcripts,
						'' as Verification,
						'' as Veteran_Affairs,
						'' as Dead_Call_Type,
						'' as Resolved,
						'' as Call_Back_Required,
						'' as Ticket_Created,
						'' as Transfer_OSA,
						'' as Transfer_NON_OSA,
						'' as Other_Outcome,
						'' as Dead_Call_Outcome
				from calls

				union

				select 	'TOTAL' as user_id,
						sum(411_osa) as 411_OSA,
						sum(411_other) as 411_Other,
						sum(academic_advising) as Academic_Advisement,
						sum(academic_scheduling) as Academic_Scheduling,
						sum(admissions) as Admissions,
						sum(auxillary_services) as Auxillary_Services,
						sum(CPE) as CPE,
						sum(Confirm_Receipt) as Confirm_Receipt,
						sum(degree_audit) as Degree_Audit,
						sum(financial_aid) as Financial_Aid,
						sum(immunization) as Immunization,
						sum(IT) as IT,
						sum(Other_Call_type)  as Other_Call_Type,
						sum(OSA_appeals) as OSA_Appeals,
						sum(registration) as Registration,
						sum(residential_life) as Residential_Life,
						sum(student_accounts) as Student_accounts,
						sum(student_activities) as Student_Activities,
						sum(TAP) as TAP,
						sum(transfer_credit) as Transfer_Credit,
						sum(transcripts) as Transcripts,
						sum(verification) as Verification,
						sum(veteran_affairs) as Veteran_Affairs,
						sum(Dead_Call_type)  as Dead_Call_Type,
						sum(resolved) as Resolved,
						sum(call_back_required) as Call_Back_Required,
						sum(ticket_created) as Ticket_Created,
						sum(transferOSA) as Transfer_OSA,
						sum(transfer_nonOSA) as Transfer_NON_OSA,
						sum(Other_Outcome) as Other_Outcome,
						sum(Dead_Call_Outcome) as Dead_Call_Outcome
				from calls

			";
	}
	else {

		$fromdate = date('Y-m-d', strtotime($fromdate));

		$todate = date('Y-m-d', strtotime('+1 day', (strtotime($todate))));

		$sql = "	select 	user_id,
						sum(411_osa) as 411_OSA,
						sum(411_other) as 411_Other,
	sum(academic_advising) as Academic_Advisement,
	sum(academic_scheduling) as Academic_Scheduling,
	sum(admissions) as Admissions,
	sum(auxillary_services) as Auxillary_Services,
						sum(CPE) as CPE,
						sum(Confirm_Receipt) as Confirm_Receipt,
	sum(degree_audit) as Degree_Audit,
	sum(financial_aid) as Financial_Aid,
	sum(immunization) as Immunization,
	sum(IT) as IT,
						sum(Other_Outcome) as Other_Outcome,
	sum(OSA_appeals) as OSA_Appeals,
	sum(registration) as Registration,
	sum(residential_life) as Residential_Life,
	sum(student_accounts) as Student_accounts,
						sum(student_activities) as Student_Activities,
	sum(TAP) as TAP,
	sum(transfer_credit) as Transfer_Credit,
	sum(transcripts) as Transcripts,
	sum(verification) as Verification,
	sum(veteran_affairs) as Veteran_Affairs,
	sum(Other_Call_type)  as Other_Call_Type,
	sum(Dead_Call_type)  as Dead_Call_Type,

					sum(resolved) as Resolved,
					sum(call_back_required) as Call_Back_Required,
					sum(ticket_created) as Ticket_Created,
					sum(transferOSA) as Transfer_OSA,
					sum(transfer_nonOSA) as Transfer_NON_OSA,
					sum(Other_Outcome) as Other_Outcome,
					sum(Dead_Call_Outcome) as Dead_Call_Outcome
	from calls where timestamp >= '$fromdate' and timestamp < '$todate' group by user_id

					 union

					select 	'' as user_id,
						'' as 411_OSA,
						'' as 411_Other,
						'' as Academic_Advisement,
						'' as Academic_Scheduling,
						'' as Admissions,
						'' as Auxillary_Services,
						'' as CPE,
						'' as Confirm_Receipt,
						'' as Degree_Audit,
						'' as Financial_Aid,
						'' as Immunization,
						'' as IT,
						'' as Other_Outcome,
						'' as OSA_Appeals,
						'' as Registration,
					    '' as Residential_Life,
						'' as Student_accounts,
						'' as Student_Activities,
						'' as TAP,
						'' as Transfer_Credit,
						'' as Transcripts,
						'' as Verification,
						'' as Veteran_Affairs,
						'' as Other_Call_Type,
						'' as Dead_Call_Type,

						'' as Resolved,
						'' as Call_Back_Required,
						'' as Ticket_Created,
						'' as Transfer_OSA,
						'' as Transfer_NON_OSA,
						'' as Other_Outcome,
						'' as Dead_Call_Outcome

				from calls
	union

	select 	'TOTAL' as user_id,
						sum(411_osa) as 411_OSA,
						sum(411_other) as 411_Other,
						sum(academic_advising) as Academic_Advisement,
						sum(academic_scheduling) as Academic_Scheduling,
	sum(admissions) as Admissions,
	sum(auxillary_services) as Auxillary_Services,
						sum(CPE) as CPE,
						sum(Confirm_Receipt) as Confirm_Receipt,
	sum(degree_audit) as Degree_Audit,
	sum(financial_aid) as Financial_Aid,
	sum(immunization) as Immunization,
	sum(IT) as IT,
						sum(Other_Outcome) as Other_Outcome,
						sum(OSA_appeals) as OSA_Appeals,
	sum(registration) as Registration,
	sum(residential_life) as Residential_Life,
	sum(student_accounts) as Student_accounts,
						sum(student_activities) as Student_Activities,
	sum(TAP) as TAP,
	sum(transfer_credit) as Transfer_Credit,
	sum(transcripts) as Transcripts,
	sum(verification) as Verification,
						sum(veteran_affairs) as Veteran_Affairs,
						sum(Other_Call_type)  as Other_Call_Type,
						sum(Dead_Call_type)  as Dead_Call_Type,
												sum(resolved) as Resolved,
						sum(call_back_required) as Call_Back_Required,
						sum(ticket_created) as Ticket_Created,
						sum(transferOSA) as Transfer_OSA,
						sum(transfer_nonOSA) as Transfer_NON_OSA,
						sum(Other_Outcome) as Other_Outcome,
						sum(Dead_Call_Outcome) as Dead_Call_Outcome
	from calls where timestamp >= '$fromdate' and timestamp < '$todate' ";
	}

	$objPHPExcel->setActiveSheetIndex(0);  // Set to 1st Worksheet

	$objPHPExcel->getActiveSheet()->setTitle('Call Totals');

	if ($query = $db->prepare($sql)) {

  		if ($query->execute()) {
    		$result = $query->fetchAll(PDO::FETCH_OBJ);
  		}
	}


	fillWorksheet($result,0,1);

	// AND THEN Make Visit LOG:

	if ($fromdate == 'All Dates' || $todate == 'All Dates') {

		$sql2 = "	select * from calls order by timestamp ";
	}
	else {
		//$fromdate = date('Y-m-d', strtotime($fromdate));
		//$todate = date('Y-m-d', strtotime('+1 day', (strtotime($todate))));
		$sql2 = "	select * from calls where timestamp >= '$fromdate' and timestamp < '$todate' order by timestamp ";
	}

	$lastworksheet = $objPHPExcel->getSheetCount();
	$objPHPExcel->createSheet();
	$objPHPExcel->setActiveSheetIndex($lastworksheet);
	$objPHPExcel->getActiveSheet()->setTitle('Call Detail Log');

	if ($query = $db->prepare($sql2)) {

  		if ($query->execute()) {
    		$result = $query->fetchAll(PDO::FETCH_OBJ);
  		}
	}

	fillWorksheet($result, $lastworksheet, 2);

	// RESET TO 1st worksheet if not empty
	if (!$objPHPExcel->getSheetCount() >0 ) {
		exit();
	}
	$objPHPExcel->setActiveSheetIndex(0);

	// Save Excel 2007 file
	//echo date('H:i:s') , " Write to Excel2007 format" , PHP_EOL;
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	//$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
	$filename = 'call_log'.date ('mdYHis');

	//$objWriter->save($filename.'.xlsx');

	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');

	$objWriter->save('php://output');