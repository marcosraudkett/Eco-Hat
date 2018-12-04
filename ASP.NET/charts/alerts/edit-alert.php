 <?php 

  require_once("../src/require.php"); //database

  //setlocale(LC_TIME, array('fi_FI.UTF-8','fi_FI@euro','fi_FI','finnish')); 
  date_default_timezone_set('Europe/Tallinn');

?>
<html>
  <head>
    <title>Edit Alert - Organized Chaos</title>
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
    <h3>Edit Alert</h3>
    <p>Edit Alert Configuration</p>
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
            $alert_initiation_type = $row["Alert_initiation_type"];
            $alert_initiation_value = $row["Alert_initiation_value"];

        }
    ?>
    <form method="POST" action="initiate-edit.php">
      <div style="margin-bottom:15px;margin-left: -15px;" class="col-sm-4">
        <div class="input-group">
          <input name="type" type="text" class="form-control" value="<?php echo $alert_name; ?>" placeholder="Alert Type/Name (eg. High Temp #1)" required="required">
        </div>
      </div>

      <div style="margin-bottom:15px;margin-left: -15px;" class="col-sm-4">
        <div class="input-group">
          <input name="description" type="text" value="<?php echo $alert_desc; ?>" class="form-control" placeholder="Alert Description">
        </div>
      </div>

      <div style="margin-bottom:15px;margin-left: -15px;" class="col-sm-4">
        <div class="input-group">
          <select class="form-control" name="selected_device" required="required">
            <option>Select Device</option>
            <optgroup label="Devices">
            <?php
              /* SENT ITEMS */
             $tsql = "SELECT * FROM Devices";
             $params = array();
             $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
             $getResults = sqlsrv_query($conn, $tsql, $params, $options) or die( print_r( sqlsrv_errors(), true));
             $get_rows = sqlsrv_num_rows($getResults);
             while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
                
                echo '<option value="'.$row["Device_secret"].'" ';
                if($alert_device == $row["Device_secret"]) { echo 'selected="selected"'; }
                echo '>'.$row["Device_name"];
                if($row["Device_description"] != '')
                {
                  echo ' ('.$row["Device_description"].')';
                }
                echo '</option>';

            }
            ?>
            </optgroup>
          </select>
        </div>
      </div>

      <h6>When will this alert initiate?</h6>
      <div style="margin-bottom:15px;margin-left: -15px;" class="col-sm-4">
        <div class="input-group">
          <select name="initiation_type" class="form-control initiation_type" required="required" onchange="int()">
            <option>Select Initiation Type</option>
            <optgroup label="Temperature">
              <option <?php if($alert_initiation_type == '1') { echo 'selected="selected"'; } ?> value="1">When temperature drops to</option>
              <option <?php if($alert_initiation_type == '2') { echo 'selected="selected"'; } ?> value="2">When temperature raises to</option>
            </optgroup>
            <optgroup label="Humidity">
              <option <?php if($alert_initiation_type == '3') { echo 'selected="selected"'; } ?> value="3">When humidity drops to</option>
              <option <?php if($alert_initiation_type == '4') { echo 'selected="selected"'; } ?> value="4">When humidity raises to</option>
            </optgroup>
            <optgroup label="Air Pressure">
              <option <?php if($alert_initiation_type == '5') { echo 'selected="selected"'; } ?> value="5">When Air Pressure drops to</option>
              <option <?php if($alert_initiation_type == '6') { echo 'selected="selected"'; } ?> value="6">When Air Pressure raises to</option>
            </optgroup>
            <optgroup label="Account">
              <option <?php if($alert_initiation_type == '7') { echo 'selected="selected"'; } ?> value="7">When a new Device is added.</option>
              <option <?php if($alert_initiation_type == '8') { echo 'selected="selected"'; } ?> value="8">When a Device is deleted.</option>
              <option <?php if($alert_initiation_type == '9') { echo 'selected="selected"'; } ?> value="9">When a Device is modified.</option>
            </optgroup>
          </select>
        </div>
      </div>

      <div style="margin-bottom:15px;margin-left: -15px; <?php if($alert_initiation_type != '1' || $alert_initiation_type != '2' || $alert_initiation_type != '3' || $alert_initiation_type != '4' || $alert_initiation_type != '5' || $alert_initiation_type != '6') { echo 'display:block;';  } else  { echo 'display:none;'; } ?>" class="col-sm-4 initiation_value_box">
        <div class="input-group">
          <input name="initiation_value" type="text" value="<?php echo $alert_initiation_value; ?>" class="form-control initiation_value">
        </div>
      </div>

      <h6>When alert is initiated what will happen?</h6>
      <div style="margin-bottom:15px;margin-left: -15px;" class="col-sm-4">
        <div class="input-group">
          <select name="action" class="form-control" required="required">
            <option <?php if($alert_action == '1') { echo 'selected="selected"'; } ?> value="1">Notify by Email</option>
          </select>
        </div>
      </div>

      <input type="hidden" value="<?php echo $_GET["id"]; ?>" name="alert_id">

      <div style="margin-bottom:15px;margin-left: -15px;" class="col-sm-4">
        <div class="input-group">
          <button type="submit" name="create" class="btn btn-secondary">Save Alert</button>
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

   <script>
    function int() {
      var type = $(".initiation_type").val();
      switch(type)
      {
        case '1':
        case '2':
          $(".initiation_value").attr({
            "placeholder" : "Enter a temperature amount (without any symbols)"
          });
          $(".initiation_value_box").css("display","block");
          break;

        case '3':
        case '4':
          $(".initiation_value").attr({
            "placeholder" : "Enter a humidity amount (without any symbols)"
          });
          $(".initiation_value_box").css("display","block");
          break;

        case '4':
        case '5':
          $(".initiation_value").attr({
            "placeholder" : "Enter a Air Pressure amount (without any symbols)"
          });
          $(".initiation_value_box").css("display","block");
          break;

        default:
          $(".initiation_value_box").css("display","none");
          break;
      }

    }
   </script>
  <footer>
      <p>© 2018 - Organized Chaos</p>
  </footer>
   </div>
</html>
