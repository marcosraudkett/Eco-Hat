 <?php 

  require_once("../src/require.php"); //database

  //setlocale(LC_TIME, array('fi_FI.UTF-8','fi_FI@euro','fi_FI','finnish')); 
  date_default_timezone_set('Europe/Tallinn');


/* Function joka toimii loputtomasti(?) voi rajata vaikka koko vuoden */
function tilastot($dates, $amount, $conn) {
  $new = str_replace(' ',',', $dates);
  $box_array = explode(',', $new);

  $i = 0; /* lasku on 0 */
  if($i != $amount) {
    if (is_array($box_array) || is_object($box_array))  {
      foreach ($box_array as $this_date) {

       if($amount >= 60) { 
        /* tähän voi muokata tilastonnäkymää(?) että esim jos käyttäjä on rajannut enemmän kuin 60 pv niin sitten tulostuu kk eikä päivät */
         $date_day = ucwords(strftime('%A', strtotime($this_date, '-'.$amount.' day')));
         $date_date = ucwords(strftime('%d.%m', strtotime($this_date, '-'.$amount.' day')));
         $date_fulldate = ucwords(strftime('%d.%m.%Y', strtotime($this_date, '-'.$amount.' day')));
       } else {
         $date_day = ucwords(strftime('%A', strtotime($this_date, '-'.$amount.' day')));
         $date_date = ucwords(strftime('%d.%m', strtotime($this_date, '-'.$amount.' day')));
         $date_fulldate = ucwords(strftime('%d.%m.%Y', strtotime($this_date, '-'.$amount.' day')));
       }

       /* */
       $date_mysql = ucwords(strftime('%Y-%m-%d 00:00:00', strtotime($this_date, '-'.$amount.' day')));
       $date_mysql_2 = ucwords(strftime('%Y-%m-%d 23:59:59', strtotime($this_date, '-'.$amount.' day')));
       
       /* SENT ITEMS */
       if($_GET["selected_device"] == 'NO-DEVICE' || !isset($_GET["selected_device"])) { 
        $tsql = "SELECT * FROM InitiatedAlerts WHERE Initiated_alert_datetime BETWEEN '$date_mysql' AND '$date_mysql_2' ORDER BY Initiated_alert_id DESC";
       } else {
        $selected_device = $_GET["selected_device"];
        $tsql = "SELECT * FROM InitiatedAlerts WHERE Initiated_alert_device_secret = '$selected_device' AND Initiated_alert_datetime BETWEEN '$date_mysql' AND '$date_mysql_2' ORDER BY Initiated_alert_id DESC";
       }
       $params = array();
       $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
       $getResults = sqlsrv_query($conn, $tsql, $params, $options) or die( print_r( sqlsrv_errors(), true));
       $get_rows = sqlsrv_num_rows($getResults);


       if($date_fulldate != '01.01.1970') { /* jos pvm on väärä niin ei tulosteta */
         echo "['".$date_day." (".$date_date.")', ".$get_rows."],";
       }
       $i++; /* lisätään jokaisen pvm kohdalla +1 laskuriin */
     }
    }
  }
}

$currentday = ucwords(strftime( '%A' )); date_default_timezone_set('Europe/Helsinki');
$current_date = strftime( '%d.%m' ); date_default_timezone_set('Europe/Helsinki');
$current_fulldate = strftime( '%d.%m.%Y' ); date_default_timezone_set('Europe/Helsinki');
$currentday_mysqlfulldate_1 = strftime( '%Y-%m-%d 00:00:00' ); date_default_timezone_set('Europe/Helsinki');
$currentday_mysqlfulldate = strftime( '%Y-%m-%d 23:59:59' ); date_default_timezone_set('Europe/Helsinki');


?><?php 

if($_GET["selected_device"] == 'NO-DEVICE' || !isset($_GET["selected_device"])) { 
  $tsql = "SELECT * FROM InitiatedAlerts WHERE Initiated_alert_datetime BETWEEN '$currentday_mysqlfulldate_1' AND '$currentday_mysqlfulldate' ORDER BY Initiated_alert_id DESC";
} else {
  $selected_device = $_GET["selected_device"];
  $tsql = "SELECT * FROM InitiatedAlerts WHERE Initiated_alert_device_secret = '$selected_device' AND Initiated_alert_datetime BETWEEN '$currentday_mysqlfulldate_1' AND '$currentday_mysqlfulldate' ORDER BY Initiated_alert_id DESC";
}
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$getResults = sqlsrv_query($conn, $tsql, $params, $options) or die( print_r( sqlsrv_errors(), true));
$get_rows = sqlsrv_num_rows($getResults);
//echo ("Reading data from table " . PHP_EOL);

