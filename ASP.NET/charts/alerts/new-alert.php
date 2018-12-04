 <?php 

  require_once("../src/require.php"); //database

  //setlocale(LC_TIME, array('fi_FI.UTF-8','fi_FI@euro','fi_FI','finnish')); 
  date_default_timezone_set('Europe/Tallinn');

?>
<html>
  <head>
    <title>New Alert - Organized Chaos</title>
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
    <h3><svg class="feather feather-bell sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 17H2a3 3 0 0 0 3-3V9a7 7 0 0 1 14 0v5a3 3 0 0 0 3 3zm-8.27 4a2 2 0 0 1-3.46 0"></path></svg> New Alert</h3>
    <p>New Alert Configuration</p>
    <?php
    if(isset($_GET["error"]))
    {
      echo '<div class="alert alert-danger">'.$_GET["error"].'</div>';
    }
    ?>
    <form method="POST" action="initiate-create.php">
      <div style="margin-bottom:15px;margin-left: -15px;" class="col-sm-4">
        <div class="input-group">
          <input name="type" type="text" class="form-control" placeholder="Alert Type/Name (eg. High Temp #1)" required="required">
        </div>
      </div>

      <div style="margin-bottom:15px;margin-left: -15px;" class="col-sm-4">
        <div class="input-group">
          <input name="description" type="text" class="form-control" placeholder="Alert Description">
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
                
                echo '<option value="'.$row["Device_secret"].'">'.$row["Device_name"];
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
              <option value="1">When temperature drops to</option>
              <option value="2">When temperature raises to</option>
            </optgroup>
            <optgroup label="Humidity">
              <option value="3">When humidity drops to</option>
              <option value="4">When humidity raises to</option>
            </optgroup>
            <optgroup label="Air Pressure">
              <option value="5">When Air Pressure drops to</option>
              <option value="6">When Air Pressure raises to</option>
            </optgroup>
            <optgroup label="Account">
              <option value="7">When a new Device is added.</option>
              <option value="8">When a Device is deleted.</option>
              <option value="9">When a Device is modified.</option>
            </optgroup>
          </select>
        </div>
      </div>

      <div style="margin-bottom:15px;margin-left: -15px; display: none;" class="col-sm-4 initiation_value_box">
        <div class="input-group">
          <input name="initiation_value" type="text" class="form-control initiation_value">
        </div>
      </div>

      <h6>What will happen on initiation?</h6>
      <div style="margin-bottom:15px;margin-left: -15px;" class="col-sm-4">
        <div class="input-group">
          <select name="action" class="form-control" required="required">
            <option value="1">Notify by Email</option>
          </select>
        </div>
      </div>

      <div style="margin-bottom:15px;margin-left: -15px;" class="col-sm-4">
        <div class="input-group">
          <button type="submit" name="create" class="btn btn-secondary">Add Alert</button>
        </div>
      </div>

    </form>
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
