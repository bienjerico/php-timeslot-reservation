
<?php
/*
  Author: Bien Jerico Cueto
  File name: attendees.php
  Description: Time Reservation Result
  Dependencies: PHP and MySql
*/

include ("dbxconnect.php");
          
$qryReservationResult = mysqli_query($conn,"SELECT a.slots, b.firstname,b.lastname, b.id, b.datemodified
                  FROM schedules a
                  LEFT JOIN participants b ON a.id = b.schedule
                  GROUP BY b.emailaddress
                  ORDER BY a.slots,b.firstname ASC;");
$rsReservationResult = mysqli_fetch_assoc($qryReservationResult);

$arReservationResult = array();
if($qryReservationResult>0){
  while ($row = mysqli_fetch_assoc($qryReservationResult)){
    $arReservationResult[$row['slots']][$row['id']]  = array(
                          'firstname' => $row['firstname'],
                          'lastname' => $row['lastname'],
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
        <h2 class="text-center">Time Reservation - Attendees</h2>   
        <div class="clearfix">&nbsp;</div>
        <div class="pull-right"><a href="generate-attendees-excel.php" style="text-decoration: none;" class="text-success">Download Excel File</a></div>
        <div class="clearfix">&nbsp;</div>
        <div class="clearfix">&nbsp;</div>
        <?php 
          $cntAccordion  = 0;
          if($arReservationResult){
            foreach($arReservationResult as $key => $value){
              $cntVal = 0;
                  if(count($value)>0){
                    foreach($value as $val){
                      if($val['firstname']!="" && $val['lastname']!="" && $val['datemodified']!=""){
                        $cntVal++;
                      }
                    }
            ?>
            <ul class="list-unstyled">
              <li class="accordion-label">
                <div class="alert alert-empty cursor-pointer" role="alert" data-toggle="collapse" data-target="#single-accordion-<?php echo $cntAccordion; ?>"> <?php echo $key; ?> -- <?php echo $cntVal; ?> Participant/s
                <span class="glyphicon glyphicon-chevron-<?php echo ($cntAccordion==0 ? 'up' : 'down' );   ?>  pull-right" aria-hidden="true"></span></div> 
              </li>
              <li id="single-accordion-<?php echo $cntAccordion; ?>" class="collapse <?php echo ($cntAccordion==0 ? 'in' : '' );   ?> accordion-list">
                <table class="table table-hover">
                  <?php 
                  
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
                          <td><?php echo $val['firstname'].' '.$val['lastname']; ?></td>
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