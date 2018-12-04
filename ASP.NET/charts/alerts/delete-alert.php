 <?php 

  require_once("../src/require.php"); //database

  //setlocale(LC_TIME, array('fi_FI.UTF-8','fi_FI@euro','fi_FI','finnish')); 
  date_default_timezone_set('Europe/Tallinn');

?>
<html>
  <head>
    <title>Delete Alert - Organized Chaos</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" />
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
    <script type="text/javascript" src="https://marcosraudkett.com/calendar/assets/plugins/datepicker/custom.js"></script>


    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />
    
    
  <body>
    <?php 
    $this_page = 'new-device';
    include("../includes/menu.php"); 
    ?>

    </center>
    <br><br>
<div class="container body-content">
    <h3>Delete Alert</h3><br>
    <?php
    if(isset($_GET["error"]))
    {
      echo '<div class="alert alert-danger">'.$_GET["error"].'</div>';
    }

    if(isset($_GET["id"]))
    {

         $alert_id = $_GET["id"];
         $tsql = "SELECT * FROM Alerts WHERE Alert_id = '$alert_id'";
         $params = array();
         $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
         $getResults = sqlsrv_query($conn, $tsql, $params, $options) or die( print_r( sqlsrv_errors(), true));
         $get_rows = sqlsrv_num_rows($getResults);
         while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
            
            $alert_name = $row["Alert_type"];
            $alert_desc = $row["Alert_description"];
            $alert_device = $row["Alert_device_secret"];
            $alert_action = $row["Alert_action"];
        }
    ?>
    <form method="POST" action="initiate-delete.php">
      
      <div class="alert alert-info">
       <h6>Are you sure you wish to delete alert: <b><?php echo $alert_name; if($alert_desc != '') { echo ' (<i>'.$alert_desc.'</i>)'; } ?></b></h6>
      </div>

      <input type="hidden" name="alert_id" value="<?php echo $alert_id; ?>">

      <div style="margin-bottom:15px;margin-left: -15px;" class="col-sm-4">
        <div class="input-group">
          <button type="submit" name="delete" class="btn btn-danger">Delete Alert</button>
        </div>
      </div>

    </form>
    <?php
    }
    ?>
    <br>
    <br>
    <br>
   <hr>
  <footer>
      <p>© 2018 - Organized Chaos</p>
  </footer>
   </div>
</html>
