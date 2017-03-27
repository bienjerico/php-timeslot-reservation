
<?php
/*
  Author: Bien Jerico Cueto
  File name: index.php
  Description: Time Reservation
  Dependencies: PHP and MySql
*/

include ("dbxconnect.php");
          
/* email is available */
if(isset($_GET['email'])){
  $useremail = trim($_GET['email']); 
  $qryFindUser = mysqli_query($conn,"SELECT a.firstname, a.emailaddress, a.schedule, b.slots
                              FROM participants a LEFT JOIN schedules b ON a.schedule = b.id
                              WHERE a.emailaddress = '{$useremail}' LIMIT 1");
  $cntFindUser = mysqli_num_rows($qryFindUser);
  $rsFindUser = mysqli_fetch_assoc($qryFindUser);
  $rsUserSlot = $rsFindUser['slots'];
  $strSchedEmail = $rsFindUser['emailaddress'];

  /* if email is not in the list */
  if ($strSchedEmail != $useremail || $cntFindUser==0) {
    header("Location: error.html");
  }
}else{
  header("Location: error.html");
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
      <h2 class="text-center">Time Reservation</h2>   
      </header>

      <section class="radio-container">

        <?php if($rsUserSlot) { ?>
          <div class="alert alert-success" role="alert">
          Congratulations! You are now reserved.  See you on January 17, 2017 (<strong><?php echo $rsUserSlot; ?></strong>)
          </div>           
        <?php }else{ ?>
          <div class="alert alert-empty" role="alert">
          Please select an available time slot and submit.
          </div>
        <?php } ?>

        <div class="row radio-row">
          <p> 

          <?php 
          $qrySched = mysqli_query($conn,"SELECT * FROM schedules");
          $cntSched = mysqli_num_rows($qrySched);

          $cntList = 0;
          $cntColumn = 4;

          $numRow = ($cntSched/$cntColumn);
          $arrNumRow = explode('.', $numRow);
          $cntNewRow = $arrNumRow[0];

          if(isset($arrNumRow[1]) && $arrNumRow[1]>1){
            $cntNewRow = $cntNewRow + 1;
          }

          $cnt = 0;
          $cntSchedLoop = 0;

          if($cntSched>0){
            while ($row = mysqli_fetch_assoc($qrySched))  
            {

              $numSchedStatus = $row['status'];
              /* if slot still is available */
              if($numSchedStatus!=0){
                $strSchedStatusColor = "text-success";
                $strSchedStatus = "Available (".$numSchedStatus.")";  
                $strRadioHide = '';
              }else{
                $strSchedStatusColor = "text-danger";
                $strSchedStatus = "Not Available";
                $strRadioHide = 'hidden="hidden"';
              }

              /* already reserved - hide radio button */
              if($rsUserSlot) { 
                $strRadioHide = 'hidden="hidden"';
              }

              if($cnt == 0){
              ?>
                <div class="col-xs-12 col-sm-12 col-md-3">
                    <ul class="list-unstyled">
                      <?php 
                      }
                      ?>
                          <?php  $cnt++; $cntSchedLoop++; ?>
                          <li>
                            <div class="radio-list">
                              <div class="radio-space">
                                <input type="radio" name="radioReserve" value="<?php echo $row['id']; ?>" <?php echo $strRadioHide; ?>>
                              </div>
                              <div class="radio-content">
                                <input type="text" value="<?php echo $row['slots']; ?>" class="input-label" readonly="readonly">
                                <br/>
                                <span class="<?php echo $strSchedStatusColor; ?>"><?php echo $strSchedStatus; ?></span>
                              </div>
                            </div>
                          </li>

                      <?php 
                      if($cnt == $cntNewRow || $cntSchedLoop == $cntSched){
                        $cnt = 0;
                      ?>
                    </ul>
                </div>
              <?php
              }
            }
          }
          ?>

        </div>

        <?php if(!$rsUserSlot) { /* already reserved - submit button */ ?>
        <div class="row text-center">
          <div class="col-xs-12 col-sm-12">
            <input type="hidden" id="schedEmail" value="<?php echo $strSchedEmail; ?>">
            <button type="button" class="btn btn-primary pull-right" id="btnSubmit"  data-toggle="modal" data-target="#myModal" disabled="disabled">Submit</button>
            <button type="button" class="btn btn-default pull-right" id="btnRefresh">Refresh</button>
          </div>
        </div>
        <?php } ?>


        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
                <h4 class="modal-title" id="myModalLabel"> Are you sure you want to reserve this schedule?</h4>
              </div>
              <div class="modal-body text-center">
                <h3><span id="modalResult"></span></h3>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="btnClose">Close</button>
                <button type="button" class="btn btn-primary" id="btnSubmitConfirmed">Submit</button>
              </div>
            </div>
          </div>
        </div>

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