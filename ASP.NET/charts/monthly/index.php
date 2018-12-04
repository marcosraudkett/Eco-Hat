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

       $date_day = ucwords(strftime('%B', strtotime($this_date, '-'.$amount.' month')));
       $date_date = ucwords(strftime('%B', strtotime($this_date, '-'.$amount.' month')));
       $date_fulldate = ucwords(strftime('%d.%m.%Y', strtotime($this_date, '-'.$amount.' month')));

       /* */
       //$amount_new = $amount + 2;
       $date_mysql = ucwords(strftime('%Y-%m-%d', strtotime($this_date, '-'.$amount.' month')));
       $date_mysql_2 = ucwords(strftime('%Y-%m-%d', strtotime($this_date. 'last day of this month')));
       //echo 'this: '.$this_date.' '.$date_mysql.' - '.$date_mysql_2;

       /* SENT ITEMS */
       if($_GET["selected_device"] == 'NO-DEVICE' || !isset($_GET["selected_device"]))
       {
         $tsql = "SELECT * FROM SenseHat WHERE Sense_hat_datetime BETWEEN '$date_mysql' AND '$date_mysql_2' ORDER BY Sense_hat_entry_id DESC";
       } else {
         $device_secret = $_GET["selected_device"];
         $tsql = "SELECT * FROM SenseHat WHERE Sense_hat_device_secret = '$device_secret' AND Sense_hat_datetime BETWEEN '$date_mysql' AND '$date_mysql_2' ORDER BY Sense_hat_entry_id DESC";
       }
         $params = array();
         $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
         $getResults = sqlsrv_query($conn, $tsql, $params, $options) or die( print_r( sqlsrv_errors(), true));
         $get_rows = sqlsrv_num_rows($getResults);

       /* temperature */
       if($_GET["selected_device"] == 'NO-DEVICE' || !isset($_GET["selected_device"]))
       {
         $tsql2 = "SELECT Floor(AVG(Sense_hat_temperature)) AS average_temp  FROM SenseHat WHERE Sense_hat_datetime BETWEEN '$date_mysql' AND '$date_mysql_2'";
       } else {
         $device_secret = $_GET["selected_device"];
         $tsql2 = "SELECT Floor(AVG(Sense_hat_temperature)) AS average_temp  FROM SenseHat WHERE Sense_hat_device_secret = '$device_secret' AND Sense_hat_datetime BETWEEN '$date_mysql' AND '$date_mysql_2'";
       }
       $params2 = array();
       $options2 =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
       $getResults2 = sqlsrv_query($conn, $tsql2, $params2, $options2) or die( print_r( sqlsrv_errors(), true));
       while ($row = sqlsrv_fetch_array($getResults2, SQLSRV_FETCH_ASSOC)) {
        $temperature = $row["average_temp"];
       }
       if($temperature == '') { $temperature = 0; }

       /* air pressure */
       if(!isset($_GET["air_pressure"])) {
         if($_GET["selected_device"] == 'NO-DEVICE' || !isset($_GET["selected_device"]))
         {
           $tsql3 = "SELECT Floor(AVG(Sense_hat_air_pressure)) AS average_air  FROM SenseHat WHERE Sense_hat_datetime BETWEEN '$date_mysql' AND '$date_mysql_2'";
         } else {
           $device_secret = $_GET["selected_device"];
           $tsql3 = "SELECT Floor(AVG(Sense_hat_air_pressure)) AS average_air  FROM SenseHat WHERE Sense_hat_device_secret = '$device_secret' AND Sense_hat_datetime BETWEEN '$date_mysql' AND '$date_mysql_2'";
         }
         $params3 = array();
         $options3 =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
         $getResults3 = sqlsrv_query($conn, $tsql3, $params3, $options3) or die( print_r( sqlsrv_errors(), true));
         while ($row = sqlsrv_fetch_array($getResults3, SQLSRV_FETCH_ASSOC)) {
          $average_air = $row["average_air"];
         }
         if($average_air == '') { $average_air = 0; }
        }

       /* Humidity */
       if($_GET["selected_device"] == 'NO-DEVICE' || !isset($_GET["selected_device"]))
       {
         $tsql4 = "SELECT Floor(AVG(Sense_hat_humidity)) AS average_humidity  FROM SenseHat WHERE Sense_hat_datetime BETWEEN '$date_mysql' AND '$date_mysql_2'";
       } else {
         $device_secret = $_GET["selected_device"];
         $tsql4 = "SELECT Floor(AVG(Sense_hat_humidity)) AS average_humidity  FROM SenseHat WHERE Sense_hat_device_secret = '$device_secret' AND Sense_hat_datetime BETWEEN '$date_mysql' AND '$date_mysql_2'";
       }
       $params4 = array();
       $options4 =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
       $getResults4 = sqlsrv_query($conn, $tsql4, $params4, $options4) or die( print_r( sqlsrv_errors(), true));
       while ($row = sqlsrv_fetch_array($getResults4, SQLSRV_FETCH_ASSOC)) {
        $average_humidity = $row["average_humidity"];
       }
       if($average_humidity == '') { $average_humidity = 0; }

       if($date_fulldate != '01.01.1970') { /* jos pvm on väärä niin ei tulosteta */
        if(!isset($_GET["air_pressure"])) {
         echo "['".$date_day."', ".$get_rows.", ".$temperature.", ".$average_air.", ".$average_humidity."],";
        } else {
         echo "['".$date_day."', ".$get_rows.", ".$temperature.", ".$average_humidity."],";
        }
       }
       $i++; /* lisätään jokaisen pvm kohdalla +1 laskuriin */
     }
    }
  }
}