$current_testdate = strftime( '%Y-%m-%d %H:%M:%S' );
$test_date = strftime( '%Y-%m-%d %H:%M:%S', strtotime($current_testdate. '-5 seconds'));
//echo $current_testdate.' '.$test_date;

?>
<html>
  <head>
    <title>Alerts - Organized Chaos</title>
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
    $this_page = 'alerts';
    include("../includes/menu.php"); 
    ?>

    <img style="height: 56px;float:left;margin-top: -21px;" src="https://marcosraudkett.com/mvrclabs/code/scripts/admin/images/organizedchaos_withouttext.png">
    <center style="border-bottom: 1px solid #c7c7c7;">
    <form action="" style="display: inline-flex;margin-top: -5px;margin-bottom: 9px;" method="GET">
      <input class="form-control" style="width: 150px;padding: 5px;margin-right: 5px;" id="datepicker" autocomplete="off" value="<?php if(isset($_GET["from"])) { echo $_GET["from"]; } else { echo date('01.m.Y'); } ?>" name="from" type="text" placeholder="From (dd.mm.yyyy)">
      <input class="form-control" style="width: 150px;padding: 5px;margin-right:5px;" id="datepicker1" autocomplete="off" value="<?php if(isset($_GET["to"])) { echo $_GET["to"]; } else { echo date('d.m.Y'); } ?>" name="to" type="text" placeholder="To (dd.mm.yyyy)">
       <select class="form-control" style="margin-right: 20px;" name="selected_device">
        <option value="NO-DEVICE">Select Device</option>
        <optgroup label="Devices">
        <?php
          /* SENT ITEMS */
         $tsql = "SELECT * FROM Devices";
         $params = array();
         $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
         $getResults = sqlsrv_query($conn, $tsql, $params, $options) or die( print_r( sqlsrv_errors(), true));
         $get_rows_devices = sqlsrv_num_rows($getResults);
         while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
            

            echo '<option value="'.$row["Device_secret"].'" ';
            if($_GET["selected_device"] == $row["Device_secret"]) { echo 'selected="selected"'; }
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
      <button type="submit" class="btn btn-secondary btn-sm">Submit</button>
    </form>




    </center>
    <br><br>
