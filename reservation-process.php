<?php
/*
  Author: Bien Jerico Cueto
  File name: reservation-process.php
  Description: Process the user selected time slot
  Dependencies: PHP and MySql
*/

include ("dbxconnect.php");

$schedEmail = filter_var($_POST['schedEmail'], FILTER_SANITIZE_EMAIL);
$timeSlotId = filter_var($_POST['timeSlotId'], FILTER_VALIDATE_INT);
$userIpAddress = $_SERVER["REMOTE_ADDR"];

/* if user email address and time slot id is not empty */
if(!empty($schedEmail) && !empty($timeSlotId)){

	$qrySchedCheckStatus = mysqli_query($conn,"SELECT status
			                              FROM schedules 
			                              WHERE id = {$timeSlotId} LIMIT 1; ");
  	$rsSchedCheckStatus = mysqli_fetch_assoc($qrySchedCheckStatus);

  	$qryUserSchedValid = mysqli_query($conn,"SELECT count(*) as userSchedValid
  								 FROM participants
  								 WHERE emailaddress = '{$schedEmail}'
  								 	AND (schedule IS NULL OR schedule=0) LIMIT 1");
  	$rsUserSchedValid = mysqli_fetch_assoc($qryUserSchedValid);

  	/* if user is not yet reserve */
  	if($rsUserSchedValid['userSchedValid']>0){
  		/* if time slot still available */
	  	if($rsSchedCheckStatus['status']>0){

	  		/* update status of time slot */
	  		mysqli_query($conn,"UPDATE schedules 
						 SET status = (status-1) 
						 WHERE status>0 
							AND id = {$timeSlotId} ");
	  		$afTimeSlot = mysqli_affected_rows($conn);

	  		/* if time slot status has been updated */
	  		if($afTimeSlot>0){
		  		/* update user schedule */
		  		mysqli_query($conn,"UPDATE participants 
							 SET schedule = '{$timeSlotId}',
							 	ipaddress = '{$userIpAddress}'
							 WHERE emailaddress = '{$schedEmail}'; ");

		  		$afParticipantsSched = mysqli_affected_rows($conn);

		  		$result = array('status' => true,
		   						'message' => 'Thank you! You are successfully reserved.');

	  		}else{
	  			$result = array('status' => true,
		   						'message' => 'Sorry! This Time Slot is already full. Kindly refresh the browser for updates.');
	  		}
	  	}else{
	  		$result = array('status' => true,
	   						'message' => 'Sorry! This Time Slot is already full. Kindly refresh the browser for updates.');
	  	}
  	}else{
  		$result = array('status' => true,
   						'message' => 'Your email address already reserved.');
  	}
}else{
	$result = array('status' => false,
		   			'message' => 'Something went wrong. Kindly refresh your browser.');

}

echo json_encode($result);

?>