$currentday = ucwords(strftime( '%A' )); date_default_timezone_set('Europe/Helsinki');
$current_date = strftime( '%B' ); date_default_timezone_set('Europe/Helsinki');
$current_fulldate = strftime( '%d.%m.%Y' ); date_default_timezone_set('Europe/Helsinki');
$currentday_mysqlfulldate_1 = strftime( '%Y-%m-%d' ); date_default_timezone_set('Europe/Helsinki');
$currentday_mysqlfulldate = ucwords(strftime('%Y-%m-%d', strtotime($current_fulldate. 'last day of this month'))); date_default_timezone_set('Europe/Helsinki');


?><?php 

if($_GET["selected_device"] == 'NO-DEVICE' || !isset($_GET["selected_device"]))
{
  $tsql = "SELECT * FROM SenseHat WHERE Sense_hat_datetime BETWEEN '$currentday_mysqlfulldate_1' AND '$currentday_mysqlfulldate' ORDER BY Sense_hat_entry_id DESC";
} else {
  $device_secret = $_GET["selected_device"];
  $tsql = "SELECT * FROM SenseHat WHERE Sense_hat_device_secret = '$device_secret' AND Sense_hat_datetime BETWEEN '$currentday_mysqlfulldate_1' AND '$currentday_mysqlfulldate' ORDER BY Sense_hat_entry_id DESC";
}
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$getResults = sqlsrv_query($conn, $tsql, $params, $options) or die( print_r( sqlsrv_errors(), true));
$get_rows = sqlsrv_num_rows($getResults);
//echo ("Reading data from table " . PHP_EOL);

/* temperature */
if($_GET["selected_device"] == 'NO-DEVICE' || !isset($_GET["selected_device"]))
{
  $tsql2 = "SELECT Floor(AVG(Sense_hat_temperature)) AS average_temp  FROM SenseHat WHERE Sense_hat_datetime BETWEEN '$date_mysql' AND '$date_mysql_2'";
} else {
  $device_secret = $_GET["selected_device"];
  $tsql2 = "SELECT Floor(AVG(Sense_hat_temperature)) AS average_temp  FROM SenseHat WHERE Sense_hat_device_secret = '$device_secret' AND Sense_hat_datetime BETWEEN '$date_mysql' AND '$date_mysql_2'";
}
$params2 = array();
$options2 =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$getResults2 = sqlsrv_query($conn, $tsql2, $params2, $options2) or die( print_r( sqlsrv_errors(), true));
while ($row = sqlsrv_fetch_array($getResults2, SQLSRV_FETCH_ASSOC)) {
$temperature = $row["average_temp"];
}
if($temperature == '') { $temperature = 0; }

/* air pressure */
if(!isset($_GET["air_pressure"])) {
  if($_GET["selected_device"] == 'NO-DEVICE' || !isset($_GET["selected_device"]))
  {
    $tsql3 = "SELECT Floor(AVG(Sense_hat_air_pressure)) AS average_air  FROM SenseHat WHERE Sense_hat_datetime BETWEEN '$date_mysql' AND '$date_mysql_2'";
  } else {
    $device_secret = $_GET["selected_device"];
    $tsql3 = "SELECT Floor(AVG(Sense_hat_air_pressure)) AS average_air  FROM SenseHat WHERE Sense_hat_device_secret = '$device_secret' AND Sense_hat_datetime BETWEEN '$date_mysql' AND '$date_mysql_2'";
  }
 $params3 = array();
 $options3 =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
 $getResults3 = sqlsrv_query($conn, $tsql3, $params3, $options3) or die( print_r( sqlsrv_errors(), true));
 while ($row = sqlsrv_fetch_array($getResults3, SQLSRV_FETCH_ASSOC)) {
  $average_air = $row["average_air"];
 }
 if($average_air == '') { $average_air = 0; }
}