<div class="container body-content">
    <h3><svg class="feather feather-bell sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="margin-top: -7px;"><path d="M22 17H2a3 3 0 0 0 3-3V9a7 7 0 0 1 14 0v5a3 3 0 0 0 3 3zm-8.27 4a2 2 0 0 1-3.46 0"></path></svg> <?php 
    if($_GET["selected_device"] == 'NO-DEVICE' || !isset($_GET["selected_device"])) { 
      echo 'Your'; 
    } else { 
        $selected_device = $_GET["selected_device"];
        $tsql4 = "SELECT * FROM Devices WHERE Device_secret = '$selected_device'";
        $params4 = array();
        $options4 =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
        $getResults4 = sqlsrv_query($conn, $tsql4, $params4, $options4) or die( print_r( sqlsrv_errors(), true));
        $get_rows_devices = sqlsrv_num_rows($getResults4);
        while ($row_selected = sqlsrv_fetch_array($getResults4, SQLSRV_FETCH_ASSOC)) {
          
          $device_name = $row_selected["Device_name"];

        }
        echo '<span style="color:#a7d86d;">'.$device_name.'</span>'; 
    } ?> Alerts</h3>
    <p>On this page you can setup your own custom alerts that Ecohat will initiate if for example the limits are exceeded.</p>
    <button style="float: right;margin-bottom: 21px;margin-top: -65px;" onclick="window.location.replace('/alerts/new-alert.php');" class="btn btn-secondary btn-xs">New Alert</button>
    <table id="alerts" class="table">
    <thead>
        <tr>
            <th>
                Device
            </th>
            <th>
                Alert Name
            </th>
            <th>
                Description
            </th>
            <th>
                Action
            </th>
            <th>
                Alert Created
            </th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
          if($_GET["selected_device"] == 'NO-DEVICE' || !isset($_GET["selected_device"]))
          {
           $tsql = "SELECT * FROM Alerts
                    LEFT JOIN Devices ON Alerts.Alert_device_secret = Devices.Device_secret";
          } else {
            $device_secret = $_GET["selected_device"];
            $tsql = "SELECT * FROM Alerts
                     LEFT JOIN Devices ON Alerts.Alert_device_secret = Devices.Device_secret
                     WHERE Alerts.Alert_device_secret = '$device_secret'";
          }
           $params = array();
           $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
           $getResults = sqlsrv_query($conn, $tsql, $params, $options) or die( print_r( sqlsrv_errors(), true));
           $get_rows_alerts = sqlsrv_num_rows($getResults);
           while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
              switch($row["Alert_action"])
              {
                  case "1": $action = 'Notify by Email'; break;
              }

                //echo $value['language_id'];
                $last_date = substr($row["Alert_created"],0,-7);
                $new_last_date = strftime( '%d.%m.%Y %H:%M:%S', strtotime($last_date));

                $date = $row["Alert_created"];
                //$result = $date->format('Y-m-d H:i:s');
              
          ?>
        <tr>
          <td><?php echo $row["Device_name"]; ?></td>
          <td><?php echo $row["Alert_type"]; ?></td>
          <td><?php if($row["Alert_description"] == '') { echo '<h6 style="font-size:12px;">No description set</h6>'; } else { echo $row["Alert_description"]; } ?></td>
          <td><p class="badge badge-dark"><?php echo $action; ?></p></td>
          <td><?php echo $row["Alert_created"]->format('d.m.Y H:i:s'); ?></td>
          <td>
            <button onclick="window.location.replace('/app/alerts/edit-alert.php?id=<?php echo $row["Alert_id"]; ?>');" class="btn btn-secondary btn-sm">Edit</button>
            <button onclick="window.location.replace('/app/alerts/delete-alert.php?id=<?php echo $row["Alert_id"]; ?>');" class="btn btn-danger btn-sm">Delete</button>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>

    <script>
    $(document).ready( function () {
        $('#alerts').DataTable({
            "order": [[ 0, "asc" ]]
        });
    } );
    </script>

<br>
<hr>
<br>
    <h3><svg class="feather feather-alert-triangle sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" data-reactid="56" style="margin-top: -7px;"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12" y2="17"></line></svg> Initiated Alerts <?php 
    if($_GET["selected_device"] == 'NO-DEVICE' || !isset($_GET["selected_device"])) { 
       
    } else { 
        echo 'for <span style="color:#a7d86d;">'.$device_name.'</span>'; 
    } ?></h3>
    <table id="initiated" class="table">
    <thead>
        <tr>
            <th>
                Alert Type
            </th>
            <th>
                Device
            </th>
            <th>
                Initiation Time
            </th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
          if($_GET["selected_device"] == 'NO-DEVICE' || !isset($_GET["selected_device"]))
          {
           $tsql = "SELECT * FROM InitiatedAlerts
                    LEFT JOIN Devices ON InitiatedAlerts.Initiated_alert_device_secret = Devices.Device_secret";
          } else {
            $device_secret = $_GET["selected_device"];
            $tsql = "SELECT * FROM InitiatedAlerts
                     LEFT JOIN Devices ON InitiatedAlerts.Initiated_alert_device_secret = Devices.Device_secret
                     WHERE InitiatedAlerts.Initiated_alert_device_secret = '$device_secret'";
          }
           $params = array();
           $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
           $getResults = sqlsrv_query($conn, $tsql, $params, $options) or die( print_r( sqlsrv_errors(), true));
           $get_rows_alerts = sqlsrv_num_rows($getResults);
           while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
          ?>
        <tr>
          <td><?php 

          switch($row["Initiated_alert_type"])
          {
            case "1": $initiated_alert_type = 'Temperature dropped to <b>'.$row["Initiated_alert_value"].'°C</b>'; break;
            case "2": $initiated_alert_type = 'Temperature exceeded <b>'.$row["Initiated_alert_value"].'°C</b>'; break;
            case "3": $initiated_alert_type = 'Humidity dropped to <b>'.$row["Initiated_alert_value"].'%</b>'; break;
            case "4": $initiated_alert_type = 'Humidity exceeded <b>'.$row["Initiated_alert_value"].'%</b>'; break;
            case "5": $initiated_alert_type = 'Air Pressure dropped to <b>'.$row["Initiated_alert_value"].'kPa</b>'; break;
            case "6": $initiated_alert_type = 'Air Pressure exceeded <b>'.$row["Initiated_alert_value"].'kPa</b>'; break;
            case "7": $initiated_alert_type = 'New Device added.'; break;
            case "8": $initiated_alert_type = 'Device has been deleted.'; break;
            case "9": $initiated_alert_type = 'Device has been modified.'; break;

          }

          echo $initiated_alert_type; 

          ?></td>
          <td><?php echo $row["Device_name"]; ?></td>
          <td><?php echo $row["Initiated_alert_datetime"]->format('d.m.Y H:i:s'); ?></td>
          <td>
            <button onclick="window.location.replace('/app/alerts/view-initiation.php?id=<?php echo $row["Initiated_alert_id"]; ?>');" class="btn btn-secondary btn-sm">Details</button>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>

