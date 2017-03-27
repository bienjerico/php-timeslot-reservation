
<?php
/*
  Author: Bien Jerico Cueto
  File name: reservation-result.php
  Description: Time Reservation Result
  Dependencies: PHP and MySql
*/

include ("dbxconnect.php");
          
$qryReservationResult = mysqli_query($conn,"SELECT a.slots, b.firstname, b.id, b.datemodified
									FROM schedules a
									LEFT JOIN participants b ON a.id = b.schedule
									ORDER BY a.slots ASC;");
$rsReservationResult = mysqli_fetch_assoc($qryReservationResult);

$arReservationResult = array();
if(count($qryReservationResult)>0){
	while ($row = mysqli_fetch_assoc($qryReservationResult)){
		$arReservationResult[$row['slots']][$row['id']]  = array(
													'firstname' => $row['firstname'],
													'datemodified' => $row['datemodified'],
													);
	}
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Time Reservation</title>

    <!-- Bootstrap -->
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">

	<header>
	</header>

  	<section class="single-list">
        <h2 class="text-center">Time Reservation Result</h2>   
        <div class="clearfix">&nbsp;</div>
        <?php 
        	$cntAccordion  = 0;
			if($arReservationResult){
				foreach($arReservationResult as $key => $value){
        ?>
        <ul class="list-unstyled">
        	<li><div class="alert alert-empty cursor-pointer text-center" role="alert" data-toggle="collapse" data-target="#single-accordion-<?php echo $cntAccordion; ?>"> <?php echo $key; ?></div></li>
        	<li  id="single-accordion-<?php echo $cntAccordion; ?>" class="collapse <?php echo ($cntAccordion==0 ? 'in' : '' );   ?>">
        		<table class="table table-hover">
        			<?php 
        			$cntVal = 0;
					if(count($value)>0){
						foreach($value as $val){
							if($val['firstname']!="" && $val['datemodified']!=""){
								$cntVal++;
							}
						}
						if($cntVal>0){
					?>
	        			<thead>
	        				<tr>
		        				<th>Name</th>
		        				<th>Date/Time Signed Up</th>
	        				</tr>
	        			</thead>
	        			<tbody>
	        				<?php 
    						foreach($value as $val){
	        				?>
		        				<tr>
			        				<td><?php echo $val['firstname']; ?></td>
			        				<td><?php echo $val['datemodified']; ?></td>
		        				</tr>
	        				<?php 
    						} 
							?>
	        			</tbody>
	        			<?php 
    					} else {
	    				?>	
	    				<div class="text-danger text-center">No Reservation</div>
    				<?php 	
    					}
    				}
    				?>
        		</table>
        	</li>
        </ul>
        
        <?php 
        		$cntAccordion++;
				}
			}
        ?>


      </section>

	<footer>
		<div>Copyright &copy; 2017. All rights reserved.</div>  
	</footer>

    </div>

    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="app.js"></script>
  </body>
</html>