/* Humidity */
if($_GET["selected_device"] == 'NO-DEVICE' || !isset($_GET["selected_device"]))
{
  $tsql4 = "SELECT Floor(AVG(Sense_hat_humidity)) AS average_humidity  FROM SenseHat WHERE Sense_hat_datetime BETWEEN '$date_mysql' AND '$date_mysql_2'";
} else {
  $device_secret = $_GET["selected_device"];
  $tsql4 = "SELECT Floor(AVG(Sense_hat_humidity)) AS average_humidity  FROM SenseHat WHERE Sense_hat_device_secret = '$device_secret' AND Sense_hat_datetime BETWEEN '$date_mysql' AND '$date_mysql_2'";
}
$params4 = array();
$options4 =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$getResults4 = sqlsrv_query($conn, $tsql4, $params4, $options4) or die( print_r( sqlsrv_errors(), true));
while ($row = sqlsrv_fetch_array($getResults4, SQLSRV_FETCH_ASSOC)) {
$average_humidity = $row["average_humidity"];
}
if($average_humidity == '') { $average_humidity = 0; }


?>
<html>
  <head>
    <title>Monthly Charts - Organized Chaos</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" />
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="https://marcosraudkett.com/calendar/assets/plugins/datepicker/custom.js"></script>
    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    
  <body>
    <?php 
    $this_page = 'monthly';
    include("../includes/menu.php"); 
    ?>

    <img style="height: 56px;float:left;margin-top: -13px;" src="https://marcosraudkett.com/mvrclabs/code/scripts/admin/images/organizedchaos_withouttext.png">
    <center style="border-bottom: 1px solid #c7c7c7;">
    <form action="" style="display: inline-flex;margin-top: -5px;margin-bottom: 9px;" method="GET">
      <input class="form-control" style="width: 150px;padding: 5px;margin-right: 5px;" id="datepicker" autocomplete="off" value="<?php if(isset($_GET["from"])) { echo $_GET["from"]; } else { echo date('01.m.Y'); } ?>" name="from" type="text" placeholder="From (dd.mm.yyyy)">
      <input class="form-control" style="width: 150px;padding: 5px;margin-right:5px;" id="datepicker1" autocomplete="off" value="<?php if(isset($_GET["to"])) { echo $_GET["to"]; } else { echo date('d.m.Y'); } ?>" name="to" type="text" placeholder="To (dd.mm.yyyy)">
      <label style="margin-right: 10px;margin-left: 10px;width: 381px;white-space: nowrap;"><input name="air_pressure" type="checkbox" <?php if(isset($_GET["air_pressure"])) { echo 'checked="checked"'; } ?>> Hide Air Pressure</label>
      <select class="form-control" style="margin-right: 20px;" name="selected_device">
        <option value="NO-DEVICE">All Devices</option>
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
      <button type="submit" class="btn btn-default btn-sm">Submit</button>
    </form>

    </center>
    <br>
    <br>
<div class="container body-content">
    <h3>Statistics</h3>
    <p>Here you can see the average for every single month that is selected or for a specific device.</p>
    <hr style="opacity:0.2;">
    <script type="text/javascript">
      google.charts.load('current', {'packages':['line']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          <?php if(!isset($_GET["air_pressure"])) { ?>
          ['Month', 'Total Entries', 'Average Temperature (C)', 'Average Air Pressure (kPa)', 'Average Humidity (%)'],
          <?php } else { ?>
          ['Month', 'Total Entries', 'Average Temperature (C)', 'Average Humidity (%)'],
          <?php

          }
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
               new DateInterval('P1M'),
               new DateTime($to)
            );

            $begin = new DateTime($from);
            $end = new DateTime($to);

            $daterange = new DatePeriod($begin, new DateInterval('P1M'), $end);

            $amount = iterator_count($period);
            foreach($daterange as $date){
                $dates = $date->format("d.m.Y").' ';
                tilastot($dates, $amount, $conn);
            }            

          ?>
          <?php if(!isset($_GET["air_pressure"])) { ?>
          ['<?php echo 'Current Month ('.$current_date.')'; ?>',  <?php echo $get_rows; ?>, <?php echo $average_temp; ?>, <?php echo $average_air; ?>, <?php echo $average_humidity; ?>],
          <?php } else { ?>
          ['<?php echo 'Current Month ('.$current_date.')'; ?>',  <?php echo $get_rows; ?>, <?php echo $average_temp; ?>, <?php echo $average_humidity; ?>],
          <?php } ?>
        ]);

        var options = {
          title: 'Statistics',
          curveType: 'function',
          legend: { position: 'bottom' },
          series: {
            0: { color: '#a7d86d' },
            1: { color: '#d86d6d' },
            <?php if(!isset($_GET["air_pressure"])) { ?>
            2: { color: '#6dc3d8' },
            <?php } ?>
            <?php if(isset($_GET["air_pressure"])) { ?>
            2: { color: '#737373' }
            <?php } else { ?>
            3: { color: '#737373' }
            <?php } ?>
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
    dateFormat:"mm.yy",
    minDate: 0, maxDate: '+1M', numberOfMonths:2
  }).val()
})
  $(function(){
$("#datepicker1").datepicker();
  $("#datepicker1").datepicker({
    language:"fi",
    showWeek:1,
    firstDay:1,
    showButtonPanel:!0,
    dateFormat:"mm.yy",
    minDate: 0, maxDate: '+1M', numberOfMonths:2
  }).val()
})
  </script>
</html>