<br>
<hr>
     <script>
    $(document).ready( function () {
        $('#initiated').DataTable({
            "order": [[ 0, "asc" ]]
        });
    } );
    </script>

    <br><br>
    <h3><svg class="feather feather-bar-chart-2 sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="margin-top: -7px;"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg> Initiated Alerts Data <?php 
    if($_GET["selected_device"] == 'NO-DEVICE' || !isset($_GET["selected_device"])) { 
       
    } else { 
        echo 'for <span style="color:#a7d86d;">'.$device_name.'</span>'; 
    } ?></h3>
    <p>Here you can see the amount of alerts initated. (on the top of the page you can change the dates)</p>
    <hr style="opacity:0.2;">
    <script type="text/javascript">
      google.charts.load('current', {'packages':['line']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Day', 'Alerts Initiated'],
          <?php
          if(isset($_GET["from"]))
          {
            $from = $_GET["from"];
          }

          if(isset($_GET["to"]))
          { 
            $to = $_GET["to"];
          }

            $period = new DatePeriod(
               new DateTime($from),
               new DateInterval('P1D'),
               new DateTime($to)
            );

            $begin = new DateTime($from);
            $end = new DateTime($to);

            $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);

            $amount = iterator_count($period);
            foreach($daterange as $date){
                $dates = $date->format("d.m.Y").' ';
                tilastot($dates, $amount, $conn);
            }            

          ?>
          ['<?php echo 'Today ('.$current_date.')'; ?>',  <?php echo $get_rows; ?>],
        ]);

        var options = {
          title: 'Statistics',
          curveType: 'function',
          legend: { position: 'bottom' },
          series: {
            0: { color: '#a7d86d' }
          }
        };

        var chart = new google.charts.Line(document.getElementById('line_top_x'));

        chart.draw(data, options);
      }
    </script>
    <?php echo "<script>console.log( 'Debug Objects: " . $dates.' '.$amount . "' );</script>"; ?>
  </head>
  <body>
    <center>
      <div id="line_top_x" style="width: 1200px; height: 500px"></div>
    </center>
  </body>
  <style>
  .ui-dialog {
    border-radius: 0px !important;
  } 
  .ui-dialog-titlebar {
    background: #a7d86d  !important;
    border-radius: 0px !important;
  }
  .ui-state-hover {
    background: white !important;
  }
  .ui-state-highlight {
    border: 1px solid #a7d86d  !important;
    background: rgba(87, 193, 134, 0.08) !important;
  }
  .ui-state-default {
    background: #efefef !important;
  }
  .ui-state-default:hover {
    background: #d8d8d8 !important;
  }
  .ui-datepicker {
    border-radius: 0px !important;
    font-family: 'Open Sans', 'Segoe UI', 'Droid Sans', Tahoma, Arial, sans-serif !important;
  }
  .ui-datepicker-header {
    background: #a7d86d  !important;
    color: #FFFFFF !important;
    border-radius: 0px !important;
  }
  .ui-datepicker-calendar tr {
    background: white !important;
  }
</style>
  
  <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
  <hr>
  <footer>
      <p>© 2018 - Organized Chaos</p>
  </footer>
</div>
</body>
  <script>
  $(function(){
$("#datepicker").datepicker();
  $("#datepicker").datepicker({
    language:"fi",
    showWeek:1,
    firstDay:1,
    showButtonPanel:!0,
    dateFormat:"dd.mm.yy"
  }).val()
})
  $(function(){
$("#datepicker1").datepicker();
  $("#datepicker1").datepicker({
    language:"fi",
    showWeek:1,
    firstDay:1,
    showButtonPanel:!0,
    dateFormat:"dd.mm.yy"
  }).val()
})
  </script>
</html>
